<?php

namespace common\helpers;

use Yii;

class EmailHelper
{
    public static function sendEmail($sender, $receiver, $subject, $content)
    {
        $is_Sent = Yii::$app->mailer->compose()
            ->setFrom($sender)
            ->setTo($receiver)
            ->setSubject('Message subject')
            ->setTextBody('Plain text content')
            ->setHtmlBody('<b>HTML content</b>')
            ->send();
        return $is_Sent;
    }
}
