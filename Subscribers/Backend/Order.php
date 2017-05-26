<?php
namespace Shopware\Plugins\ViisonSCDDeliveredButton\Subscribers\Backend;

use Shopware\Plugins\ViisonCommon\Classes\Subscribers\Base;

/**
 * @copyright Copyright (c) 2017, VIISON GmbH
 */
class Order extends Base
{
    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatchSecure_Backend_Order' => 'onPostDispatchSecure'
        ];
    }

    /**
     * @param \Enlight_Event_EventArgs $args
     */
    public function onPostDispatchSecure(\Enlight_Event_EventArgs $args)
    {
        if ($args->getRequest()->getActionName() === 'load') {
            $view = $args->getSubject()->View();
            $view->extendsTemplate('backend/viison_scd_delivered_button_order_status_button/view/detail/overview.js');
        }
    }
}
