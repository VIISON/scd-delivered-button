<?php
namespace Shopware\Plugins\ViisonSCDDeliveredButton\Subscribers;

use Shopware\Plugins\ViisonCommon\Classes\Subscribers\SubApplicationRegistration as SubApplicationRegistrationSubscriber;

/**
 * @copyright Copyright (c) 2017, VIISON GmbH
 */
class SubApplicationRegistration extends SubApplicationRegistrationSubscriber
{
    /**
     * @inheritdoc
     */
    public function getSubApplications()
    {
        return [
            'ViisonSCDDeliveredButtonOrderStatusButton' => 'Order'
        ];
    }
}
