<?php namespace Ams\Report;

use Backend;
use System\Classes\PluginBase;

/**
 * Report Plugin Information File
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
            'name'        => 'Report',
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
            'Ams\Report\Components\MyComponent' => 'myComponent',
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
            'ams.report.some_permission' => [
                'tab' => 'Report',
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
            'report' => [
                'label'       => 'Report',
                'url'         => Backend::url('ams/report/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['ams.report.*'],
                'order'       => 500,
            ],
        ];
    }
}
