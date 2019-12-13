<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2016-01-05 10:40:51
 * @@Modify Date: 2018-07-24 18:13:22
 * @@Function:
 */

namespace Magiccart\Magicslider\Block\Adminhtml\Magicslider\Edit\Tab;

use \Magento\Catalog\Model\Product\Attribute\Source\Status;

class Responsive extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Framework\DataObjectFactory
     */
    protected $_objectFactory;
    protected $_col;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Framework\DataObjectFactory $objectFactory,
        \Magiccart\Magicslider\Model\System\Config\Col $col,
        array $data = []
    ) {
        $this->_objectFactory = $objectFactory;
        $this->_col = $col;
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

        $form->setHtmlIdPrefix('magic_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Responsive Tab Information')]);

        if ($model->getId()) {
            $fieldset->addField('magicslider_id', 'hidden', ['name' => 'magicslider_id']);
        }

        $fieldset->addField('mobile', 'select',
            [
                'label' => __('max-width 360:'),
                'title' => __('Display in Screen <= 360:'),
                'name' => 'mobile',
                'options' => $this->_col->toOptionArray(),
                'value' => 1,
            ]
        );

        $fieldset->addField('portrait', 'select',
            [
                'label' => __('max-width 480:'),
                'title' => __('Display in Screen 480:'),
                'name' => 'portrait',
                'options' => $this->_col->toOptionArray(),
                'value' => 1,
            ]
        );

        $fieldset->addField('landscape', 'select',
            [
                'label' => __('max-width 576:'),
                'title' => __('Display in Screen 576:'),
                'name' => 'landscape',
                'options' => $this->_col->toOptionArray(),
                'value' => 1,
            ]
        );

        $fieldset->addField('tablet', 'select',
            [
                'label' => __('max-width 768:'),
                'title' => __('Display in Screen 768:'),
                'name' => 'tablet',
                'options' => $this->_col->toOptionArray(),
                'value' => 1,
            ]
        );

        $fieldset->addField('notebook', 'select',
            [
                'label' => __('max-width 991:'),
                'title' => __('Display in Screen 991:'),
                'name' => 'notebook',
                'options' => $this->_col->toOptionArray(),
                'value' => 1,
            ]
        );
		
        $fieldset->addField('laptop', 'select',
            [
                'label' => __('max-width 1199:'),
                'title' => __('Display in Screen 1199:'),
                'name' => 'laptop',
                'options' => $this->_col->toOptionArray(),
                'value' => 1,
            ]
        );
        
        $fieldset->addField('desktop', 'select',
            [
                'label' => __('max-width 1479:'),
                'title' => __('Display in Screen 1479:'),
                'name' => 'desktop',
                'options' => $this->_col->toOptionArray(),
                'value' => 1,
            ]
        );

        $fieldset->addField('widescreen', 'select',
            [
                'label' => __('max-width 1919:'),
                'title' => __('Display in Screen 1919:'),
                'name' => 'widescreen',
                'options' => $this->_col->toOptionArray(),
                'value' => 1,
            ]
        );

        $fieldset->addField('visible', 'select',
            [
                'label' => __('min-width 1920:'),
                'title' => __('Display Visible Items:'),
                'name' => 'visible',
                'options' => $this->_col->toOptionArray(),
                'value' => 1,
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
        return __('Responsive Information');
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
