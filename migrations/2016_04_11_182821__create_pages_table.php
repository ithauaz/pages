<?php

/*
  * Tệp này là một phần của Ithauaz/pages.
  *
  * Bản quyền (c) 2020 Ithauaz.
  *
  * Để biết đầy đủ thông tin về bản quyền và giấy phép, vui lòng xem GIẤY PHÉP
  * tệp đã được phân phối với mã nguồn này.
  */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

return [
    'up' => function (Builder $schema) {
        if ($schema->hasTable('pages')) {
            return;
        }

        $schema->create('pages', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title', 200);
            $table->string('slug', 200);
            $table->dateTime('time');
            $table->dateTime('edit_time')->nullable();
            $table->text('content')->nullable();

            $table->boolean('is_hidden')->default(0);
        });
    },
    'down' => function (Builder $schema) {
        $schema->dropIfExists('pages');
    },
];
