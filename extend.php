<?php

/*
  * Tệp này là một phần của Ithauaz/pages.
  *
  * Bản quyền (c) 2020 Ithauaz.
  *
  * Để biết đầy đủ thông tin về bản quyền và giấy phép, vui lòng xem GIẤY PHÉP
  * tệp đã được phân phối với mã nguồn này.
  */

namespace Ithauaz\Pages;

use Flarum\Extend;
use Flarum\Formatter\Formatter;
use Flarum\Foundation\Paths;
use Ithauaz\Pages\Api\Controller;
use Illuminate\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;

return [
    new Extend\Locales(__DIR__.'/resources/locale'),

    (new Extend\Frontend('admin'))
        ->css(__DIR__.'/resources/less/admin.less')
        ->js(__DIR__.'/js/dist/admin.js'),

    (new Extend\Frontend('forum'))
        ->css(__DIR__.'/resources/less/forum.less')
        ->js(__DIR__.'/js/dist/forum.js')
        ->route('/pages/home', 'pages.home')
        ->route('/p/{id:[\d\S]+(?:-[^/]*)?}', 'pages.page', Content\Page::class)
        ->content(Content\AddHomePageId::class),

    (new Extend\Routes('api'))
        ->get('/pages', 'pages.index', Controller\ListPagesController::class)
        ->post('/pages', 'pages.create', Controller\CreatePageController::class)
        ->get('/pages/{id}', 'pages.show', Controller\ShowPageController::class)
        ->patch('/pages/{id}', 'pages.update', Controller\UpdatePageController::class)
        ->delete('/pages/{id}', 'pages.delete', Controller\DeletePageController::class),

    (new Extend\View())
        ->namespace('fof-pages', __DIR__.'/resources/views'),

    function (Container $app, Dispatcher $events) {
        $app->instance('path.pages', (app(Paths::class))->base.DIRECTORY_SEPARATOR.'pages');

        Page::setFormatter(app(Formatter::class));

        $events->subscribe(Access\PagePolicy::class);
    },
];
