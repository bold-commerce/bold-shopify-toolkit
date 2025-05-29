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
     * @param array $array
     *
     * @return object
     */
    public function createFromArray($array)
    {
        return $this->unserializeModel($array, ShopifyProduct::class);
    }

    public function getByParams($params)
    {
        throw new \Exception('Deprecated method. Use GQL toolkit instead.');
    }
}
