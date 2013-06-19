<?php namespace Ink\InkTranslatable\Models;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

abstract class EloquentTranslatable extends \Eloquent {

    public static function find($id, $columns = array('*'))
    {
        $record = parent::find($id);
        return $record->join(
            static::$translatable['table'],
            $record->getTable().'.id', '=', static::$translatable['table'].'.'.static::$translatable['relationship_field']
        )
            ->where(static::$translatable['table'].'.'.static::$translatable['locale_field'], '=', Config::get('locales.default'))
            ->where(static::$translatable['table'].'.'.static::$translatable['relationship_field'], '=', $id)
            ->first();
    }

    public function delete()
    {
        $translations = DB::table(static::$translatable['table'])->where(static::$translatable['relationship_field'], '=', $this->id)->delete();

        if( $translations )
            parent::delete();
        return true;
    }

    public function scopeTranslations($query)
    {
        return $query->join(
            static::$translatable['table'],
            $this->table.'.id', '=', static::$translatable['table'].'.'.static::$translatable['relationship_field']
        )->where(static::$translatable['table'].'.'.static::$translatable['locale_field'], '=', Config::get('locales.default'));
    }

    public function getTranslation($locale)
    {
        return $this->join(
            static::$translatable['table'],
            $this->table.'.id', '=', static::$translatable['table'].'.'.static::$translatable['relationship_field']
        )
            ->where(static::$translatable['table'].'.'.static::$translatable['locale_field'], '=', $locale)
            ->where(static::$translatable['table'].'.'.static::$translatable['relationship_field'], '=', $this->id)
            ->first();
    }

}