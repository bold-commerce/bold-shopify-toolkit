<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Exceptions\ShopifyException;
use BoldApps\ShopifyToolkit\Models\Image as ShopifyImage;
use BoldApps\ShopifyToolkit\Models\Metafield as ShopifyMetafield;
use BoldApps\ShopifyToolkit\Models\Option as ShopifyOption;
use BoldApps\ShopifyToolkit\Models\Product as ShopifyProduct;
use BoldApps\ShopifyToolkit\Models\Variant as ShopifyVariant;
use BoldApps\ShopifyToolkit\Services\Client as ShopifyClient;
use BoldApps\ShopifyToolkit\Services\Image as ImageService;
use BoldApps\ShopifyToolkit\Services\Metafield as MetafieldService;
use BoldApps\ShopifyToolkit\Services\Option as OptionService;
use BoldApps\ShopifyToolkit\Services\Variant as VariantService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;

class Product extends CollectionEntity
{
    /** @var Variant */
    protected $variantService;

    /** @var Option */
    protected $optionService;

    /** @var Image */
    protected $imageService;

    /** @var Metafield */
    protected $metafieldService;

    /** @var array */
    protected $unserializationExceptions = [
        'variants' => 'unserializeVariants',
        'options' => 'unserializeOptions',
        'image' => 'unserializeImage',
        'images' => 'unserializeImages',
        'metafields' => 'unserializeMetafields',
    ];

    /** @var array */
    protected $serializationExceptions = [
        'variants' => 'serializeVariants',
        'options' => 'serializeOptions',
        'image' => 'serializeImage',
        'images' => 'serializeImages',
        'metafields' => 'serializeMetafields',
    ];

    /**
     * Product constructor.
     *
     * @param Client  $client
     * @param Variant $variantService
     * @param Option  $optionService
     * @param Image   $imageService
     */
    public function __construct(
        ShopifyClient $client,
        VariantService $variantService,
        OptionService $optionService,
        ImageService $imageService,
        MetafieldService $metafieldService
    ) {
        $this->variantService = $variantService;
        $this->optionService = $optionService;
        $this->imageService = $imageService;
        $this->metafieldService = $metafieldService;
        parent::__construct($client);
    }

    /**
     * @return object
     *
     * @throws ShopifyException
     * @throws GuzzleException
     */
    public function create(ShopifyProduct $product, bool $publish = true)
    {
        $serializedModel = ['product' => array_merge($this->serializeModel($product), ['published' => $publish])];

        $raw = $this->client->post("{$this->getApiBasePath()}/products.json", [], $serializedModel);

        return $this->unserializeModel($raw['product'], ShopifyProduct::class);
    }

    /**
     * @param $id
     *
     * @return ShopifyProduct | object
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function getById($id, array $filter = [])
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/products/$id.json", $filter);

        $product = $this->unserializeModel($raw['product'], ShopifyProduct::class);

        return $this->unserializeModel($raw['product'], ShopifyProduct::class);
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
        $raw = $this->client->get('admin/products.json', array_merge(['page' => $page, 'limit' => $limit], $filter));

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
     */
    public function getByParams(array $params)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/products.json", $params);

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
     */
    public function getByProductIdArray(array $productIds, array $filter = [])
    {
        $products = [];
        $limit = 250;

        for ($i = 0; $i < ceil(count($productIds) / $limit); ++$i) {
            $idList = implode(',', array_slice($productIds, ($i * $limit), $limit));

            $params = array_merge(
                $filter,
                [
                    'ids' => $idList,
                    'limit' => $limit,
                ]
            );

            $shopifyProductsBatch = $this->getByParams($params);

            /** @var ShopifyProduct $shopifyProduct */
            foreach ($shopifyProductsBatch as $shopifyProduct) {
                $products[] = $shopifyProduct;
            }
        }

        return new Collection($products);
    }

    /**
     * @return object
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function update(ShopifyProduct $product)
    {
        $serializedModel = ['product' => $this->serializeModel($product)];

        $raw = $this->client->put("{$this->getApiBasePath()}/products/{$product->getId()}.json", [], $serializedModel);

        return $this->unserializeModel($raw['product'], ShopifyProduct::class);
    }

    /**
     * @return array | null
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function delete(ShopifyProduct $product)
    {
        return $this->client->delete("{$this->getApiBasePath()}/products/{$product->getId()}.json");
    }

    /**
     * @return int
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function count(array $filter = [])
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/products/count.json", $filter);

        return $raw['count'];
    }

    /**
     * @return object
     */
    public function createFromArray(array $array)
    {
        return $this->unserializeModel($array, ShopifyProduct::class);
    }

