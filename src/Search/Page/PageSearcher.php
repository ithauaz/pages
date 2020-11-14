<?php

/*
  * Tệp này là một phần của Ithauaz/pages.
  *
  * Bản quyền (c) 2020 Ithauaz.
  *
  * Để biết đầy đủ thông tin về bản quyền và giấy phép, vui lòng xem GIẤY PHÉP
  * tệp đã được phân phối với mã nguồn này.
  */

namespace Ithauaz\Pages\Search\Page;

use Flarum\Search\ApplySearchParametersTrait;
use Flarum\Search\GambitManager;
use Flarum\Search\SearchCriteria;
use Flarum\Search\SearchResults;
use Ithauaz\Pages\PageRepository;

class PageSearcher
{
    use ApplySearchParametersTrait;

    /**
     * @var GambitManager
     */
    protected $gambits;

    /**
     * @var PageRepository
     */
    protected $pages;

    /**
     * @param GambitManager  $gambits
     * @param PageRepository $pages
     */
    public function __construct(GambitManager $gambits, PageRepository $pages)
    {
        $this->gambits = $gambits;
        $this->pages = $pages;
    }

    /**
     * @param SearchCriteria $criteria
     * @param int|null       $limit
     * @param int            $offset
     *
     * @return SearchResults
     */
    public function search(SearchCriteria $criteria, $limit = null, $offset = 0)
    {
        $actor = $criteria->actor;

        $query = $this->pages->query()->whereVisibleTo($actor);

        $search = new PageSearch($query->getQuery(), $actor);

        $this->gambits->apply($search, $criteria->query);
        $this->applySort($search, $criteria->sort);
        $this->applyOffset($search, $offset);
        $this->applyLimit($search, $limit + 1);

        $pages = $query->get();

        if ($areMoreResults = ($limit > 0 && $pages->count() > $limit)) {
            $pages->pop();
        }

        return new SearchResults($pages, $areMoreResults);
    }
}
