<?php

/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2016-01-05 10:40:51
 * @@Modify Date: 2019-01-25 21:06:07
 * @@Function:
 */

namespace Magiccart\Magicslider\Block\Adminhtml\Magicslider;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{

    /**
     * Review data
     *
     * @var \Magento\Review\Helper\Data
     */
    protected $_status = null;

    /**
     * magicslider collection factory.
     *
     * @var \Magiccart\Magicslider\Model\ResourceModel\Magicslider\CollectionFactory
     */
    protected $_magicsliderCollectionFactory;


    /**
     * construct.
     *
     * @param \Magento\Backend\Block\Template\Context                         $context
     * @param \Magento\Backend\Helper\Data                                    $backendHelper
     * @param \Magiccart\Magicslider\Model\ResourceModel\Magicslider\CollectionFactory $magicsliderCollectionFactory
     * @param array                                                           $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magento\Review\Helper\Data $reviewData,
        \Magiccart\Magicslider\Model\Status $status,
        \Magiccart\Magicslider\Model\ResourceModel\Magicslider\CollectionFactory $magicsliderCollectionFactory,

        array $data = []
    ) {

        $this->_status = $status;
        $this->_magicsliderCollectionFactory = $magicsliderCollectionFactory;

        parent::__construct($context, $backendHelper, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setId('magicsliderGrid');
        $this->setDefaultSort('magicslider_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $store = $this->getRequest()->getParam('store');
        $collection = $this->_magicsliderCollectionFactory->create();
        if ($store) $collection->addFieldToFilter('stores', array(array('finset' => 0), array('finset' => $store)));
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * @return $this
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'magicslider_id',
            [
                'header' => __('Magicslider ID'),
                'type' => 'number',
                'index' => 'magicslider_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );

        $this->addColumn(
            'title',
            [
                'header' => __('Title'),
                'type' => 'text',
                'index' => 'title',
                'header_css_class' => 'col-title',
                'column_css_class' => 'col-title',
            ]
        );

        $this->addColumn(
            'identifier',
            [
                'header' => __('Identifier'),
                'type' => 'text',
                'index' => 'identifier',
                'header_css_class' => 'col-identifier',
                'column_css_class' => 'col-identifier',
            ]
        );

        $this->addColumn(
            'snippet',
            [
                'header' => __('Copy Shortcode'),
                'class' => 'xxx',
                'width' => '10px',
                'filter' => false,
                'renderer' => 'Magiccart\Magicslider\Block\Adminhtml\Magicslider\Helper\Grid\Snippet',
            ]
        );

        $this->addColumn(
            'image',
            [
                'header' => __('Image'),
                'class' => 'xxx',
                'filter' => false,
                'renderer' => 'Magiccart\Magicslider\Block\Adminhtml\Magicslider\Helper\Grid\Image',
            ]
        );

        // if (!$this->_storeManager->isSingleStoreMode()) {
        //     $this->addColumn(
        //         'stores',
        //         [
        //             'header' => __('Store View'),
        //             'index' => 'stores',
        //             'type' => 'store',
        //             'store_all' => true,
        //             'store_view' => true,
        //             'sortable' => false,
        //             'filter_condition_callback' => [$this, '_filterStoreCondition']
        //         ]
        //     );
        // }

        $this->addColumn(
            'status',
            [
                'header' => __('Status'),
                'index' => 'status',
                'type' => 'options',
                'options' => $this->_status->getOptionArray(),
            ]
        );

        $this->addColumn(
            'edit',
            [
                'header' => __('Edit'),
                'type' => 'action',
                'getter' => 'getId',
                'actions' => [
                    [
                        'caption' => __('Edit'),
                        'url' => ['base' => '*/*/edit'],
                        'field' => 'magicslider_id',
                    ],
                ],
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
                'header_css_class' => 'col-action',
                'column_css_class' => 'col-action',
            ]
        );
        $this->addExportType('*/*/exportCsv', __('CSV'));
        $this->addExportType('*/*/exportXml', __('XML'));
        $this->addExportType('*/*/exportExcel', __('Excel'));

        return parent::_prepareColumns();
    }

    /**
     * get magicslider vailable option
     *
     * @return array
     */

    /**
     * @return $this
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('magicslider_id');
        $this->getMassactionBlock()->setFormFieldName('magicslider');

        $this->getMassactionBlock()->addItem(
            'delete',
            [
                'label' => __('Delete'),
                'url' => $this->getUrl('magicslider/*/massDelete'),
                'confirm' => __('Are you sure?'),
            ]
        );

        $statuses = $this->_status->getOptionArray();

        array_unshift($statuses, ['label' => '', 'value' => '']);
        $this->getMassactionBlock()->addItem(
            'status',
            [
                'label' => __('Change status'),
                'url' => $this->getUrl('magicslider/*/massStatus', ['_current' => true]),
                'additional' => [
                    'visibility' => [
                        'name' => 'status',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => __('Status'),
                        'values' => $statuses,
                    ],
                ],
            ]
        );

        return $this;
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', ['_current' => true]);
    }

    /**
     * get row url
     * @param  object $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl(
            '*/*/edit',
            ['magicslider_id' => $row->getId()]
        );
    }

    public function toHtml()
    {
        $html = '
            <script type="text/javascript">
                document.addEventListener("DOMContentLoaded", function() {
                    document.querySelectorAll(".copy-to-clipboard").forEach((button) => {
                        button.addEventListener("click", function(e){
                            e.stopPropagation();
                            var copyInput = button.closest(".magiccart-snippet").querySelector(".copy-input");
                            copyInput.type = "text";
                            copyInput.select();
                            copyInput.setSelectionRange(0, 99999);
                            document.execCommand("copy");
                            copyInput.type = "hidden";
                        });
                    });
                });
            </script>';

        return parent::toHtml() . $html;
    }
}
