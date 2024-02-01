<?php

namespace Modules\LirCrud\app\Supports\Enum;

Enum PropertyEnum: string
{
    /**
     * Key for property
     */
    case KEY = 'name';

    /**
     * Key for label
     */
    case LABEL = 'label';

    /**
     * Key for component name
     */
    case TYPE = 'type';

    /**
     * Key for translate label
     */
    case TRANSLATE = 'translate';
}