<?php namespace Ams\Asset;

use Backend;
use System\Classes\PluginBase;

/**
 * Asset Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Asset',
            'description' => 'No description provided yet...',
            'author'      => 'Ams',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Ams\Asset\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'ams.asset.some_permission' => [
                'tab' => 'Asset',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'asset' => [
                'label'       => 'Asset',
                'url'         => Backend::url('ams/asset/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['ams.asset.*'],
                'order'       => 500,
            ],
        ];
    }
}
