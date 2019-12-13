<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2016-01-05 10:40:51
 * @@Modify Date: 2016-04-22 16:54:00
 * @@Function:
 */

namespace Magiccart\Magicslider\Controller\Adminhtml\Index;

use Magento\Framework\App\Filesystem\DirectoryList;

class ExportCsv extends \Magiccart\Magicslider\Controller\Adminhtml\Action
{
    public function execute()
    {
        $fileName = 'magicsliders.csv';

        /** @var \\Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $content = $resultPage->getLayout()->createBlock('Magiccart\Magicslider\Block\Adminhtml\Magicslider\Grid')->getCsv();

        return $this->_fileFactory->create($fileName, $content, DirectoryList::VAR_DIR);
    }
}
