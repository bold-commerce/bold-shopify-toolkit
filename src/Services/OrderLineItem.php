<?php

namespace BoldApps\ShopifyToolkit\Services;


use BoldApps\ShopifyToolkit\Models\TaxLine as LineItemTaxLine;
use BoldApps\ShopifyToolkit\Services\TaxLine as TaxLineService;
use Illuminate\Support\Collection;
use BoldApps\ShopifyToolkit\Services\Client as ShopifyClient;


/**
 * Class OrderLineItem.
 */
class OrderLineItem extends Base
{

    /**
     * @var TaxLine
     */
    protected $taxLineService;

    /**
     * @var array
     */
    protected $unserializationExceptions = [
        'tax_lines' => 'unserializeTaxLines',
    ];

    /**
     * @var array
     */
    protected $serializationExceptions = [
        'taxLines' => 'serializeTaxLines',
    ];

    /**
     * Order constructor.
     * @param Client $client
     * @param TaxLineService $taxLineService
     */
    public function __construct(ShopifyClient $client, TaxLineService $taxLineService)
    {
        $this->taxLineService = $taxLineService;
        parent::__construct($client);
    }

    /**
     * @param $entities
     *
     * @return array|null
     */
    protected function serializeTaxLines($entities)
    {
        if (null === $entities) {
            return;
        }

        $imageService = &$this->taxLineService;

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
    protected function unserializeTaxLines($data)
    {

        if (null === $data) {
            return;
        }

        $taxLineService = &$this->taxLineService;
        $images = array_map(function ($taxLine) use ($taxLineService) {
            return $taxLineService->unserializeModel($taxLine, LineItemTaxLine::class);
        }, $data);

        return new Collection($images);
    }



}
