<?php

namespace BoldApps\ShopifyToolkit\Services;

class GraphQL extends Base
{
    public function query($query, $variables = [])
    {
        $data = [];
        $data['query'] = $query;
        if (!empty($variables)) {
            $data['variables'] = $variables;
        }
        return $this->client->post("{$this->getApiBasePath()}/graphql.json", [], $data);
    }
}
