<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\Country;
use BoldApps\ShopifyToolkit\Models\Province;
use BoldApps\ShopifyToolkit\Models\ShippingZone as ShippingZoneModel;
use Illuminate\Support\Collection;

class ShippingZone extends Base
{
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
        $raw = $this->client->get('admin/shipping_zones.json', array_merge([
            'page' => $page,
            'limit' => $limit,
        ], $filter));

        $shippingZones = array_map(function ($zone) {
            $zone['countries'] = $this->unserializeCountries($zone['countries']);

            return $this->unserializeModel($zone, ShippingZoneModel::class);
        }, $raw['shipping_zones']);

        return collect($shippingZones);
    }

    /**
     * @param array $params
     *
     * @return Collection
     */
    public function getByParams($params = [])
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/shipping_zones.json", $params);

        $shippingZones = array_map(function ($zone) {
            $zone['countries'] = $this->unserializeCountries($zone['countries']);

            return $this->unserializeModel($zone, ShippingZoneModel::class);
        }, $raw['shipping_zones']);

        return collect($shippingZones);
    }

    /**
     * @return Collection
     */
    public function unserializeCountries($data)
    {
        if (null === $data) {
            return;
        }
        $countries = array_map(function ($country) {
            $country['provinces'] = $this->unserializeProvinces($country['provinces']);

            return $this->unserializeModel($country, Country::class);
        }, $data);

        return collect($countries);
    }

    /**
     * @return Collection
     */
    public function unserializeProvinces($data)
    {
        if (null === $data) {
            return;
        }
        $provinces = array_map(function ($province) {
            return $this->unserializeModel($province, Province::class);
        }, $data);

        return collect($provinces);
    }
}
