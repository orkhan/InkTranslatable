<p>{{ Form::label('az[title]', 'Title AZ') }} : {{ Form::text('az[title]', isset($record) ? $record->getTranslation('az')->title : '') }}</p>

<p>{{ Form::label('ru[title]', 'Title RU') }} : {{ Form::text('ru[title]', isset($record) ? $record->getTranslation('ru')->title : '') }}</p>

<p>{{ Form::label('en[title]', 'Title EN') }} : {{ Form::text('en[title]', isset($record) ? $record->getTranslation('en')->title : '') }}</p>

<p>{{ Form::submit('Save') }}</p>