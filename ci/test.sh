#!/bin/sh
cd /var/www
echo "UPDATE s_core_shops SET host = '${HOST}';" | mysql -h mysql_host shopware
vendor/bin/phpunit -c ./engine/Shopware/Plugins/Community/Backend/ViisonSCDDeliveredButton/Test/phpunit.xml
