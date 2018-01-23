{!! Form::open(['url' => 'foo/bar']) !!}
    <div class="form-group">
        {{ Form::label('api-name', 'Api name', ['class' => 'control-label']) }}
        {{ Form::text('api-name', '', ['class' => 'form-control']) }}
    </div>
    <div class="form-group">
        {{ Form::label('api-url', 'Api url', ['class' => 'control-label']) }}
        {{ Form::text('api-url', '', ['class' => 'form-control']) }}
    </div>
{{ Form::submit('Set mapped fields',['class' => 'btn btn-info btn-lg', 'id' => 'set-mapped-fields'])}}

{!! Form::close() !!}