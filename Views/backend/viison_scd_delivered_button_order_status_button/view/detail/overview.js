//{namespace name=backend/viison_scd_delivered_button_order_status_button}
Ext.define('Shopware.apps.ViisonSCDDeliveredButtonOrderStatusButton.view.detail.Overview', {

    override: 'Shopware.apps.Order.view.detail.Overview',

    /**
     * @override
     */
    createDetailsContainer: function() {
        var container = this.callParent(arguments);

        // Add a 'mark as delivered' unicorn button
        container.add(Ext.create('Shopware.apps.ViisonSCDOrderButtonUnicornButton.Button', {
            text: '{s name=view/detail/button/mark_as_delivered/title}{/s}',
            scope: this,
            handler: function() {
                var window = this.up('order-detail-window');
                window.setLoading(true);

                // Send a request for updating the order
                Ext.Ajax.request({
                    method: 'PUT',
                    params: {
                        orderId: this.record.get('id')
                    },
                    url: '{url controller=ViisonSCDDeliveredButtonOrderStatusButton action=markAsDelivered}',
                    success: function() {
                        window.setLoading(false);
                        Shopware.Notification.createGrowlMessage('{s name=view/detail/button/mark_as_delivered/notification/success}{/s}', '', 'ViisonSCDDeliveredButton');
                    },
                    failure: function() {
                        window.setLoading(false);
                        Shopware.Notification.createGrowlMessage('{s name=view/detail/button/mark_as_delivered/notification/failure}{/s}', '', 'ViisonSCDDeliveredButton');
                    }
                });
            }
        }));

        return container;
    }

});
