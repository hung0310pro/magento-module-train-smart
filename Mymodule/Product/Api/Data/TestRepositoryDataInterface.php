<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mymodule\Product\Api\Data;

/**
 * @api
 * @since 100.0.2
 */
interface TestRepositoryDataInterface
{
    /**
     * Name
     *
     * @return string|null
     */
    public function getName();

    /**
     * Set name
     *
     * @param string $name
     * @return object
     */
    public function setName(string $name): object;

    /**
     * Age
     *
     * @return string|null
     */
    public function getAge();

    /**
     * Set age
     *
     * @param int $age
     * @return object
     */
    public function setAge(int $age): object;

    /**
     * Address
     *
     * @return string|null
     */
    public function getAddress();

    /**
     * Set address
     *
     * @param string $address
     * @return object
     */
    public function setAddress(string $address): object;
}
