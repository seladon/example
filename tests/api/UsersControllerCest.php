<?php

use Codeception\Util\HttpCode;

class UsersControllerCest
{

    /** @test  */
    public function createUserViaAPI(\ApiTester $I)
    {
        $firstName = 'Sergey';
        $lastName = 'Rudnev';
        $userEmail = 'ru@ru.ru';
        $phone = '+79261167248';

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/users/create', [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $userEmail,
            'phone' => $phone
        ]);
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'userId' => 'integer',
        ]);

        list($userId) = $I->grabDataFromResponseByJsonPath('$.userId');

        $I->sendGet('/users/' . $userId);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'id' => $userId,
            'keyCloakId' => null,
            'phone' => [
                'number' => $phone
            ],
            'email' => [
                'email' => $userEmail,
                'confirmEmail' => false
            ],
            'firstName' => $firstName,
            'lastName' => $lastName,
        ]);
    }
}
