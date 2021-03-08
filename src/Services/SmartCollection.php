<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Exceptions\ShopifyException;
use BoldApps\ShopifyToolkit\Models\Product as ShopifyProduct;
use BoldApps\ShopifyToolkit\Models\SmartCollection as ShopifySmartCollection;
use BoldApps\ShopifyToolkit\Models\SmartCollectionRule as ShopifySmartCollectionRule;
use BoldApps\ShopifyToolkit\Services\Client as ShopifyClient;
use BoldApps\ShopifyToolkit\Services\SmartCollectionRule as SmartCollectionRuleService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;

class SmartCollection extends CollectionEntity
{
    /** @var SmartCollectionRuleService */
    protected $ruleService;

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
     * @return object
     *
     * @throws ShopifyException
     * @throws GuzzleException
     */
    public function create(ShopifySmartCollection $collection, bool $publish = true)
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
     * @return ShopifySmartCollection | object
     */
    public function createFromArray(array $array)
    {
        return $this->unserializeModel($array, ShopifySmartCollection::class);
    }

    /**
     * @param $id
     *
     * @return ShopifySmartCollection
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function getById($id)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/smart_collections/$id.json");

        return $this->unserializeModel($raw['smart_collection'], ShopifySmartCollection::class);
    }

    /**
     * @return Collection
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function getProductsBySmartCollectionId(int $id, array $filter = [])
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/collections/$id/products.json", $filter);

        $products = array_map(function ($product) {
            return $this->unserializeModel($product, ShopifyProduct::class);
        }, $raw['products']);

        return new Collection($products);
    }

    /**
     * @return Collection
     *
     * @throws GuzzleException
     * @throws ShopifyException
     *
     * @deprecated Use getByParams()
     * @see getByParams()
     */
    public function getAll(int $page = 1, int $limit = 50, array $filter = [])
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
     * @return Collection
     */
    public function getByParams(array $params)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/smart_collections.json", $params);

        $collection = array_map(function ($product) {
            return $this->unserializeModel($product, ShopifySmartCollection::class);
        }, $raw['smart_collections']);

        return new Collection($collection);
    }

    /**
     * @return object
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function update(ShopifySmartCollection $collection)
    {
        $serializedModel = ['smart_collection' => $this->serializeModel($collection)];

        $raw = $this->client->put("{$this->getApiBasePath()}/smart_collections/{$collection->getId()}.json", [], $serializedModel);

        return $this->unserializeModel($raw['smart_collection'], ShopifySmartCollection::class);
    }

    /**
     * @return array
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function delete(ShopifySmartCollection $collection)
    {
        return $this->client->delete("{$this->getApiBasePath()}/smart_collections/{$collection->getId()}.json");
    }

    /**
     * @return int
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function count(array $filter = [])
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/smart_collections/count.json", $filter);

        return $raw['count'];
    }

    /**
     * @return int
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function countByParams(array $filter = [])
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
     * @return Collection
     */
    protected function unserializeRules(array $data)
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
