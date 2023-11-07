<?php

namespace BoldApps\ShopifyToolkit\Services;

class GraphQL extends Base
{
    public function query($query, $variables = [])
    {
        return $this->client->post("{$this->getApiBasePath()}/graphql.json", [], ['query' => $query, 'variables' => $variables]);
    }
}
