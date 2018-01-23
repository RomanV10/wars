<form action="/foo/bar" method="PUT">
    <div class="form-group" id="enabled-apis-form">
    @foreach ($enabled_apis as $api_machine_name => $settings)
        <div class="checkbox checkbox-primary">
            <label class="custom-control custom-checkbox">
                <input type="checkbox" name="{{ $api_machine_name }}" class="custom-control-input" {{ $settings['enabled'] ? 'checked="checked"' : '' }}>
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description">{{ $settings['name'] }}</span>
                <span class="message-wrap"></span>
            </label>
        </div>
    @endforeach
</div>
    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="submit" class="btn btn-info btn-lg" value="save" id="save-enabled">
{{--{{ Form::submit('Save enabled apis',['class' => 'btn btn-info btn-lg', 'id' => 'save-enabled'])}}--}}
</form>
