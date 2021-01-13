<?php

use BoldApps\ShopifyToolkit\Services\Client;
use BoldApps\ShopifyToolkit\Models\RecurringApplicationCharge;
use BoldApps\ShopifyToolkit\Services\RecurringApplicationCharge as RecurringApplicationChargeService;

class RecurringApplicationChargeTest extends \PHPUnit\Framework\TestCase
{
    /** @var RecurringApplicationChargeService */
    private $recurringApplicationChargeService;

    protected function setUp()
    {
        /** @var Client $client */
        $client = $this->createMock(Client::class);
        $this->recurringApplicationChargeService = new RecurringApplicationChargeService($client);
    }

    /**
     * @test
     */
    public function ShopifyRecurringApplicationChargeSerializesProperly()
    {
        $recurringApplicationChargeEntity = $this->createRecurringApplicationChargeEntity();

        $expected = $this->getRecurringApplicationChargeArray();

        $actual = $this->recurringApplicationChargeService->serializeModel($recurringApplicationChargeEntity);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function ShopifyRecurringApplicationChargeDeserializesProperly()
    {
        $recurringApplicationChargeJson = $this->getRecurringApplicationChargeJson();
        $jsonArray = (array) json_decode($recurringApplicationChargeJson, true);

        $expected = $this->createRecurringApplicationChargeEntity();
        $actual = $this->recurringApplicationChargeService->unserializeModel($jsonArray, RecurringApplicationCharge::class);

        $this->assertEquals($expected, $actual);
    }

    private function createRecurringApplicationChargeEntity()
    {
        /** @var RecurringApplicationCharge $recurringApplicationChargeEntity */
        $recurringApplicationChargeEntity = $this->recurringApplicationChargeService->createFromArray($this->getRecurringApplicationChargeArray());

        return $recurringApplicationChargeEntity;
    }

    private function getRecurringApplicationChargeJson()
    {
        return '{
            "id": 455696195,
            "name": "Super Mega Plan",
            "api_client_id": 755357713,
            "price": "15.00",
            "status": "accepted",
            "return_url": "http://yourapp.com",
            "billing_on": "2018-07-05",
            "created_at": "2018-07-05T12:41:00-04:00",
            "updated_at": "2018-07-05T13:01:13-04:00",
            "test": true,
            "activated_on": "2018-07-05T13:01:13-04:00",
            "trial_ends_on": "2018-07-05T13:01:13-04:00",
            "cancelled_on": "2018-07-05T13:01:13-04:00",
            "balance_remaining": "1000.00",
            "trial_days": 0,
            "decorated_return_url": "http://yourapp.com?charge_id=455696195"
        }';
    }

    private function getRecurringApplicationChargeArray()
    {
        return [
            'id' => 455696195,
            'name' => 'Super Mega Plan',
            'api_client_id' => 755357713,
            'price' => '15.00',
            'status' => 'accepted',
            'return_url' => 'http://yourapp.com',
            'billing_on' => '2018-07-05',
            'created_at' => '2018-07-05T12:41:00-04:00',
            'updated_at' => '2018-07-05T13:01:13-04:00',
            'test' => true,
            'activated_on' => '2018-07-05T13:01:13-04:00',
            'trial_ends_on' => '2018-07-05T13:01:13-04:00',
            'cancelled_on' => '2018-07-05T13:01:13-04:00',
            'balance_remaining' => '1000.00',
            'trial_days' => 0,
            'decorated_return_url' => 'http://yourapp.com?charge_id=455696195',
        ];
    }
}
