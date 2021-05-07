<?php

namespace App\Services\LogViewer;

use Exception;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use SplFileInfo;

class LogViewerService
{
    /**
     * 文件系统
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    public $filesystem;

    /**
     * 日志文件
     *
     * @var string
     */
    public $file;

    /**
     * 根目录
     *
     * @var string
     */
    protected $basePath;

    /**
     * 当前目录（相对目录）
     *
     * @var string
     */
    protected $currDir;

    /**
     * 日志文件路径
     *
     * @var string
     */
    protected $filePath;

    /**
     * 开始偏移量
     *
     * @var array
     */
    protected $offsetStart = 0;

    /**
     * 结束偏移量
     *
     * @var array
     */
    protected $offsetEnd = 0;

    /**
     * 关键字
     *
     * @var string
     */
    protected $keyword;

    /**
     * 文件名
     *
     * @var string|string[]
     */
    protected $filename;

    /**
     * 日志等级颜色
     *
     * @var array
     */
    public static $levelColors = [
        'EMERGENCY' => 'black',
        'ALERT'     => 'navy',
        'CRITICAL'  => 'maroon',
        'ERROR'     => 'danger',
        'WARNING'   => 'orange',
        'NOTICE'    => 'light-blue',
        'INFO'      => 'primary',
        'DEBUG'     => 'light',
    ];

    /**
     * 构造函数
     *
     *
     * @param  string      $basePath
     * @param  string      $dir
     * @param  string|null $file
     * @return void
     */
    public function __construct($basePath, $dir, $file = null)
    {
        $this->basePath = $this->getRealPath(rtrim($basePath, '/'));
        $this->currDir  = $this->formatPath(rtrim($dir, '/'));
        $this->file     = $this->formatPath($file);

        $this->filesystem = new Filesystem();
    }

    /**
     * 设置关键字
     *
     * @param  string $value
     * @return void
     */
    public function setKeyword($value)
    {
        $this->keyword = strtolower($value);
    }

    /**
     * 获取关键字
     *
     * @return string
     */
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * 设置文件名
     *
     * @param  string $value
     * @return void
     */
    public function setFilename($value)
    {
        $this->filename = $this->formatPath($value);
    }

    /**
     * 获取文件名
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * 获取开始偏移量
     *
     * @return string
     */
    public function getOffsetStart()
    {
        return $this->offsetStart;
    }

    /**
     * 获取结束偏移量
     *
     * @return string
     */
    public function getOffsetEnd()
    {
        return $this->offsetEnd;
    }

    /**
     * 获取当前目录
     *
     * @return string
     */
    public function getCurrDir()
    {
        return $this->currDir;
    }

    /**
     * 获取下一个起始偏移量
     *
     * @return int|float|false
     */
    public function getNextOffset()
    {
        if ($this->offsetStart == 0) {
            return false;
        }

        return -$this->offsetStart;
    }

    /**
     * 获取日志内容
     *
     * @param  int     $offset 起始偏移量
     * @param  int     $lines  获取行数
     * @param  int     $buffer 读取字节数
     * @return array
     */
    public function fetch($offset = 0, $lines = 20, $buffer = 4096)
    {
        $logs = $this->read($offset, $lines, $buffer);

        if (!$this->keyword || !$logs) {
            return $logs;
        }

        $result = [];

        foreach ($logs as $log) {
            if (Str::contains(strtolower(implode(' ', $log)), $this->keyword)) {
                $result[] = $log;
            }
        }

        if (count($result) >= $lines || !$this->getNextOffset()) {
            return $result;
        }

        return array_merge($result, $this->fetch($this->getNextOffset(), $lines - count($result), $buffer));
    }

    /**
     * 读取日志文件
     *
     * @param  int     $offset 起始偏移量
     * @param  int     $lines  获取行数
     * @param  int     $buffer 读取字节数
     * @return array
     */
    protected function read($offset = 0, $lines = 20, $buffer = 4096)
    {
        if (!$filePath = $this->getFilePath()) {
            return [];
        }

        $file = fopen($filePath, 'rb');

        if ($offset) {
            fseek($file, abs($offset));
        } else {
            fseek($file, 0, SEEK_END);
        }

        if (fread($file, 1) != "\n") {
            $lines -= 1;
        }
        fseek($file, -1, SEEK_CUR);

        if ($offset > 0) {
            // 从前往后读,上一页
            $output = $this->readPrevPage($file, $lines, $buffer);
        } else {
            // 从后往前读,下一页
            $output = $this->readNextPage($file, $lines, $buffer);
        }

        fclose($file);

        return $this->parserLogText($output);
    }

    /**
     * 读取上一页日志文件
     *
     * @param  resource $file   文件
     * @param  int      $lines  获取行数
     * @param  int      $buffer 读取字节数
     * @return string
     */
    protected function readPrevPage($file, &$lines, $buffer)
    {
        $output = '';

        $this->offsetStart = ftell($file);

        while (!feof($file) && $lines >= 0) {
            $output = $output . ($chunk = fread($file, $buffer));
            $lines -= substr_count($chunk, "\n[20");
        }

        $this->offsetEnd = ftell($file);

        while ($lines++ < 0) {
            $strpos = strrpos($output, "\n[20") + 1;
            $_      = mb_strlen($output, '8bit') - $strpos;
            $output = substr($output, 0, $strpos);
            $this->offsetEnd -= $_;
        }

        return $output;
    }

