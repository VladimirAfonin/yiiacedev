<?php

namespace frontend\services;

use common\models\User;
use frontend\models\SignupForm;
use yii\mail\MailerInterface;

class SignupService
{
    private $_mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->_mailer = $mailer;
    }

    /**
     * @param SignupForm $form
     * @throws \yii\base\Exception
     */
    public function signup(SignupForm $form): void
    {
        $user = User::requestSignup($form->username, $form->email, $form->password);
        if(!$user->save()) {
            throw new \RuntimeException('saving error.');
        }

        $sent = $this->_mailer->compose(
            ['html' => 'emailConfirmToken-html', 'text' => 'emailConfirmToken-txt'],
            ['user' => $user]
        )
            ->setTo($form->email)
            ->setSubject('signup for ' . \Yii::$app->name)
            ->setFrom(\Yii::$app->params['supportEmail'])
            ->send();
        if(!$sent) {
            throw new \RuntimeException('Email sending error.');
        }
    }

    public function confirm($token): void
    {
        if (empty($token)) {
            throw new \DomainException('empty confirm token');
        }
        $user = User::findOne(['email_confirm_token' => $token]);
        if(!$user) {
            throw new \DomainException('user is not found');
        }

        $user->confirmSignup();
        if(!$user->save()) { throw new \DomainException('saving error'); }
    }
}