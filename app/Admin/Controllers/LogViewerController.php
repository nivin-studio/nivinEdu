<?php

namespace App\Admin\Controllers;

use App\Services\LogViewer\LogViewerService;
use App\Utils\System;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Content;
use Illuminate\Support\Str;

class LogViewerController extends AdminController
{
    /**
     * 主页
     *
     * @param  Content   $content
     * @return Content
     */
    public function index(Content $content)
    {
        $request = app('request');

        $dir  = trim($request->get('dir'));
        $file = trim($request->get('file'));

        $filename = trim($request->get('filename'));
        $keyword  = trim($request->get('keyword'));

        $offset = $request->get('offset');
        $lines  = $keyword ? 500 : 30;

        $logViewerService = new LogViewerService(storage_path('logs'), $dir, $file);

        $logViewerService->setKeyword($keyword);
        $logViewerService->setFilename($filename);

        return $content
            ->header('日志查看器')
            ->body(view('admin.logviewer', [
                'dir'  => $logViewerService->getCurrDir(),
                'file' => $logViewerService->file,

                'logs'     => $logViewerService->fetch($offset, $lines),
                'logFiles' => $this->formatLogFiles($logViewerService, $dir),
                'logDirs'  => $logViewerService->getLogDirectories(),
                'filePath' => $logViewerService->getFilePath(),

                'fileName' => $logViewerService->getFilename(),
                'keyword'  => $logViewerService->getKeyword(),

                'prevUrl' => $this->getPrevPageUrl($logViewerService),
                'nextUrl' => $this->getNextPageUrl($logViewerService),

                'size' => System::conv($logViewerService->getFilesize()),
            ]));

    }

    /**
     * 下载
     *
     */
    public function download()
    {
        $request = app('request');

        $dir      = trim($request->get('dir'));
        $file     = trim($request->get('file'));
        $filename = trim($request->get('filename'));
        $keyword  = trim($request->get('keyword'));

        $viewer = new LogViewerService(storage_path('logs'), $dir, $file);

        $viewer->setKeyword($keyword);
        $viewer->setFilename($filename);

        return response()->download($viewer->getFilePath());
    }

    /**
     * 格式化日志文件列表
     *
     * @param  LogViewerService $logViewer
     * @param  string           $currentDir
     * @return array
     */
    protected function formatLogFiles(LogViewerService $logViewerService, $currentDir)
    {
        return array_map(function ($value) use ($logViewerService, $currentDir) {
            $file = $value;
            $dir  = $currentDir;

            if (Str::contains($value, '/')) {
                $array = explode('/', $value);
                $file  = end($array);

                array_pop($array);
                $dir = implode('/', $array);
            }

            return [
                'file'   => $value,
                'url'    => route('dcat.admin.logviewer', ['file' => $file, 'dir' => $dir]),
                'active' => $logViewerService->isCurrentFile($value),
            ];
        }, $logViewerService->getLogFiles());
    }

    /**
     * 获取上一页URL
     *
     * @param  LogViewerService $logViewerService
     * @return false|string
     */
    protected function getPrevPageUrl(LogViewerService $logViewerService)
    {
        if (
            !$logViewerService->getFilePath()
            || $logViewerService->getOffsetEnd() >= $logViewerService->getFilesize() - 1
            || $logViewerService->getKeyword()
        ) {
            return false;
        }

        return route('dcat.admin.logviewer', [
            'file'     => $logViewerService->getFile(),
            'offset'   => $logViewerService->getOffsetEnd(),
            'keyword'  => $logViewerService->getKeyword(),
            'dir'      => $logViewerService->getCurrDir(),
            'filename' => $logViewerService->getFilename(),
        ]);
    }

    /**
     * 获取下一页URL
     *
     * @param  LogViewerService $logViewerService
     * @return false|string
     */
    protected function getNextPageUrl(LogViewerService $logViewerService)
    {
        if (
            !$logViewerService->getFilePath()
            || $logViewerService->getOffsetStart() == 0
            || $logViewerService->getKeyword()
        ) {
            return false;
        }

        return route('dcat.admin.logviewer', [
            'file'     => $logViewerService->getFile(),
            'offset'   => -$logViewerService->getOffsetStart(),
            'keyword'  => $logViewerService->getKeyword(),
            'dir'      => $logViewerService->getCurrDir(),
            'filename' => $logViewerService->getFilename(),
        ]);
    }
}
