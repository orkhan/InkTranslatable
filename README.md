# InkTranslatable

Easy translation manipulation of your Eloquent models in Laravel 4.

## Installation

First, you'll need to add the package to the `require` attribute of your `composer.json` file:

```json
{
    "require": {
        "ink/ink-translatable": "dev-master"
    },
}
```

Afterwards, run `composer update` from your command line.

Then, add `'Ink\InkTranslatable\InkTranslatableServiceProvider',` to the list of service providers in `app/config/app.php`
and add `'Translatable' => 'Ink\InkTranslatable\Facades\Translatable'` to the list of class aliases in `app/config/app.php`.

From the command line again, run `php artisan config:publish ink/ink-translatable`.


## Adding locales config

Create `app/config/locales.php` file in the following content:

```php
return array(
    'locales' => array('az', 'ru', 'en'),
    'default' => 'az',
);
```

## Creating migration

```php
Schema::create('posts', function($table)
{
  $table->increments('id')->unsigned();
  $table->timestamps();
});
Schema::create('posts_translations', function($table)
{
  $table->integer('post_id')->unsigned();
  $table->string('title');
  $table->string('lang');
});
```

## Creating RESTful controller & views

`example/app/controllers/PostController.php` file contains controller sample
`example/app/views/post` folder contains sample view files

## Routing

Edit `app/routes.php` file and add following content:

```php
Route::resource('posts', 'PostController');
Route::get('/posts/{id}/delete', 'PostController@destroy');
```

## Updating your Models

Change `Eloquent` to `EloquentTranslatable`

Define a public static property `$translatable` with the definitions (see [#Configuration] below for details):

```php
use Ink\InkTranslatable\Models\EloquentTranslatable;

class Post extends EloquentTranslatable
{

  public static $translatable = array(
      'table' => 'posts_translations',
      'relationship_field' => 'post_id',
      'locale_field' => 'lang',
      'translatables' => array(
          'title' => '',
      )
  );

}
```

That's it ... your model is now "translatable"!


## Configuration

Configuration was designed to be as flexible as possible.  You can set up defaults for all of your EloquentTranslatable models, and then override those settings for individual models.

By default, global configuration can be set in the `app/config/packages/ink/ink-translatable/config.php` file.  If a configuration isn't set, then the package defaults from `vendor/ink/ink-translatable/src/config/config.php` are used.  Here is an example configuration, with all the default settings shown:

```php
return array(
    'table' => null,
    'relationship_field' => null,
    'locale_field' => 'lang',
    'translatables' => array(
        'title' => '',
    )
);
```

## Bugs and Suggestions

Please use Github for bugs, comments, suggestions.  Pull requests are preferred!


## Copyright and License

InkTranslatable was written by Orkhan Maharramli and released under the MIT License. See the LICENSE file for details.

Copyright 2013 Orkhan Maharramli
