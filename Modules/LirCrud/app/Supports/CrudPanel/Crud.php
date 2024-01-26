<?php

namespace Modules\LirCrud\app\Supports\CrudPanel;

use Illuminate\Support\Str;
use Modules\LirCrud\app\LirCrud;

class Crud
{
    use \Modules\LirCrud\app\Supports\CrudPanel\Traits\AccessTrait;
    // use \Modules\BaseApiCore\Supports\CrudPanel\Traits\AutoSetTrait;
    use \Modules\LirCrud\app\Supports\CrudPanel\Traits\SettingTrait;
    // use \Modules\BaseApiCore\Supports\CrudPanel\Traits\ValidationTrait;
    use \Modules\LirCrud\app\Supports\CrudPanel\Traits\OperationTrait;
    use \Modules\LirCrud\app\Supports\CrudPanel\Traits\QueryTrait;
    use \Modules\LirCrud\app\Supports\CrudPanel\Traits\MacroableTrait;
    // use \Modules\BaseApiCore\Supports\CrudPanel\Traits\SearchTrait;
    // use \Modules\BaseApiCore\Supports\CrudPanel\Traits\DataByKeyTrait;
    use \Modules\LirCrud\app\Supports\CrudPanel\Traits\InertiaTrait;

    public $model = "\App\Models\Entity";
    public $entry;

    public function __construct()
    {
        if ($operation = $this->getCurrentOperation()) {
            $this->setOperation($operation);
        }

        // $this->initDefaultFieldValue();
        // $this->initDefaultRelationFilterValue();
    }


    // ------------------------------------------------------
    // BASICS - model, route, entity_name, entity_name_plural
    // ------------------------------------------------------

    /**
     * This function binds the CRUD to its corresponding Model (which extends Eloquent).
     * All Create-Read-Update-Delete operations are done using that Eloquent Collection.
     *
     * @param  string  $model_namespace  Full model namespace. Ex: App\Models\Article
     *
     * @throws \Exception in case the model does not exist
     */
    public function setModel(string $modelNamespace)
    {
        if (! class_exists($modelNamespace)) {
            throw new \UnexpectedValueException('The model does not exist.', 500);
        }

        // if (! method_exists($modelNamespace, 'CrudTrait')) {
            // throw new \UnexpectedValueException('Please use CrudTrait on the model.', 500)
        // }

        $this->model = new $modelNamespace();
        $this->query = $this->model->select('*');
        $this->entry = null;
    }

    /**
     * Set page title
     *
     * @param string $singular
     * @param null|string $plural
     */
    public function setTitle($singular, $plurals)
    {
        $this->set('pageTitle', $singular);
        $this->set('pageTitles', $plurals);
    }

    public function lang($key, $replace = [], $local = null)
    {
        // provide a way to move from local to database or any driver
        if (method_exists($this, $method = 'langDriver')) {
            return $this->{$method}($key, $replace, $local);
        }

        return __(LirCrud::MNAME_SYMBOL.'default.'.$key, $replace, $local);
    }
}
