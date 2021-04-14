<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ParserController;
use App\Http\Controllers\Videos;
/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('parser:yell', function() { 
    $get = new ParserController();
    $get->parserYell();
})->purpose('Отзывы с YELL успешно добавлены!');

Artisan::command('parser:yandex', function() { 
    $get = new ParserController();
    $get->parserYandex();
})->purpose('Отзывы с YANDEX успешно добавлены!');

Artisan::command('parser:flamp', function() { 
    $get = new ParserController();
    $get->parserFlamp();
})->purpose('Отзывы с FLAMP успешно добавлены!');

Artisan::command('parser:youtube', function() {
    $get = new Videos();
    $get->setVideos();
});
