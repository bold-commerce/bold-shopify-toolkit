<?php

namespace BoldApps\ShopifyToolkit\Models;

use BoldApps\ShopifyToolkit\Contracts\Serializeable;
use BoldApps\ShopifyToolkit\Traits\HasAttributesTrait;

class User implements Serializeable, \JsonSerializable
{
    use HasAttributesTrait;

    /** @var int */
    protected $id;

    /** @var string */
    protected $firstName;

    /** @var string */
    protected $lastName;

    /** @var string */
    protected $email;

    /** @var string */
    protected $url;

    /** @var string */
    protected $im;

    /** @var string */
    protected $screenName;

    /** @var string */
    protected $phone;

    /** @var bool */
    protected $accountOwner;

    /** @var int */
    protected $receiveAnnouncements;

    /** @var string */
    protected $bio;

    /** @var array */
    protected $permissions;

    /** @var string */
    protected $userType;

    /** @var bool */
    protected $phoneValidated;

    /** @var bool */
    protected $tfaEnabled;

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
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getIm()
    {
        return $this->im;
    }

    /**
     * @param string $im
     */
    public function setIm($im)
    {
        $this->im = $im;
    }

    /**
     * @return string
     */
    public function getScreenName()
    {
        return $this->screenName;
    }

    /**
     * @param string $screenName
     */
    public function setScreenName($screenName)
    {
        $this->screenName = $screenName;
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
     * @return bool
     */
    public function getAccountOwner()
    {
        return $this->accountOwner;
    }

    /**
     * @param bool $accountOwner
     */
    public function setAccountOwner($accountOwner)
    {
        $this->accountOwner = $accountOwner;
    }

    /**
     * @return int
     */
    public function getReceiveAnnouncements()
    {
        return $this->receiveAnnouncements;
    }

    /**
     * @param int $receiveAnnouncements
     */
    public function setReceiveAnnouncements($receiveAnnouncements)
    {
        $this->receiveAnnouncements = $receiveAnnouncements;
    }

    /**
     * @return string
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * @param string $bio
     */
    public function setBio($bio)
    {
        $this->bio = $bio;
    }

    /**
     * @return array
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * @param array $permissions
     */
    public function setPermissions($permissions)
    {
        $this->permissions = $permissions;
    }

    /**
     * @return string
     */
    public function getUserType()
    {
        return $this->userType;
    }

    /**
     * @param string $userType
     */
    public function setUserType($userType)
    {
        $this->userType = $userType;
    }

    /**
     * @return bool
     */
    public function getPhoneValidated()
    {
        return $this->phoneValidated;
    }

    /**
     * @param bool $phoneValidated
     */
    public function setPhoneValidated($phoneValidated)
    {
        $this->phoneValidated = $phoneValidated;
    }

    /**
     * @return bool
     */
    public function getTfaEnabled()
    {
        return $this->tfaEnabled;
    }

    /**
     * @param bool $tfaEnabled
     */
    public function setTfaEnabled($tfaEnabled)
    {
        $this->tfaEnabled = $tfaEnabled;
    }
}
