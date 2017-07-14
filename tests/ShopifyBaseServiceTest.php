<?php

namespace BoldApps\Common\Test\Services\Shopify;

use BoldApps\ShopifyToolkit\Test\Fakes\FakeModel;
use BoldApps\ShopifyToolkit\Services\Client;
use BoldApps\ShopifyToolkit\Services\Base;

class ShopifyBaseServiceTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function unserializeModel()
    {
        $shopifyClientMock = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->getMock();

        $base = new Base($shopifyClientMock);

        $dataModel = [
            'foo' => 'donkey',
            'bar' => 'kick',
        ];

        /** @var FakeModel $model */
        $model = $base->unserializeModel($dataModel, FakeModel::class);

        $this->assertTrue($model->getFoo() === $dataModel['foo']);
        $this->assertTrue($model->getBar() === $dataModel['bar']);
    }

    /** @test */
    public function serializeModel()
    {
        $shopifyClientMock = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->getMock();

        $base = new Base($shopifyClientMock);

        $fakeModel = new FakeModel();
        $fakeModel->setFoo('donkey');
        $fakeModel->setBar('kick');

        $modelArray = $base->serializeModel($fakeModel);

        $this->assertTrue($fakeModel->getFoo() === $modelArray['foo']);
        $this->assertTrue($fakeModel->getBar() === $modelArray['bar']);
    }

    /** @test */
    public function unserializeSerializedModel()
    {
        $shopifyClientMock = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->getMock();

        $base = new Base($shopifyClientMock);

        $dataModel = [
            'foo' => 'donkey',
            'bar' => 'kick',
        ];

        /** @var FakeModel $model */
        $model = $base->unserializeModel($dataModel, FakeModel::class);

        $newArray = $base->serializeModel($model);

        $this->assertTrue($dataModel == $newArray);
    }



    /** @test */
    public function unserializeSerializedModelWithExtraField()
    {
        $shopifyClientMock = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->getMock();

        $base = new Base($shopifyClientMock);


        $expectedResult =[
            'foo' => 'donkey',
            'bar' => 'kick',
        ];

        $dataModelWithExtraField = array_merge($expectedResult, ['yetAnotherField' => 'face']);

        /** @var FakeModel $model */
        $model = $base->unserializeModel($dataModelWithExtraField, FakeModel::class);

        $newArray = $base->serializeModel($model);

        $this->assertTrue($expectedResult == $newArray);
    }
}