<?php
/**
 * 
 * This file is auto generate by Nicelizhi\Apps\Commands\Create
 * @author Steve
 * @date 2024-07-31 16:40:01
 * @link https://github.com/xxxl4
 * 
 */
return [
    /**
     * Apps Dashboard.
     */
    [
        'key'        => 'Apps',
        'name'       => 'apps::app.apps.demo',
        'route'      => 'apps.admin.example.demo',
        'sort'       => 1,
        'icon'       => 'icon-dashboard',
        'permission' => 'apps.admin.example.demo',
    ],
    [
        'key'        => 'Apps.Settings',
        'name'       => 'apps::app.apps.Settings',
        'route'      => 'apps.admin.apps.setting',
        'sort'       => 2,
        'icon'       => 'icon-dashboard',
        'permission' => 'apps.admin.settings.index',
    ]
    // ],
    // [
    //     'key'        => 'Apps.Packages',
    //     'name'       => 'apps::app.apps.Packages',
    //     'route'      => 'apps.admin.packages.index',
    //     'sort'       => 3,
    //     'icon'       => 'icon-dashboard',
    //     'permission' => 'apps.admin.rules.index',
    // ]
];