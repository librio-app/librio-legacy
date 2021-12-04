@stack($name . '_input_start')

<div class="form-group {{ $col }} {{ isset($attributes['required']) ? 'required' : '' }} {{ $errors->has($name) ? 'has-error' : '' }}">
    {!! Form::label($name, $text, ['class' => 'control-label']) !!}
    <div class="input-group">
        <div class="btn-group radio-inline" data-toggle="buttons">
            <?php $checked = (isset($attributes['reset'])) ? null : true ?>
            <label id="{{ $name }}_1" class="btn btn-default">
                {!! Form::radio($name, '1', (isset($checked)) ? $checked : null, ['id' => $name . '_1']) !!}
                <span class="radiotext">{{ trans('general.yes') }}</span>
            </label>
            <label id="{{ $name }}_0" class="btn btn-default">
                {!! Form::radio($name, '0', (isset($checked)) ? !$checked : null, ['id' => $name . '_0']) !!}
                <span class="radiotext">{{ trans('general.no') }}</span>
            </label>
            @if (isset($attributes['reset']))
               <label id="{{ $name }}_reset" class="btn btn-default">
                    {!! Form::radio($name, '', true, ['id' => $name . '_reset']) !!}
                    <span class="fa fa-remove"></span>
               </label>
            @endif
        </div>
    </div>
    {!! $errors->first($name, '<p class="help-block">:message</p>') !!}
</div>

@stack($name . '_input_end')
