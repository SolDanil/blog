<?php

namespace app\component;

use Yii;
use yii\queue\JobInterface;
use yii\base\BaseObject;

class SendMailToAdmin extends BaseObject implements JobInterface
{
    public $id;
    public $title;
    public $user_id;
    public $date;
    public $email;
        
    public function execute($queue)
    {
        

        $body="
            <html>
                <head>
                </head>
                <body>
                    <h1> Новое статья на блоге</h1>
                    <ul> 
	                    <li>id статьи:".$this->id."</li>
	                    <li>Заголовок:".$this->title."</li>
	                    <li>Пользователь:".$this->user_id."</li>
	                    <li>Время:".$this->date."</li>                 
                    
                    </ul>
                </body>
            </html>";

           

            Yii::$app->mailer->compose()
                ->setTo($this->email)
                ->setFrom('st_nikon@mail.ru')
                ->setSubject('Новая статья на блоге:'.$this->title)
                ->setHtmlBody($body)
                ->send();
        
    }
}