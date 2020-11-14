<?php

/*
  * Tệp này là một phần của Ithauaz/pages.
  *
  * Bản quyền (c) 2020 Ithauaz.
  *
  * Để biết đầy đủ thông tin về bản quyền và giấy phép, vui lòng xem GIẤY PHÉP
  * tệp đã được phân phối với mã nguồn này.
  */

namespace Ithauaz\Pages\Api\Serializer;

use Flarum\Api\Serializer\AbstractSerializer;
use Ithauaz\Pages\Page;
use Ithauaz\Pages\Util\Html;

class PageSerializer extends AbstractSerializer
{
    /**
     * {@inheritdoc}
     */
    protected $type = 'pages';

    /**
     * @param Page $page
     *
     * @return array
     */
    protected function getDefaultAttributes($page)
    {
        $attributes = [
            'id'          => $page->id,
            'title'       => $page->title,
            'slug'        => $page->slug,
            'time'        => $page->time,
            'editTime'    => $page->edit_time,
            'contentHtml' => Html::render($page->content_html, $page),
        ];

        if ($this->actor->isAdmin()) {
            $attributes['content'] = $page->content;
            $attributes['isHidden'] = $page->is_hidden;
            $attributes['isRestricted'] = $page->is_restricted;
            $attributes['isHtml'] = $page->is_html;
        }

        return $attributes;
    }
}
