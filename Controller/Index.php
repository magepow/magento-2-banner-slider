<?php

/**
 * @Author: Alex Dong
 * @Date:   2021-07-12 09:40:49
 * @Last Modified by:   Alex Dong
 * @Last Modified time: 2021-07-12 09:41:09
 */

namespace Magiccart\Magicslider\Controller;

abstract class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * Magicslider factory.
     *
     * @var \Magiccart\Magicslider\Model\MagicsliderFactory
     */
    protected $_magicsliderFactory;

    protected $_resultPageFactory;

    /**
     * Index constructor.
     *
     * @param \Magento\Framework\App\Action\Context                                $context
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
    }
}
