<?php

namespace BoldApps\ShopifyToolkit\Services;

class GraphQL extends base
{
    public function query($query, $variables = [])
    {
        return $this->client->post("{$this->getApiBasePath()}/graphql.json", [], ['query' => $query, 'variables' => $variables]);
    }
}
