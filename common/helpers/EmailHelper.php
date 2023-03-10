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
        $ideaAuthor = User::find()->where(['=', 'id', $idea->userId])->one();
        $subject = "New idea submitted";
        $content = "User: " . $ideaAuthor->full_name . " have just posted new idea: " . $idea->title . " at " .DateTimeHelper::getDateTimeString($idea->created_at);
        $htmlBody = "<b>$content</b>";
        EmailHelper::sendEmail(ConfigParams::SMTP_EMAIL, $receiver->email, $subject, $content, $htmlBody);
    }
}
