<?php

/* @var $this yii\web\View */
/* @var $user \common\models\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['site/confirm', 'token' => $user->email_confirm_token]);
?>
    Hello <?= $user->username ?>,

    Follow the link below to confirm your email:

<?= $confirmLink ?>