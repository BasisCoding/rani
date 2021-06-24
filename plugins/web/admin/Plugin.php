<?php namespace Web\Admin;

use Backend;
use System\Classes\PluginBase;

/**
 * Admin Plugin Information File
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
            'name'        => 'Admin',
            'description' => 'No description provided yet...',
            'author'      => 'Web',
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
        // return []; // Remove this line to activate
        return [
            'Web\Admin\Components\AdminDashboard'             => 'AdminDashboard',

            'Web\Admin\Components\AdminLetter'                => 'AdminLetter',
            'Web\Admin\Components\AdminLetterDetail'          => 'AdminLetterDetail',

            'Web\Admin\Components\AdminReport'                => 'AdminReport',
            'Web\Admin\Components\AdminReportDetail'          => 'AdminReportDetail',

            'Web\Admin\Components\AdminLabel'                 => 'AdminLabel',

            'Web\Admin\Components\AdminAsset'                 => 'AdminAsset',
            'Web\Admin\Components\AdminAssetItem'             => 'AdminAssetItem',
            'Web\Admin\Components\AdminAssetDetail'           => 'AdminAssetDetail',
            'Web\Admin\Components\AdminAssetLocationDetail'   => 'AdminAssetLocationDetail',
            'Web\Admin\Components\AdminCategory'              => 'AdminCategory',
            'Web\Admin\Components\AdminCategoryDetail'        => 'AdminCategoryDetail',
            'Web\Admin\Components\AdminCategoryItem'          => 'AdminCategoryItem',
            'Web\Admin\Components\AdminStatus'                => 'AdminStatus',
            'Web\Admin\Components\AdminStatusDetail'          => 'AdminStatusDetail',

            'Web\Admin\Components\AdminEmployee'              => 'AdminEmployee',
            'Web\Admin\Components\AdminEmployeeDetail'        => 'AdminEmployeeDetail',
            'Web\Admin\Components\AdminDepartment'            => 'AdminDepartment',
            'Web\Admin\Components\AdminDepartmentDetail'      => 'AdminDepartmentDetail',
            'Web\Admin\Components\AdminTeam'                  => 'AdminTeam',
            'Web\Admin\Components\AdminTeamDetail'            => 'AdminTeamDetail',
            'Web\Admin\Components\AdminUnit'                  => 'AdminUnit',
            'Web\Admin\Components\AdminUnitDetail'            => 'AdminUnitDetail',

            'Web\Admin\Components\AdminLocation'              => 'AdminLocation',
            'Web\Admin\Components\AdminLocationDetail'        => 'AdminLocationDetail',
            'Web\Admin\Components\AdminOffice'                => 'AdminOffice',
            'Web\Admin\Components\AdminOfficeDetail'          => 'AdminOfficeDetail',
            'Web\Admin\Components\AdminBuilding'              => 'AdminBuilding',
            'Web\Admin\Components\AdminBuildingDetail'        => 'AdminBuildingDetail',
            'Web\Admin\Components\AdminRoom'                  => 'AdminRoom',
            'Web\Admin\Components\AdminRoomDetail'            => 'AdminRoomDetail',

            'Web\Admin\Components\AdminUser'                  => 'AdminUser',
            'Web\Admin\Components\AdminUserDetail'            => 'AdminUserDetail',

            'Web\Admin\Components\AdminPartner'               => 'AdminPartner',
            'Web\Admin\Components\AdminPartnerDetail'         => 'AdminPartnerDetail',
            'Web\Admin\Components\AdminPartnerCategory'       => 'AdminPartnerCategory',
            'Web\Admin\Components\AdminPartnerCategoryDetail' => 'AdminPartnerCategoryDetail',

            'Web\Admin\Components\AdminSetting'               => 'AdminSetting',

            'Web\Admin\Components\AdminReminder'              => 'AdminReminder',
            'Web\Admin\Components\AdminReminderDetail'        => 'AdminReminderDetail',
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
            'web.admin.some_permission' => [
                'tab' => 'Admin',
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
            'admin' => [
                'label'       => 'Admin',
                'url'         => Backend::url('web/admin/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['web.admin.*'],
                'order'       => 500,
            ],
        ];
    }
}
