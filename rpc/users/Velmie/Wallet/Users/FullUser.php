<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: users.proto

namespace Velmie\Wallet\Users;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;
use Google\Protobuf\Internal\GPBWrapperUtils;

/**
 * Generated from protobuf message <code>velmie.wallet.users.FullUser</code>
 */
class FullUser extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string uid = 1;</code>
     */
    private $uid = '';
    /**
     * Generated from protobuf field <code>string email = 2;</code>
     */
    private $email = '';
    /**
     * Generated from protobuf field <code>string username = 3;</code>
     */
    private $username = '';
    /**
     * Generated from protobuf field <code>string password = 4;</code>
     */
    private $password = '';
    /**
     * Generated from protobuf field <code>string first_name = 5;</code>
     */
    private $first_name = '';
    /**
     * Generated from protobuf field <code>string last_name = 6;</code>
     */
    private $last_name = '';
    /**
     * Generated from protobuf field <code>string phone_number = 7;</code>
     */
    private $phone_number = '';
    /**
     * Generated from protobuf field <code>bool is_corporate = 8;</code>
     */
    private $is_corporate = false;
    /**
     * Generated from protobuf field <code>string role_name = 9;</code>
     */
    private $role_name = '';
    /**
     * Generated from protobuf field <code>string status = 10;</code>
     */
    private $status = '';
    /**
     * Generated from protobuf field <code>uint64 user_group_id = 11;</code>
     */
    private $user_group_id = 0;
    /**
     * Generated from protobuf field <code>string created_at = 12;</code>
     */
    private $created_at = '';
    /**
     * Generated from protobuf field <code>.velmie.wallet.users.UserDetails user_details = 13;</code>
     */
    private $user_details = null;
    /**
     * Generated from protobuf field <code>.velmie.wallet.users.PhysicalAdress physical_adress = 14;</code>
     */
    private $physical_adress = null;
    /**
     * Generated from protobuf field <code>.velmie.wallet.users.BenificialOwner benificial_owner = 15;</code>
     */
    private $benificial_owner = null;
    /**
     * Generated from protobuf field <code>.velmie.wallet.users.UserGroup user_group = 16;</code>
     */
    private $user_group = null;
    /**
     * Generated from protobuf field <code>.velmie.wallet.users.Company company_details = 17;</code>
     */
    private $company_details = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $uid
     *     @type string $email
     *     @type string $username
     *     @type string $password
     *     @type string $first_name
     *     @type string $last_name
     *     @type string $phone_number
     *     @type bool $is_corporate
     *     @type string $role_name
     *     @type string $status
     *     @type int|string $user_group_id
     *     @type string $created_at
     *     @type \Velmie\Wallet\Users\UserDetails $user_details
     *     @type \Velmie\Wallet\Users\PhysicalAdress $physical_adress
     *     @type \Velmie\Wallet\Users\BenificialOwner $benificial_owner
     *     @type \Velmie\Wallet\Users\UserGroup $user_group
     *     @type \Velmie\Wallet\Users\Company $company_details
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Users::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string uid = 1;</code>
     * @return string
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Generated from protobuf field <code>string uid = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setUid($var)
    {
        GPBUtil::checkString($var, True);
        $this->uid = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string email = 2;</code>
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Generated from protobuf field <code>string email = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setEmail($var)
    {
        GPBUtil::checkString($var, True);
        $this->email = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string username = 3;</code>
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Generated from protobuf field <code>string username = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setUsername($var)
    {
        GPBUtil::checkString($var, True);
        $this->username = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string password = 4;</code>
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Generated from protobuf field <code>string password = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setPassword($var)
    {
        GPBUtil::checkString($var, True);
        $this->password = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string first_name = 5;</code>
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Generated from protobuf field <code>string first_name = 5;</code>
     * @param string $var
     * @return $this
     */
    public function setFirstName($var)
    {
        GPBUtil::checkString($var, True);
        $this->first_name = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string last_name = 6;</code>
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Generated from protobuf field <code>string last_name = 6;</code>
     * @param string $var
     * @return $this
     */
    public function setLastName($var)
    {
        GPBUtil::checkString($var, True);
        $this->last_name = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string phone_number = 7;</code>
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    /**
     * Generated from protobuf field <code>string phone_number = 7;</code>
     * @param string $var
     * @return $this
     */
    public function setPhoneNumber($var)
    {
        GPBUtil::checkString($var, True);
        $this->phone_number = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>bool is_corporate = 8;</code>
     * @return bool
     */
    public function getIsCorporate()
    {
        return $this->is_corporate;
    }

    /**
     * Generated from protobuf field <code>bool is_corporate = 8;</code>
     * @param bool $var
     * @return $this
     */
    public function setIsCorporate($var)
    {
        GPBUtil::checkBool($var);
        $this->is_corporate = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string role_name = 9;</code>
     * @return string
     */
    public function getRoleName()
    {
        return $this->role_name;
    }

    /**
     * Generated from protobuf field <code>string role_name = 9;</code>
     * @param string $var
     * @return $this
     */
    public function setRoleName($var)
    {
        GPBUtil::checkString($var, True);
        $this->role_name = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string status = 10;</code>
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Generated from protobuf field <code>string status = 10;</code>
     * @param string $var
     * @return $this
     */
    public function setStatus($var)
    {
        GPBUtil::checkString($var, True);
        $this->status = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>uint64 user_group_id = 11;</code>
     * @return int|string
     */
    public function getUserGroupId()
    {
        return $this->user_group_id;
    }

    /**
     * Generated from protobuf field <code>uint64 user_group_id = 11;</code>
     * @param int|string $var
     * @return $this
     */
    public function setUserGroupId($var)
    {
        GPBUtil::checkUint64($var);
        $this->user_group_id = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string created_at = 12;</code>
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Generated from protobuf field <code>string created_at = 12;</code>
     * @param string $var
     * @return $this
     */
    public function setCreatedAt($var)
    {
        GPBUtil::checkString($var, True);
        $this->created_at = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.velmie.wallet.users.UserDetails user_details = 13;</code>
     * @return \Velmie\Wallet\Users\UserDetails
     */
    public function getUserDetails()
    {
        return $this->user_details;
    }

    /**
     * Generated from protobuf field <code>.velmie.wallet.users.UserDetails user_details = 13;</code>
     * @param \Velmie\Wallet\Users\UserDetails $var
     * @return $this
     */
    public function setUserDetails($var)
    {
        GPBUtil::checkMessage($var, \Velmie\Wallet\Users\UserDetails::class);
        $this->user_details = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.velmie.wallet.users.PhysicalAdress physical_adress = 14;</code>
     * @return \Velmie\Wallet\Users\PhysicalAdress
     */
    public function getPhysicalAdress()
    {
        return $this->physical_adress;
    }

    /**
     * Generated from protobuf field <code>.velmie.wallet.users.PhysicalAdress physical_adress = 14;</code>
     * @param \Velmie\Wallet\Users\PhysicalAdress $var
     * @return $this
     */
    public function setPhysicalAdress($var)
    {
        GPBUtil::checkMessage($var, \Velmie\Wallet\Users\PhysicalAdress::class);
        $this->physical_adress = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.velmie.wallet.users.BenificialOwner benificial_owner = 15;</code>
     * @return \Velmie\Wallet\Users\BenificialOwner
     */
    public function getBenificialOwner()
    {
        return $this->benificial_owner;
    }

    /**
     * Generated from protobuf field <code>.velmie.wallet.users.BenificialOwner benificial_owner = 15;</code>
     * @param \Velmie\Wallet\Users\BenificialOwner $var
     * @return $this
     */
    public function setBenificialOwner($var)
    {
        GPBUtil::checkMessage($var, \Velmie\Wallet\Users\BenificialOwner::class);
        $this->benificial_owner = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.velmie.wallet.users.UserGroup user_group = 16;</code>
     * @return \Velmie\Wallet\Users\UserGroup
     */
    public function getUserGroup()
    {
        return $this->user_group;
    }

    /**
     * Generated from protobuf field <code>.velmie.wallet.users.UserGroup user_group = 16;</code>
     * @param \Velmie\Wallet\Users\UserGroup $var
     * @return $this
     */
    public function setUserGroup($var)
    {
        GPBUtil::checkMessage($var, \Velmie\Wallet\Users\UserGroup::class);
        $this->user_group = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.velmie.wallet.users.Company company_details = 17;</code>
     * @return \Velmie\Wallet\Users\Company
     */
    public function getCompanyDetails()
    {
        return $this->company_details;
    }

    /**
     * Generated from protobuf field <code>.velmie.wallet.users.Company company_details = 17;</code>
     * @param \Velmie\Wallet\Users\Company $var
     * @return $this
     */
    public function setCompanyDetails($var)
    {
        GPBUtil::checkMessage($var, \Velmie\Wallet\Users\Company::class);
        $this->company_details = $var;

        return $this;
    }

}
