<?php
namespace Shopware\Plugins\ViisonSCDDeliveredButton\Test\Integration\Controllers\Backend;

use Shopware\Models\Order\Status;
use VIISON\ShopwareTestingCommon\ControllerTestCase;
use VIISON\ShopwareTestingCommon\TestResource;

/**
 * @group Controller
 * @group Integration
 */
class ViisonSCDDeliveredButtonOrderStatusButtonTest extends ControllerTestCase
{
    /**
     * PUT /backend/ViisonSCDDeliveredButtonOrderStatusButton/markAsDelivered
     */
    public function test_markAsDeliveredAction()
    {
        // Create the test data
        $order = TestResource::createSimpleOrder();

        // Send the test request
        $response = $this->dispatchPUT(
            '/backend/ViisonSCDDeliveredButtonOrderStatusButton/markAsDelivered',
            [
                'orderId' => $order->getId()
            ]
        );

        // Check response
        $parsedResponse = json_decode($response->getBody(), true);
        $this->assertEquals(
            [
                'success' => true
            ],
            $parsedResponse
        );

        // Check order
        $this->assertEquals(Status::ORDER_STATE_COMPLETELY_DELIVERED, $order->getOrderStatus()->getId());
    }
}
