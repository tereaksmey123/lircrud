<?php

namespace Modules\LirCrud\app\Supports\CrudPanel\Crud;

use Modules\LirCrud\app\Supports\Enum\CrudApiEnum;
use Modules\LirCrud\app\Exceptions\AccessDeniedException;

trait AccessTrait
{
    public function allowAccess(string|array $operations): bool
    {
        foreach ((array) $operations as $op) {
            $this->set($op.'.'.CrudApiEnum::ACCESS->value, true);
        }

        return $this->hasAccessToAll($operations);
    }

    public function denyAccess(string|array $operations): bool
    {
        foreach ((array) $operations as $op) {
            $this->set($op.'.'.CrudApiEnum::ACCESS->value, false);
        }

        return ! $this->hasAccessToAny($operations);
    }

    public function hasAccess(string $operation): bool
    {
        return $this->get($operation.'.'.CrudApiEnum::ACCESS->value) ?? false;
    }

    public function hasAccessToAny(string|array $operations): bool
    {
        foreach ((array) $operations as $op) {
            if ($this->get($op.'.'.CrudApiEnum::ACCESS->value) === true) {
                return true;
            }
        }

        return false;
    }

    public function hasAccessToAll(string|array $operations): bool
    {
        foreach ((array) $operations as $op) {
            if (! $this->get($op.'.'.CrudApiEnum::ACCESS->value)) {
                return false;
            }
        }

        return true;
    }

    public function hasAccessOrFail(string $operation): AccessDeniedException|bool
    {
        if (! $this->get($operation.'.'.CrudApiEnum::ACCESS->value)) {
            throw new AccessDeniedException(
                // $this->get($operation.'.'.CrudApiEnum::ACCESS->value)
                $this->lirTrans('default.deny_access_on_operation', [
                    'operation' =>  $this->lirTrans('default.'.$operation)]
                )
            );
        }

        return true;
    }
}
