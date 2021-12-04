<div class="form-group {{ $col }} {{ isset($attributes['required']) ? 'required' : '' }} {{ $errors->has($name) ? 'has-error' : '' }}">
    {!! Form::label($name, $text, ['class' => 'control-label']) !!}
    <div class="input-group">
        <div class="input-group-addon"><i class="fa fa-{{ $icon }}"></i></div>
        {!! Form::text($name, $value, array_merge(['class' => 'form-control date', 'placeholder' => trans('general.form.enter', ['field' => $text])], $attributes)) !!}
    </div>
    {!! $errors->first($name, '<p class="help-block">:message</p>') !!}
</div>

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $(function () {
                $('#{{ $name }}').datepicker({
                    format: 'dd-mm-yyyy',
                    icons: {
                        time: "fa fa-clock-o",
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down"
                    }
                });
            });
        });
    </script>
@endpush
