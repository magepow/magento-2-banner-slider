<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

// @codingStandardsIgnoreFile

namespace Magiccart\Magicslider\Model\Magicslider\Media;

use Magento\Eav\Model\Entity\Attribute;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Catalog product media config
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */

class ConfigMobile extends \Magento\Catalog\Model\Product\Media\Config
{

    protected $_mediaDir = 'magiccart/magicslider/mobile';

    public function getBaseMediaPathAddition()
    {
        return $this->_mediaDir;
    }

    /**
     * Web-based directory path of product images
     * relatively to media folder
     *
     * @return string
     */
    public function getBaseMediaUrlAddition()
    {
        return $this->_mediaDir;
    }

    /**
     * @return string
     */
    public function getBaseMediaPath()
    {
        return $this->_mediaDir;
    }

    /**
     * @return string
     */
    public function getBaseMediaUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . $this->_mediaDir;
    }

    /**
     * Filesystem directory path of temporary product images
     * relatively to media folder
     *
     * @return string
     */
    public function getBaseTmpMediaPath()
    {
        return $this->getBaseMediaPathAddition();
    }

    /**
     * @return string
     */
    public function getBaseTmpMediaUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl(
            \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
        ) . $this->getBaseMediaUrlAddition();
    }

    /**
     * Part of URL of temporary product images
     * relatively to media folder
     *
     * @param string $file
     * @return string
     */
    public function getTmpMediaShortUrl($file)
    {
        return $this->getBaseMediaUrlAddition() . '/' . $this->_prepareFile($file);
    }


}
