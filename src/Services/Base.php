<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Contracts\Serializeable;
use BoldApps\ShopifyToolkit\Services\Client as ShopifyClient;

/**
 * Class Base.
 */
abstract class Base
{
    /*
     *
     * TODO: Implement an ignoredFields property
     *       We should be able to ignore a specific field on the serialization process (IE: Refund.OrderId)
     *
     */


    /**
     * @var ShopifyClient
     */
    protected $client;

    /**
     * @var array
     * Key: JSON name
     * Value: PHP Variable name (string)
     */
    protected $nameMap = [];

    /**
     * @var array
     */
    protected $unserializationExceptions = [];

    /**
     * @var array
     */
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
     * @param Serializeable $entity
     *
     * @return array
     */
    public function serializeModel(Serializeable $entity)
    {
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
            return $a !== null;
        });
    }

    /**
     * @param array $data
     * @param $className
     *
     * @return object
     */
    public function unserializeModel(array $data, $className)
    {
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
     *     *
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
}
