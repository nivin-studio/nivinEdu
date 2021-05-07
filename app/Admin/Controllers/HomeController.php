<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\CreateApp;
use App\Admin\Forms\CreateSchool;
use App\Admin\Grids\SchoolGrid;
use App\Http\Controllers\Controller;
use App\Models\Application;
use Dcat\Admin\Admin;
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
                $row->column(6, function (Column $column) {

                    $column->row(function (Row $row) {
                        $application = Application::where(['admin_id' => Admin::user()->id])->first();

                        if ($application) {
                            $row->column(12, function (Column $column) {
                                $createApp = new CreateApp();
                                $createApp->disableResetButton();
                                $column->row($createApp->render());
                            });
                        } else {
                            $row->column(12, function (Column $column) {
                                $createApp = new CreateApp();
                                $createApp->disableResetButton();
                                $column->row($createApp->render());
                            });

                            $row->column(12, function (Column $column) {
                                $createSchool = new CreateSchool();
                                $createSchool->disableResetButton();
                                $column->row($createSchool->render());
                            });
                        }
                    });
                });

                $row->column(6, function (Column $column) {
                    $schoolGrid = new SchoolGrid();

                    $column->row($schoolGrid->render());
                });
            });
    }
}
