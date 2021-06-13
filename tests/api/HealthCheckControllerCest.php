<?php

use Codeception\Util\HttpCode;

class HealthCheckControllerCest
{

    /** @test  */
    public function createUserViaAPI(\ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGet('/health/test');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['status' => "ok"]);
    }
}
