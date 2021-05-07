<?php

namespace App\Admin\Grids;

use App\Models\School;
use Dcat\Admin\Admin;
use Dcat\Admin\Grid;

class SchoolGrid
{
    public function render()
    {

        Admin::style('.complex-container { margin-top:0 !important; height: 730px; overflow-y: auto; overflow-x:auto; } .d-block { display:none !important; }');

        return Grid::make(School::with(['admin']), function (Grid $grid) {

            $grid->column('icon', '校徽')
                ->image('', 80, 80);

            $grid->column('name', '校名');

            $grid->column('type', '教务类型')
                ->using(School::TYPE_MAP);

            $grid->column('state', '状态')
                ->using(School::STATE_MAP)
                ->dot(School::STATE_COLOR_MAP);

            $grid->model()->orderBy('state', 'desc');

            $grid->disableRowSelector();
            $grid->disableFilterButton();
            $grid->disableCreateButton();
            $grid->disableDeleteButton();
            $grid->disableRefreshButton();
            $grid->disableActions();
            $grid->disablePagination();
            $grid->paginate(100);
        });
    }
}
