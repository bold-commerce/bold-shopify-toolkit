<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\LineItem as LineItemModel;
use BoldApps\ShopifyToolkit\Models\Variant as VariantModel;
use BoldApps\ShopifyToolkit\Services\Client as ShopifyClient;
use BoldApps\ShopifyToolkit\Services\Variant as VariantService;

/**
 * Class LineItem.
 */
class LineItem extends Base
{
    /**
     * @var Variant
     */
    protected $variantService;

    /**
     * @var array
     */
    protected $unserializationExceptions = [
        'platform_variant' => 'unserializePlatformVariant',
    ];

    /**
     * @var array
     */
    protected $serializationExceptions = [];

    /**
     * LineItem constructor.
     *
     * @param Client  $client
     * @param Variant $variantService
     */
    public function __construct(ShopifyClient $client, VariantService $variantService)
    {
        $this->variantService = $variantService;
        parent::__construct($client);
    }

    public function createFromArray($array)
    {
        return $this->unserializeModel($array, LineItemModel::class);
    }

    /**
     * @param array $data
     *
     * @return VariantModel
     */
    protected function unserializePlatformVariant($data)
    {
        if (null === $data) {
            return;
        }

        return $this->variantService->unserializeModel($data, VariantModel::class);
    }
}
