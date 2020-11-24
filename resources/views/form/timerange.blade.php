<div class="{{$viewClass['form-group']}} {!! ($errors->has($errorKey['start'].'start') || $errors->has($errorKey['end'].'end')) ? 'has-error' : ''  !!}">

    <label for="{{$id['start']}}" class="{{$viewClass['label']}} control-label">
        {{$label}}

        @if(\Illuminate\Support\Arr::get($help, 'position') === \Encore\Admin\Form\Field::HELP_NEAR_LABEL_POSITION)
            @include('admin::form.help-block')
        @endif
    </label>

    <div class="{{$viewClass['field']}}">

        @include('admin::form.error')

        <div class="row" style="width: 370px">
            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="text" name="{{$name['start']}}" value="{{ old($column['start'], $value['start'] ?? null) }}" class="form-control {{$class['start']}}" autocomplete="off" style="width: 150px" {!! $attributes !!} />
                </div>
            </div>

            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="text" name="{{$name['end']}}" value="{{ old($column['end'], $value['end'] ?? null) }}" class="form-control {{$class['end']}}" autocomplete="off" style="width: 150px" {!! $attributes !!} />
                </div>
            </div>
        </div>

        @if(\Illuminate\Support\Arr::get($help, 'position') == \Encore\Admin\Form\Field::HELP_UNDER_FIELD_POSITION)
            @include('admin::form.help-block')
        @endif
    </div>
</div>
