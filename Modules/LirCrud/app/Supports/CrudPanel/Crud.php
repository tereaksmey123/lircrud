<?php

namespace Modules\LirCrud\app\Supports\CrudPanel;

use Illuminate\Support\Str;
use Modules\LirCrud\app\LirCrud;

class Crud
{
    use \Modules\LirCrud\app\Traits\DumpableTrait;
    use \Modules\LirCrud\app\Supports\CrudPanel\Traits\AccessTrait;
    // use \Modules\BaseApiCore\Supports\CrudPanel\Traits\AutoSetTrait;
    use \Modules\LirCrud\app\Supports\CrudPanel\Traits\SettingTrait;
    // use \Modules\BaseApiCore\Supports\CrudPanel\Traits\ValidationTrait;
    use \Modules\LirCrud\app\Supports\CrudPanel\Traits\OperationTrait;
    use \Modules\LirCrud\app\Supports\CrudPanel\Traits\QueryTrait;
    use \Modules\LirCrud\app\Traits\MacroableTrait;
    // use \Modules\BaseApiCore\Supports\CrudPanel\Traits\SearchTrait;
    use \Modules\LirCrud\app\Supports\CrudPanel\Traits\DataByKeyTrait;
    use \Modules\LirCrud\app\Supports\CrudPanel\Traits\InertiaTrait;
    use \Modules\LirCrud\app\Supports\CrudPanel\Traits\TranslateTrait;

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

    public function setTitle(string $singular, string $plurals): void
    {
        $this->set('pageTitle', Str::ucfirst($this->getOperation().' '.$singular));
        $this->set('pageTitles', Str::ucfirst($this->getOperation().' '.$plurals));
    }
}
