<?php

namespace BoldApps\ShopifyToolkit\Traits;

use Illuminate\Support\Str;

/**
 * Based off of HasAttributes from Eloquent:
 * https://github.com/laravel/framework/blob/16983a689d15333e7101457c3e0c0d0b7da01d69/src/Illuminate/Database/Eloquent/Concerns/HasAttributes.php.
 */
trait HasAttributesTrait
{
    public function __get($name)
    {
        if ($this->hasGetMutator($name)) {
            return $this->{'get'.Str::studly($name)}();
        }
    }

    public function __isset($name)
    {
        return $this->hasGetMutator($name) && $this->{'get'.Str::studly($name)}() !== null;
    }

    public function hasGetMutator($name)
    {
        if (!$name) {
            return false;
        }

        return method_exists($this, 'get'.Str::studly($name));
    }
}
