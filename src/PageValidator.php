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

use Flarum\Foundation\AbstractValidator;

class PageValidator extends AbstractValidator
{
    /**
     * {@inheritdoc}
     */
    protected $rules = [
        'title' => [
            'required',
            'max:200',
        ],
        'slug' => [
            'required',
            'unique:pages,slug',
            'max:200',
        ],
        'content' => [
            'required',
            'max:16777215',
        ],
    ];
}
