<?php

namespace Mymodule\Product\Setup;

use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;

class UpgradeData implements UpgradeDataInterface
{
    private $eavSetupFactory;
    private $customerSetupFactory;

    public function __construct(
        EavSetupFactory $eavSetupFactory,
        CustomerSetupFactory $customerSetupFactory
    )
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->customerSetupFactory = $customerSetupFactory;
    }

	public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
	{
        $setup->startSetup();
        if ($context->getVersion() && version_compare($context->getVersion(), '1.0.4')) {
            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
            $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

            $attributeCode = 'customer_image';

            $customerSetup->addAttribute(
                \Magento\Customer\Model\Customer::ENTITY,
                $attributeCode,
                [
                    'type' => 'text',
                    'label' => 'Customer File/Image',
                    'input' => 'image',
                    'source' => '',
                    'required' => false,
                    'visible' => true,
                    'position' => 200,
                    'system' => false,
                    'backend' => ''
                ]
            );

            // used this attribute in the following forms
            $attribute = $customerSetup->getEavConfig()
                ->getAttribute(\Magento\Customer\Model\Customer::ENTITY, $attributeCode)
                ->addData(
                    ['used_in_forms' => [
                        'adminhtml_customer',
                        'adminhtml_checkout',
                        'customer_account_create',
                        'customer_account_edit'
                    ]
                    ]);

            $attribute->save();
        }
        if ($context->getVersion() && version_compare($context->getVersion(), '1.0.5')) {
            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Category::ENTITY,
                'category_mobile_thumbnail',
                [
                    'type' => 'varchar',
                    'label' => 'Category Image Custom',
                    'visible' => true,
                    'input' => 'image',
                    'backend' => 'Magento\Catalog\Model\Category\Attribute\Backend\Image',
                    'required' => false,
                    'sort_order' => 100,
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                    'group' => 'General Information',
                ]
            );
        }

        $setup->endSetup();
	}
}