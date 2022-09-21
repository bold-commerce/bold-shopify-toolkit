<?php

namespace BoldApps\ShopifyToolkit\Models;

use BoldApps\ShopifyToolkit\Contracts\Serializeable;
use BoldApps\ShopifyToolkit\Traits\HasAttributesTrait;

class Customer implements Serializeable, \JsonSerializable
{
    use HasAttributesTrait;

    /** @var int */
    protected $id;

    /** @var bool */
    protected $acceptsMarketing;

    /** @var string */
    protected $email;

    /** @var string */
    protected $firstName;

    /** @var string */
    protected $lastName;

    /** @var int */
    protected $lastOrderId;

    /** @var string */
    protected $multipassIdentifier;

    /** @var string */
    protected $note;

    /** @var int */
    protected $ordersCount;

    /** @var string */
    protected $state;

    /** @var string */
    protected $totalSpent;

    /** @var bool */
    protected $verifiedEmail;

    /** @var string */
    protected $tags;

    /** @var string */
    protected $lastOrderName;

    /** @var */
    protected $defaultAddress;

    /** @var */
    protected $addresses;

    /** @var string */
    protected $createdAt;

    /** @var string */
    protected $updatedAt;

    /** @var bool */
    protected $taxExempt;

    /** @var string */
    protected $phone;

    /** @var string */
    protected $password;

    /** @var string */
    protected $passwordConfirmation;

    /** @var bool */
    protected $sendWelcomeEmail;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return int
     */
    public function getLastOrderId()
    {
        return $this->lastOrderId;
    }

    /**
     * @return string
     */
    public function getMultipassIdentifier()
    {
        return $this->multipassIdentifier;
    }

    /**
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @return int
     */
    public function getOrdersCount()
    {
        return $this->ordersCount;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function getTotalSpent()
    {
        return $this->totalSpent;
    }

    /**
     * @return bool
     */
    public function getVerifiedEmail()
    {
        return $this->verifiedEmail;
    }

    /**
     * @return string
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @return string
     */
    public function getLastOrderName()
    {
        return $this->lastOrderName;
    }

    /**
     * @return array
     */
    public function getDefaultAddress()
    {
        return $this->defaultAddress;
    }

    /**
     * @return array
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * @return bool
     */
    public function isAcceptsMarketing()
    {
        return $this->acceptsMarketing;
    }

    /**
     * @param bool $acceptsMarketing
     */
    public function setAcceptsMarketing($acceptsMarketing)
    {
        $this->acceptsMarketing = $acceptsMarketing;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param string $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return bool
     */
    public function isTaxExempt()
    {
        return $this->taxExempt;
    }

    /**
     * @param bool $taxExempt
     */
    public function setTaxExempt($taxExempt)
    {
        $this->taxExempt = $taxExempt;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @param $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param $passwordConfirmation
     */
    public function setPasswordConfirmation($passwordConfirmation)
    {
        $this->passwordConfirmation = $passwordConfirmation;
    }

    /**
     * @param $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param bool $sendWelcomeEmail
     */
    public function setSendWelcomeEmail($sendWelcomeEmail = false)
    {
        $this->sendWelcomeEmail = $sendWelcomeEmail;
    }

    /**
     * @return bool
     */
    public function getAcceptsMarketing()
    {
        return $this->acceptsMarketing;
    }

    /**
     * @return bool
     */
    public function getTaxExempt()
    {
        return $this->taxExempt;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getPasswordConfirmation()
    {
        return $this->passwordConfirmation;
    }

    /**
     * @return bool
     */
    public function getSendWelcomeEmail()
    {
        return $this->sendWelcomeEmail;
    }

    /**
     * @param $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * @param $addresses
     */
    public function setAddresses($addresses)
    {
        $this->addresses = $addresses;
    }
}
