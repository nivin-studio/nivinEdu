<?php

namespace App\Admin\Controllers;

use App\Admin\Metrics\NumCard;
use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\School;
use App\Models\User;
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
                $row->column(4, function (Column $column) {
                    $numCard = new NumCard();
                    $numCard->title('学校数');
                    $numCard->setNum(School::count());
                    $column->row($numCard);
                });

                $row->column(4, function (Column $column) {
                    $numCard = new NumCard();
                    $numCard->title('学生数');
                    $numCard->setNum(User::count());
                    $column->row($numCard);
                });

                $row->column(4, function (Column $column) {
                    $numCard = new NumCard();
                    $numCard->title('成绩数');
                    $numCard->setNum(Grade::count());
                    $column->row($numCard);
                });

            });
    }
}
