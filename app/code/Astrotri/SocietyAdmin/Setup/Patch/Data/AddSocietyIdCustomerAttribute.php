<?php

declare(strict_types=1);

namespace Astrotri\SocietyAdmin\Setup\Patch\Data;

use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Model\Entity\Attribute\SetFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class AddSocietyIdCustomerAttribute implements DataPatchInterface
{
    private ModuleDataSetupInterface $moduleDataSetup;
    private CustomerSetupFactory $customerSetupFactory;
    private SetFactory $attributeSetFactory;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CustomerSetupFactory $customerSetupFactory,
        SetFactory $attributeSetFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $customerSetup = $this->customerSetupFactory->create([
            'setup' => $this->moduleDataSetup
        ]);

        $customerSetup->addAttribute(
            Customer::ENTITY,
            'society_id',
            [
                'type' => 'int',
                'label' => 'Society',
                'input' => 'text',
                'required' => false,
                'visible' => true,
                'user_defined' => true,
                'system' => false,
                'position' => 999,
                'sort_order' => 999,
                'is_used_in_grid' => true,
                'is_visible_in_grid' => true,
                'is_filterable_in_grid' => true,
                'is_searchable_in_grid' => false,
            ]
        );

        $customerEntity = $customerSetup->getEavConfig()->getEntityType(Customer::ENTITY);

        $attributeSetId = $customerEntity->getDefaultAttributeSetId();

        $attributeGroupId = $this->attributeSetFactory
            ->create()
            ->getDefaultGroupId($attributeSetId);

        $attribute = $customerSetup->getEavConfig()
            ->getAttribute(Customer::ENTITY, 'society_id');

        $attribute->addData([
            'attribute_set_id' => $attributeSetId,
            'attribute_group_id' => $attributeGroupId,
            'used_in_forms' => [
                'adminhtml_customer',
                'customer_account_create',
                'customer_account_edit'
            ]
        ]);

        $attribute->save();

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public static function getDependencies(): array
    {
        return [];
    }

    public function getAliases(): array
    {
        return [];
    }
}