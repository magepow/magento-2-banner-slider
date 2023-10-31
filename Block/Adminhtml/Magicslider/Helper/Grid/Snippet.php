<?php

/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2016-03-04 11:44:03
 * @@Modify Date: 2016-03-29 13:48:49
 * @@Function:
 */

namespace Magiccart\Magicslider\Block\Adminhtml\Magicslider\Helper\Grid;

class Snippet extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    /**
     * Store manager.
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Magicslider factory.
     *
     * @var \Magiccart\Magicslider\Model\MagicsliderFactory
     */
    protected $magicsliderFactory;

    /**
     *
     * @param \Magento\Backend\Block\Context              $context
     * @param \Magento\Store\Model\StoreManagerInterface  $storeManager
     * @param \Magento\Cms\Model\BlockFactory $blockFactory
     * @param array                                       $data
     */
    public function __construct(
        \Magento\Backend\Block\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magiccart\Magicslider\Model\MagicsliderFactory $magicsliderFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->storeManager = $storeManager;
        $this->magicsliderFactory  = $magicsliderFactory;
    }

    /**
     * Render action.
     *
     * @param \Magento\Framework\DataObject $row
     *
     * @return string
     */
    public function render(\Magento\Framework\DataObject $row)
    {
        $storeViewId = $this->getRequest()->getParam('store');
        $item = $this->magicsliderFactory->create()->setStoreViewId($storeViewId)->load($row->getId());
        $identifier = $item->getIdentifier();
        $shortcodeWidget = $this->_escaper->escapeHtml('{{widget type="Magiccart\Magicslider\Block\Widget\Slider" identifier="' . $identifier . '" template="magicslider.phtml"}}');
        $shortcodeBlock  = $this->_escaper->escapeHtml('<?= $block->getLayout()->createBlock(\'Magiccart\Magicslider\Block\Widget\Slider\')->setIdentifier("' . $identifier . '")->setTemplate(\'magicslider.phtml\')->toHtml(); ?>');
        $emojiCopy = '<span style="font-size:30px">✂️</span>';
        $html = '<div class="magiccart-snippet" style="display:inline-block;width:150px; float:left"><input class="copy-input" type="hidden" value="' . $shortcodeWidget . '" readonly><button style="display: inline-flex" class="copy-to-clipboard action-default scalable add primaryx">' . __('Copy to Page|Block') . $emojiCopy . '</button></div>';
        $html .= '<div class="magiccart-snippet" style="display:inline-block;width:150px; float:right"><input class="copy-input" type="hidden" value="' . $shortcodeBlock . '" readonly><button style="display: inline-flex" class="copy-to-clipboard action-default scalable add primaryx">' . __('Copy to .phtml') . $emojiCopy . '</button></div>';

        return $html;
    }
}