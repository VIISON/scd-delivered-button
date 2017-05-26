<?php
// Require composer dependecies if necessary
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once(__DIR__ . '/vendor/autoload.php');
}

if (!class_exists('ViisonCommon_Plugin_BootstrapV4')) {
    require_once('ViisonCommon/PluginBootstrapV4.php');
}

use Shopware\Plugins\ViisonCommon\Classes\Subscribers as ViisonCommonSubscribers;
use Shopware\Plugins\ViisonSCDDeliveredButton\Subscribers;

/**
 * @copyright Copyright (c) 2017, VIISON GmbH
 */
final class Shopware_Plugins_Backend_ViisonSCDDeliveredButton_Bootstrap extends ViisonCommon_Plugin_BootstrapV4
{
    /**
     * @return array
     */
    public function getInfo()
    {
        $info = parent::getInfo();
        $info['label'] = 'SCD Delivered Button';

        return $info;
    }

    /**
     * Must be re-declared to please Shopware's automatic code review.
     *
     * @return string
     */
    public function getVersion()
    {
        return parent::getVersion();
    }

    /**
     * @return array|boolean
     */
    public function install()
    {
        return $this->update('install');
    }

    /**
     * @param string $oldVersion
     * @return array|boolean
     */
    public function update($oldVersion)
    {
        // Call parent method from ViisonCommon_Plugin_Bootstrap to make sure that we can use ViisonCommon
        parent::update($oldVersion);

        switch ($oldVersion) {
            case 'install':
                /* Subscribes */

                $this->subscribeEvent(
                    'Enlight_Controller_Front_StartDispatch',
                    'onStartDispatch'
                );
                $this->subscribeEvent(
                    'Shopware_Console_Add_Command',
                    'onAddConsoleCommand'
                );
            case '1.0.0':
                // Next release

                // *** *** *** *** ***
                // NEVER REMOVE THE FOLLOWING BREAK! All updates must be added above this comment block!
                // *** *** *** *** ***
                break;
            default:
                return false;
        }

        // Update ViisonCommon
        $this->importViisonCommonSnippetsIntoDb();

        return [
            'success' => true,
            'message' => 'Bitte laden Sie das Shopware Backend neu, nachdem Sie die Caches geleert haben.',
            'invalidateCache' => [
                'config',
                'template',
                'proxy'
            ]
        ];
    }

    /**
     * @return array|boolean
     */
    public function uninstall()
    {
        return [
            'success' => true,
            'message' => 'Bitte laden Sie das Shopware Backend neu, nachdem Sie die Caches geleert haben.',
            'invalidateCache' => [
                'config',
                'template',
                'proxy'
            ]
        ];
    }

    /**
     * @return array|boolean
     */
    public function enable()
    {
        return [
            'success' => true,
            'message' => 'Bitte laden Sie das Shopware Backend neu, nachdem Sie die Caches geleert haben.',
            'invalidateCache' => [
                'config',
                'template',
                'proxy'
            ]
        ];
    }

    /**
     * @return array|boolean
     */
    public function disable()
    {
        return [
            'success' => true,
            'message' => 'Bitte laden Sie das Shopware Backend neu, nachdem Sie die Caches geleert haben.',
            'invalidateCache' => [
                'config',
                'template',
                'proxy'
            ]
        ];
    }

    /**
     * Registers the plugin's namespaces.
     */
    public function afterInit()
    {
        $this->loadDependencies();
        $this->loadPlugin();
    }

    /* Events & Hooks */

    /**
     * @param \Enlight_Event_EventArgs $args
     */
    public function onStartDispatch(\Enlight_Event_EventArgs $args)
    {
    }

    /**
     * @param \Enlight_Event_EventArgs $args
     */
    public function onAddConsoleCommand(\Enlight_Event_EventArgs $args)
    {
    }

    /* Other */

    /**
     * Uses the dependency loader to load the namespaces and susbcribers of all required,
     * shared dependencies.
     */
    private function loadDependencies()
    {
        // Require all shared dependencies
        $loader = VIISON\ShopwarePluginDependencyLoader\Loader::getInstance();
        $loader->requireDependencies($this->Path(), [
            'ViisonCommon',
            'ViisonSCDOrderButton'
        ]);

        // Add the subscribers of ViisonCommon
        $subscriberRegistrator = new Shopware\Plugins\ViisonCommon\Classes\SubscriberRegistrator($this);
        $subscriberRegistrator->registerSubscribers();

        // Add the subscribers of ViisonSCDOrderButton
        $subscriberRegistrator = new Shopware\Plugins\ViisonSCDOrderButton\Classes\SubscriberRegistrator($this);
        $subscriberRegistrator->registerSubscribers();
    }

    /**
     * Registers the namespace of this plugin with the class loader and addds all subscribers to the event manager.
     */
    private function loadPlugin()
    {
        if (!$this->isInstalledAndActive()) {
            return;
        }

        // Register the main namespace of this plugin
        $this->get('loader')->registerNamespace(
            'Shopware\Plugins\ViisonSCDDeliveredButton',
            $this->Path()
        );

        // Create all plugin subscribers
        $subscribers = [
            new Subscribers\Controllers($this),
            new Subscribers\SubApplicationRegistration($this),
            new ViisonCommonSubscribers\ViewLoading($this, 'ViisonSCDDeliveredButton')
        ];

        // Make sure that the subscribers are only added once
        if (!$this->isSubscriberRegistered($subscribers[0])) {
            $eventManager = $this->get('events');
            foreach ($subscribers as $subscriber) {
                $eventManager->addSubscriber($subscriber);
            }
        }
    }
}
