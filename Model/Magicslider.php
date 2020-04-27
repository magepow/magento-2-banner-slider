<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2016-01-11 23:15:05
 * @@Modify Date: 2020-04-26 16:52:18
 * @@Function:
 */

namespace Magiccart\Magicslider\Model;

class Magicslider extends \Magento\Framework\Model\AbstractModel
{

    /**
     * Name of object id field
     *
     * @var string
     */
    protected $_idFieldName = 'magicslider_id';

    /**
     * @var \Magiccart\Magicslider\Model\ResourceModel\Magicslider\CollectionFactory
     */
    protected $_magicsliderCollectionFactory;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magiccart\Magicslider\Model\ResourceModel\Magicslider\CollectionFactory $magicsliderCollectionFactory,
        \Magiccart\Magicslider\Model\ResourceModel\Magicslider $resource,
        \Magiccart\Magicslider\Model\ResourceModel\Magicslider\Collection $resourceCollection
    ) {
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection
        );
        $this->_magicsliderCollectionFactory = $magicsliderCollectionFactory;
    }

}
