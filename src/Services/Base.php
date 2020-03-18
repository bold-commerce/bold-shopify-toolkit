<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Contracts\Serializeable;
use BoldApps\ShopifyToolkit\Services\Client as ShopifyClient;

abstract class Base
{
    const BASE_API_PATH = 'admin/api/%s';

    const DEFAULT_API_VERSION = '2020-04';

    /** @var string */
    protected $shopifyApiVersion = self::DEFAULT_API_VERSION;

    /*
     * TODO: Implement an ignoredFields property
     *       We should be able to ignore a specific field on the serialization process (IE: Refund.OrderId)
     */

    /** @var ShopifyClient */
    protected $client;

    /**
     * @var array
     *            Key: JSON name
     *            Value: PHP Variable name (string)
     */
    protected $nameMap = [];

    /** @var array */
    protected $unserializationExceptions = [];

    /** @var array */
    protected $serializationExceptions = [];

    /**
     * Product constructor.
     *
     * @param $client
     */
    public function __construct(ShopifyClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param Serializeable|null $entity
     *
     * @return array
     */
    public function serializeModel(Serializeable $entity = null)
    {
        if (null === $entity) {
            return null;
        }

        $arr = [];
        $class = new \ReflectionClass($entity);

        $properties = array_map(function ($property) {
            return $property->name;
        }, $class->getProperties());

        foreach ($properties as $property) {
            $value = $entity->{'get'.ucfirst($property)}();

            if (isset($this->serializationExceptions[$property])) {
                $value = $this->{$this->serializationExceptions[$property]}($value);
            }

            $propertyName = $this->getArrayPropertyName($property);

            $arr[$propertyName] = $value;
        }

        return array_filter($arr, function ($a) {
            return null !== $a;
        });
    }

    /**
     * @param array|null $data
     * @param $className
     *
     * @return object
     */
    public function unserializeModel($data, $className)
    {
        if (null === $data) {
            return null;
        }

        if (!is_array($data)) {
            throw new \InvalidArgumentException('Invalid argument $data supplied for unserializeModel. Please pass array|null.');
        }

        $class = new \ReflectionClass($className);

        $instance = $class->newInstance();

        foreach ($data as $property => $value) {
            try {
                if (isset($this->unserializationExceptions[$property])) {
                    $value = $this->{$this->unserializationExceptions[$property]}($value);
                }

                $propertyName = $this->getJsonPropertyName($property);
                $property = $class->getProperty($propertyName);
                $property->setAccessible(true);
                $property->setValue($instance, $value);
            } catch (\ReflectionException $e) {
                //dump($e);
            }
        }

        return $instance;
    }

    /**
     * @param string $property
     *
     * @return string
     */
    private function getArrayPropertyName($property)
    {
        $nameMapResult = array_search($property, $this->nameMap);
        if ($nameMapResult) {
            return $nameMapResult;
        }

        return ltrim(strtolower(preg_replace('/[A-Z]/', '_$0', $property)), '_');
    }

    /**
     * @param string $property
     *
     * @return string
     */
    private function getJsonPropertyName($property)
    {
        if (isset($this->nameMap[$property])) {
            return $this->nameMap[$property];
        }

        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $property))));
    }

    /**
     * @return string
     */
    public function getApiBasePath()
    {
        return sprintf(self::BASE_API_PATH, $this->getShopifyApiVersion());
    }

    /**
     * @return string
     */
    public function getShopifyApiVersion()
    {
        return $this->shopifyApiVersion;
    }

    /**
     * @param string $shopifyApiVersion
     */
    public function setShopifyApiVersion(string $shopifyApiVersion)
    {
        $this->shopifyApiVersion = $shopifyApiVersion;
    }
}
