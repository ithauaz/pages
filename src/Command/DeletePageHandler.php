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

use Flarum\Settings\SettingsRepositoryInterface;
use Ithauaz\Pages\PageRepository;

class DeletePageHandler
{
    /**
     * @var SettingsRepositoryInterface
     */
    protected $settings;

    /**
     * @var PageRepository
     */
    protected $pages;

    /**
     * @param PageRepository $pages
     */
    public function __construct(PageRepository $pages, SettingsRepositoryInterface $settings)
    {
        $this->pages = $pages;
        $this->settings = $settings;
    }

    /**
     * @param DeletePage $command
     *
     * @throws \Flarum\Core\Exception\PermissionDeniedException
     *
     * @return \FoF\Pages\Page
     */
    public function handle(DeletePage $command)
    {
        $actor = $command->actor;

        $page = $this->pages->findOrFail($command->pageId, $actor);

        $actor->assertAdmin();

        // if it has been set as home page revert back to default router
        $homePage = intval($this->settings->get('pages_home'));
        if ($homePage && $page->id === $homePage) {
            $this->settings->delete('pages_home');
            $this->settings->set('default_route', '/all');
        }

        $page->delete();

        return $page;
    }
}
