<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mymodule\Product\Api;

/**
 * @api
 * @since 100.0.2
 */
interface ProductCustomInterface
{
    /**#@+
     * Constants defined for keys of  data array
     */
    const SKU = 'sku';

    const NAME = 'name';

    const STATUS = 'status';

    const DESCRIPTION = 'description';

    const IMAGE = 'image';

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';

    /**#@-*/

    /**
     * Product id
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set product id
     *
     * @param int $id
     * @return $this
     */
    public function setId(int $id);

    /**
     * Product name
     *
     * @return string|null
     */
    public function getName();

    /**
     * Set product name
     *
     * @param string $name
     * @return $this
     */
    public function setName(string $name);

    /**
     * Product sku
     *
     * @return string|null
     */
    public function getSku();

    /**
     * Set product sku
     *
     * @param string $sku
     * @return $this
     */
    public function setSku(string $sku);

    /**
     * Product status
     *
     * @return bool|null
     */
    public function getStatus();

    /**
     * Set product status
     *
     * @param bool $status
     * @return $this
     */
    public function setStatus(bool $status);

    /**
     * Product description
     *
     * @return string|null
     */
    public function getDescription();

    /**
     * Set product description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description);

    /**
     * Product image
     *
     * @return string|null
     */
    public function getImage();

    /**
     * Set product image
     *
     * @param string $image
     * @return $this
     */
    public function setImage(string $image);

    /**
     * Product created at
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set product created at
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt(string $createdAt);

    /**
     * Product updated at
     *
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * Set product updated at
     *
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt(string $updatedAt);
}
