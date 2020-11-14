<?php

/*
  * Tệp này là một phần của Ithauaz/pages.
  *
  * Bản quyền (c) 2020 Ithauaz.
  *
  * Để biết đầy đủ thông tin về bản quyền và giấy phép, vui lòng xem GIẤY PHÉP
  * tệp đã được phân phối với mã nguồn này.
  */

namespace Ithauaz\Pages\Command;

use Flarum\User\User;

class DeletePage
{
    /**
     * The ID of the page to delete.
     *
     * @var int
     */
    public $pageId;

    /**
     * The user performing the action.
     *
     * @var User
     */
    public $actor;

    /**
     * Any other page input associated with the action. This is unused by
     * default, but may be used by extensions.
     *
     * @var array
     */
    public $data;

    /**
     * @param int   $pageId The ID of the page to delete.
     * @param User  $actor  The user performing the action.
     * @param array $data   Any other page input associated with the action. This
     *                      is unused by default, but may be used by extensions.
     */
    public function __construct($pageId, User $actor, array $data = [])
    {
        $this->pageId = $pageId;
        $this->actor = $actor;
        $this->data = $data;
    }
}
