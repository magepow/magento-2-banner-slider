<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magiccart\Magicslider\Controller\Adminhtml\Index\Gallery;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\File\Uploader;
use \Magento\Framework\Validator\AllowedProtocols;
use \Magento\Framework\Exception\LocalizedException;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class RetrieveImage extends \Magento\ProductVideo\Controller\Adminhtml\Product\Gallery\RetrieveImage
{

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\RawFactory $resultRawFactory
     * @param \Magento\Catalog\Model\Product\Media\Config $mediaConfig
     * @param \Magento\Framework\Filesystem $fileSystem
     * @param \Magento\Framework\Image\AdapterFactory $imageAdapterFactory
     * @param \Magento\Framework\HTTP\Adapter\Curl $curl
     * @param \Magento\MediaStorage\Model\ResourceModel\File\Storage\File $fileUtility
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory,
        \Magiccart\Magicslider\Model\Magicslider\Media\Config $mediaConfig,
        \Magento\Framework\Filesystem $fileSystem,
        \Magento\Framework\Image\AdapterFactory $imageAdapterFactory,
        \Magento\Framework\HTTP\Adapter\Curl $curl,
        \Magento\MediaStorage\Model\ResourceModel\File\Storage\File $fileUtility
    ) {
        
        parent::__construct($context, $resultRawFactory, $mediaConfig, $fileSystem, $imageAdapterFactory, $curl, $fileUtility );
    }

}
