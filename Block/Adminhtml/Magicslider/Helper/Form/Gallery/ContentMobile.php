<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * Catalog product form gallery content
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 *
 * @method \Magento\Framework\Data\Form\Element\AbstractElement getElement()
 */
namespace Magiccart\Magicslider\Block\Adminhtml\Magicslider\Helper\Form\Gallery;

use Magento\Backend\Block\Media\Uploader;
use Magento\Framework\View\Element\AbstractBlock;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\ObjectManager;
use Magento\Backend\Block\DataProviders\ImageUploadConfig as ImageUploadConfigDataProvider;

class ContentMobile extends \Magento\Catalog\Block\Adminhtml\Product\Helper\Form\Gallery\Content
{

    /**
     * @var string
     */
    protected $_template = 'helper/gallery.phtml';

    /**
     * @var string
     */
    // protected $_template = 'Magento_Catalog:catalog/product/helper/gallery.phtml';
    

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magiccart\Magicslider\Model\Magicslider\Media\Config $mediaConfig,
        ImageUploadConfigDataProvider $imageUploadConfigDataProvider = null,
        array $data = []
    ) {
        $this->_jsonEncoder = $jsonEncoder;
        $this->_mediaConfig = $mediaConfig;
        parent::__construct($context, $jsonEncoder, $mediaConfig, $data);
        try {
            if (class_exists(ImageUploadConfigDataProvider::class)) {
                $this->imageUploadConfigDataProvider = $imageUploadConfigDataProvider
            ?: ObjectManager::getInstance()->get(ImageUploadConfigDataProvider::class);
            } elseif (class_exists(ImageUploadConfigDataProvider::class)) {
            
                $this->imageUploadConfigDataProvider = ObjectManager::getInstance()->get(ImageUploadConfigDataProvider::class);
            }
        } catch (\Exception $e) {}
    }

    protected function _prepareLayout()
    {
        $this->addChild(
            'uploader',
            \Magento\Backend\Block\Media\Uploader::class,
            ['image_upload_config_data' => $this->imageUploadConfigDataProvider]
        );

        // $this->addChild(
        //     'uploader',
        //     \Magento\Backend\Block\Media\Uploader::class,
        //     ['image_upload_config_data' => $this]
        // );

        $this->getChildBlock('uploader')->setTemplate('Magiccart_Magicslider::media/uploader.phtml');
        // $this->addChild(
        //     'uploader', 
        //     'Magento\Backend\Block\Media\Uploader',
        //     [
        //         'template' => 'Magiccart_Magicslider::media/uploader.phtml'
        //     ]
        // );

        $this->getUploader()->getConfig()->setUrl(
            // $this->_urlBuilder->addSessionParam()->getUrl('magicslider/index_gallery/uploadMobile')
            $this->_urlBuilder->getUrl('magicslider/index_gallery/uploadMobile')
        )->setFileField(
            'image_mobile'
        )->setFilters(
            [
                'images' => [
                    'label' => __('Images (.gif, .jpg, .png)'),
                    'files' => ['*.gif', '*.jpg', '*.jpeg', '*.png'],
                ],
            ]
        );


        $this->_eventManager->dispatch('catalog_product_gallery_prepare_layout', ['block' => $this]);
        // $this->setTemplate('catalog/product/helper/gallery.phtml');
        // $this->setTemplate('catalog/video/helper/gallery.phtml');
        // return parent::_prepareLayout();
    }

    public function  getImageUploadConfigData()
    {
        return $this;
    }
    public function  getIsResizeEnabled()
    {
        return 0;
    } 

}
