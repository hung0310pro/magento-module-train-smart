<?php

namespace CheckoutCustom\Attribute\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{

    /**
     * {@inheritdoc}
     */
    public function install(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    )
    {
        $installer = $setup;

        $installer->startSetup();

        $installer->getConnection()->addColumn(
            $installer->getTable('quote'),
            'agree',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                'visible' => true,
                'default' => 0,
                'comment' => 'Custom Condition'
            ]
        );


        $installer->getConnection()->addColumn(
            $installer->getTable('sales_order'),
            'agree',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                'visible' => true,
                'default' => 0,
                'comment' => 'Custom Condition'
            ]
        );

        $installer->getConnection()->addColumn(
            $installer->getTable('sales_order_grid'),
            'agree',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                'visible' => true,
                'default' => 0,
                'comment' => 'Custom Condition'
            ]
        );

        $setup->endSetup();
    }
}