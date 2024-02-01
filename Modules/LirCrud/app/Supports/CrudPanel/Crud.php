<?php

namespace Modules\LirCrud\app\Supports\CrudPanel;

use Illuminate\Support\Str;
use Modules\LirCrud\app\LirCrud;

class Crud
{
    use \Modules\LirCrud\app\Traits\DumpableTrait;
    use \Modules\LirCrud\app\Supports\CrudPanel\Crud\AccessTrait;
    // use \Modules\BaseApiCore\Supports\CrudPanel\Crud\AutoSetTrait;
    use \Modules\LirCrud\app\Supports\CrudPanel\Crud\SettingTrait;
    // use \Modules\BaseApiCore\Supports\CrudPanel\Crud\ValidationTrait;
    use \Modules\LirCrud\app\Supports\CrudPanel\Crud\OperationTrait;
    use \Modules\LirCrud\app\Supports\CrudPanel\Crud\QueryTrait;
    use \Modules\LirCrud\app\Traits\MacroableTrait;
    // use \Modules\BaseApiCore\Supports\CrudPanel\Crud\SearchTrait;
    use \Modules\LirCrud\app\Supports\CrudPanel\Crud\PropertyTrait;
    use \Modules\LirCrud\app\Supports\CrudPanel\Crud\ResponseTrait;
    use \Modules\LirCrud\app\Supports\CrudPanel\Crud\TranslateTrait;

    public $model = "\App\Models\Entity";
    public $entry;

    public function __construct()
    {
        $this->setDefaultTranslate();
        
        if ($operation = $this->getOperation()) {
            $this->setOperation($operation);
        }

        // $this->initDefaultFieldValue();
        // $this->initDefaultRelationFilterValue();
    }

    /**
     * Set model for crud operations
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

    public function setTitle(string $singular, string $plurals, bool $operation = true): void
    {
        $prefix = $operation ? $this->getOperation().' ' : '';
        
        $this->set('pageTitle', Str::ucfirst($prefix.$singular));
        $this->set('pageTitles', Str::ucfirst($prefix.$plurals));
    }
}
