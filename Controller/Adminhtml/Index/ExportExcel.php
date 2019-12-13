<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2016-01-05 10:40:51
 * @@Modify Date: 2016-04-22 16:53:57
 * @@Function:
 */

namespace Magiccart\Magicslider\Controller\Adminhtml\Index;

use Magento\Framework\App\Filesystem\DirectoryList;

class ExportExcel extends \Magiccart\Magicslider\Controller\Adminhtml\Action
{
    public function execute()
    {
        $fileName = 'magicsliders.xls';

        /** @var \\Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $content = $resultPage->getLayout()->createBlock('Magiccart\Magicslider\Block\Adminhtml\Magicslider\Grid')->getExcel();

        return $this->_fileFactory->create($fileName, $content, DirectoryList::VAR_DIR);
    }
}
