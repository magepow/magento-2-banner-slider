<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2016-01-05 10:40:51
 * @@Modify Date: 2016-02-29 14:25:17
 * @@Function:
 */

namespace Magiccart\Magicslider\Block\Adminhtml;

class Magicslider extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor.
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_magicslider';
        $this->_blockGroup = 'Magiccart_Magicslider';
        $this->_headerText = __('Magicslider');
        $this->_addButtonLabel = __('Add New Magicslider');
        parent::_construct();
    }
}
