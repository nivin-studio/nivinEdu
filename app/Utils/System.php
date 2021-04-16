<?php

namespace App\Utils;

class System
{

    /**
     * cpu使用率
     *
     * @return array
     */
    public static function cpu()
    {
        try {
            $info    = file_get_contents('/proc/stat');
            $pattern = "/(cpu[0-9]?)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)/";
            preg_match_all($pattern, $info, $out);

            $total = $out[2][0] + $out[3][0] + $out[4][0] + $out[5][0] + $out[6][0] + $out[7][0] + $out[8][0] + $out[9][0] + $out[10][0];
            $used  = $total - $out[5][0];
            $pcpu  = round(($used / $total) * 100, 2);
            $core  = count($out[0]) - 1;

            return ['used' => $used, 'total' => $total, 'percent' => $pcpu, 'core' => $core];
        } catch (\Throwable $th) {
            return [];
        }
    }

    /**
     * 内存信息
     *
     * @return array
     */
    public static function memory()
    {
        try {
            $data = [];
            $info = file_get_contents('/proc/meminfo');
            foreach (explode("\n", $info) as $item) {
                if (preg_match('/^(\w+):\s+(\d+)\skB$/', $item, $matches)) {
                    $data[$matches[1]] = $matches[2] * 1024;
                }
            }
            return $data;
        } catch (\Throwable $th) {
            return [];
        }
    }

    /**
     * 磁盘信息
     *
     * @param  string  $directory
     * @return array
     */
    public static function disk($directory = '.')
    {
        $free  = disk_free_space($directory);
        $total = disk_total_space($directory);
        return ['free' => $free, 'total' => $total, 'used' => $total - $free];
    }

    /**
     * 单位转换
     *
     * @param  $size
     * @return string
     */
    public static function conv($size)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
        for ($n = 0; $size >= 1024 && $n < count($units); $n++) {
            $size /= 1024;
        }
        return sprintf('%s %s', round($size, 2), $units[$n]);
    }
}