    /**
     * 读取下一页日志文件
     *
     * @param  resource $file   文件
     * @param  int      $lines  获取行数
     * @param  int      $buffer 读取字节数
     * @return string
     */
    protected function readNextPage($file, &$lines, $buffer)
    {
        $output = '';

        $this->offsetEnd = ftell($file);

        while (ftell($file) > 0 && $lines >= 0) {
            $offset = min(ftell($file), $buffer);
            fseek($file, -$offset, SEEK_CUR);
            $output = ($chunk = fread($file, $offset)) . $output;
            fseek($file, -mb_strlen($chunk, '8bit'), SEEK_CUR);
            $lines -= substr_count($chunk, "\n[20");
        }

        $this->offsetStart = ftell($file);

        while ($lines++ < 0) {
            $strpos = strpos($output, "\n[20") + 1;
            $output = substr($output, $strpos);
            $this->offsetStart += $strpos;
        }

        return $output;
    }

    /**
     * 解析日志文本
     *
     * @param  string  $raw
     * @return array
     */
    protected function parserLogText($raw)
    {
        $logs = preg_split(
            '/\[(\d{4}(?:-\d{2}){2} \d{2}(?::\d{2}){2})\] (\w+)\.(\w+):((?:(?!{"exception").)*)?/',
            trim($raw),
            -1,
            PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY
        );

        if ($logs) {
            foreach ($logs as $index => $log) {
                if (preg_match('/^\d{4}/', $log)) {
                    break;
                } else {
                    unset($logs[$index]);
                }
            }
        }

        if (empty($logs)) {
            return [];
        }

        $parsed = [];

        foreach (array_chunk($logs, 5) as $log) {
            $parsed[] = [
                'time'  => $log[0] ?? '',
                'env'   => $log[1] ?? '',
                'level' => $log[2] ?? '',
                'info'  => $log[3] ?? '',
                'trace' => $this->replaceRootPath(trim($log[4] ?? '')),
            ];
        }

        unset($logs);

        rsort($parsed);

        return $parsed;
    }

    /**
     * 获取真实路径
     *
     * @param  string   $path
     * @return string
     */
    protected function getRealPath($path)
    {
        try {
            $paths = explode('/', $path);

            $result = '';
            foreach ($paths as $v) {
                $result .= $v . '/';

                $current = rtrim($result, '/');
                if (is_link($current)) {
                    $result = readlink($current) . '/';
                }
            }

            return rtrim($result, '/');
        } catch (Exception $e) {
            return $path;
        }
    }

    /**
     * 格式化路径
     *
     * @param  string   $path
     * @return string
     */
    protected function formatPath($path)
    {
        return str_replace(['../'], '', $path);
    }

    /**
     * 获取文件路径
     *
     * @return string
     */
    public function getFilePath()
    {
        if (!$this->filePath) {
            $path = $this->getCurrPath() . '/' . $this->getFile();

            $this->filePath = is_file($path) ? $path : false;
        }

        return $this->filePath;
    }

    /**
     * 获取日志文件
     *
     * @return string
     */
    public function getFile()
    {
        if (!$this->file) {
            $this->file = $this->getLastModifiedLog();
        }

        return $this->file;
    }

    /**
     * 获取最后一次修改的日志文件
     *
     * @return string
     */
    public function getLastModifiedLog()
    {
        return current($this->getLogFiles());
    }

    /**
     * 拼接当前目录（相对目录）
     *
     * @return string
     */
    public function getCurrPath()
    {
        if (!$this->currDir) {
            return $this->getLogBasePath();
        }

        return $this->getLogBasePath() . '/' . $this->currDir;
    }

    /**
     * 获取根目录
     *
     * @return string
     */
    public function getLogBasePath()
    {
        return $this->basePath;
    }

    /**
     * 获取文件大小
     *
     * @return int
     */
    public function getFilesize()
    {
        if (!$this->getFilePath()) {
            return 0;
        }

        return filesize($this->getFilePath());
    }

    /**
     * 获取日志文件列表
     *
     * @return array
     */
    public function getLogFiles()
    {
        if ($this->filename) {
            return collect($this->filesystem->allFiles($this->getCurrPath()))->map(function (SplFileInfo $fileInfo) {
                return $this->replaceBasePath($fileInfo->getRealPath());
            })->filter(function ($v) {
                return Str::contains($v, $this->filename);
            })->toArray();
        }

        $files = glob($this->getCurrPath() . '/*.*');

        rsort($files);

        return array_map('basename', $files);
    }

    /**
     * 获取日志文件目录列表
     *
     * @return array
     */
    public function getLogDirectories()
    {
        return array_map([$this, 'replaceBasePath'], $this->filesystem->directories($this->getCurrPath()));
    }

    /**
     * 判断是当前日志文件
     *
     * @param  mixed  $file
     * @return bool
     */
    public function isCurrentFile($file)
    {
        return $this->replaceBasePath($this->getFilePath()) === trim($this->currDir . '/' . $file, '/');
    }

    /**
     * 替换修正路径
     *
     * @param  string   $path
     * @return string
     */
    protected function replaceBasePath($path)
    {
        $basePath = str_replace('\\', '/', $this->getLogBasePath());

        return str_replace($basePath . '/', '', str_replace('\\', '/', $path));
    }

    /**
     * 替换修正路径
     *
     * @param  string   $content
     * @return string
     */
    protected function replaceRootPath($content)
    {
        $basePath = str_replace('\\', '/', base_path() . '/');

        return str_replace($basePath, '', str_replace(['\\\\', '\\'], '/', $content));
    }

}
