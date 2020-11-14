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

use Ithauaz\Pages\Page;
use Ithauaz\Pages\PageValidator;
use Illuminate\Support\Arr;

class CreatePageHandler
{
    /**
     * @var PageValidator
     */
    protected $validator;

    /**
     * @param PageValidator $validator
     */
    public function __construct(PageValidator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param CreatePage $command
     *
     * @return Page
     */
    public function handle(CreatePage $command)
    {
        $actor = $command->actor;
        $data = $command->data;

        $actor->assertAdmin();

        $page = Page::build(
            Arr::get($data, 'attributes.title'),
            Arr::get($data, 'attributes.slug'),
            Arr::get($data, 'attributes.content'),
            Arr::get($data, 'attributes.isHidden'),
            Arr::get($data, 'attributes.isRestricted'),
            Arr::get($data, 'attributes.isHtml')
        );

        $this->validator->assertValid($page->getAttributes());

        $page->save();

        return $page;
    }
}
