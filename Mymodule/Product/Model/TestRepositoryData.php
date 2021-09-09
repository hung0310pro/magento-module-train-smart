<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mymodule\Product\Model;

/**
 * SearchResults Service Data Object used for the search service requests
 *
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
class TestRepositoryData implements \Mymodule\Product\Api\Data\TestRepositoryDataInterface
{
    protected $_data;

    const NAME = 'name';
    const AGE = 'age';
    const ADDRESS = 'address';

    /**
     * Name
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->_get(self::NAME);
    }

    /**
     * Set name
     *
     * @param string $name
     * @return object
     */
    public function setName(string $name): object
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Age
     *
     * @return string|null
     */
    public function getAge()
    {
        return $this->_get(self::AGE);
    }

    /**
     * Set age
     *
     * @param int $age
     * @return object
     */
    public function setAge(int $age): object
    {
        return $this->setData(self::AGE, $age);
    }

    /**
     * Address
     *
     * @return string|null
     */
    public function getAddress()
    {
        return $this->_get(self::ADDRESS);
    }

    /**
     * Set address
     *
     * @param string $address
     * @return object
     */
    public function setAddress(string $address): object
    {
        return $this->setData(self::ADDRESS, $address);
    }

    /**
     * Set value for the given key
     *
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function setData($key, $value)
    {
        $this->_data[$key] = $value;
        return $this;
    }

    /**
     * Retrieves a value from the data array if set, or null otherwise.
     *
     * @param string $key
     * @return mixed|null
     */
    protected function _get($key)
    {
        return $this->_data[$key] ?? null;
    }
}

