<?php

use Architecture\Infrastructure\Kernel;
use OpenTracing\GlobalTracer;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\HttpFoundation\Request;
use Zipkin\Endpoint;
use Zipkin\Samplers\BinarySampler;
use Zipkin\TracingBuilder;
use OpenTracing\Formats;

require dirname(__DIR__).'/vendor/autoload.php';

if($_SERVER["APP_ENV"] == 'dev') {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}

if ($_SERVER['APP_DEBUG']) {
    umask(0000);

    Debug::enable();
}

if ($trustedProxies = $_SERVER['TRUSTED_PROXIES'] ?? false) {
    Request::setTrustedProxies(explode(',', $trustedProxies), Request::HEADER_X_FORWARDED_FOR | Request::HEADER_X_FORWARDED_PORT | Request::HEADER_X_FORWARDED_PROTO);
}

if ($trustedHosts = $_SERVER['TRUSTED_HOSTS'] ?? false) {
    Request::setTrustedHosts([$trustedHosts]);
}

/** TODO убрать в события */
/** Инициализируем трассировщик по имени сервиса */
$endpoint = Endpoint::create($_SERVER['SERVICE_NAME']);
/** Инициализируем экспортер Zipkin в jaeger */
$reporter = new \Zipkin\Reporters\Http(['endpoint_url' => "http://{$_SERVER['AUXMONEY_OPENTRACING_AGENT_HOST']}:{$_SERVER['AUXMONEY_OPENTRACING_AGENT_PORT']}/api/v2/spans"]);
$sampler = BinarySampler::createAsAlwaysSample();
$tracing = TracingBuilder::create()
    ->havingLocalEndpoint($endpoint)
    ->havingSampler($sampler)
    ->havingReporter($reporter)
    ->build();

/** Инициализируем трейсер Zipkin */
$zipkinTracer = new \ZipkinOpenTracing\Tracer($tracing);
/** для удобного использования GlobalTracer::get() в методах */
GlobalTracer::set($zipkinTracer);
/** TODO переупаковка реквеста в PSR-7 костыль нужно что то сделать */
$request = new \GuzzleHttp\Psr7\Request('GET', '', getallheaders());
/** считываем заголовки трассировки входящего запроса  */
$spanContext = GlobalTracer::get()->extract(Formats\HTTP_HEADERS, $request);
/** стартуем основной спан сервиса и устанавливаем его дочерним  */
$option = [];
    $option['child_of'] = $spanContext;

$span = GlobalTracer::get()->startActiveSpan($_SERVER['SERVICE_NAME'], $option);
/** закрываем рутовый спан и трейсер сервиса перед завершением, отправляем в джагер  */
register_shutdown_function(
    static function () use ($span) {
        $span->getSpan()->finish();
        $tracer = GlobalTracer::get();
        $tracer->flush();
    }
);

$kernel = new Kernel($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
