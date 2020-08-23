<?php

namespace App\Admin\Controllers;

use App\Admin\Metrics\UsersLine;
use App\Http\Controllers\Controller;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->header('应用概况')
            ->body(function (Row $row) {
                $row->column(3, function (Column $column) {
                    $column->row(new UsersLine());
                });

                $row->column(3, function (Column $column) {
                    $column->row(new UsersLine());
                });

                $row->column(3, function (Column $column) {
                    $column->row(new UsersLine());
                });

                $row->column(3, function (Column $column) {
                    $column->row(new UsersLine());
                });
            });
    }
}
