<?php

namespace Mymodule\Product\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\App\ResourceConnection;

class ProductCustom extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    private $table = 'product_custom';

    /**
     * @var ResourceConnection
     */
    protected $resourceConnection;

    /**
     * Resource Product Constructor.
     * @param Context $context
     * @param ResourceConnection $resourceConnection
     * @param string|null $connectionName
     */
    public function __construct(
        Context $context,
        ResourceConnection $resourceConnection,
        string $connectionName = null
    )
    {
        $this->resourceConnection = $resourceConnection;
        parent::__construct($context, $connectionName);
    }

    protected function _construct()
    {
        $this->_init($this->table, 'entity_id');
    }

    /**
     * @param array $ids
     * @return void
     */
    public function deleteProduct(array $ids): void
    {
        $connection = $this->resourceConnection->getConnection();
        $ids = implode(',', $ids);
        $sql = "DELETE  FROM $this->table WHERE entity_id in (" . $ids . ") ";
        $connection->query($sql);
    }
}