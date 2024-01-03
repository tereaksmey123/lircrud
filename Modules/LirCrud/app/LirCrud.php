<?php

namespace Modules\LirCrud\app;

use Illuminate\Support\Facades\Route;
use Modules\LirCrud\Macro\RouteMacro;

class LirCrud
{
    /**
     * @var string module name
     */
    const MNAME = 'lircrud';

    /**
     * @var string module name with prefix ::
     */
    const MNAME_SYMBOL = self::MNAME.'::';

    // /**
    //  * @var string key name on request()
    //  */
    // const CURRENT_ON_RESPONSE_FIELD_NAME = 'current_on_response_field_name';

    // /**
    //  * @var string key name on request()
    //  */
    // const CURRENT_ON_RESPONSE_TO_EMPTY = 'current_on_response_to_empty';

    // /**
    //  * @var string Operation setting name
    //  */
    // const DISABLE_ENFORCE_RULE_AFTER_OPERATION = 'disableEnforceRuleAfterOperation';

    // /**
    //  * @var string Operation setting name
    //  */
    // const DISABLE_SEARCH_FILTER_PROTECTION_FROM_BACKEND = 'disableSearchFilterProtectionFromBackend';

    // /**
    //  * @var string Operation setting name
    //  */
    // const DISABLE_AUTO_SEARCH_FILTER_FROM_REQUEST = 'disableAutoSearchFilterFromRequest';

    // /**
    //  * @var string model method scope name
    //  */
    // const ENFORCE_RULE_AFTER_OPERATION_MODEL_SCOPE = 'WithSharing';

    /**
     * @var string Operation setting name
     */
    const FORM_REQUEST = 'FORM_REQUEST';

    public static function appServiceProviderBoot(): void
    {
        // Route::mixin(new RouteMacro);
    }

    public static function getCrudPanel($namespaceOnly = false)
    {
        $class = config(self::MNAME.'.classes.crud')
            ?: \Modules\LirCrud\app\Supports\CrudPanel\Crud::class;

        if ($namespaceOnly) {
            return $class;
        }

        return app($class);
    }

    // public static function getFilterPanel()
    // {
    //     $class = config(self::MNAME.'.classes.filter')
    //         ?: \Modules\BaseApiCore\Supports\FilterPanel::class;

    //     return new $class;
    // }

    // public static function getAggregatePanel(): object
    // {
    //     $class = config(self::MNAME.'.panel_class.aggregate')
    //         ?: \Modules\BaseApiCore\Supports\AggregatePanel::class;
        
    //     return new $class;
    // }

    // public static function enforceRuleAfterOperationModelScope(): string
    // {
    //     return config(self::MNAME.'.enforce_rule_after_operation_model_scope')
    //         ?: self::ENFORCE_RULE_AFTER_OPERATION_MODEL_SCOPE;
    // }

    /**
     * Translate the given message.
     *
     * @param  string|null  $key
     * @param  array  $replace
     * @param  string|null  $locale
     * @return string|array|null
     */
    public static function lang($key, $replace = [], $local = null)
    {
        return __(self::MNAME_SYMBOL.'default.'.$key, $replace, $local);
    }

    // public static function defaultJsonResource(): string
    // {
    //     return config(self::MNAME.'.resource_class.default_json_resource')
    //         ?: \Modules\BaseApiCore\Http\Resources\DefaultJsonResource::class;
    // }

    // public static function defaultOnRelationJsonResource(): string
    // {
    //     return config(self::MNAME.'.resource_class.default_on_relation_json_resource')
    //         ?: \Modules\BaseApiCore\Http\Resources\DefaultOnRelationJsonResource::class;
    // }

    // public static function registerCommands()
    // {
    //     return config(self::MNAME.'.commands') ?: [
    //         \Modules\BaseApiCore\Console\ControllerCommand::class,
    //         \Modules\BaseApiCore\Console\OperationCommand::class,
    //         \Modules\BaseApiCore\Console\ResourceCommand::class
    //     ];
    // }
}
