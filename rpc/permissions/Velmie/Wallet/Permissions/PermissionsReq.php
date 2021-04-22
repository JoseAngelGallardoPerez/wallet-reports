<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: permissions.proto

namespace Velmie\Wallet\Permissions;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;
use Google\Protobuf\Internal\GPBWrapperUtils;

/**
 * Generated from protobuf message <code>velmie.wallet.permissions.PermissionsReq</code>
 */
class PermissionsReq extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string user_id = 1;</code>
     */
    private $user_id = '';
    /**
     * Generated from protobuf field <code>repeated string action_keys = 2;</code>
     */
    private $action_keys;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $user_id
     *     @type string[]|\Google\Protobuf\Internal\RepeatedField $action_keys
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Permissions::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string user_id = 1;</code>
     * @return string
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Generated from protobuf field <code>string user_id = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setUserId($var)
    {
        GPBUtil::checkString($var, True);
        $this->user_id = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>repeated string action_keys = 2;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getActionKeys()
    {
        return $this->action_keys;
    }

    /**
     * Generated from protobuf field <code>repeated string action_keys = 2;</code>
     * @param string[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setActionKeys($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->action_keys = $arr;

        return $this;
    }

}

