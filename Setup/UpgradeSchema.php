<?php
namespace Magiccart\Magicslider\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $version = $context->getVersion();
        $connection = $installer->getConnection();

        if (version_compare($version, '2.1') < 0) {

            $connection->addColumn(
                $installer->getTable('magiccart_magicslider'),
                'stores',
                [
                    'type'      => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length'    => 255,
                    'nullable'  => false,
                    'default'   => 0,
                    'comment'   => 'Stores',
                ]
            );
        }

        $setup->endSetup();
    }
}