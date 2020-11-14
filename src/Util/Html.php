<?php

/*
  * Tệp này là một phần của Ithauaz/pages.
  *
  * Bản quyền (c) 2020 Ithauaz.
  *
  * Để biết đầy đủ thông tin về bản quyền và giấy phép, vui lòng xem GIẤY PHÉP
  * tệp đã được phân phối với mã nguồn này.
  */

namespace Ithauaz\Pages\Util;

use Ithauaz\Pages\Page;

class Html
{
    public static function render($html, Page $page)
    {
        if (strpos($html, '@include(') !== false) {
            $html = preg_replace_callback(
                '/\@include\([\"\']?([\.\/\w\s]+)[\"\']?\)/mi',
                function ($matches) use ($page) {
                    $base = app('path.pages');
                    $path = trim($matches[1], " \r\n\t\f/.");
                    $path = $base.DIRECTORY_SEPARATOR.$path;
                    if (substr($path, -4) != '.php') {
                        $path .= '.php';
                    }
                    $path = realpath($path);
                    if (!empty($path) && strpos($path, $base) === 0 && is_readable($path)) {
                        $view = app('view')->file($path);
                        $view->page = $page;

                        return $view->render();
                    }

                    return $matches[0];
                },
                $html
            );
        }

        return $html;
    }
}
