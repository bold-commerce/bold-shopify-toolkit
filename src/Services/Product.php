<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\Metafield as ShopifyMetafield;
use BoldApps\ShopifyToolkit\Models\Product as ShopifyProduct;
use BoldApps\ShopifyToolkit\Models\Product as ProductModel;
use BoldApps\ShopifyToolkit\Models\Variant as VariantModel;
use BoldApps\ShopifyToolkit\Models\Option as OptionModel;
use BoldApps\ShopifyToolkit\Models\Image as ImageModel;
use BoldApps\ShopifyToolkit\Services\Client as ShopifyClient;
use BoldApps\ShopifyToolkit\Services\Variant as VariantService;
use BoldApps\ShopifyToolkit\Services\Option as OptionService;
use BoldApps\ShopifyToolkit\Services\Image as ImageService;
use BoldApps\ShopifyToolkit\Services\Metafield as MetafieldService;
use Illuminate\Support\Collection;

/**
 * Class Product.
 */
class Product extends CollectionEntity
{
    /**
     * @var Variant
     */
    protected $variantService;
    /**
     * @var Option
     */
    protected $optionService;
    /**
     * @var Image
     */
    protected $imageService;

    /**
     * @var Metafield
     */
    protected $metafieldService;

    /**
     * @var array
     */
    protected $unserializationExceptions = [
        'variants' => 'unserializeVariants',
        'options' => 'unserializeOptions',
        'image' => 'unserializeImage',
        'images' => 'unserializeImages',
        'metafields' => 'unserializeMetafields',
    ];

    /**
     * @var array
     */
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

        $raw = $this->client->post('admin/products.json', [], $serializedModel);

