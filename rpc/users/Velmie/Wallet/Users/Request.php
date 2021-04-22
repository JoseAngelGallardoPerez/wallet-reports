<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: users.proto

namespace Velmie\Wallet\Users;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;
use Google\Protobuf\Internal\GPBWrapperUtils;

/**
 * Generated from protobuf message <code>velmie.wallet.users.Request</code>
 */
class Request extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string UID = 1;</code>
     */
    private $UID = '';
    /**
     * Generated from protobuf field <code>string AccessToken = 2;</code>
     */
    private $AccessToken = '';
    /**
     * Generated from protobuf field <code>string username = 3;</code>
     */
    private $username = '';
    /**
     * Generated from protobuf field <code>string roleName = 4;</code>
     */
    private $roleName = '';
    /**
     * Generated from protobuf field <code>repeated string UIDs = 5;</code>
     */
    private $UIDs;
    /**
     * Generated from protobuf field <code>uint64 GroupId = 6;</code>
     */
    private $GroupId = 0;
    /**
     * Generated from protobuf field <code>uint64 ClassId = 7;</code>
     */
    private $ClassId = 0;
    /**
     * Generated from protobuf field <code>string TmpAuthToken = 8;</code>
     */
    private $TmpAuthToken = '';
    /**
     * Generated from protobuf field <code>string ParentUID = 9;</code>
     */
    private $ParentUID = '';
    /**
     * Generated from protobuf field <code>repeated string SearchColumns = 10;</code>
     */
    private $SearchColumns;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $UID
     *     @type string $AccessToken
     *     @type string $username
     *     @type string $roleName
     *     @type string[]|\Google\Protobuf\Internal\RepeatedField $UIDs
     *     @type int|string $GroupId
     *     @type int|string $ClassId
     *     @type string $TmpAuthToken
     *     @type string $ParentUID
     *     @type string[]|\Google\Protobuf\Internal\RepeatedField $SearchColumns
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
     * Generated from protobuf field <code>string AccessToken = 2;</code>
     * @return string
     */
    public function getAccessToken()
    {
        return $this->AccessToken;
    }

    /**
     * Generated from protobuf field <code>string AccessToken = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setAccessToken($var)
    {
        GPBUtil::checkString($var, True);
        $this->AccessToken = $var;

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
     * Generated from protobuf field <code>string roleName = 4;</code>
     * @return string
     */
    public function getRoleName()
    {
        return $this->roleName;
    }

    /**
     * Generated from protobuf field <code>string roleName = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setRoleName($var)
    {
        GPBUtil::checkString($var, True);
        $this->roleName = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>repeated string UIDs = 5;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getUIDs()
    {
        return $this->UIDs;
    }

    /**
     * Generated from protobuf field <code>repeated string UIDs = 5;</code>
     * @param string[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setUIDs($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->UIDs = $arr;

        return $this;
    }

    /**
     * Generated from protobuf field <code>uint64 GroupId = 6;</code>
     * @return int|string
     */
    public function getGroupId()
    {
        return $this->GroupId;
    }

    /**
     * Generated from protobuf field <code>uint64 GroupId = 6;</code>
     * @param int|string $var
     * @return $this
     */
    public function setGroupId($var)
    {
        GPBUtil::checkUint64($var);
        $this->GroupId = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>uint64 ClassId = 7;</code>
     * @return int|string
     */
    public function getClassId()
    {
        return $this->ClassId;
    }

    /**
     * Generated from protobuf field <code>uint64 ClassId = 7;</code>
     * @param int|string $var
     * @return $this
     */
    public function setClassId($var)
    {
        GPBUtil::checkUint64($var);
        $this->ClassId = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string TmpAuthToken = 8;</code>
     * @return string
     */
    public function getTmpAuthToken()
    {
        return $this->TmpAuthToken;
    }

    /**
     * Generated from protobuf field <code>string TmpAuthToken = 8;</code>
     * @param string $var
     * @return $this
     */
    public function setTmpAuthToken($var)
    {
        GPBUtil::checkString($var, True);
        $this->TmpAuthToken = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string ParentUID = 9;</code>
     * @return string
     */
    public function getParentUID()
    {
        return $this->ParentUID;
    }

    /**
     * Generated from protobuf field <code>string ParentUID = 9;</code>
     * @param string $var
     * @return $this
     */
    public function setParentUID($var)
    {
        GPBUtil::checkString($var, True);
        $this->ParentUID = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>repeated string SearchColumns = 10;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getSearchColumns()
    {
        return $this->SearchColumns;
    }

    /**
     * Generated from protobuf field <code>repeated string SearchColumns = 10;</code>
     * @param string[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setSearchColumns($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->SearchColumns = $arr;

        return $this;
    }

}

