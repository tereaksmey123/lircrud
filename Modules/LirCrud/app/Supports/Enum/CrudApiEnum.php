<?php

namespace Modules\LirCrud\app\Supports\Enum;

Enum CrudApiEnum: string
{
    /**
     * Access key in setting
     */
    case ACCESS = 'access';

    /**
     * 
     */
    case PROPERTY_KEY = 'name';

    /**
     * Operation key in setting & route
     */
    case OPERATION = 'operation';

    /**
     * Configuration key in setting: [operation].[CONFIGURATION]
     */
    case CONFIGURATION = 'configuration';
    
    /**
     * Translate key in setting
     */
    case SET_TRANSLATE = 'setTranslate';
}