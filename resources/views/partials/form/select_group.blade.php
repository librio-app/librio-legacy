@stack($name . '_input_start')

<div class="form-group {{ $col }} {{ isset($attributes['required']) ? 'required' : '' }} {{ $errors->has($name) ? 'has-error' : ''}}">
    {!! Form::label($name, $text, ['class' => 'control-label']) !!}
    <div class="input-group">
        <div class="input-group-addon"><i class="fa fa-{{ $icon }}"></i></div>
        <?php
            $newAttributes = [
                'id' => $name,
                'name' => (isset($attributes['multiple'])) ? $name . '[]' : $name,
                'class' => 'form-control',
            ];

            if (!isset($attributes['multiple'])) {
                $newAttributes['placeholder'] = trans('general.form.select.field', ['field' => $text]);
            }
        ?>

        {!! Form::select(
            $name,
            $values,
            $selected,
            array_merge($newAttributes, $attributes))
        !!}

        @if(isset($attributes['add']) && $attributes['add'])
            <span class="input-group-btn">
                <button type="button" id="button-{{ str_replace('_id', '', $name) }}" class="btn btn-default btn-icon"><i class="fa fa-plus"></i></button>
            </span>
        @endif
    </div>
    {!! $errors->first($name, '<p class="help-block">:message</p>') !!}
</div>

@stack($name . '_input_end')
