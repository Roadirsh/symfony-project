<?php namespace App\Tests;

class CreateOrUpdateBotCest
{
    public function _before(ApiTester $I)
    {

    }

    // tests
    public function createOrUpdate(ApiTester $I)
    {
        $I->sendPOST('/bots', []);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST);

        $I->sendPOST('/bots', ['type' => 'test', 'name' => 'test', 'category' => 'test']);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);

        $I->sendPOST('/bots', ['type' => 'test', 'name' => 'test', 'category' => 'test']);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);

        $I->sendPOST('/bots', ['type' => 'test2', 'name' => 'test2', 'category' => 'test2']);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
    }
    public function getBySlugAndId(ApiTester $I)
    {
        $I->sendGET('/bots/99999999999');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::NOT_FOUND);

        $I->sendGET('/bots/not-found');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::NOT_FOUND);
    }
}
