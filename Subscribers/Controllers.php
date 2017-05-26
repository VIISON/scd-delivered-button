<?php
namespace Shopware\Plugins\ViisonSCDDeliveredButton\Subscribers;

use Shopware\Plugins\ViisonCommon\Classes\Subscribers\Controllers as ControllersSubscriber;

/**
 * @copyright Copyright (c) 2017, VIISON GmbH
 */
class Controllers extends ControllersSubscriber
{
    /**
     * @inheritdoc
     */
    public static function getControllerNames()
    {
        return [
            static::MODULE_BACKEND => [
                'ViisonSCDDeliveredButtonOrderStatusButton'
            ]
        ];
    }
}
