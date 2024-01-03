<?php

namespace Modules\LirCrud\app\Traits\Controllers\Operations;

use Modules\BaseApiCore\BaseApiCore;
use Illuminate\Support\Facades\Route;

trait DeleteByIdOperationTrait
{
    /**
     * Registe Route
     *
     * @param string $segment
     * @param string $controller
     */
    protected function setupDeleteByIdRoutes($segment, $controller, $extraData, $operation = 'deleteById'): void
    {
        if ($extraData) {
            // fix sonar bro
        } 

        Route::delete($segment.'/{id}', [
            // 'as'        => $segment.'.index',
            'uses'      => $controller.'@'.$operation,
            'operation' => $operation,
        ]);
    }

    protected function setupDeleteByIdDefault(): void
    {
        $this->crud->allowAccess('deleteById');
        $this->enableForceDeleteById(true);
    }

    /**
     * Enable force delete or disable by pass argument
     *
     * @param bool $forceDisable
     */
    protected function enableForceDeleteById($forceDisable = false): void
    {
        $this->crud->setOperationSetting(
            'enableForceDeleteById',
            $forceDisable ? false : true
        );
    }

    public function deleteById()
    {
        $this->crud->hasAccessOrFail('deleteById');

        $isEnableForceDelete = $this->crud->getOperationSetting('enableForceDeleteById')
            && request()->force_delete == 1;

        if ($isEnableForceDelete) {
            $this->crud->addClause('withTrashed');
        }

        if (! $entry = $this->crud->query->find(request()->route('id'))) {
            return $this->responseFail(
                $this->crud->getLanguageOperationSetting($key = 'not_found')
                    ?: BaseApiCore::facade()::lang($key)
            );
        }

        if ($isEnableForceDelete) {
            $isDeleted = $entry->forceDelete();
        } else {
            $isDeleted = $entry->delete();
        }

        // key: event_error_msg use to support observer fail delete message
        if (! $isDeleted) {
            return $this->responseFail(
                $this->crud->getLanguageOperationSetting($key = 'fail_to_delete')
                    ?: (request()->event_error_msg ?: BaseApiCore::facade()::lang($key)),
                400
            );
        }

        return $this->responseOK(
            $this->crud->getLanguageOperationSetting($key = 'success_delete')
                ?: BaseApiCore::facade()::lang($key)
        );
    }
}
