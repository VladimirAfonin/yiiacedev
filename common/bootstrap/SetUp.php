<?php

namespace common\bootstrap;

use yii\base\BootstrapInterface;
use yii\mail\MailerInterface;

class SetUp implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        $container = \Yii::$container;

        $container->setSingleton(MailerInterface::class, function() use ($app) {
            return $app->mailer;
        });
    }
}