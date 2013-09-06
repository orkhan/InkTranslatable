<?php namespace Ink\InkTranslatable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class Translatable {

    /**
     * The configuration array
     *
     * @var array
     */
    protected $config = array();

    /**
     * The locales array
     *
     * @var array
     */
    protected $locales = array();

    /**
     * Constructor
     *
     * @param array $config
     * @param array $locales
     */
    public function __construct( array $config, array $locales ) {

        $this->config = $config;
        $this->locales = $locales;

    }

    /**
     * Translate model
     *
     * @param  Model     $model The model
     * @return boolean
     */
    public function translate( Model $model )
    {

        // if the model isn't translatable, then do nothing

        if ( !isset( $model::$translatable ) )
            return true;


        // load the configuration

        $config = array_merge( $this->config, $model::$translatable );


        // nicer variables for readability

        $model_name = $table_name = $relationship_field = $locale_field = $translatables = null;
        extract( $config, EXTR_IF_EXISTS );

        // POST parameters

        $inputs = Input::all();

        // iterating locales

        foreach($this->locales as $locale)
        {
            // if $locale exists in POST parameters

            if ( array_key_exists($locale, $inputs) )
            {

                // merge translatable fields from POST parameters

                $translatables = array_merge( $translatables, $inputs[$locale] );

                // finding translation

                $translation = DB::table($table_name)->where( $relationship_field, '=', $model->id )
                    ->where( $locale_field, '=', $locale )
                    ->first();

                // if translation exists do update

                if ($translation)
                {
                    DB::table($table_name)
                        ->where( $relationship_field, '=', $translation->{$relationship_field} )
                        ->where( $locale_field, '=', $translation->{$locale_field} )
                        ->update($translatables);
                }

                // if translation not exists do insert

                else
                {
                    $translatables[$locale_field] = $locale;
                    $translatables[$relationship_field] = $model->id;

                    DB::table($table_name)->insert(
                        $translatables
                    );
                }

            }

        }

        // done!

        return true;

    }


}
