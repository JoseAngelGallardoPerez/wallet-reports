<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: users.proto

namespace Velmie\Wallet\Users;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;
use Google\Protobuf\Internal\GPBWrapperUtils;

/**
 * Generated from protobuf message <code>velmie.wallet.users.Company</code>
 */
class Company extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>uint64 ID = 2;</code>
     */
    private $ID = 0;
    /**
     * Generated from protobuf field <code>string company_name = 3;</code>
     */
    private $company_name = '';
    /**
     * Generated from protobuf field <code>string company_type = 4;</code>
     */
    private $company_type = '';
    /**
     * Generated from protobuf field <code>string company_role = 5;</code>
     */
    private $company_role = '';
    /**
     * Generated from protobuf field <code>string director_first_name = 6;</code>
     */
    private $director_first_name = '';
    /**
     * Generated from protobuf field <code>string director_last_name = 7;</code>
     */
    private $director_last_name = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int|string $ID
     *     @type string $company_name
     *     @type string $company_type
     *     @type string $company_role
     *     @type string $director_first_name
     *     @type string $director_last_name
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Users::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>uint64 ID = 2;</code>
     * @return int|string
     */
    public function getID()
    {
        return $this->ID;
    }

    /**
     * Generated from protobuf field <code>uint64 ID = 2;</code>
     * @param int|string $var
     * @return $this
     */
    public function setID($var)
    {
        GPBUtil::checkUint64($var);
        $this->ID = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string company_name = 3;</code>
     * @return string
     */
    public function getCompanyName()
    {
        return $this->company_name;
    }

    /**
     * Generated from protobuf field <code>string company_name = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setCompanyName($var)
    {
        GPBUtil::checkString($var, True);
        $this->company_name = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string company_type = 4;</code>
     * @return string
     */
    public function getCompanyType()
    {
        return $this->company_type;
    }

    /**
     * Generated from protobuf field <code>string company_type = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setCompanyType($var)
    {
        GPBUtil::checkString($var, True);
        $this->company_type = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string company_role = 5;</code>
     * @return string
     */
    public function getCompanyRole()
    {
        return $this->company_role;
    }

    /**
     * Generated from protobuf field <code>string company_role = 5;</code>
     * @param string $var
     * @return $this
     */
    public function setCompanyRole($var)
    {
        GPBUtil::checkString($var, True);
        $this->company_role = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string director_first_name = 6;</code>
     * @return string
     */
    public function getDirectorFirstName()
    {
        return $this->director_first_name;
    }

    /**
     * Generated from protobuf field <code>string director_first_name = 6;</code>
     * @param string $var
     * @return $this
     */
    public function setDirectorFirstName($var)
    {
        GPBUtil::checkString($var, True);
        $this->director_first_name = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string director_last_name = 7;</code>
     * @return string
     */
    public function getDirectorLastName()
    {
        return $this->director_last_name;
    }

    /**
     * Generated from protobuf field <code>string director_last_name = 7;</code>
     * @param string $var
     * @return $this
     */
    public function setDirectorLastName($var)
    {
        GPBUtil::checkString($var, True);
        $this->director_last_name = $var;

        return $this;
    }

}
