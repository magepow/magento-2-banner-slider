<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2016-01-05 10:40:51
 * @@Modify Date: 2016-03-29 13:54:35
 * @@Function:
 */

namespace Magiccart\Magicslider\Block\Adminhtml\Magicslider\Edit\Tab;

use \Magento\Catalog\Model\Product\Attribute\Source\Status;

class Images extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Framework\DataObjectFactory
     */
    protected $_objectFactory;


    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @var \Magento\Cms\Model\Wysiwyg\Config
     */
    protected $_wysiwygConfig;


    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Framework\DataObjectFactory $objectFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        array $data = []
    ) {
        $this->_objectFactory = $objectFactory;
        $this->_systemStore = $systemStore;
        $this->_wysiwygConfig = $wysiwygConfig;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * prepare layout.
     *
     * @return $this
     */
    protected function _prepareLayout()
    {
        $this->getLayout()->getBlock('page.title')->setPageTitle($this->getPageTitle());
        return $this;
    }

    /**
     * Prepare form.
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        $model = $this->getMagicslider();

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('media_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Magicslider Information')]);

        if ($model->getId()) {
            $fieldset->addField('magicslider_id', 'hidden', ['name' => 'magicslider_id']);
        }


        $fieldset->addField('media_gallery', 'note',
            [
                'label' => '',
                'title' => __('Media Gallery'),
                'name'  => 'media_gallery',
                // 'required' => true,
                'text'      => $this->getContentHtml(),
            ]
        );


        $form->addValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * @return mixed
     */
    public function getMagicslider()
    {
        return $this->_coreRegistry->registry('magicslider');
    }

    /**
     * @return \Magento\Framework\Phrase
     */
    public function getPageTitle()
    {
        return $this->getMagicslider()->getId()
            ? __("Edit Magicslider '%1'", $this->escapeHtml($this->getMagicslider()->getName())) : __('New Magicslider');
    }

    /**
     * Prepare label for tab.
     *
     * @return string
     */
    public function getTabLabel()
    {
        // return __('Content Slider');
        return __('Images And Videos');
    }

    /**
     * Prepare title for tab.
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->getTabLabel();
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    // Gallery
    public function getContentHtml()
    {
        
        $this->getDataObject();
        $gallery = $this->getLayout()->createBlock(
                '\Magento\Catalog\Block\Adminhtml\Product\Helper\Form\Gallery' 
            );
        // $gallery->setDataObject($this->getMagicslider());
        /* @var $content \Magento\Catalog\Block\Adminhtml\Product\Helper\Form\Gallery\Content */
        // $content = $this->getChildBlock('content');
        $content = $this->getLayout()->createBlock(
                // '\Magento\Catalog\Block\Adminhtml\Product\Helper\Form\Gallery\Content' 
                'Magiccart\Magicslider\Block\Adminhtml\Magicslider\Helper\Form\Gallery\Content'
            );
        $content->setTemplate('helper/gallery.phtml');
        $content->getUploader()->getConfig()->setUrl(
            // $this->_urlBuilder->addSessionParam()->getUrl('magicslider/index_gallery/upload')
            $this->_urlBuilder->getUrl('magicslider/index_gallery/upload')
        );
        
        // $video = $this->getLayout()->createBlock(
        //         '\Magento\ProductVideo\Block\Adminhtml\Product\Edit\NewVideo',
        //          'new-video'
        //     );
        $video = $this->getLayout()->createBlock(
                'Magiccart\Magicslider\Block\Adminhtml\Magicslider\Edit\NewVideo',
                 'new-video'
            );


        $video->setTemplate('Magento_ProductVideo::product/edit/slideout/form.phtml');
        $content->setId($this->getHtmlId() . '_content')->setElement($gallery);
        // $content->setFormName($this->formName);
        $content->setFormName('product_form');
        $galleryJs = $content->getJsObjectName();
        $content->setChild('new-video',$video);
        $content->getUploader()->getConfig()->setMegiaGallery($galleryJs);


        return $content->toHtml();
    }

    // public function getName()
    // {
    //     return 'product[media_gallery]';
    // }

    // public function getDataObject()
    // {
    //     return $this->getMagicslider();
    // }

    // public function getImages()
    // {
    //     $this->getMagicslider()->getData('media_gallery') ?: null;
    // }

}
