<?php


namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\User as ShopifyUser;
use Illuminate\Support\Collection;


class User extends Base
{

    /**
     * @var array
     * Key: JSON name
     * Value: PHP Variable name (string)
     */
    protected $nameMap = [
        'phone_validated?' => 'phoneValidated',
        'tfa_enabled?' => 'tfaEnabled',
    ];

    /**
     * @return Collection of ShopifyUser
     */
    public function getAll()
    {
        $raw = $this->client->get("admin/users.json");
        $users = array_map(function ($user) {
            return $this->unserializeModel($user, ShopifyUser::class);
        }, $raw['users']);
        return new Collection($users);
    }

    /**
     * @return ShopifyUser|null
     */
    public function get($id)
    {
        $raw = $this->client->get("admin/users/$id.json");
        return $this->unserializeModel($raw['user'], ShopifyUser::class);
    }

    /**
     * @return ShopifyUser|null
     */
    public function current()
    {
        $raw = $this->client->get("admin/users/current.json");
        return $this->unserializeModel($raw['user'], ShopifyUser::class);
    }
}