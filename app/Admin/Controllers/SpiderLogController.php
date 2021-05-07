<?php

namespace App\Admin\Controllers;

use App\Models\Application;
use App\Models\SpiderLog;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\Displayers\Actions;
use Dcat\Admin\Grid\Filter;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;
use Dcat\Admin\Show\Field;

class SpiderLogController extends AdminController
{
    /**
     * 爬虫日志
     *
     * @param  Content   $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('爬虫日志')
            ->body($this->grid());
    }

    /**
     * 构建列表
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(SpiderLog::with(['school']), function (Grid $grid) {
            $grid->column('id');
            $grid->column('school.name', '学校');
            $grid->column('request_url', '请求地址');
            $grid->column('request_type', '请求类型');
            $grid->column('request_body', '请求参数')
                ->display(function ($content) {
                    if ($content) {
                        return '查看';
                    } else {
                        return '';
                    }
                })
                ->modal(function ($modal) {
                    // 设置弹窗标题
                    $modal->title('请求参数');
                    $modal->icon('');

                    $requestBody = base64_decode($this->request_body);
                    $requestBody = @iconv('GBK', 'UTF-8', $requestBody);
                    $requestBody = htmlspecialchars($requestBody);
                    $requestBody = explode('&amp;', $requestBody);
                    $requestBody = implode(PHP_EOL, $requestBody);

                    return '<textarea class="form-control" rows="20">'
                        . $requestBody
                        . '</textarea>';
                });

            $grid->column('response_body', '返回结果')
                ->display(function ($content) {
                    if ($content) {
                        return '查看';
                    } else {
                        return '';
                    }
                })
                ->modal(function ($modal) {
                    // 设置弹窗标题
                    $modal->title('返回结果');
                    $modal->icon('');

                    $responseBody = base64_decode($this->response_body);
                    $imagesString = getimagesizefromstring($responseBody);
                    if ($imagesString) {
                        $imageType   = $imagesString['mime'];
                        $imageBase64 = 'data:' . $imageType . ';base64,' . $this->response_body;

                        return '<img style="width: 100%;" class="img img-thumbnail" src="' . $imageBase64 . '" >';
                    } else {
                        $responseBody = @iconv('GBK', 'UTF-8', $responseBody);
                        $responseBody = htmlspecialchars($responseBody);

                        return '<textarea class="form-control" rows="20">'
                            . $responseBody
                            . '</textarea>';
                    }
                });

            $grid->column('state', '状态')
                ->using(SpiderLog::STATE_MAP)
                ->dot(SpiderLog::STATE_COLOR_MAP);
            $grid->column('created_at', '创建时间');
            $grid->column('updated_at', '更新时间');

            $grid->model()->orderBy('created_at', 'desc');

            $grid->disableRowSelector();
            $grid->disableFilterButton();
            $grid->disableCreateButton();
            // 查询过滤
            $grid->filter(function (Filter $filter) {
                $filter->panel();
                $filter->expand();
                $filter->equal('ID', 'ID')->width(2);
            });
            // 查询事件
            $grid->listen(Fetching::class, function ($grid) {
                // 如果管理员用户是普通用户，只看获取自己创建的学校的学生成绩
                if (Admin::user()->isRole('general')) {
                    $application = Application::whereAdminId(Admin::user()->id)->first();
                    $grid->model()->where('application_id', $application ? $application->id : 0);
                }
            });
            // 工具操作
            $grid->actions(function (Actions $actions) {
                $actions->disableDelete();
                $actions->disableEdit();
            });
        });
    }

    /**
     * 构建显示
     *
     * @param  mixed  $id
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, SpiderLog::with(['school']), function (Show $show) {
            $show->field('id');
            $show->field('school.name', '学校');
            $show->field('request_url', '请求地址');
            $show->field('request_type', '请求类型');
            $show->field('request_body', '请求参数');
            $show->field('response_body', '返回结果');
            $show->field('state', '状态')
                ->using(SpiderLog::STATE_MAP)
                ->dot(SpiderLog::STATE_COLOR_MAP);
            $show->field('created_at', '创建时间');
            $show->field('updated_at', '更新时间');
        });
    }

    /**
     * 构建表单
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new SpiderLog(), function (Form $form) {
            $form->display('id');
            $form->text('application_id', '应用ID');
            $form->text('school_id', '学校ID');
            $form->text('request_url', '请求地址');
            $form->text('request_type', '请求类型');
            $form->text('request_body', '请求参数');
            $form->text('response_body', '返回结果');
            $form->select('state', '状态')
                ->options(SpiderLog::STATE_MAP);
            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}
