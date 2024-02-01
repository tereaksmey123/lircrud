<?php

namespace Modules\LirCrud\app\Supports\CrudPanel\Crud;

use Modules\LirCrud\app\Supports\Enum\CrudEnum;
use Modules\LirCrud\app\Exceptions\AccessDeniedException;

trait AccessTrait
{
    public function allowAccess(string|array $operations): bool
    {
        foreach ((array) $operations as $op) {
            $this->set($op.'.'.CrudEnum::ACCESS->value, true);
        }

        return $this->hasAccessToAll($operations);
    }

    public function denyAccess(string|array $operations): bool
    {
        foreach ((array) $operations as $op) {
            $this->set($op.'.'.CrudEnum::ACCESS->value, false);
        }

        return ! $this->hasAccessToAny($operations);
    }

    public function hasAccess(string $operation): bool
    {
        return $this->get($operation.'.'.CrudEnum::ACCESS->value) ?? false;
    }

    public function hasAccessToAny(string|array $operations): bool
    {
        foreach ((array) $operations as $op) {
            if ($this->get($op.'.'.CrudEnum::ACCESS->value) === true) {
                return true;
            }
        }

        return false;
    }

    public function hasAccessToAll(string|array $operations): bool
    {
        foreach ((array) $operations as $op) {
            if (! $this->get($op.'.'.CrudEnum::ACCESS->value)) {
                return false;
            }
        }

        return true;
    }

    public function hasAccessOrFail(string $operation): AccessDeniedException|bool
    {
        if (! $this->get($operation.'.'.CrudEnum::ACCESS->value)) {
            throw new AccessDeniedException(
                // $this->get($operation.'.'.CrudEnum::ACCESS->value)
                $this->lirTrans('default.deny_access_on_operation', [
                    'operation' =>  $this->lirTrans('default.'.$operation)]
                )
            );
        }

        return true;
    }
}
