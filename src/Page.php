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

use Carbon\Carbon;
use Flarum\Database\AbstractModel;
use Flarum\Database\ScopeVisibilityTrait;
use Flarum\Formatter\Formatter;
use Flarum\Post\Post;

/**
 * @property string title
 * @property string slug
 * @property Carbon time
 * @property Carbon edit_time
 * @property string content
 * @property bool is_hidden
 * @property bool is_restricted
 * @property bool is_html
 */
class Page extends AbstractModel
{
    use ScopeVisibilityTrait;

    /**
     * {@inheritdoc}
     */
    protected $table = 'pages';

    /**
     * @var array
     */
    protected $casts = [
        'id'            => 'integer',
        'is_hidden'     => 'boolean',
        'is_restricted' => 'boolean',
        'is_html'       => 'boolean',
    ];

    /**
     * {@inheritdoc}
     */
    protected $dates = ['time', 'edit_time'];

    /**
     * The text formatter instance.
     *
     * @var \Flarum\Formatter\Formatter
     */
    protected static $formatter;

    /**
     * Create a new page.
     *
     * @return static
     */
    public static function build($title, $slug, $content, $isHidden, $isRestricted, $isHtml)
    {
        $page = new static();

        $page->title = $title;
        $page->slug = $slug;
        $page->time = time();
        $page->content = $content;
        $page->is_restricted = (bool) $isRestricted;
        $page->is_hidden = (bool) $isHidden;
        $page->is_html = (bool) $isHtml;

        return $page;
    }

    /**
     * Unparse the parsed content.
     *
     * @param string $value
     *
     * @return string
     */
    public function getContentAttribute($value)
    {
        return static::$formatter->unparse($value);
    }

    /**
     * Get the parsed/raw content.
     *
     * @return string
     */
    public function getParsedContentAttribute()
    {
        return $this->attributes['content'];
    }

    /**
     * Parse the content before it is saved to the database.
     *
     * @param string $value
     */
    public function setContentAttribute($value)
    {
        $this->attributes['content'] = $value ? static::$formatter->parse($value, new Post()) : null;
    }

    /**
     * Get the content rendered as HTML.
     *
     * @return string
     */
    public function getContentHtmlAttribute()
    {
        if ($this->is_html) {
            return $this->content;
        }

        return static::$formatter->render($this->attributes['content'], new Post());
    }

    /**
     * Get the text formatter instance.
     *
     * @return \Flarum\Formatter\Formatter
     */
    public static function getFormatter()
    {
        return static::$formatter;
    }

    /**
     * Set the text formatter instance.
     *
     * @param \Flarum\Formatter\Formatter $formatter
     */
    public static function setFormatter(Formatter $formatter)
    {
        static::$formatter = $formatter;
    }
}
