<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: users.proto

namespace Velmie\Wallet\Users;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;
use Google\Protobuf\Internal\GPBWrapperUtils;

/**
 * Generated from protobuf message <code>velmie.wallet.users.DevicesRequest</code>
 */
class DevicesRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string UID = 1;</code>
     */
    private $UID = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $UID
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

}

