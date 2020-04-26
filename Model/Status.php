<?php

/**
 * @Author: nguyen
 * @Date:   2020-04-26 11:54:56
 * @Last Modified by:   nguyen
 * @Last Modified time: 2020-04-26 11:59:27
 */

namespace Magiccart\Magicslider\Model;

class Status
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * get available statuses.
     *
     * @return []
     */
    public static function getAvailableStatuses()
    {
        return [
            self::STATUS_ENABLED => __('Enabled')
            , self::STATUS_DISABLED => __('Disabled'),
        ];
    }

    public static function getOptionArray()
    {
        return self::getAvailableStatuses();
    }

}
