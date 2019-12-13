<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2016-01-05 10:40:51
 * @@Modify Date: 2016-04-22 16:53:38
 * @@Function:
 */

namespace Magiccart\Magicslider\Controller\Adminhtml\Index;

use Magento\Framework\App\Filesystem\DirectoryList;

class Save extends \Magiccart\Magicslider\Controller\Adminhtml\Action
{
    
    private $_mediaDir = 'magiccart/magicslider/';

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $resultRedirect = $this->_resultRedirectFactory->create();

        if ($data = $this->getRequest()->getPostValue()) {
            $model = $this->_magicsliderFactory->create();
            $storeViewId = $this->getRequest()->getParam('store');

            if ($id = $this->getRequest()->getParam('magicslider_id')) {
                $model->load($id);
            }

            if (isset($_FILES['image']) && isset($_FILES['image']['name']) && strlen($_FILES['image']['name'])) {
                /*
                 * Save image upload
                 */
                try {
                    $uploader = $this->_objectManager->create(
                        'Magento\MediaStorage\Model\File\Uploader',
                        ['fileId' => 'image']
                    );
                    $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);

                    /** @var \Magento\Framework\Image\Adapter\AdapterInterface $imageAdapter */
                    $imageAdapter = $this->_objectManager->get('Magento\Framework\Image\AdapterFactory')->create();

                    $uploader->addValidateCallback('magicslider_image', $imageAdapter, 'validateUploadFile');
                    $uploader->setAllowRenameFiles(true);
                    $uploader->setFilesDispersion(true);

                    /** @var \Magento\Framework\Filesystem\Directory\Read $mediaDirectory */
                    $mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')
                        ->getDirectoryRead(DirectoryList::MEDIA);
                    $result = $uploader->save(
                        $mediaDirectory->getAbsolutePath($this->_mediaDir)
                    );
                    $data['image'] = $this->_mediaDir . $result['file'];
                } catch (\Exception $e) {
                    if ($e->getCode() == 0) {
                        $this->messageManager->addError($e->getMessage());
                    }
                }
            } else {
                if (isset($data['image']) && isset($data['image']['value'])) {
                    if (isset($data['image']['delete'])) {
                        $data['image'] = null;
                        $data['delete_image'] = true;
                    } elseif (isset($data['image']['value'])) {
                        $data['image'] = $data['image']['value'];
                    } else {
                        $data['image'] = null;
                    }
                }
            }
            /** @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate */
            // $localeDate = $this->_objectManager->get('Magento\Framework\Stdlib\DateTime\TimezoneInterface');
            // $data['start_time'] = $localeDate->date($data['start_time'])->setTimezone(new \DateTimeZone('UTC'))->format('Y-m-d H:i');
            // $data['end_time'] = $localeDate->date($data['end_time'])->setTimezone(new \DateTimeZone('UTC'))->format('Y-m-d H:i');

            if(isset($data['stores'])) $data['stores'] = implode(',', $data['stores']);
            if( isset($data['product']['media_gallery']['images']) || isset($data['product']['media_gallery_mobile']) ){
                $mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
                $mediaRootDir = $mediaDirectory->getAbsolutePath() .$this->_mediaDir;
                
                $_file = $this->_objectManager->get('Magento\Framework\Filesystem\Driver\File');
                if(isset($data['product']['media_gallery'])){
                    $media_gallery = $data['product']['media_gallery'];
                    $images = $media_gallery['images'];
                    foreach ($images as $key => $image) {
                        if($image['removed']){
                            if ($_file->isExists($mediaRootDir . $image['file']))  {

                                $_file->deleteFile($mediaRootDir . $image['file']);    
                            }
                            unset($images[$key]);                
                        }
      
                    }
                    $data['media_gallery'] =  array('images'=>$images);
                }
                if(isset($data['product']['media_gallery_mobile'])){
                    $media_gallery_mobile = $data['product']['media_gallery_mobile'];
                    $images = $media_gallery_mobile['images'];
                    foreach ($images as $key => $image) {
                        if($image['removed']){
                            if ($_file->isExists($mediaRootDir . $image['file']))  {

                                $_file->deleteFile($mediaRootDir . $image['file']);    
                            }
                            unset($images[$key]);                
                        } else {
                            if(!preg_match ( '/^\/mobile\/*/', $image['file'])){
                                $images[$key]['file']= '/mobile' . $image['file'];
                            }

                        }

                  
                    }

                    $data['media_gallery_mobile'] =  array('images'=>$images);                    
                }

                unset($data['form_key']);
                unset($data['product']);
                $data['config'] = json_encode($data);
            }
            $model->setData($data)
                ->setStoreViewId($storeViewId);

            try {
                $model->save();

                $this->messageManager->addSuccess(__('The Magicslider menu has been saved.'));
                $this->_getSession()->setFormData(false);

                if ($this->getRequest()->getParam('back') === 'edit') {
                    return $resultRedirect->setPath(
                        '*/*/edit',
                        [
                            'magicslider_id' => $model->getId(),
                            '_current' => true,
                            'store' => $storeViewId,
                            'current_magicslider_id' => $this->getRequest()->getParam('current_magicslider_id'),
                            'saveandclose' => $this->getRequest()->getParam('saveandclose'),
                        ]
                    );
                } elseif ($this->getRequest()->getParam('back') === 'new') {
                    return $resultRedirect->setPath(
                        '*/*/new',
                        ['_current' => TRUE]
                    );
                }

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                $this->messageManager->addException($e, __('Something went wrong while saving the magicslider.'));
            }

            $this->_getSession()->setFormData($data);

            return $resultRedirect->setPath(
                '*/*/edit',
                ['magicslider_id' => $this->getRequest()->getParam('magicslider_id')]
            );
        }

        return $resultRedirect->setPath('*/*/');
    }
}
