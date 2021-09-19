<?php

namespace SmartOsc\CustomizeCustomer\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Config;
use Magento\Customer\Model\Customer;

class InstallData implements InstallDataInterface
{
    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @var Config
     */
    private $eavConfig;

    public function __construct(EavSetupFactory $eavSetupFactory, Config $eavConfig)
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig = $eavConfig;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->addAttribute(
            \Magento\Customer\Model\Customer::ENTITY,
            'customer_vip',
            [
                'type' => 'int',
                'label' => 'Customer Vip',
                'input' => 'boolean',
                'required' => false,
                'visible' => true,
                'position' => 999,
                'system' => false,
                'backend' => ''
            ]
        );
        $attribute = $this->eavConfig->getAttribute(Customer::ENTITY, 'customer_vip');

        $attribute->setData(
            'used_in_forms',
            [
                'adminhtml_customer',
                'customer_account_edit'
            ]

        );
        $attribute->save();
    }
}
