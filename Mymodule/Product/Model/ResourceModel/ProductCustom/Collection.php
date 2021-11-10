<?php

namespace Mymodule\Product\Model\ResourceModel\ProductCustom;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Mymodule\Product\Model\ProductCustom', 'Mymodule\Product\Model\ResourceModel\ProductCustom');
    }
}