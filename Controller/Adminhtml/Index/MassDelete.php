<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2016-01-05 10:40:51
 * @@Modify Date: 2016-04-22 16:55:00
 * @@Function:
 */

namespace Magiccart\Magicslider\Controller\Adminhtml\Index;

class MassDelete extends \Magiccart\Magicslider\Controller\Adminhtml\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $magicsliderIds = $this->getRequest()->getParam('magicslider');
        if (!is_array($magicsliderIds) || empty($magicsliderIds)) {
            $this->messageManager->addError(__('Please select magicslider(s).'));
        } else {
            $collection = $this->_magicsliderCollectionFactory->create()
                ->addFieldToFilter('magicslider_id', ['in' => $magicsliderIds]);
            try {
                foreach ($collection as $item) {
                    $item->delete();
                }
                $this->messageManager->addSuccess(
                    __('A total of %1 record(s) have been deleted.', count($magicsliderIds))
                );
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath('*/*/');
    }
}
