<?php

namespace common\helpers;

use common\models\constant\ConfigParams;
use common\models\constant\UserRolesConstant;
use frontend\models\User;
use Yii;

class EmailHelper
{
    public static function sendEmail($sender, $receiver, $subject, $content, $htmlBody)
    {
        $is_Sent = Yii::$app->mailer->compose()
            ->setFrom($sender)
            ->setTo($receiver)
            ->setSubject($subject)
            ->setTextBody($content)
            ->setHtmlBody($htmlBody)
            ->send();
        return $is_Sent;
    }

    public static function emailWhenSubmitIdea($idea)
    {
        // Get sender id (QA coordinator of department)
        $receiver = User::find()->where(['=', 'departmentId', $idea->departmentId])->andWhere(['=', 'role', UserRolesConstant::QA_COORDINATOR])->one();
        if ($receiver)
        {
            $ideaAuthor = User::find()->where(['=', 'id', $idea->userId])->one();
            $subject = "New idea submitted";
            $content = "User: " . $ideaAuthor->full_name . " have just posted new idea: " . $idea->title;
            $htmlBody = "<b>$content</b>";
            EmailHelper::sendEmail(ConfigParams::SMTP_EMAIL, $receiver->email, $subject, $content, $htmlBody);
        }
    }

    public static function emailWhenCreateComment($idea, $comment)
    {
        // Get sender id (QA coordinator of department)
        $ideaAuthor = User::find()->where(['=', 'id', $idea->userId])->one();
        if ($ideaAuthor)
        {
            $commentAuthor = User::find()->where(['=', 'id', $comment->userId])->one();
            $subject = "New comment submitted";
            $content = "User: " . $commentAuthor->full_name . " have just posted new comment: " . $comment->content;
            $htmlBody = "<b>$content</b>";
            EmailHelper::sendEmail(ConfigParams::SMTP_EMAIL, $ideaAuthor->email, $subject, $content, $htmlBody);
        }
    }
}
