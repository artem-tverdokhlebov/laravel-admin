
<div class="row">
    <div class="{{$viewClass['label']}}"><h4 class="pull-right">{{ $label }}</h4></div>
    <div class="{{$viewClass['field']}}"></div>
</div>

<hr style="margin-top: 0px;">

<div class="has-many-{{$column}} {{$uniqueId}}">

    <div class="has-many-{{$column}}-forms">

        @foreach($forms as $pk => $form)

            <div class="has-many-{{$column}}-form fields-group">

                @foreach($form->fields() as $field)
                    {!! $field->render() !!}
                @endforeach

                <div class="form-group">
                    <label class="{{$viewClass['label']}} control-label"></label>
                    <div class="{{$viewClass['field']}}">
                        @if($options['allowDelete'])
                            <div class="remove btn btn-warning btn-sm pull-right"><i class="fa fa-trash">&nbsp;</i>{{ trans('admin.remove') }}</div>
                        @endif

                        @if($options['orderable'])
                            <div class="pull-right" style="padding-right: 5px">
                                <div class="move-up btn btn-info btn-sm" style="padding-right: 5px"><i class="fa fa-arrow-up"></i>&nbsp;</div>
                                <div class="move-down btn btn-info btn-sm" style="padding-right: 5px"><i class="fa fa-arrow-down"></i>&nbsp;</div>
                            </div>
                        @endif
                    </div>
                </div>
                <hr>
            </div>

        @endforeach
    </div>


    <template class="{{$column}}-tpl {{$uniqueId}}">
        <div class="has-many-{{$column}}-form fields-group">

            {!! $template !!}

            <div class="form-group">
                <label class="{{$viewClass['label']}} control-label"></label>
                <div class="{{$viewClass['field']}}">
                    <div class="remove btn btn-warning btn-sm pull-right"><i class="fa fa-trash"></i>&nbsp;{{ trans('admin.remove') }}</div>

                    @if($options['orderable'])
                        <div class="pull-right" style="padding-right: 5px">
                            <div class="move-up btn btn-info btn-sm" style="padding-right: 5px"><i class="fa fa-arrow-up"></i>&nbsp;</div>
                            <div class="move-down btn btn-info btn-sm" style="padding-right: 5px"><i class="fa fa-arrow-down"></i>&nbsp;</div>
                        </div>
                    @endif
                </div>
            </div>
            <hr>
        </div>
    </template>

    @if($options['allowCreate'])
        <div class="form-group">
            <label class="{{$viewClass['label']}} control-label"></label>
            <div class="{{$viewClass['field']}}">
                <div class="add btn btn-success btn-sm"><i class="fa fa-save"></i>&nbsp;{{ trans('admin.new') }}</div>
            </div>
        </div>
    @endif

</div>