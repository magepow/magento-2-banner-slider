<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magiccart\Magicslider\Block\Adminhtml\Magicslider\Helper\Form;

use Magento\Framework\Registry;
use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute;
use Magento\Catalog\Api\Data\ProductInterface;

class Gallery extends \Magento\Catalog\Block\Adminhtml\Product\Helper\Form\Gallery
{
    // public function getImages()
    // {
    //     return $this->registry->registry('current_magicslider')->getData('media_gallery') ?: null;
    // }

    public function getDataObject()
    {
        /* Fake product */

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $productCollectionFactory = $objectManager->get(\Magento\Catalog\Model\ResourceModel\Product\CollectionFactory::class);

        $product = $productCollectionFactory->create()
            ->addAttributeToSelect('*')
            ->setOrder('entity_id', 'ASC')
            ->setPageSize(1)
            ->getFirstItem();
        
        $this->_coreRegistry->register('current_product', $product, 1);
        $this->_coreRegistry->register('product', $product, 1);
        
        return $product;
    }

}