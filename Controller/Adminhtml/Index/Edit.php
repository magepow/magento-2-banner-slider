<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2016-01-05 10:40:51
 * @@Modify Date: 2016-04-22 16:54:02
 * @@Function:
 */

namespace Magiccart\Magicslider\Controller\Adminhtml\Index;

class Edit extends \Magiccart\Magicslider\Controller\Adminhtml\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('magicslider_id');
        $storeViewId = $this->getRequest()->getParam('store');
        $model = $this->_magicsliderFactory->create();

        if ($id) {
            $model->setStoreViewId($storeViewId)->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This Magicslider no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }else {
                if($model->getData('config')){
                    $tmp = json_decode($model->getData('config'), true);
                    if(is_array($tmp)){
                        // unset($tmp['form_key']);
                        unset($tmp['magicslider_id']);
                        $model->addData($tmp);
                    }
                }
            }
        }

        $data = $this->_getSession()->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        
        $model->setData('media_attributes', array());

        // $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        // $model = $objectManager->get('Magento\Catalog\Model\Product')->load(3);

        $this->_coreRegistry->register('magicslider', $model);
        $this->_coreRegistry->register('current_product', $model, 1);
        $this->_coreRegistry->register('product', $model, 1);
        $resultPage = $this->_resultPageFactory->create();

        return $resultPage;
    }
}
