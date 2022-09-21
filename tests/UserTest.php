<?php

use BoldApps\ShopifyToolkit\Models\User as ShopifyUser;
use BoldApps\ShopifyToolkit\Services\User as UserService;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /** @var UserService */
    private $userService;

    protected function setUp(): void
    {
        /** @var \BoldApps\ShopifyToolkit\Services\Client $client */
        $client = $this->createMock(\BoldApps\ShopifyToolkit\Services\Client::class);
        $this->userService = new UserService($client);
    }

    /**
     * @test
     */
    public function shopifyRefundSerializesProperly()
    {
        $userEntity = new ShopifyUser();
        $userEntity->setId(55347909);
        $userEntity->setFirstName('Nathan');
        $userEntity->setLastName('Koop');
        $userEntity->setEmail('nathank@boldcommerce.com');
        $userEntity->setUrl('http://');
        $userEntity->setIm('nathan.koop.com');
        $userEntity->setScreenName('Nathan Koop');
        $userEntity->setPhone('');
        $userEntity->setAccountOwner(true);
        $userEntity->setReceiveAnnouncements(1);
        $userEntity->setBio('');
        $userEntity->setPermissions(['full']);
        $userEntity->setUserType('regular');
        $userEntity->setPhoneValidated(true);
        $userEntity->setTfaEnabled(false);

        $expected = $this->getUserArray();

        $actual = $this->userService->serializeModel($userEntity);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function shopifyUserDeserializesProperly()
    {
        $expected = new ShopifyUser();
        $expected->setId(55347909);
        $expected->setFirstName('Nathan');
        $expected->setLastName('Koop');
        $expected->setEmail('nathank@boldcommerce.com');
        $expected->setUrl('http://');
        $expected->setIm('nathan.koop.com');
        $expected->setScreenName('Nathan Koop');
        $expected->setPhone('');
        $expected->setAccountOwner(true);
        $expected->setReceiveAnnouncements(1);
        $expected->setBio('');
        $expected->setPermissions(['full']);
        $expected->setUserType('regular');
        $expected->setPhoneValidated(true);
        $expected->setTfaEnabled(false);

        // from the shopify documentation
        $userJson = $this->getUserJson();
        $jsonArray = (array) json_decode($userJson, true);

        $actual = $this->userService->unserializeModel($jsonArray, ShopifyUser::class);

        $this->assertEquals($expected, $actual);
    }

    private function getUserJson()
    {
        return '{
            "id": 55347909,
            "first_name": "Nathan",
            "email": "nathank@boldcommerce.com",
            "url": "http://",
            "im": "nathan.koop.com",
            "screen_name": "Nathan Koop",
            "phone": "",
            "last_name": "Koop",
            "account_owner": true,
            "receive_announcements": 1,
            "bio": "",
            "permissions": [
              "full"
            ],
            "user_type": "regular",
            "phone_validated?": true,
            "tfa_enabled?": false
        }';
    }

    private function getUserArray()
    {
        return [
            'id' => 55347909,
            'first_name' => 'Nathan',
            'email' => 'nathank@boldcommerce.com',
            'url' => 'http://',
            'im' => 'nathan.koop.com',
            'screen_name' => 'Nathan Koop',
            'phone' => '',
            'last_name' => 'Koop',
            'account_owner' => true,
            'receive_announcements' => 1,
            'bio' => '',
            'permissions' => [
              'full',
            ],
            'user_type' => 'regular',
            'phone_validated?' => true,
            'tfa_enabled?' => false,
        ];
    }
}
