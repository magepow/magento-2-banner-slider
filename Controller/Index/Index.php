<?php

/**
 * @Author: Alex Dong
 * @Date:   2021-07-12 09:41:19
 * @Last Modified by:   Alex Dong
 * @Last Modified time: 2021-07-12 09:41:27
 */

namespace Magiccart\Magicslider\Controller\Index;

class Index extends \Magiccart\Magicslider\Controller\Index
{
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }

}
