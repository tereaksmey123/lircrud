<?php

namespace Modules\LirCrud\app\Http\Controllers\Admin;

use CrudController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\LirCrud\app\Supports\Facades\Crud;
use Modules\LirCrud\app\Traits\Controllers\Operations\ListOperationTrait;

class UserController extends \Modules\LirCrud\app\Supports\CrudPanel\Controllers\CrudController
{
    use \Modules\LirCrud\app\Traits\Controllers\Operations\ListOperationTrait;
    use \Modules\LirCrud\app\Traits\Controllers\Operations\CreateOperationTrait;

    public function setup()
    {
        Crud::setModel(User::class);
        Crud::setTitle('User', 'Users');
        /**
         * List of global disable operation setting
         * ----------------------------------------
         * $this->crud->disableAutoSearchFilterFromRequest();
         *
         * $this->crud->disableSearchFilterProtectionFromBackend();
         *
         * $this->disableEnforceRuleAfterOperation();
         */

        /**
         * List of global set operation setting
         *
         * Override default will make some of global disable operation to stop working
         * 
         * Depend on how you implement your code
         * -------------------------------------
         * $this->crud->setDefaultJsonResource(JsonResource::class);
         *
         * $this->crud->setDefaultOnRelationJsonResource(JsonResource::class);
         *
         * $this->crud->setDefaultAggregatePanel(AggregatePanel::class);
         */

        /**
         * Apply some default to single or multiple operation without declare a operation function
         *
         * Operation Name: string / array
         * 
         * Example: 'list' or ['list', 'showById']
         */
        // $this->crud->operation('Operation Name', function () {
        //     // add field / add clause or whatever
        // });

        /**
         * How to use addField()
         *
         * Below is avialable key to set
         * 
         * (string) name: column_name|Accessor|custom_name with onRelation
         *
         * (boolean) onCreateUpdate: allow or deny to add to create/update
         *
         * (boolean) onFilter: allow or deny to use filters
         *
         * (boolean) onResponse: allow or deny to display on response
         *
         * (closure($resource, $fieldName)) onRelation: use to apply relation data
         *
         * (closure($field)) onAggregate: use to allow or deny list of function from request
         */

        // $this->crud->addField([
        //     'name' => 'id',
        // ])

        // $this->crud->addField([
        //     'name' => 'account_info',
        //     'onRelation' => fn ($resource, $fieldName) => $this->crud->onRelationClosure(
        //         $resource,
        //         $fieldName,
        //         'relationMethodName',
        //         // [], // EagerLoading with()
        //         // JsonResource::class // generate sample to custom resource: php artisan fsc:make-baseapicore-resource
        //     )
        // ])

        /**
         * All regisger aggregate/custom will add to $this->query->select(<aggregate>)
         *
         * Default Aggregate: count, sum, avg, min, max
         *
         * $this->crud->onAggregateClosure(), first argument use case
         *
         * ['count', 'sum']
         * ['count', 'count_as_new' => fn ($field) => fn ($field) => DB::raw('count('.$field.') as count_as_new')]
         */
        // $this->crud->addField([
        //     'name' => 'domain',
        //     'onAggregate' => fn ($field) => $this->crud->onAggregateClosure(
        //         // [], // select/add/replace exists default aggregate
        //         // true // remove default aggregate
        //     )
        // ]);

        /**
         * How to use addRelationFilter()
         *
         * Below is avialable key to set
         * 
         * (string) name: relation method name in model
         *
         * (array) fields: allow field filter inside relation or only check has relation
         */
        // $this->crud->addRelationFilter([
        //     'name' => 'contact',
        //     // 'fields' => [] // when empty - it will only check has relation or not
        //     // 'fields' => ['field', field'] // when has value - it will allow field filter inside relation
        // ]);
    }
}
