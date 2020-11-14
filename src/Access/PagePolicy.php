<?php

/*
  * Tệp này là một phần của Ithauaz/pages.
  *
  * Bản quyền (c) 2020 Ithauaz.
  *
  * Để biết đầy đủ thông tin về bản quyền và giấy phép, vui lòng xem GIẤY PHÉP
  * tệp đã được phân phối với mã nguồn này.
  */
namespace Ithauaz\Pages\Access;

use Flarum\User\AbstractPolicy;
use Flarum\User\User;
use Ithauaz\Pages\Page;
use Illuminate\Database\Eloquent\Builder;

class PagePolicy extends AbstractPolicy
{
    protected $model = Page::class;

    public function find(User $actor, Builder $query)
    {
        if (!$actor->hasPermission('ithauaz-pages.viewHidden')) {
            $query->whereIsHidden(0);
        }

        if (!$actor->hasPermission('ithauaz-pages.viewRestricted')) {
            $query->whereIsRestricted(0);
        }
    }
}
