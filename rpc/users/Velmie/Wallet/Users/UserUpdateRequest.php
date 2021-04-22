<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: users.proto

namespace Velmie\Wallet\Users;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;
use Google\Protobuf\Internal\GPBWrapperUtils;

/**
 * Generated from protobuf message <code>velmie.wallet.users.UserUpdateRequest</code>
 */
class UserUpdateRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string UID = 1;</code>
     */
    private $UID = '';
    /**
     * Generated from protobuf field <code>string Email = 2;</code>
     */
    private $Email = '';
    /**
     * Generated from protobuf field <code>string PhoneNumber = 3;</code>
     */
    private $PhoneNumber = '';
    /**
     * Generated from protobuf field <code>string FirstName = 4;</code>
     */
    private $FirstName = '';
    /**
     * Generated from protobuf field <code>string LastName = 5;</code>
     */
    private $LastName = '';
    /**
     * Generated from protobuf field <code>repeated .velmie.wallet.users.Attribute attributes = 6;</code>
     */
    private $attributes;
    /**
     * Generated from protobuf field <code>repeated .velmie.wallet.users.Address mailingAddresses = 7;</code>
     */
    private $mailingAddresses;
    /**
     * Generated from protobuf field <code>repeated .velmie.wallet.users.Address physicalAddresses = 8;</code>
     */
    private $physicalAddresses;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $UID
     *     @type string $Email
     *     @type string $PhoneNumber
     *     @type string $FirstName
     *     @type string $LastName
     *     @type \Velmie\Wallet\Users\Attribute[]|\Google\Protobuf\Internal\RepeatedField $attributes
     *     @type \Velmie\Wallet\Users\Address[]|\Google\Protobuf\Internal\RepeatedField $mailingAddresses
     *     @type \Velmie\Wallet\Users\Address[]|\Google\Protobuf\Internal\RepeatedField $physicalAddresses
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Users::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string UID = 1;</code>
     * @return string
     */
    public function getUID()
    {
        return $this->UID;
    }

    /**
     * Generated from protobuf field <code>string UID = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setUID($var)
    {
        GPBUtil::checkString($var, True);
        $this->UID = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string Email = 2;</code>
     * @return string
     */
    public function getEmail()
    {
        return $this->Email;
    }

    /**
     * Generated from protobuf field <code>string Email = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setEmail($var)
    {
        GPBUtil::checkString($var, True);
        $this->Email = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string PhoneNumber = 3;</code>
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->PhoneNumber;
    }

    /**
     * Generated from protobuf field <code>string PhoneNumber = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setPhoneNumber($var)
    {
        GPBUtil::checkString($var, True);
        $this->PhoneNumber = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string FirstName = 4;</code>
     * @return string
     */
    public function getFirstName()
    {
        return $this->FirstName;
    }

    /**
     * Generated from protobuf field <code>string FirstName = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setFirstName($var)
    {
        GPBUtil::checkString($var, True);
        $this->FirstName = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string LastName = 5;</code>
     * @return string
     */
    public function getLastName()
    {
        return $this->LastName;
    }

    /**
     * Generated from protobuf field <code>string LastName = 5;</code>
     * @param string $var
     * @return $this
     */
    public function setLastName($var)
    {
        GPBUtil::checkString($var, True);
        $this->LastName = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>repeated .velmie.wallet.users.Attribute attributes = 6;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Generated from protobuf field <code>repeated .velmie.wallet.users.Attribute attributes = 6;</code>
     * @param \Velmie\Wallet\Users\Attribute[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setAttributes($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Velmie\Wallet\Users\Attribute::class);
        $this->attributes = $arr;

        return $this;
    }

    /**
     * Generated from protobuf field <code>repeated .velmie.wallet.users.Address mailingAddresses = 7;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getMailingAddresses()
    {
        return $this->mailingAddresses;
    }

    /**
     * Generated from protobuf field <code>repeated .velmie.wallet.users.Address mailingAddresses = 7;</code>
     * @param \Velmie\Wallet\Users\Address[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setMailingAddresses($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Velmie\Wallet\Users\Address::class);
        $this->mailingAddresses = $arr;

        return $this;
    }

    /**
     * Generated from protobuf field <code>repeated .velmie.wallet.users.Address physicalAddresses = 8;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getPhysicalAddresses()
    {
        return $this->physicalAddresses;
    }

    /**
     * Generated from protobuf field <code>repeated .velmie.wallet.users.Address physicalAddresses = 8;</code>
     * @param \Velmie\Wallet\Users\Address[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setPhysicalAddresses($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Velmie\Wallet\Users\Address::class);
        $this->physicalAddresses = $arr;

        return $this;
    }

}
