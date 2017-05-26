<?php
use Shopware\Models\Order\Order;
use Shopware\Models\Order\Status;
use Shopware\Plugins\ViisonCommon\Controllers\ViisonCommonBaseController;

/**
 * @copyright Copyright (c) 2017 VIISON GmbH
 */
class Shopware_Controllers_Backend_ViisonSCDDeliveredButtonOrderStatusButton extends ViisonCommonBaseController
{
    /**
     * Tries to find the order for the given 'orderId' and, if found, sets its order status to 'completely delivered'.
     */
    public function markAsDeliveredAction()
    {
        // Try to find the order
        $orderId = $this->Request()->getParam('orderId', 0);
        $order = $this->get('models')->find(Order::class, $orderId);
        if (!$order) {
            $this->Response()->setHttpResponseCode(404);
            $this->View()->assign([
                'success' => false,
                'message' => sprintf('Order with ID %s not found', $orderId)
            ]);
            return;
        }

        // Set the order status to 'completely delivered'
        $status = $this->get('models')->find(Status::class, Status::ORDER_STATE_COMPLETELY_DELIVERED);
        $order->setOrderStatus($status);
        $this->get('models')->flush($order);

        $this->View()->assign([
            'success' => true
        ]);
    }
}
