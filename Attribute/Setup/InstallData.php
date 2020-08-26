<?php

namespace Web\Attribute\Setup;

use Magento\Catalog\Model\Category;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Catalog\Setup\CategorySetupFactory;

/**
 * Class InstallData
 */
class InstallData implements InstallDataInterface
{

    /**
     * InstallData constructor.
     * @param CategorySetupFactory $categorySetupFactory
     */
    public function __construct(
        CategorySetupFactory $categorySetupFactory
    ) {
        $this->categorySetupFactory = $categorySetupFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws LocalizedException
     */
    public function install(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;
        $installer->startSetup();

        $categorySetup = $this->categorySetupFactory->create(['setup' => $setup]);
        $entityTypeId = $categorySetup->getEntityTypeId(Category::ENTITY);
        $attributeSetId = $categorySetup->getDefaultAttributeSetId($entityTypeId);
        $categorySetup->addAttribute(
            Category::ENTITY, 'custom_image', [
                'type' => 'varchar',
                'label' => 'Custom Image',
                'input' => 'image',
                'backend' => 'Magento\Catalog\Model\Category\Attribute\Backend\Image',
                'required' => false,
                'sort_order' => 5,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'General Information',
                'visible_on_front' => true,
                'used_in_product_listing' => true,
                'unique' => false,
                'is_html_allowed_on_front' => true,
                'apply_to' => '',
                'visible' => true,
                'is_used_in_grid' => true,
                'is_visible_in_grid' => true
            ]
        );

        $installer->endSetup();
    }

}
