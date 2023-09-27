<?php

namespace Magiccart\Magicslider\Block\Adminhtml\Magicslider\Helper\Form;

use Magento\Framework\Data\Form\Element\AbstractElement;

class Snippet extends AbstractElement
{
    /**
     * @return string
     */
    public function getElementHtml()
    {
        $slider   = $this->getSlider();
        $identifier = $slider->getIdentifier() ?? '$identifier';
        $shortcodeWidget = '{{widget type="Magiccart\Magicslider\Block\Widget\Slider" identifier="' . $identifier . '" template="magicslider.phtml"}}';
        $shortcodeBlock  = $this->_escaper->escapeHtml('<?= $block->getLayout()->createBlock(\'Magiccart\Magicslider\Block\Widget\Slider\')->setIdentifier("' . $identifier . '")->setTemplate(\'magicslider.phtml\')->toHtml(); ?>');
        $html = '<ol class="magicslider-snippet"><li>';
        $html .= '<span>' . __('Add Widget name "Magiccart Magicslider widget" and set Identifier or MagicsliderId for it.') . '</span>';
        $html .= '</li><li>';
        $html .= '<span>' . __('CMS Page/Static Block') . '</span>';
        $html .= '<code>' . $shortcodeWidget . '</code>';
        $html .= '<p>' . __('You can paste the above block of snippet into any page in Magento 2 and set Identifier or MagicsliderId for it.') . '</p>';
        $html .= '</li><li>';
        $html .= '<span>' . __('Template .phtml file. Open a .phtml file and insert where you want to display Banner Slider.') . '</span>';
        $html .= '<code>' . $shortcodeBlock . '</code>';
        $html .= '</li></ol>';

        return $html;
    }
}
