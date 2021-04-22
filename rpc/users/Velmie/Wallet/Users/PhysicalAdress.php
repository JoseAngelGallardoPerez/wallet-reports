<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: users.proto

namespace Velmie\Wallet\Users;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;
use Google\Protobuf\Internal\GPBWrapperUtils;

/**
 * Generated from protobuf message <code>velmie.wallet.users.PhysicalAdress</code>
 */
class PhysicalAdress extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string pa_zip_postal_code = 1;</code>
     */
    private $pa_zip_postal_code = '';
    /**
     * Generated from protobuf field <code>string pa_address = 2;</code>
     */
    private $pa_address = '';
    /**
     * Generated from protobuf field <code>string pa_address_2nd_line = 3;</code>
     */
    private $pa_address_2nd_line = '';
    /**
     * Generated from protobuf field <code>string pa_city = 4;</code>
     */
    private $pa_city = '';
    /**
     * Generated from protobuf field <code>string pa_country_iso2 = 5;</code>
     */
    private $pa_country_iso2 = '';
    /**
     * Generated from protobuf field <code>string pa_state_prov_region = 6;</code>
     */
    private $pa_state_prov_region = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $pa_zip_postal_code
     *     @type string $pa_address
     *     @type string $pa_address_2nd_line
     *     @type string $pa_city
     *     @type string $pa_country_iso2
     *     @type string $pa_state_prov_region
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Users::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string pa_zip_postal_code = 1;</code>
     * @return string
     */
    public function getPaZipPostalCode()
    {
        return $this->pa_zip_postal_code;
    }

    /**
     * Generated from protobuf field <code>string pa_zip_postal_code = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setPaZipPostalCode($var)
    {
        GPBUtil::checkString($var, True);
        $this->pa_zip_postal_code = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string pa_address = 2;</code>
     * @return string
     */
    public function getPaAddress()
    {
        return $this->pa_address;
    }

    /**
     * Generated from protobuf field <code>string pa_address = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setPaAddress($var)
    {
        GPBUtil::checkString($var, True);
        $this->pa_address = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string pa_address_2nd_line = 3;</code>
     * @return string
     */
    public function getPaAddress2NdLine()
    {
        return $this->pa_address_2nd_line;
    }

    /**
     * Generated from protobuf field <code>string pa_address_2nd_line = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setPaAddress2NdLine($var)
    {
        GPBUtil::checkString($var, True);
        $this->pa_address_2nd_line = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string pa_city = 4;</code>
     * @return string
     */
    public function getPaCity()
    {
        return $this->pa_city;
    }

    /**
     * Generated from protobuf field <code>string pa_city = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setPaCity($var)
    {
        GPBUtil::checkString($var, True);
        $this->pa_city = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string pa_country_iso2 = 5;</code>
     * @return string
     */
    public function getPaCountryIso2()
    {
        return $this->pa_country_iso2;
    }

    /**
     * Generated from protobuf field <code>string pa_country_iso2 = 5;</code>
     * @param string $var
     * @return $this
     */
    public function setPaCountryIso2($var)
    {
        GPBUtil::checkString($var, True);
        $this->pa_country_iso2 = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string pa_state_prov_region = 6;</code>
     * @return string
     */
    public function getPaStateProvRegion()
    {
        return $this->pa_state_prov_region;
    }

    /**
     * Generated from protobuf field <code>string pa_state_prov_region = 6;</code>
     * @param string $var
     * @return $this
     */
    public function setPaStateProvRegion($var)
    {
        GPBUtil::checkString($var, True);
        $this->pa_state_prov_region = $var;

        return $this;
    }

}

