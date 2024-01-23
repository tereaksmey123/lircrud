<?php

namespace Modules\LirCrud\app\Supports\CrudPanel\Traits;

use Modules\LirCrud\app\LirCrud;
use Modules\LirCrud\app\Exceptions\AccessDeniedException;

trait AccessTrait
{
    private $accessKey = 'access';
    /**
     * Set an operation as having access using the Settings API.
     *
     * @param  array  $operation
     * @return bool
     */
    public function allowAccess($operation)
    {
        foreach ((array) $operation as $op) {
            $this->set($op.'.'.$this->accessKey, true);
        }

        return $this->hasAccessToAll($operation);
    }

    /**
     * Disable the access to a certain operation, or the current one.
     *
     * @param  array  $operation  [description]
     * @return [type] [description]
     */
    public function denyAccess($operation)
    {
        foreach ((array) $operation as $op) {
            $this->set($op.'.'.$this->accessKey, false);
        }

        return ! $this->hasAccessToAny($operation);
    }

    /**
     * Check if a operation is allowed for a Crud Panel. Return false if not.
     *
     * @param  string  $operation
     * @return bool
     */
    public function hasAccess($operation)
    {
        return $this->get($operation.'.'.$this->accessKey) ?? false;
    }

    /**
     * Check if any operations are allowed for a Crud Panel. Return false if not.
     *
     * @param  array  $operation_array
     * @return bool
     */
    public function hasAccessToAny($operation_array)
    {
        foreach ((array) $operation_array as $operation) {
            if ($this->get($operation.'.'.$this->accessKey) === true) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if all operations are allowed for a Crud Panel. Return false if not.
     *
     * @param  array  $operation_array  Permissions.
     * @return bool
     */
    public function hasAccessToAll($operation_array)
    {
        foreach ((array) $operation_array as $operation) {
            if (! $this->get($operation.'.'.$this->accessKey)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if a operation is allowed for a Crud Panel. Fail if not.
     *
     * @param  string  $operation
     * @return bool
     *
     * @throws AccessDeniedException in case the operation is not enabled
     */
    public function hasAccessOrFail($operation)
    {
        if (! $this->get($operation.'.'.$this->accessKey)) {
            throw new AccessDeniedException(
                // $this->get($operation.'.'.$this->accessKey)
               $this->lang('deny_access_on_operation', ['operation' => $operation])
            );
        }

        return true;
    }
}
