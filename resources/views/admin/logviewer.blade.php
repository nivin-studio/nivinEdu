<style>
    .lognav {
        padding-left: 0;
        margin-bottom: 0;
        list-style: none;
    }

    .lognav>li {
        position: relative;
        display: block;
    }

    .lognav-pills>li {
        float: left;
    }

    .lognav-stacked>li {
        float: none;
        width: 100%;
    }

    .lognav>li>a {
        position: relative;
        display: block;
        padding: 6px 15px;
    }

    .lognav-pills>li>a {
        border-radius: 4px;
    }

    .lognav-pills>li>a {
        border-radius: 0;
        border-top: 3px solid transparent;
        color: #444;
    }

    .lognav-stacked>li>a {
        border-radius: 0;
        border-top: 0;
        border-left: 3px solid transparent;
        color: #444;
    }

    .lognav-pills>li>a>.fa,
    .lognav-pills>li>a>.glyphicon,
    .lognav-pills>li>a>.ion {
        margin-right: 5px;
    }

    .lognav-stacked>li.active>a,
    .lognav-stacked>li.active>a:hover {
        background: transparent;
        color: #13c2c2;
        border-top: 0;
        font-weight: 600;
    }

    .lognav>li>a.dir {
        font-size: 1rem;
    }

</style>

<div class="wrapper pl-2 pr-2">
    <div class="row">
        <div class="col-md-2">
            <div class="">

                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-folder-open-o"></i>
                        <a href="{{ route('dcat.admin.logviewer') }}">logs</a>
                        @if ($dir)
                            @php $tmp = ''; @endphp
                            @foreach (explode('/', $dir) as $v)
                                @php $tmp .= '/' . $v; @endphp
                                /
                                <a href="{{ route('dcat.admin.logviewer', ['dir' => trim($tmp, '/')]) }}">
                                    {{ $v }}
                                </a>
                            @endforeach
                        @endif
                    </h3>
                </div>

                <form action="{{ route('dcat.admin.logviewer') }}"
                    style="display: inline-block;width: 220px;padding-left: 15px">
                    <div class="input-group-sm" style="display: inline-block;width: 100%">
                        <input name="filename" class="form-control" value="{{ $fileName }}" type="text"
                            placeholder="搜索" />
                    </div>
                </form>

                <div class="box-body no-padding">
                    <ul class="lognav lognav-pills lognav-stacked">
                        @if (!$fileName)
                            @foreach ($logDirs as $dirs)
                                <li @if ($dirs === $file) class="active" @endif>
                                    <a class="dir" href="{{ route('dcat.admin.logviewer', ['dir' => $dirs]) }}">
                                        <i class="fa fa-folder-o"></i>{{ basename($dirs) }}
                                    </a>
                                </li>
                            @endforeach
                        @endif

                        @foreach ($logFiles as $log)
                            <li @if ($log['active']) class="active" @endif>
                                <a href="{{ $log['url'] }}">
                                    <i class="fa fa-file-text{{ $log['active'] ? '' : '-o' }}"></i>
                                    {{ $log['file'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>

        <div class="col-md-10">
            <div class="box box-primary">
                <div class="box-header with-border">

                    <a href="{{ route('dcat.admin.logviewer.download', ['dir' => $dir, 'file' => $file, 'filename' => $fileName]) }}"
                        class="btn btn-primary btn-sm download" style="color: #fff">
                        <i class="fa-download fa"></i>
                        下载
                    </a>

                    <form action="{{ route('dcat.admin.logviewer') }}" style="display: inline-block;width: 180px">
                        <div class="input-group-sm" style="display: inline-block;width: 100%">
                            <input type="hidden" name="dir" value="{{ $dir }}">
                            <input type="hidden" name="file" value="{{ $file }}">
                            <input type="hidden" name="filename" value="{{ $fileName }}">
                            <input name="keyword" class="form-control" value="{{ $keyword }}" type="text"
                                placeholder="搜索" />
                        </div>
                    </form>

                    <div class="float-right">
                        <a class="">
                            <strong>文件大小:</strong> {{ $size }} &nbsp;
                            <strong>更新时间:</strong> {{ date('Y-m-d H:i:s', filectime($filePath)) }}
                        </a>
                        &nbsp;
                        &nbsp;
                        <div class="btn-group">
                            @if ($prevUrl)
                                <a href="{{ $prevUrl }}" class="btn btn-default btn-sm">
                                    <i class="fa fa-chevron-left"></i> 上一页
                                </a>
                            @endif

                            @if ($nextUrl)
                                <a href="{{ $nextUrl }}" class="btn btn-default btn-sm">
                                    下一页 <i class="fa fa-chevron-right"></i>
                                </a>
                            @endif
                        </div>

                    </div>

                </div>

                <div class="box-body no-padding">
                    <div class="table-responsive">

                        <table class="table table-hover">

                            <thead>
                                <tr>
                                    <th>序号</th>
                                    <th>等级</th>
                                    <th>环境</th>
                                    <th>时间</th>
                                    <th>内容</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($logs as $index => $log)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <span
                                                class="label bg-{{ \App\Services\LogViewer\LogViewerService::$levelColors[$log['level']] }}">
                                                {{ $log['level'] }}
                                            </span>
                                        </td>
                                        <td><strong>{{ $log['env'] }}</strong></td>
                                        <td style="width:150px;">{{ $log['time'] }}</td>
                                        <td>
                                            <pre>{{ $log['info'] }}</pre>
                                        </td>
                                        <td>
                                            @if (!empty($log['trace']))
                                                <button class="btn btn-primary btn-sm" data-toggle="collapse"
                                                    data-target=".trace-{{ $index }}">
                                                    <i class="fa fa-info"></i>&nbsp;&nbsp;展开
                                                </button>
                                            @endif
                                        </td>
                                    </tr>

                                    @if (!empty($log['trace']))
                                        <tr class="collapse trace-{{ $index }}">
                                            <td colspan="6">
                                                <div class="trace-dump">{{ $log['trace'] }}</div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>

                <div class="box-footer">
                    <div class="float-left">
                        <a class="">
                            <strong>文件大小:</strong> {{ $size }} &nbsp;
                            <strong>更新时间:</strong>
                            {{ \Carbon\Carbon::create(date('Y-m-d H:i:s', filectime($filePath)))->diffForHumans() }}
                        </a>
                    </div>
                    &nbsp;
                    &nbsp;
                    <div class="float-right">
                        <div class="btn-group">
                            @if ($prevUrl)
                                <a href="{{ $prevUrl }}" class="btn btn-default btn-sm">
                                    <i class="fa fa-chevron-left"></i> 上一页
                                </a>
                            @endif

                            @if ($nextUrl)
                                <a href="{{ $nextUrl }}" class="btn btn-default btn-sm">
                                    下一页 <i class="fa fa-chevron-right"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

            </div>
        </div>
    </div>
</div>
