<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2016-01-05 10:40:51
 * @@Modify Date: 2016-04-22 17:50:51
 * @@Function:
 */

namespace Magiccart\Magicslider\Block\Adminhtml\Magicslider\Edit\Tab;

use \Magento\Catalog\Model\Product\Attribute\Source\Status;

class Config extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Framework\DataObjectFactory
     */
    protected $_objectFactory;
    protected $_yesNo;
    protected $_trueFalse;
    protected $_row;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Config\Model\Config\Source\Yesno $yesNo,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Framework\DataObjectFactory $objectFactory,
        \Magiccart\Magicslider\Model\System\Config\Row $row,
        array $data = []
    ) {
        $this->_objectFactory = $objectFactory;
        $this->_yesNo = $yesNo;
        $this->_trueFalse = ['true' => __('True'), 'false' => __('False')];
        $this->_row = $row;
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

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Config Tab Information')]);

        if ($model->getId()) {
            $fieldset->addField('magicslider_id', 'hidden', ['name' => 'magicslider_id']);
        }

        // $fieldset->addField(
        //     'timer',
        //     'select',
        //     [
        //         'label' => __('Progressbar'),
        //         'title' => __('Progressbar'),
        //         'name' => 'timer',
        //         'options' => $this->_yesNo->toArray(),
        //         'value' => 0,
        //     ]
        // );

        // Option with value TRUE or FALSE
        $fieldset->addField(
            'vertical',
            'select',
            [
                'label' => __('Slide Vertical'),
                'title' => __('Slide Vertical'),
                'name' => 'vertical',
                'options' => $this->_trueFalse,
                'value' => 'false',
            ]
        );

        $fieldset->addField(
            'infinite',
            'select',
            [
                'label' => __('Infinite'),
                'title' => __('Infinite'),
                'name' => 'infinite',
                'options' => $this->_trueFalse,
            ]
        );

        $fieldset->addField(
            'autoplay',
            'select',
            [
                'label' => __('Auto Play'),
                'title' => __('Auto Play'),
                'name' => 'autoplay',
                'options' => $this->_trueFalse,
            ]
        );        

        $fieldset->addField(
            'arrows',
            'select',
            [
                'label' => __('Arrows'),
                'title' => __('Arrows'),
                'name' => 'arrows',
                'options' => $this->_trueFalse,
            ]
        );

        $fieldset->addField(
            'dots',
            'select',
            [
                'label' => __('Dots'),
                'title' => __('Dots'),
                'name' => 'dots',
                'options' => $this->_trueFalse,
                'value' => 'false',
            ]
        );

        $fieldset->addField(
            'adaptive-height', 
            'select',
            [
                'label' => __('Adaptive Height'),
                'title' => __('Adaptive Height'),
                'name' => 'adaptive-height',
                'options' => $this->_trueFalse,
                'value' => 'false',
            ]
        );

        $fieldset->addField(
            'fade', 
            'select',
            [
                'label' => __('Fade'),
                'title' => __('Fade'),
                'name' => 'fade',
                'options' => $this->_trueFalse,
                'value' => 'false',
            ]
        );

        $fieldset->addField(
            'rows',
            'select',
            [
                'label' => __('Rows'),
                'title' => __('Rows'),
                'name' => 'rows',
                'options' => $this->_row->toOptionArray(),
                'value' => '0',
            ]
        );

        // End option with value TRUE or FALSE

        // Option Text
        $fieldset->addField('speed', 'text',
            [
                'label' => __('Speed'),
                'title' => __('Speed'),
                'name'  => 'speed',
                'required' => true,
                'class' => 'validate-zero-or-greater',
                'value' => 600,
            ]
        );

        $fieldset->addField('autoplay-Speed', 'text',
            [
                'label' => __('autoplay Speed'),
                'title' => __('autoplay Speed'),
                'name'  => 'autoplay-Speed',
                'required' => true,
                'class' => 'validate-zero-or-greater',
                'value' => 6000,
            ]
        );

        $fieldset->addField('padding', 'text',
            [
                'label' => __('Padding'),
                'title' => __('Padding'),
                'name'  => 'padding',
                'required' => true,
                'class' => 'validate-zero-or-greater',
                'value' => 15,
            ]
        );

        $fieldset->addField('center-Mode', 'select',
            [
                'label' => __('Center Mode'),
                'title' => __('Center Mode'),
                'name'  => 'center-Mode',
                'required' => true,
                'options' => $this->_trueFalse,
                'value' => 'false',
            ]
        );

        $fieldset->addField('center-Padding', 'text',
            [
                'label' => __('Center Padding (Example 50px enter value: 50)'),
                'title' => __('Center Padding'),
                'name'  => 'center-Padding',
                'required' => true,
                'class' => 'validate-zero-or-greater',
                'value' => 0,
            ]
        );

        // $fieldset->addField('widthImages', 'text',
        //     [
        //         'label' => __('width Images'),
        //         'title' => __('width Images'),
        //         'name'  => 'widthImages',
        //         'required' => true,
        //         'class' => 'validate-greater-than-zero',
        //         'value' => 300,
        //     ]
        // );

        // $fieldset->addField('heightImages', 'text',
        //     [
        //         'label' => __('height Images'),
        //         'title' => __('height Images'),
        //         'name'  => 'heightImages',
        //         'required' => true,
        //         'class' => 'validate-greater-than-zero',
        //         'value' => 300,
        //     ]
        // );

        // End option Text

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
        return __('Config Information');
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
