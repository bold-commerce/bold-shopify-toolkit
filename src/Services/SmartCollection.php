<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\Product as ShopifyProduct;
use BoldApps\ShopifyToolkit\Models\SmartCollection as ShopifySmartCollection;
use BoldApps\ShopifyToolkit\Models\SmartCollectionRule as ShopifySmartCollectionRule;
use BoldApps\ShopifyToolkit\Services\Client as ShopifyClient;
use BoldApps\ShopifyToolkit\Services\SmartCollectionRule as SmartCollectionRuleService;
use Illuminate\Support\Collection;

class SmartCollection extends CollectionEntity
{
    /** @var SmartCollectionRuleService */
    protected $ruleService;

    /**
     * SmartCollection constructor.
     *
     * @param Client $client
     */
    public function __construct(
        ShopifyClient $client,
        SmartCollectionRuleService $ruleService
    ) {
        $this->ruleService = $ruleService;
        parent::__construct($client);
    }

    /**
     * @var array
     */
    protected $unserializationExceptions = [
        'rules' => 'unserializeRules',
    ];

    /**
     * @var array
     */
    protected $serializationExceptions = [
        'rules' => 'serializeRules',
    ];

    /**
     * @param bool $publish
     *
     * @return object
     */
    public function create(ShopifySmartCollection $collection, $publish = true)
    {
        $serializedModel = [
            'smart_collection' => array_merge($this->serializeModel($collection), ['published' => $publish]),
        ];

        $raw = $this->client->post("{$this->getApiBasePath()}/smart_collections.json", [], $serializedModel);

        return $this->unserializeModel($raw['smart_collection'], ShopifySmartCollection::class);
    }

    /**
     * @param $array
     *
     * @return ShopifySmartCollection|object
     */
    public function createFromArray($array)
    {
        return $this->unserializeModel($array, ShopifySmartCollection::class);
    }

    /**
     * @param $id
     *
     * @return ShopifySmartCollection
     */
    public function getById($id)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/smart_collections/$id.json");

        return $this->unserializeModel($raw['smart_collection'], ShopifySmartCollection::class);
    }

    /**
     * @param int   $id
     * @param array $filter
     *
     * @return Collection
     */
    public function getProductsBySmartCollectionId($id, $filter = [])
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/collections/$id/products.json", $filter);

        $products = array_map(function ($product) {
            return $this->unserializeModel($product, ShopifyProduct::class);
        }, $raw['products']);

        return new Collection($products);
    }

    /**
     * @deprecated Use getByParams()
     * @see getByParams()
     *
     * @param int   $page
     * @param int   $limit
     * @param array $filter
     *
     * @return Collection
     */
    public function getAll($page = 1, $limit = 50, $filter = [])
    {
        $raw = $this->client->get('admin/smart_collections.json',
            array_merge(['page' => $page, 'limit' => $limit], $filter));

        $collection = array_map(function ($collection) {
            return $this->unserializeModel($collection, ShopifySmartCollection::class);
        }, $raw['smart_collections']);

        return new Collection($collection);
    }

    /**
     * @param $params
     *
     * @return \Illuminate\Support\Collection
     */
    public function getByParams($params)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/smart_collections.json", $params);

        $collection = array_map(function ($product) {
            return $this->unserializeModel($product, ShopifySmartCollection::class);
        }, $raw['smart_collections']);

        return new Collection($collection);
    }

    /**
     * @return object
     */
    public function update(ShopifySmartCollection $collection)
    {
        $serializedModel = ['smart_collection' => $this->serializeModel($collection)];

        $raw = $this->client->put("{$this->getApiBasePath()}/smart_collections/{$collection->getId()}.json", [], $serializedModel);

        return $this->unserializeModel($raw['smart_collection'], ShopifySmartCollection::class);
    }

    /**
     * @return array
     */
    public function delete(ShopifySmartCollection $collection)
    {
        return $this->client->delete("{$this->getApiBasePath()}/smart_collections/{$collection->getId()}.json");
    }

    /**
     * @param array $filter
     *
     * @return int
     */
    public function count($filter = [])
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/smart_collections/count.json", $filter);

        return $raw['count'];
    }

    /**
     * @param $filter
     *
     * @return int
     */
    public function countByParams($filter = [])
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/smart_collections/count.json", $filter);

        return $raw['count'];
    }

    /**
     * @param $entities
     *
     * @return array|null
     */
    protected function serializeRules($entities)
    {
        if (null === $entities) {
            return;
        }

        $ruleService = &$this->ruleService;

        if ($entities instanceof Collection) {
            return $entities->map(function ($entity) use ($ruleService) {
                return $ruleService->serializeModel($entity);
            })->toArray();
        }

        return $entities;
    }

    /**
     * @param array $data
     *
     * @return Collection
     */
    protected function unserializeRules($data)
    {
        if (null === $data) {
            return;
        }

        $ruleService = &$this->ruleService;

        $options = array_map(function ($option) use ($ruleService) {
            return $ruleService->unserializeModel($option, ShopifySmartCollectionRule::class);
        }, $data);

        return new Collection($options);
    }
}
