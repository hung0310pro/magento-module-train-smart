<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace CheckoutCustom\Attribute\Model\ResourceModel\Order\Grid;

use Magento\Sales\Model\ResourceModel\Order\Grid\Collection as CollectionSale;

/**
 * Order grid collection
 */
class Collection extends CollectionSale
{
    /**
     * @inheritdoc
     */
    protected function _initSelect()
    {
        parent::_initSelect();

        $this->getSelect()
            ->join(
                ['so' => $this->getTable('sales_order')],
                'main_table.entity_id = so.entity_id',
                'so.agree'
            );

        $tableDescription = $this->getConnection()->describeTable($this->getMainTable());
        foreach ($tableDescription as $columnInfo) {
            $this->addFilterToMap($columnInfo['COLUMN_NAME'], 'main_table.' . $columnInfo['COLUMN_NAME']);
        }

        return $this;
    }
}
