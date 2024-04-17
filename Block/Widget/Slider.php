<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magepow.com/) 
 * @license     http://www.magepow.com/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-01-05 10:40:51
 * @@Modify Date: 2020-10-22 18:09:48
 * @@Function:
 */

namespace Magiccart\Magicslider\Block\Widget;

use Magento\Framework\App\Filesystem\DirectoryList;

class Slider extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface, \Magento\Framework\DataObject\IdentityInterface
{
    const DEFAULT_CACHE_TAG = 'MAGICCART_MAGICSLIDER';
    const MEDIA_PATH = 'magiccart/magicslider';

    public $_sysCfg;

    public $_urlMedia;

    protected $_filesystem;

    protected $_directory;

    /**
     * @var \Magento\Framework\Data\CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @var \Magento\Framework\Image\AdapterFactory
     */
    protected $_imageFactory;

    /**
     * @var \Magento\Backend\Model\UrlInterface
     */
    protected $backendUrl;

    /**
     * @var \Magento\Cms\Model\Template\FilterProvider
     */
    protected $filterProvider;

    /**
     * @var \Magiccart\Magicslider\Model\MagicsliderFactory
     */
    protected $_magicsliderFactory;

    protected $_magicslider;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Data\CollectionFactory $collectionFactory,
        \Magento\Framework\Image\AdapterFactory $imageFactory,
        \Magento\Backend\Model\UrlInterface $backendUrl,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider,
        \Magiccart\Magicslider\Model\MagicsliderFactory $magicsliderFactory,
        array $data = []
    ) {

        $this->_collectionFactory = $collectionFactory;
        $this->_imageFactory = $imageFactory;
        $this->_filesystem = $context->getFilesystem();
        $this->_directory = $this->_filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->backendUrl   = $backendUrl;
        $this->filterProvider = $filterProvider;
        $this->_magicsliderFactory = $magicsliderFactory;

        $this->_sysCfg= (object) $context->getScopeConfig()->getValue(
            'magicslider',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        parent::__construct($context, $data);
    }

    protected function _construct()
    {
        $identifier = $this->getIdentifier();
        $store = $this->_storeManager->getStore()->getStoreId();
        $this->_magicslider = $this->_magicsliderFactory->create()->getCollection()->addFieldToSelect('*')
                        ->addFieldToFilter('stores',array( array('finset' => 0), array('finset' => $store)))
                        ->addFieldToFilter('status', 1);
        if($identifier){
            $this->_magicslider->addFieldToFilter('identifier', $identifier);
        }else if($this->getMagicsliderId()){
            $this->_magicslider->addFieldToFilter('magicslider_id', $this->getMagicsliderId());
        }else if($this->getId()){
            $this->_magicslider->addFieldToFilter('magicslider_id', $this->getId());
        }
        $this->_magicslider = $this->_magicslider->setOrder('stores', 'desc')
                                    ->setOrder('magicslider_id', 'desc')
                                    ->setPageSize(1)
                                    ->getFirstItem();
        if (!$this->_magicslider){
            echo '<div class="message-error error message">Identifier "'. $identifier . '" not exist.</div> ';          
            return;
        }
        if (!$this->_magicslider->getStatus()){
            return;
        }
        $data = json_decode($this->_magicslider->getConfig(), true);

        $breakpoints = $this->getResponsiveBreakpoints();
        $total = count($breakpoints);
        $responsive = '[';
        foreach ($breakpoints as $size => $screen) {
            $total--;
            if(!isset($data[$screen])) continue;
            $responsive .= '{"breakpoint": '.$size.', "settings": {"slidesToShow": '.$data[$screen].'}}';
            if($total > 0) $responsive .= ', ';
        }
        $responsive .= ']';
        $data['responsive'] = $responsive;
        $data['slides-To-Show'] = $data['visible'];
        // $data['swipe-To-Slide'] = 'true';
        $data['vertical-Swiping'] = $data['vertical'];
        $data['adaptive-height'] = isset($data['adaptive-height']) ? $data['adaptive-height'] : 'false';
        if(isset($data['center-Padding'])) $data['center-Padding'] = $data['center-Padding'] . 'px';
        // $data['center-Padding'] = $data['padding'];
        $data['slide'] = 1;
        // if(!isset($data['rows'])  || $data['rows'] == 1 ) $data['rows'] = 0;
        //$data['lazy-Load'] = 'progressive';
        $this->addData($data);
        parent::_construct();
    }

    protected function getCacheLifetime()
    {
        return parent::getCacheLifetime() ?: 86400;
    }

    public function getCacheKeyInfo()
    {
        $keyInfo     =  parent::getCacheKeyInfo();
        $keyInfo[]   =  $this->getMagicslider()->getId();
        return $keyInfo;
    }

    /**
     * @return array
     */
    public function getIdentities()
    {
        return [self::DEFAULT_CACHE_TAG, self::DEFAULT_CACHE_TAG . '_' . $this->getMagicslider()->getId()];
    }

    public function getAdminUrl($adminPath, $routeParams=[], $storeCode = 'default' ) 
    {
        $routeParams[] = [ '_nosid' => true, '_query' => ['___store' => $storeCode]];
        return $this->backendUrl->getUrl($adminPath, $routeParams);
    }

    public function getQuickedit()
    {
        return;      
    }

    public function getMagicslider()
    {
        return $this->_magicslider;
    }

    /**
     * Retrieve media gallery images
     *
     * @return \Magento\Framework\Data\Collection
     */
    public function getMediaGalleryImages()
    {
        $sliderMobile = $this->getMediaGalleryMobileImages();
        $mediaPath = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath();
        if (!$this->hasData('media_gallery_images') && is_array($this->getMediaGallery('images'))) {
            $images = $this->_collectionFactory->create();
            $i=0;
            foreach ($this->getMediaGallery('images') as $image) {
                if ((isset($image['disabled']) && $image['disabled'] || !isset($image['file']))
                ) {
                    continue;
                }
                $_image = $this->_imageFactory->create();
                $image['url'] = $this->getMediaUrl($image['file']);
                $file = self::MEDIA_PATH . $image['file'];
                $absPath = $mediaPath .$file;
                if( !file_exists($absPath) ) continue;
                $_image->open($absPath);
                $image['width'] = $_image->getOriginalWidth();
                $image['height'] = $_image->getOriginalHeight();
                $image = new \Magento\Framework\DataObject($image);
                $img = isset($sliderMobile[$i]) ? $sliderMobile[$i] : '';
                if ($img){
                    $_img = $this->_imageFactory->create();
                    $file = self::MEDIA_PATH . $img->getFile();
                    $absPath = $mediaPath .$file;
                    if( !file_exists($absPath) ) continue;
                    $_img->open($absPath);
                    $width  =  $_img->getOriginalWidth();
                    $height =  $_img->getOriginalHeight();
                    $img->setData('width', $width);
                    $img->setData('height', $height);
                    $image->setData('mobile', $img);
                    /* Make compatible with old template */
                    $image->setData('url_mobile', $img->getUrl());
                    $image->setData('width_mobile', $width);
                    $image->setData('height_mobile', $height);
                }
                $images->addItem($image);
                $i++;
            }
            $this->setData('media_gallery_images', $images);
        }

        return $this->getData('media_gallery_images');
    }

    /**
     * Retrieve media gallery images
     *
     * @return \Magento\Framework\Data\Collection
     */
    public function getMediaGalleryMobileImages()
    {
        if (!$this->hasData('media_gallery_mobile_images') && is_array($this->getMediaGalleryMobile('images'))) {
            $images = array();
            foreach ($this->getMediaGalleryMobile('images') as $image) {
                if ((isset($image['disabled']) && $image['disabled'])
                ) {
                    continue;
                }
                $image['url'] = $this->getMediaUrl($image['file']);
                $images[] = new \Magento\Framework\DataObject($image);
            }
            $this->setData('media_gallery_mobile_images', $images);
        }

        return $this->getData('media_gallery_mobile_images');
    }

    public function getSlider()
    {
       return $this->getMediaGalleryImages();
    }

    public function getMediaUrl($file)
    {
        if(!$this->_urlMedia) $this->_urlMedia = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        return $this->_urlMedia .'magiccart/magicslider'. $file;
    }

    public function getImage($file)
    {        
        return $this->getMediaUrl($file);
    }

    public function getVideo($data)
    {
        $url = str_replace('vimeo.com', 'player.vimeo.com/video', $data['video_url']) .'?byline=0&amp;portrait=0&amp;api=1';
        $video = array(
            'url' => $url,
            'width' => '100%',
            'height' => '100%'
        );
        $file = self::MEDIA_PATH. $data['file'];
        $absPath = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath().$file;
        $image = $this->_imageFactory->create();
        $image->open($absPath);
        $video['width'] = $image->getOriginalWidth();
        $video['height'] = $image->getOriginalHeight();

        return $video;
    }

    public function getResponsiveBreakpoints()
    {
        return array(1921=>'visible', 1920=>'widescreen', 1479=>'desktop', 1200=>'laptop', 992=>'notebook', 768=>'tablet', 576=>'landscape', 480=>'portrait', 361=>'mobile', 1=>'mobile');
    }

    public function getSlideOptions()
    {
        return array('autoplay', 'arrows', 'autoplay-Speed', 'speed', 'dots', 'adaptive-height', 'fade', 'infinite', 'padding', 'vertical', 'vertical-Swiping', 'responsive', 'rows', 'slides-To-Show', 'center-Mode', 'center-Padding');
    }

    public function getFrontendCfg()
    { 
        if($this->getSlide()) return $this->getSlideOptions();

        $this->addData(array('responsive' =>json_encode($this->getGridOptions())));
        return array('padding', 'responsive');

    }

    public function getGridOptions()
    {
        $options = array();
        $breakpoints = $this->getResponsiveBreakpoints(); ksort($breakpoints);
        foreach ($breakpoints as $size => $screen) {
            $options[]= array($size-1 => $this->getData($screen));
        }
        return $options;
    }

    public function getCaption($context)
    {
        if($context){
            $storeId = $this->_storeManager->getStore()->getStoreId();
            return $this->filterProvider->getBlockFilter()->setStoreId($storeId)->filter($context);
        }
    }

}
