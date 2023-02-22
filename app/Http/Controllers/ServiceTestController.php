<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceTestController extends Controller
{
    public function showService()
    {
        app()->bind('lifeCycleTest', function () {
            return 'ライフサイクル';
        });

        $test = app()->make('lifeCycleTest');

        // 通常インスタンス化
        $message = new Message();
        $sample = new Sample($message);
        $sample->run();

        // サービスコンテナ利用
        app()->bind('sample', Sample::class);
        $sample = app()->make('sample');
        $sample->run();

        // dd($test, app());
    }

    public function showServiceProvider()
    {
        $encrypt = app()->make('encrypter');
        $password = $encrypt->encrypt('password');

        $sample = app()->make('ServiceProviderTest');

        // dd($sample, $password, $encrypt->decrypt($password));
    }
}

class Sample
{
    public $message;

    public function __construct(Message $message) {
        $this->message = $message;
    }

    public function run()
    {
        $this->message->send();
    }
}

class Message
{
    public function send()
    {
        echo 'this is a message.';
    }
}
