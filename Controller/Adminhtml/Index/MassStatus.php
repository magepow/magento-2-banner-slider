<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2016-01-05 10:40:51
 * @@Modify Date: 2016-04-22 16:54:37
 * @@Function:
 */

namespace Magiccart\Magicslider\Controller\Adminhtml\Index;

class MassStatus extends \Magiccart\Magicslider\Controller\Adminhtml\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $magicsliderIds = $this->getRequest()->getParam('magicslider');
        $status = $this->getRequest()->getParam('status');
        $storeViewId = $this->getRequest()->getParam('store');
        if (!is_array($magicsliderIds) || empty($magicsliderIds)) {
            $this->messageManager->addError(__('Please select Magicslider(s).'));
        } else {
            $collection = $this->_magicsliderCollectionFactory->create()
                // ->setStoreViewId($storeViewId)
                ->addFieldToFilter('magicslider_id', ['in' => $magicsliderIds]);
            try {
                foreach ($collection as $item) {
                    $item->setStoreViewId($storeViewId)
                        ->setStatus($status)
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->messageManager->addSuccess(
                    __('A total of %1 record(s) have been changed status.', count($magicsliderIds))
                );
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath('*/*/', ['store' => $this->getRequest()->getParam('store')]);
    }
}
