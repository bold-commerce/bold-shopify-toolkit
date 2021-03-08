<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Exceptions\BadRequestException;
use BoldApps\ShopifyToolkit\Exceptions\NotAcceptableException;
use BoldApps\ShopifyToolkit\Exceptions\NotFoundException;
use BoldApps\ShopifyToolkit\Exceptions\ShopifyException;
use BoldApps\ShopifyToolkit\Exceptions\TooManyRequestsException;
use BoldApps\ShopifyToolkit\Exceptions\UnauthorizedException;
use BoldApps\ShopifyToolkit\Exceptions\UnprocessableEntityException;
use BoldApps\ShopifyToolkit\Models\DiscountCode as ShopifyDiscountCode;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;

class DiscountCode extends Base
{
    /**
     * @return ShopifyDiscountCode | object
     *
     * @throws ShopifyException
     * @throws GuzzleException
     */
    public function create(ShopifyDiscountCode $discountCode)
    {
        $serializedModel = ['discount_code' => $this->serializeModel($discountCode)];
        $priceRuleId = $discountCode->getPriceRuleId();
        $raw = $this->client->post("{$this->getApiBasePath()}/price_rules/$priceRuleId/discount_codes.json", [], $serializedModel);

        return $this->unserializeModel($raw['discount_code'], ShopifyDiscountCode::class);
    }

    /**
     * @param $array
     *
     * @return object
     */
    public function createFromArray(array $array)
    {
        return $this->unserializeModel($array, ShopifyDiscountCode::class);
    }

    /**
     * @return Collection
     *
     * @throws ShopifyException
     * @throws GuzzleException
     */
    public function getAllByPriceRuleId(int $priceRuleId, array $filter = [])
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/price_rules/$priceRuleId/discount_codes.json", $filter);

        $discountCodes = array_map(function ($discountCode) {
            return $this->unserializeModel($discountCode, ShopifyDiscountCode::class);
        }, $raw['discount_codes']);

        return new Collection($discountCodes);
    }

    /**
     * @return ShopifyDiscountCode | object
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function getByDiscountCodeId(int $priceRuleId, int $discountCodeId)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/price_rules/$priceRuleId/discount_codes/$discountCodeId.json");

        return $this->unserializeModel($raw['discount_code'], ShopifyDiscountCode::class);
    }

    /**
     * @return ShopifyDiscountCode | object | null
     *
     * @throws GuzzleException
     * @throws ShopifyException
     * @throws BadRequestException
     * @throws NotAcceptableException
     * @throws NotFoundException
     * @throws TooManyRequestsException
     * @throws UnauthorizedException
     * @throws UnprocessableEntityException
     */
    public function lookup(string $discountCode)
    {
        $result = null;
        $redirectLocation = $this->client->getRedirectLocation("{$this->getApiBasePath()}/discount_codes/lookup.json", ['code' => $discountCode]);

        if (!empty($redirectLocation)) {
            $raw = $this->client->get($redirectLocation);
            $result = $this->unserializeModel($raw['discount_code'], ShopifyDiscountCode::class);
        }

        return $result;
    }

    /**
     * @return object
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function update(ShopifyDiscountCode $discountCode)
    {
        $serializedModel = ['price_rule' => $this->serializeModel($discountCode)];
        $priceRuleId = $discountCode->getPriceRuleId();
        $raw = $this->client->put("{$this->getApiBasePath()}/price_rules/$priceRuleId/{$discountCode->getId()}.json", [], $serializedModel);

        return $this->unserializeModel($raw['price_rule'], ShopifyDiscountCode::class);
    }

    /**
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function delete(ShopifyDiscountCode $discountCode): array
    {
        $priceRuleId = $discountCode->getPriceRuleId();

        return $this->client->delete("{$this->getApiBasePath()}/price_rules/$priceRuleId/discount_codes/{$discountCode->getId()}.json");
    }
}
