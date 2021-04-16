<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Action;
use Illuminate\Queue\SerializesModels;

class MailBase extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * 等级
     *
     * @var string
     */
    public $level = 'info';

    /**
     * 上行内容
     *
     * @var array
     */
    public $introLines = [];

    /**
     * 下行内容
     *
     * @var array
     */
    public $outroLines = [];

    /**
     * 动作按钮文案
     *
     * @var string
     */
    public $actionText;

    /**
     * 动作按钮链接
     *
     * @var string
     */
    public $actionUrl;

    /**
     * 成功等级
     *
     * @return $this
     */
    public function success()
    {
        $this->level = 'success';

        return $this;
    }

    /**
     * 错误等级
     *
     * @return $this
     */
    public function error()
    {
        $this->level = 'error';

        return $this;
    }

    /**
     * 等级
     *
     * @param  string  $level
     * @return $this
     */
    public function level($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * 在邮件中添加一行内容
     *
     * @param  mixed   $line
     * @return $this
     */
    public function line($line)
    {
        if ($line instanceof Action) {
            $this->action($line->text, $line->url);
        } elseif (!$this->actionText) {
            $this->introLines[] = $this->formatLine($line);
        } else {
            $this->outroLines[] = $this->formatLine($line);
        }

        return $this;
    }

    /**
     * 格式化行内容
     *
     * @param  mixed             $line
     * @return Htmlable|string
     */
    protected function formatLine($line)
    {
        if ($line instanceof Htmlable) {
            return $line;
        }

        if (is_array($line)) {
            return implode(' ', array_map('trim', $line));
        }

        return trim(implode(' ', array_map('trim', preg_split('/\\r\\n|\\r|\\n/', $line))));
    }

    /**
     * 添加动作
     *
     * @param  string  $text
     * @param  string  $url
     * @return $this
     */
    public function action($text, $url)
    {
        $this->actionText = $text;
        $this->actionUrl  = $url;

        return $this;
    }

    /**
     * 构建
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.base');
    }

    /**
     * 获取消息的数组表示形式
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'level'                => $this->level,
            'subject'              => $this->subject,
            'introLines'           => $this->introLines,
            'outroLines'           => $this->outroLines,
            'actionText'           => $this->actionText,
            'actionUrl'            => $this->actionUrl,
            'displayableActionUrl' => str_replace(['mailto:', 'tel:'], '', $this->actionUrl),
        ];
    }
}
