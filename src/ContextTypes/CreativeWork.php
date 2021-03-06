<?php

namespace JsonLd\ContextTypes;

class CreativeWork extends Thing
{
    /**
     * Property structure
     * reference: https://schema.org/CreativeWork (alphabetical order)
     *
     * @var array
     */
    private $extendedStructure = [
        'about' => Thing::class,
        'aggregateRating' => AggregateRating::class,
        'alternativeHeadline' => null,
        'author' => Person::class,
        'comment' => Comment::class,
        'commentCount' => null,
        'creator' => Person::class,
        'dateCreated' => null,
        'dateModified' => null,
        'datePublished' => null,
        'headline' => null,
        'inLanguage' => null,
        'keywords' => null,
        'mainEntity' => Thing::class,
        'publisher' => Organization::class,
        'review' => Review::class,
        'text' => null,
        'thumbnailUrl' => null,
        'video' => VideoObject::class,
    ];

    /**
     * Constructor. Merges extendedStructure up
     *
     * @param array $attributes
     * @param array $extendedStructure
     */
    public function __construct(array $attributes, array $extendedStructure = [])
    {
        parent::__construct(
            $attributes, array_merge($this->structure, $this->extendedStructure, $extendedStructure)
        );
    }

    /**
     * Set the article body attribute.
     *
     * @param  string $txt
     * @return array
     */
    protected function setTextAttribute($txt)
    {
        return $this->truncate($txt, 260);
    }

    /**
     * Set the comments
     *
     * @param array $items
     * @return array
     */
    protected function setCommentAttribute($items)
    {
        if (is_array($items) === false) {
            return $items;
        }

        return array_map(function ($item) {
            return $this->getNestedContext(Comment::class, $item);
        }, $items);
    }
}
