<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Services\Client as ShopifyClient;

class Application extends Base
{
    /**
     * Application constructor.
     *
     * @param Client $client
     */
    public function __construct(ShopifyClient $client)
    {
        parent::__construct($client);
    }

    /**
     * @return array
     */
    public function uninstall()
    {
        return $this->client->delete('admin/api_permissions/current.json');
    }
}
