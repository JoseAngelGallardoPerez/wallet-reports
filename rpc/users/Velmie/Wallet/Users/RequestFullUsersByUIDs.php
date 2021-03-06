<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: users.proto

namespace Velmie\Wallet\Users;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;
use Google\Protobuf\Internal\GPBWrapperUtils;

/**
 * Generated from protobuf message <code>velmie.wallet.users.RequestFullUsersByUIDs</code>
 */
class RequestFullUsersByUIDs extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>repeated string UIDs = 1;</code>
     */
    private $UIDs;
    /**
     * use ":" to  fetch nested fields, e.g. "UserDetails:Fax"
     *
     * Generated from protobuf field <code>repeated string fields = 2;</code>
     */
    private $fields;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string[]|\Google\Protobuf\Internal\RepeatedField $UIDs
     *     @type string[]|\Google\Protobuf\Internal\RepeatedField $fields
     *           use ":" to  fetch nested fields, e.g. "UserDetails:Fax"
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Users::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>repeated string UIDs = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getUIDs()
    {
        return $this->UIDs;
    }

    /**
     * Generated from protobuf field <code>repeated string UIDs = 1;</code>
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
     * use ":" to  fetch nested fields, e.g. "UserDetails:Fax"
     *
     * Generated from protobuf field <code>repeated string fields = 2;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * use ":" to  fetch nested fields, e.g. "UserDetails:Fax"
     *
     * Generated from protobuf field <code>repeated string fields = 2;</code>
     * @param string[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setFields($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->fields = $arr;

        return $this;
    }

}

