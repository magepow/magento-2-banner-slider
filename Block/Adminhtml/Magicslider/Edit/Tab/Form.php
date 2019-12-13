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

class Form extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Framework\DataObjectFactory
     */
    protected $_objectFactory;

    /**
     * @var \Magiccart\Magicslider\Model\Magicslider
     */

    protected $_magicslider;

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
        \Magiccart\Magicslider\Model\Magicslider $magicslider,
        array $data = []
    ) {
        $this->_objectFactory = $objectFactory;
        $this->_magicslider = $magicslider;
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

        $fieldset->addField('title', 'text',
            [
                'label' => __('Title'),
                'title' => __('Title'),
                'name'  => 'title',
                'required' => true,
            ]
        );

        $identifier = $fieldset->addField('identifier', 'text',
            [
                'label' => __('Identifier'),
                'title' => __('Identifier'),
                'name'  => 'identifier',
                'required' => true,
                'class' => 'validate-xml-identifier',
            ]
        );

        if($this->getRequest()->getParam('magicslider_id')){
            $identifier->setAfterElementHtml(
                '<p class="nm"><small>Don\'t change Identifier</small></p>
                <script type="text/javascript">
                require([
                    "jquery",
                ],  function($){
                        jQuery(document).ready(function($) {
                            var identifier  = "#'.$identifier->getHtmlId().'";                  
                            if ($(identifier).val()) {$(identifier).prop("disabled", true); }
                        })
                })
                </script>
                '
            );
        }

        // $fieldset->addField('image', 'image',
        //     [
        //         'label' => __('Image'),
        //         'title' => __('Image'),
        //         'name'  => 'image',
        //         'required' => true,
        //     ]
        // );


        /* Check is single store mode */
        // if (!$this->_storeManager->isSingleStoreMode()) {
        //     $field = $fieldset->addField(
        //         'stores',
        //         'multiselect',
        //         [
        //             'name' => 'stores[]',
        //             'label' => __('Store View'),
        //             'title' => __('Store View'),
        //             'required' => true,
        //             'values' => $this->_systemStore->getStoreValuesForForm(false, true)
        //         ]
        //     );
        //     $renderer = $this->getLayout()->createBlock(
        //         'Magento\Backend\Block\Store\Switcher\Form\Renderer\Fieldset\Element'
        //     );
        //     $field->setRenderer($renderer);
        // } else {
        //     $fieldset->addField(
        //         'stores',
        //         'hidden',
        //         ['name' => 'stores[]', 'value' => $this->_storeManager->getStore(true)->getId()]
        //     );
        //     $model->setStoreId($this->_storeManager->getStore(true)->getId());
        // }


        $fieldset->addField('status', 'select',
            [
                'label' => __('Status'),
                'title' => __('Status'),
                'name' => 'status',
                'options' => Status::getOptionArray(),
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
        return __('General Information');
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

}
