<?php

use BoldApps\ShopifyToolkit\Models\SmartCollection as ShopifySmartCollection;
use BoldApps\ShopifyToolkit\Services\Client;
use BoldApps\ShopifyToolkit\Services\SmartCollection as SmartCollectionService;
use BoldApps\ShopifyToolkit\Services\SmartCollectionRule as SmartCollectionRuleService;
use PHPUnit\Framework\TestCase;

class SmartCollectionTest extends TestCase
{
    /** @var SmartCollectionService */
    private $smartCollectionService;

    /** @var SmartCollectionRuleService */
    private $smartCollectionRuleService;

    protected function setUp(): void
    {
        /** @var Client $client */
        $client = $this->createMock(Client::class);
        $this->smartCollectionRuleService = new SmartCollectionRuleService($client);
        $this->smartCollectionService = new SmartCollectionService($client, $this->smartCollectionRuleService);
    }

    /**
     * @test
     */
    public function ShopifySmartCollectionSerializesProperly()
    {
        $smartCollectionEntity = $this->createSmartCollectionEntity();

        $expected = $this->getSmartCollectionArray();
        $actual = $this->smartCollectionService->serializeModel($smartCollectionEntity);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function ShopifySmartCollectionDeserializesProperly()
    {
        $smartCollectionJson = $this->getSmartCollectionJson();
        $jsonArray = (array) json_decode($smartCollectionJson, true);

        $expected = $this->createSmartCollectionEntity();
        $actual = $this->smartCollectionService->unserializeModel($jsonArray, ShopifySmartCollection::class);

        $this->assertEquals($expected, $actual);
    }

    private function createSmartCollectionEntity()
    {
        /** @var ShopifySmartCollection $smartCollectionEntity */
        $smartCollectionEntity = $this->smartCollectionService->createFromArray($this->getSmartCollectionArray());

        return $smartCollectionEntity;
    }

    private function getSmartCollectionJson()
    {
        return '{
            "id": 3465543691,
            "handle": "song-birds",
            "title": "Song Birds",
            "updated_at": "2018-03-15T14:47:39-05:00",
            "body_html": "",
            "published_at": "2018-01-08T10:56:11-06:00",
            "sort_order": "best-selling",
            "template_suffix": null,
            "products_count": 2,
            "disjunctive": false,
            "rules": [
                {
                    "column": "tag",
                    "relation": "equals",
                    "condition": "song bird"
                },
                {
                    "column": "tag",
                    "relation": "equals",
                    "condition": "small"
                }
            ],
            "published_scope": "web"
        }';
    }

    private function getSmartCollectionArray()
    {
        return [
            'id' => 3465543691,
            'handle' => 'song-birds',
            'title' => 'Song Birds',
            'updated_at' => '2018-03-15T14:47:39-05:00',
            'body_html' => '',
            'published_at' => '2018-01-08T10:56:11-06:00',
            'sort_order' => 'best-selling',
            'disjunctive' => false,
            'rules' => [
                [
                    'column' => 'tag',
                    'relation' => 'equals',
                    'condition' => 'song bird',
                ],
                [
                    'column' => 'tag',
                    'relation' => 'equals',
                    'condition' => 'small',
                ],
            ],
            'published_scope' => 'web',
            'products_count' => 2,
        ];
    }
}
