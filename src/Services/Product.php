<?php

namespace BoldApps\ShopifyToolkit\Services;

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
     * @param Client           $client
     * @param Variant          $variantService
     * @param Option           $optionService
     * @param Image            $imageService
     * @param MetafieldService $metafieldService
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
     * @param ShopifyProduct $product
     * @param bool           $publish
     *
     * @return object
     */
    public function create(ShopifyProduct $product, $publish = true)
    {
        $serializedModel = ['product' => array_merge($this->serializeModel($product), ['published' => $publish])];

        $raw = $this->client->post("{$this->getApiBasePath()}/products.json", [], $serializedModel);

        return $this->unserializeModel($raw['product'], ShopifyProduct::class);
    }

    /**
     * @param       $id
     * @param array $filter
     *
     * @return ShopifyProduct | object
     */
    public function getById($id, $filter = [])
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/products/$id.json", $filter);

        return $this->unserializeModel($raw['product'], ShopifyProduct::class);
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
        $raw = $this->client->get('admin/products.json', array_merge(['page' => $page, 'limit' => $limit], $filter));

        $products = array_map(function ($product) {
            return $this->unserializeModel($product, ShopifyProduct::class);
        }, $raw['products']);

        return new Collection($products);
    }

    /**
     * @param array $params
     *
     * @return Collection
     */
    public function getByParams($params)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/products.json", $params);

        $products = array_map(function ($product) {
            return $this->unserializeModel($product, ShopifyProduct::class);
        }, $raw['products']);

        return new Collection($products);
    }

    /**
     * @param array $productIds
     * @param array $filter
     *
     * @return Collection
     */
    public function getByProductIdArray($productIds, $filter = [])
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
     * @param ShopifyProduct $product
     *
     * @return object
     */
    public function update(ShopifyProduct $product)
    {
        $serializedModel = ['product' => $this->serializeModel($product)];

        $raw = $this->client->put("{$this->getApiBasePath()}/products/{$product->getId()}.json", [], $serializedModel);

        return $this->unserializeModel($raw['product'], ShopifyProduct::class);
    }

    /**
     * @param ShopifyProduct $product
     *
     * @return array | null
     */
    public function delete(ShopifyProduct $product)
    {
        return $this->client->delete("{$this->getApiBasePath()}/products/{$product->getId()}.json");
    }

    /**
     * @param array $filter
     *
     * @return int
     */
    public function count($filter = [])
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/products/count.json", $filter);

        return $raw['count'];
    }

    /**
     * @param array $array
     *
     * @return object
     */
    public function createFromArray($array)
    {
        return $this->unserializeModel($array, ShopifyProduct::class);
    }

    /**
     * @param ShopifyProduct   $product
     * @param ShopifyMetafield $metafield
     *
     * @return ShopifyMetafield | object
     */
    public function createOrUpdateMetafield(ShopifyProduct $product, ShopifyMetafield $metafield)
    {
        $serializedModel = ['metafield' => array_merge($this->serializeModel($metafield))];

        $raw = $this->client->post("{$this->getApiBasePath()}/products/{$product->getId()}/metafields.json", [], $serializedModel);

        return $this->unserializeModel($raw['metafield'], ShopifyMetafield::class);
    }

    /**
     * @param ShopifyProduct $product
     * @param array          $filter
     *
     * @return Collection
     */
    public function getMetafields(ShopifyProduct $product, $filter = [])
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/products/{$product->getId()}/metafields.json", $filter);

        $metafields = array_map(function ($metafield) {
            return $this->unserializeModel($metafield, ShopifyMetafield::class);
        }, $raw['metafields']);

        return new Collection($metafields);
    }

    /**
     * @param                $id
     * @param ShopifyProduct $product
     *
     * @return ShopifyMetafield | object
     */
    public function getMetafield(ShopifyProduct $product, $id)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/products/{$product->getId()}/metafields/$id.json");

        return $this->unserializeModel($raw['metafield'], ShopifyMetafield::class);
    }

    /**
     * @param ShopifyProduct   $product
     * @param ShopifyMetafield $metafield
     *
     * @return array | null
     */
    public function deleteMetafield(ShopifyProduct $product, ShopifyMetafield $metafield)
    {
        return $this->client->delete("{$this->getApiBasePath()}/products/{$product->getId()}/metafields/{$metafield->getId()}.json");
    }

    /**
     * @param int $metafieldId
     *
     * @return array | null
     */
    public function deleteMetafieldById($metafieldId)
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
     * @param array $data
     *
     * @return Collection | null
     */
    protected function unserializeVariants($data)
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
     * @param array $data
     *
     * @return Collection | null
     */
    protected function unserializeOptions($data)
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
     * @param array $data
     *
     * @return ShopifyImage | object
     */
    protected function unserializeImage($data)
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
     * @param array $data
     *
     * @return Collection | null
     */
    protected function unserializeImages($data)
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
    protected function unserializeMetafields($data)
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
