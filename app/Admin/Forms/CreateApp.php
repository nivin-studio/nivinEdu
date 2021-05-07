<?php

namespace App\Admin\Forms;

use App\Models\Application;
use App\Models\School;
use Dcat\Admin\Admin;
use Dcat\Admin\Contracts\LazyRenderable;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Widgets\Form;

class CreateApp extends Form implements LazyRenderable
{
    use LazyWidget;
    /**
     * Handle the form request.
     *
     *
     * @param  array   $input
     * @return mixed
     */
    public function handle(array $input)
    {
        $schoolId = $input['school_id'] ?? 0;

        $schoolInfo = School::whereId($schoolId)->first();
        if (!$schoolInfo) {
            return $this->response()->error('参数错误');
        }

        $cuurTime = time();
        $isCreate = Application::create([
            'admin_id'  => Admin::user()->id,
            'school_id' => $schoolInfo->id,
            'api_no'    => $cuurTime,
            'api_key'   => md5($cuurTime . mt_rand(100, 999)),
        ]);
        if (!$isCreate) {
            return $this->response()->error('创建失败');
        }

        return $this->response()->success('创建成功')->refresh();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $activeSchool = School::active()
            ->mapWithKeys(function ($item) {
                return [$item['id'] => $item['name']];
            });

        $this->select('school_id', '学校')
            ->options($activeSchool)
            ->required();
    }

    /**
     * 提交按钮文本.
     *
     * @return string
     */
    protected function getSubmitButtonLabel()
    {
        return '创建';
    }

    /**
     * 渲染
     *
     * @return string
     */
    public function render()
    {
        $application = Application::where(['admin_id' => Admin::user()->id])->first();

        if ($application) {
            return '<div class="card">
                        <div class="box-header with-border">
                            <h3 class="box-title" style="line-height:30px">' . $application->school->name . '</h3>
                            <div class="pull-right"></div>
                        </div>
                        <div class="box-body">
                        <div class="row">
                            <div class="col-md-3" style="display:flex;align-items: center;justify-content: center;">
                            <img src="' . $application->school->icon . '" style="max-width:100%;max-height:100%;" class="img img-thumbnail">
                            </div>
                            <div class="col-md-9" style="padding-left: 0px;">
                                <div class="row form-group">
                                    <div class="col-md-3 control-label">apiNo：</div>
                                    <div class="col-md-9 control-label" style="text-align: left;padding-left: 0px; text-transform: none">' . $application->api_no . '</div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-3 control-label">apiKey：</div>
                                    <div class="col-md-9 control-label" style="text-align: left;padding-left: 0px; text-transform: none">' . $application->api_key . '</div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-3 control-label">H5地址：</div>
                                    <div class="col-md-9 control-label" style="text-align: left;padding-left: 0px; text-transform: none;">' . route('mobile.school', ['appid' => $application->hashid()]) . '</div>
                                </div>
                            </div>
                        </div>
                </div>
                 </div>';
        } else {
            return '<div class="card">
                        <div class="box-header with-border">
                            <h3 class="box-title" style="line-height:30px">创建应用</h3>
                            <div class="pull-right"></div>
                        </div>
                        <div class="box-body">
                            ' . parent::render() .
                '</div>
                 </div>';
        }
    }
}
