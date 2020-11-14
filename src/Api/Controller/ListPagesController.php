<?php

/*
  * Tệp này là một phần của Ithauaz/pages.
  *
  * Bản quyền (c) 2020 Ithauaz.
  *
  * Để biết đầy đủ thông tin về bản quyền và giấy phép, vui lòng xem GIẤY PHÉP
  * tệp đã được phân phối với mã nguồn này.
  */

namespace Ithauaz\Pages\Api\Controller;

use Flarum\Api\Controller\AbstractListController;
use Flarum\Http\UrlGenerator;
use Flarum\Search\SearchCriteria;
use Ithauaz\Pages\Search\Page\PageSearcher;
use Illuminate\Support\Arr;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class ListPagesController extends AbstractListController
{
    /**
     * {@inheritdoc}
     */
    public $serializer = 'Ithauaz\Pages\Api\Serializer\PageSerializer';

    /**
     * {@inheritdoc}
     */
    public $sortFields = ['time', 'editTime'];

    /**
     * @var PageSearcher
     */
    protected $searcher;

    /**
     * @var UrlGenerator
     */
    protected $url;

    /**
     * @param PageSearcher $searcher
     * @param UrlGenerator $url
     */
    public function __construct(PageSearcher $searcher, UrlGenerator $url)
    {
        $this->searcher = $searcher;
        $this->url = $url;
    }

    /**
     * {@inheritdoc}
     */
    protected function data(ServerRequestInterface $request, Document $document)
    {
        $actor = $request->getAttribute('actor');
        $query = Arr::get($this->extractFilter($request), 'q');
        $sort = $this->extractSort($request);

        $criteria = new SearchCriteria($actor, $query, $sort);

        $limit = $this->extractLimit($request);
        $offset = $this->extractOffset($request);
        $results = $this->searcher->search($criteria, $limit, $offset);

        $document->addPaginationLinks(
            $this->url->to('api')->route('pages.index'),
            $request->getQueryParams(),
            $offset,
            $limit,
            $results->areMoreResults() ? null : 0
        );

        return $results->getResults();
    }
}