        return $this->unserializeModel($raw['product'], ShopifyProduct::class);
    }

    /**
     * @param $id
     * @param $filter
     *
     * @return ShopifyProduct
     */
    public function getById($id, $filter = [])
    {
        $raw = $this->client->get("admin/products/$id.json", $filter);

        return $this->unserializeModel($raw['product'], ShopifyProduct::class);
    }

    /**
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
     * @param $parms
     *
     * @return \Illuminate\Support\Collection
     */
    public function getByParams($parms)
    {
        $raw = $this->client->get('admin/products.json', $parms);

        $products = array_map(function ($product) {
            return $this->unserializeModel($product, ShopifyProduct::class);
        }, $raw['products']);

        return new Collection($products);
    }

    /**
     * @param $productIds
     * @param array $filter
     *
     * @return Collection
     */
    public function getByProductIdArray($productIds, $filter = [])
    {
        $products = [];
        $limit = 250;

        for ($i = 0; $i < ceil(count($productIds) / $limit); ++$i) {
            $sliced_ids = implode(',', array_slice($productIds, ($i * $limit), $limit));

            $params = array_merge(
                $filter,
                [
                    'ids' => $sliced_ids,
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

        $raw = $this->client->put("admin/products/{$product->getId()}.json", [], $serializedModel);

        return $this->unserializeModel($raw['product'], ShopifyProduct::class);
    }

    /**
     * @param ShopifyProduct $product
     *
     * @return object
     */
    public function delete(ShopifyProduct $product)
    {
        return $this->client->delete("admin/products/{$product->getId()}.json");
    }

    /**
     * @param array $filter
     *
     * @return int
     */
    public function count($filter = [])
    {
        $raw = $this->client->get('admin/products/count.json', $filter);

        return $raw['count'];
    }

    /**
     * @param $filter
     *
     * @return int
     */
    public function countByParams($filter = [])
    {
        $raw = $this->client->get('admin/products/count.json', $filter);

        return $raw['count'];
    }

    /**
     * @param $array
     * @return object
     */
    public function createFromArray($array)
    {
        return $this->unserializeModel($array, ProductModel::class);
    }

    /**
     * @param ShopifyProduct $product
     *
     * @return Collection
     */
    public function createOrUpdateMetafield(ShopifyProduct $product, ShopifyMetafield $metafield)
    {
        $serializedModel = ['metafield' => array_merge($this->serializeModel($metafield))];

        $raw = $this->client->post("admin/products/{$product->getId()}/metafields.json", [], $serializedModel);

        return $this->unserializeModel($raw['metafield'], ShopifyMetafield::class);
    }

    /**
     * @param ShopifyProduct $product
     * @param $filter
     *
     * @return Collection
     */
    public function getMetafields(ShopifyProduct $product, $filter = [])
    {
        $raw = $this->client->get("admin/products/{$product->getId()}/metafields.json", $filter);

        $metafields = array_map(function ($metafield) {
            return $this->unserializeModel($metafield, ShopifyMetafield::class);
        }, $raw['metafields']);

        return new Collection($metafields);
    }

    /**
     * @param ShopifyProduct $product
     *
     * @return Collection
     */
    public function getMetafield(ShopifyProduct $product, $id)
    {
        $raw = $this->client->get("admin/products/{$product->getId()}/metafields/$id.json");

        return $this->unserializeModel($raw['metafield'], ShopifyMetafield::class);
    }

    /**
     * @param ShopifyProduct $product
     *
     * @return Collection
     */
    public function deleteMetafield(ShopifyProduct $product, ShopifyMetafield $metafield)
    {
        return $this->client->delete("admin/products/{$product->getId()}/metafields/{$metafield->getId()}.json");
    }

    /**
     * @param int $metafieldId
     */
    public function deleteMetafieldById($metafieldId)
    {
        $this->client->delete("admin/metafields/{$metafieldId}.json");
    }

    /**
     * @param $entities
     *
     * @return array|null
     */
    protected function serializeVariants($entities)
    {
        if (null === $entities) {
            return;
        }

        $variantService = &$this->variantService;

        if ($entities instanceof Collection) {
            return $entities->map(function ($entity) use ($variantService) {
                return $variantService->serializeModel($entity);
            })->toArray();
        }

        return $entities;
    }

    /**
     * @param array $data
     *
     * @return Collection
     */
    protected function unserializeVariants($data)
    {
        if (null === $data) {
            return;
        }

        $variantService = &$this->variantService;

        $variants = array_map(function ($variant) use ($variantService) {
            return $variantService->unserializeModel($variant, VariantModel::class);
        }, $data);

        return new Collection($variants);
    }

    /**
     * @param $entities
     *
     * @return array|null
     */
    protected function serializeOptions($entities)
    {
        if (null === $entities) {
            return;
        }

        $optionService = &$this->optionService;

        if ($entities instanceof Collection) {
            return $entities->map(function ($entity) use ($optionService) {
                return $optionService->serializeModel($entity);
            })->toArray();
        }

        return $entities;
    }

    /**
     * @param array $data
     *
     * @return Collection
     */
    protected function unserializeOptions($data)
    {
        if (null === $data) {
            return;
        }

        $optionService = &$this->optionService;

        $options = array_map(function ($option) use ($optionService) {
            return $optionService->unserializeModel($option, OptionModel::class);
        }, $data);

        return new Collection($options);
    }

    /**
     * @param $entity
     *
     * @return array|null
     */
    protected function serializeImage($entity)
    {
        if (null === $entity) {
            return;
        }

        return $this->optionService->serializeModel($entity);
    }

    /**
     * @param array $data
     *
     * @return object
     */
    protected function unserializeImage($data)
    {
        if (null === $data) {
            return;
        }

        return $this->imageService->unserializeModel($data, ImageModel::class);
    }

    /**
     * @param $entities
     *
     * @return array|null
     */
    protected function serializeImages($entities)
    {
        if (null === $entities) {
            return;
        }

        $imageService = &$this->imageService;

        if ($entities instanceof Collection) {
            return $entities->map(function ($entity) use ($imageService) {
                return $imageService->serializeModel($entity);
            })->toArray();
        }

        return $entities;
    }

    /**
     * @param array $data
     *
     * @return Collection
     */
    protected function unserializeImages($data)
    {
        if (null === $data) {
            return;
        }

        $imageService = &$this->imageService;

        $images = array_map(function ($image) use ($imageService) {
            return $imageService->unserializeModel($image, ImageModel::class);
        }, $data);

        return new Collection($images);
    }

    /**
     * @param $entities
     */
    protected function serializeMetafields($entities)
    {
        if (null === $entities) {
            return;
        }

        if ($entities instanceof Collection) {
            return $entities->map(function ($entity) {
                return $this->metafieldService->serializeModel($entity);
            })->toArray();
        }
    }

    /**
     * @param $data
     * @return Collection|void
     */
    protected function unserializeMetafields($data)
    {
        if (null === $data) {
            return;
        }

        $metafields = array_map(function ($metafield) {
            return $this->metafieldService->unserializeModel($metafield, ShopifyMetafield::class);
        }, $data);

        return new Collection($metafields);
    }
}
