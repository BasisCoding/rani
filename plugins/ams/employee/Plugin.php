<?php namespace Ams\Employee;

use Backend;
use System\Classes\PluginBase;

/**
 * Employee Plugin Information File
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
            'name'        => 'Employee',
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
            'Ams\Employee\Components\MyComponent' => 'myComponent',
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
            'ams.employee.some_permission' => [
                'tab' => 'Employee',
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
            'employee' => [
                'label'       => 'Employee',
                'url'         => Backend::url('ams/employee/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['ams.employee.*'],
                'order'       => 500,
            ],
        ];
    }
}
