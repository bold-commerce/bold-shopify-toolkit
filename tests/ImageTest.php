<?php

use BoldApps\ShopifyToolkit\Services\Client;
use BoldApps\ShopifyToolkit\Models\Image as ShopifyImage;
use BoldApps\ShopifyToolkit\Services\Image as ImageService;

class ImageTest extends \PHPUnit\Framework\TestCase
{
    /** @var ImageService */
    private $imageService;

    protected function setUp()
    {
        /** @var Client $client */
        $client = $this->createMock(Client::class);
        $this->imageService = new ImageService($client);
    }

    /**
     * @test
     */
    public function ShopifyImageSerializesProperly()
    {
        $imageEntity = $this->imageService->createFromArray($this->getImageArray());

        $expected = $this->getImageArray();
        $actual = $this->imageService->serializeModel($imageEntity);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function ShopifyImageDeserializesProperly()
    {
        $imageJson = $this->getImageJson();
        $jsonArray = (array) json_decode($imageJson, true);

        $expected = $this->imageService->createFromArray($this->getImageArray());
        $actual = $this->imageService->unserializeModel($jsonArray, ShopifyImage::class);

        $this->assertEquals($expected, $actual);
    }

    private function getImageJson()
    {
        return '{
            "id": 2768351559737,
            "product_id": 737929166905,
            "position": 1,
            "created_at": "2017-09-12T16:23:01-04:00",
            "updated_at": "2017-09-12T16:23:01-04:00",
            "alt": "alternative text",
            "width": 300,
            "height": 300,
            "src": "https://cdn.shopify.com/s/files/1/0066/5252/6649/products/Training_hoodie.jpg?v=1525729977",
            "variant_ids": [7930513948729]
        }';
    }

    private function getImageArray()
    {
        return [
            "id" => 2768351559737,
            "product_id" => 737929166905,
            "position" => 1,
            "created_at" => "2017-09-12T16:23:01-04:00",
            "updated_at" => "2017-09-12T16:23:01-04:00",
            "alt" => "alternative text",
            "width" => 300,
            "height" => 300,
            "src" => "https://cdn.shopify.com/s/files/1/0066/5252/6649/products/Training_hoodie.jpg?v=1525729977",
            "variant_ids" => [7930513948729],
        ];
    }
}