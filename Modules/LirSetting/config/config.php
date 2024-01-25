<?php

return [
    'migration_enable' => true, // enable migration to run

    /**
     * Add crud to route
     *
     * Disable when you don't need crud ui
     * Disable when you want to add-on on route configuration
     */

    'crud_ui_enable' => true,

    /**
     * Below config when you want to override
     */

    // 'controller' => SettingCrudController::class,
    // 'model' => Setting::class,
    // 'prefix' => 'settings',
    // 'table' => 'settings',
];
