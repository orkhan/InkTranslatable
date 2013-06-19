<?php

use Ink\InkTranslatable\Models\EloquentTranslatable;

class Post extends EloquentTranslatable {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * Translatable model configs.
     *
     * @var array
     */
    public static $translatable = array(
        'table' => 'posts_translations',
        'relationship_field' => 'post_id',
        'locale_field' => 'lang',
        'translatables' => array(
            'title' => '',
        )
    );

}