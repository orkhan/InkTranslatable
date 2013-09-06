<?php namespace Ink\InkTranslatable\Models;

use Illuminate\Support\Facades\Config;

abstract class EloquentTranslatable extends \Eloquent {
	
    public function translations($locale = '')
    {
		if ( !$locale ) $locale = Config::get('app.locale');
		
        return $this->_translations()->where(static::$translatable['locale_field'], '=', $locale);
    }
	
	public function _translations()
	{
		return $this->hasMany(static::$translatable['model_name'], static::$translatable['relationship_field']);
	}
	
	public function __get($key)
	{
		$locales = Config::get('app.locales');
		
		if ( in_array($key, $locales) ) 
		{
			return $this->translations($key)->first();
		}
		
		if ( array_key_exists($key, static::$translatable['translatables']) )
		{
			return $this->translations->first()->{$key};
		}
		
		return parent::__get($key);
	}
	
	public function delete()
	{
		$this->_translations()->delete();
		return parent::delete();
	}

}
