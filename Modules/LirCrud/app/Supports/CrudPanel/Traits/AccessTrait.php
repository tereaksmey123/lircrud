<?php

namespace Modules\LirCrud\app\Supports\CrudPanel\Traits;

use Modules\LirCrud\app\Exceptions\AccessDeniedException;

trait AccessTrait
{
    private string $setAccessKey = 'access';
    
    public function allowAccess(string|array $operations): bool
    {
        foreach ((array) $operations as $op) {
            $this->set($op.'.'.$this->setAccessKey, true);
        }

        return $this->hasAccessToAll($operations);
    }

    public function denyAccess(string|array $operations): bool
    {
        foreach ((array) $operations as $op) {
            $this->set($op.'.'.$this->setAccessKey, false);
        }

        return ! $this->hasAccessToAny($operations);
    }

    public function hasAccess(string $operation): bool
    {
        return $this->get($operation.'.'.$this->setAccessKey) ?? false;
    }

    public function hasAccessToAny(string|array $operations): bool
    {
        foreach ((array) $operations as $op) {
            if ($this->get($op.'.'.$this->setAccessKey) === true) {
                return true;
            }
        }

        return false;
    }

    public function hasAccessToAll(string|array $operations): bool
    {
        foreach ((array) $operations as $op) {
            if (! $this->get($op.'.'.$this->setAccessKey)) {
                return false;
            }
        }

        return true;
    }

    public function hasAccessOrFail(string $operation): AccessDeniedException|bool
    {
        if (! $this->get($operation.'.'.$this->setAccessKey)) {
            throw new AccessDeniedException(
                // $this->get($operation.'.'.$this->setAccessKey)
                $this->lirTrans('default.deny_access_on_operation', [
                    'operation' =>  $this->lirTrans('default.'.$operation)]
                )
            );
        }

        return true;
    }
}
