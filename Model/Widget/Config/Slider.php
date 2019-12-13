<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-01-11 23:15:05
 * @@Modify Date: 2017-02-6 21:27:23
 * @@Function:
 */

namespace Magiccart\Magicslider\Model\Widget\Config;

class Slider implements \Magento\Framework\Option\ArrayInterface
{

	protected $scopeConfig;
	protected $_magicslider;

	public function __construct(
		// \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
		\Magiccart\Magicslider\Model\Magicslider $magicslider
	)
	{
		$this->_magicslider = $magicslider;
	}

    public function toOptionArray()
    {
		$magicslider = $this->_magicslider->getCollection();
		$options = array();
		foreach ($magicslider as $item) {
			$options[$item->getIdentifier()] = $item->getTitle();
		}
        return $options;
    }

}
