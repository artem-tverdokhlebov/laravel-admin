<div class="{{$viewClass['form-group']}}">
    <label class="{{$viewClass['label']}} control-label">
        {{$label}}

        @if(\Illuminate\Support\Arr::get($help, 'position') === \Encore\Admin\Form\Field::HELP_NEAR_LABEL_POSITION)
            @include('admin::form.help-block')
        @endif
    </label>

    <div class="{{$viewClass['field']}}">
        <div class="box box-solid box-default no-margin">
            <!-- /.box-header -->
            <div class="box-body">
                {!! $value !!}&nbsp;
            </div><!-- /.box-body -->
        </div>

        @if(\Illuminate\Support\Arr::get($help, 'position') == \Encore\Admin\Form\Field::HELP_UNDER_FIELD_POSITION)
            @include('admin::form.help-block')
        @endif
    </div>
</div>
