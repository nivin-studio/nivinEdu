<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\BindSchool;
use App\Admin\Forms\CreateSchool;
use App\Http\Controllers\Controller;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;

class HomeController extends Controller
{
    /**
     * 主页
     *
     * @param  Content   $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('主页')
            ->body(function (Row $row) {
                $row->column(4, function (Column $column) {

                    $column->row(function (Row $row) {
                        $row->column(12, function (Column $column) {
                            $bindSchool = new BindSchool();
                            $bindSchool->disableResetButton();
                            $column->row($bindSchool->render());
                        });

                        $row->column(12, function (Column $column) {
                            $createSchool = new CreateSchool();
                            $createSchool->disableResetButton();
                            $column->row($createSchool->render());
                        });
                    });

                });
            });
    }
}
