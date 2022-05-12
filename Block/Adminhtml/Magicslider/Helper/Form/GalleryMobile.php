<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

// @codingStandardsIgnoreFile

/**
 * Catalog product gallery attribute
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
namespace Magiccart\Magicslider\Block\Adminhtml\Magicslider\Helper\Form;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Registry;
use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute;
use Magento\Catalog\Api\Data\ProductInterface;

class GalleryMobile  extends \Magento\Catalog\Block\Adminhtml\Product\Helper\Form\Gallery
{
    /**
     * Gallery field name suffix
     *
     * @var string
     */
    protected $fieldNameSuffix = 'product';

    /**
     * Gallery html id
     *
     * @var string
     */
    protected $htmlId = 'media_gallery_mobile';

    /**
     * Gallery name
     *
     * @var string
     */
    protected $name = 'product[media_gallery_mobile]';

    public function getImages()
    {
        $images = $this->getDataObject()->getData('media_gallery_mobile') ?: [];
        // if ($images === null) {
        //     $images = ((array)$this->dataPersistor->get('catalog_product'))['product']['media_gallery'] ?? null;
        // }

        return $images;
    }

    // public function getDataObject()
    // {
    //     return $this->registry->registry('current_product');
    // }

}
