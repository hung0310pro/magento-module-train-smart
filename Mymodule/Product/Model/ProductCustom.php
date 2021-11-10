<?php

namespace Mymodule\Product\Model;

use Mymodule\Product\Api\ProductCustomInterface;

class ProductCustom extends \Magento\Framework\Model\AbstractModel implements ProductCustomInterface
{
    protected function _construct()
    {
        $this->_init('Mymodule\Product\Model\ResourceModel\ProductCustom');
    }

    /**
     * Identifier getter
     *
     * @return int|null
     * @since 101.0.0
     */
    public function getId()
    {
        return $this->_getData('entity_id');
    }

    /**
     * Get product name
     *
     * @return string
     * @codeCoverageIgnoreStart
     */
    public function getName(): string
    {
        return $this->_getData(self::NAME);
    }

    /**
     * Get product sku
     *
     * @return string
     * @codeCoverageIgnoreStart
     */
    public function getSku(): string
    {
        return $this->_getData(self::SKU);
    }

    /**
     * Get product status
     *
     * @return bool
     * @codeCoverageIgnoreStart
     */
    public function getStatus(): bool
    {
        return $this->_getData(self::STATUS);
    }

    /**
     * Get product description
     *
     * @return string
     * @codeCoverageIgnoreStart
     */
    public function getDescription(): string
    {
        return $this->_getData(self::DESCRIPTION);
    }

    /**
     * Get product image
     *
     * @return string|null
     * @codeCoverageIgnoreStart
     */
    public function getImage()
    {
        return $this->_getData(self::IMAGE);
    }

    /**
     * Get product created at
     *
     * @return string
     * @codeCoverageIgnoreStart
     */
    public function getCreatedAt(): string
    {
        return $this->_getData(self::CREATED_AT);
    }

    /**
     * Get product updated at
     *
     * @return string
     * @codeCoverageIgnoreStart
     */
    public function getUpdatedAt(): string
    {
        return $this->_getData(self::UPDATED_AT);
    }

    /**
     * Set product name
     *
     * @param string $name
     * @return $this
     */
    public function setName(string $name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Set product sku
     *
     * @param string $sku
     * @return $this
     */
    public function setSku(string $sku)
    {
        return $this->setData(self::SKU, $sku);
    }

    /**
     * Set product id
     *
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        return $this->setData('entity_id', $id);
    }

    /**
     * Set product status
     *
     * @param bool $status
     * @return $this
     */
    public function setStatus(bool $status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Set product description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description)
    {
        return $this->setData(self::DESCRIPTION, $description);
    }

    /**
     * Set product image
     *
     * @param string $image
     * @return $this
     */
    public function setImage(string $image)
    {
        return $this->setData(self::IMAGE, $image);
    }

    /**
     * Set product created at
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt(string $createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Set product updated at
     *
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt(string $updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    /**
     * Convert Data Image
     * @param array $data
     * @return array
     */
    public function convertDataImageProduct(array $data): array
    {
        if (empty($data['image'])) {
            $data['image'] = null;
            return $data;
        }
        $data['image'] = $data['image'][0]['name'];

        return $data;
    }
}