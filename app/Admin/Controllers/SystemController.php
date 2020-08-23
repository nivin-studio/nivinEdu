<?php

namespace App\Admin\Controllers;

use App\Admin\Metrics\Cpu;
use App\Admin\Metrics\Disk;
use App\Admin\Metrics\Environment;
use App\Admin\Metrics\Load;
use App\Admin\Metrics\Memory;
use App\Http\Controllers\Controller;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;

class SystemController extends Controller
{
    public function info(Content $content)
    {
        return $content
            ->header('系统信息')
            ->body(function (Row $row) {
                $row->column(4, function (Column $column) {
                    $column->row(new Environment());
                });

                $row->column(2, function (Column $column) {
                    $column->row(new Cpu());
                });

                $row->column(2, function (Column $column) {
                    $column->row(new Load());
                });

                $row->column(2, function (Column $column) {
                    $column->row(new Memory());
                });

                $row->column(2, function (Column $column) {
                    $column->row(new Disk());
                });
            });
    }
}
