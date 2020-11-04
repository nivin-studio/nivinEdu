<?php

namespace App\Admin\Grid\RowAction;

use Dcat\Admin\Grid\RowAction;
use Illuminate\Http\Request;

class TaskExecute extends RowAction
{
    public function html()
    {
        return <<<HTML
<i class="{$this->getElementClass()} fa fa-rocket"></i>
HTML;
    }

    public function handle(Request $request)
    {
        try {
            $class = $request->class;
            $id    = $this->getKey();

            $model = $class::find($id);
            $model->execute();

            return $this->response()->success("success")->refresh();
        } catch (\Exception $e) {
            return $this->response()->error($e->getMessage());
        }
    }

    public function parameters()
    {
        return [
            'class' => $this->modelClass(),
        ];
    }

    public function modelClass()
    {
        return get_class($this->parent->model()->eloquent()->repository()->eloquent());
    }
}