    /**
     * @return ShopifyMetafield | object
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function createOrUpdateMetafield(ShopifyProduct $product, ShopifyMetafield $metafield)
    {
        $serializedModel = ['metafield' => array_merge($this->serializeModel($metafield))];

        $raw = $this->client->post("{$this->getApiBasePath()}/products/{$product->getId()}/metafields.json", [], $serializedModel);

        return $this->unserializeModel($raw['metafield'], ShopifyMetafield::class);
    }

    /**
     * @return Collection
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function getMetafields(ShopifyProduct $product, array $filter = [])
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/products/{$product->getId()}/metafields.json", $filter);

        $metafields = array_map(function ($metafield) {
            return $this->unserializeModel($metafield, ShopifyMetafield::class);
        }, $raw['metafields']);

        return new Collection($metafields);
    }

    /**
     * @param $id
     *
     * @return ShopifyMetafield | object
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function getMetafield(ShopifyProduct $product, $id)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/products/{$product->getId()}/metafields/$id.json");

        return $this->unserializeModel($raw['metafield'], ShopifyMetafield::class);
    }

    /**
     * @return array | null
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function deleteMetafield(ShopifyProduct $product, ShopifyMetafield $metafield)
    {
        return $this->client->delete("{$this->getApiBasePath()}/products/{$product->getId()}/metafields/{$metafield->getId()}.json");
    }

    /**
     * @return array | null
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function deleteMetafieldById(int $metafieldId)
    {
        return $this->client->delete("{$this->getApiBasePath()}/metafields/{$metafieldId}.json");
    }

    /**
     * @param $entities
     *
     * @return array | null
     */
    protected function serializeVariants($entities)
    {
        if (null === $entities) {
            return null;
        }

        if ($entities instanceof Collection) {
            return $entities->map(function ($entity) {
                return $this->variantService->serializeModel($entity);
            })->toArray();
        }

        return $entities;
    }

    /**
     * @return Collection | null
     */
    protected function unserializeVariants(array $data)
    {
        if (null === $data) {
            return null;
        }

        $variants = array_map(function ($variant) {
            return $this->variantService->unserializeModel($variant, ShopifyVariant::class);
        }, $data);

        return new Collection($variants);
    }

    /**
     * @param $entities
     *
     * @return array | null
     */
    protected function serializeOptions($entities)
    {
        if (null === $entities) {
            return null;
        }

        if ($entities instanceof Collection) {
            return $entities->map(function ($entity) {
                return $this->optionService->serializeModel($entity);
            })->toArray();
        }

        return $entities;
    }

    /**
     * @return Collection | null
     */
    protected function unserializeOptions(array $data)
    {
        if (null === $data) {
            return null;
        }

        $options = array_map(function ($option) {
            return $this->optionService->unserializeModel($option, ShopifyOption::class);
        }, $data);

        return new Collection($options);
    }

    /**
     * @param $entity
     *
     * @return array | null
     */
    protected function serializeImage($entity)
    {
        if (null === $entity) {
            return null;
        }

        return $this->imageService->serializeModel($entity);
    }

    /**
     * @return ShopifyImage | object
     */
    protected function unserializeImage(array $data)
    {
        if (null === $data) {
            return null;
        }

        return $this->imageService->unserializeModel($data, ShopifyImage::class);
    }

    /**
     * @param $entities
     *
     * @return array | null
     */
    protected function serializeImages($entities)
    {
        if (null === $entities) {
            return null;
        }

        if ($entities instanceof Collection) {
            return $entities->map(function ($entity) {
                return $this->imageService->serializeModel($entity);
            })->toArray();
        }

        return $entities;
    }

    /**
     * @return Collection | null
     */
    protected function unserializeImages(array $data)
    {
        if (null === $data) {
            return null;
        }

        $images = array_map(function ($image) {
            return $this->imageService->unserializeModel($image, ShopifyImage::class);
        }, $data);

        return new Collection($images);
    }

    /**
     * @param $entities
     *
     * @return array | null
     */
    protected function serializeMetafields($entities)
    {
        if (null === $entities) {
            return null;
        }

        if ($entities instanceof Collection) {
            return $entities->map(function ($entity) {
                return $this->metafieldService->serializeModel($entity);
            })->toArray();
        }

        return $entities;
    }

    /**
     * @param $data
     *
     * @return Collection | null
     */
    protected function unserializeMetafields(array $data)
    {
        if (null === $data) {
            return null;
        }

        $metafields = array_map(function ($metafield) {
            return $this->metafieldService->unserializeModel($metafield, ShopifyMetafield::class);
        }, $data);

        return new Collection($metafields);
    }
}
