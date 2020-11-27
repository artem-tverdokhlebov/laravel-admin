<div class="{{$viewClass['form-group']}} {!! !$errors->has($errorKey) ? '' : 'has-error' !!}">
    <label for="{{$id}}" class="{{$viewClass['label']}} control-label">
        {{$label}}

        @if(\Illuminate\Support\Arr::get($help, 'position') == \Encore\Admin\Form\Field::HELP_NEAR_LABEL_POSITION)
            @include('admin::form.help-block')
        @endif
    </label>

    <div class="{{$viewClass['field']}}">
        @include('admin::form.error')

        <input type="hidden" name="{{$name}}"/>

        <select class="form-control {{$class}} ui-helper-hidden-accessible" name="{{$name}}" {!! $attributes !!} >
            <option value=""></option>
            @foreach($options as $select => $option)
                <option value="{{$select}}" {{ $select == old($column, $value) ?'selected':'' }}>{{$option}}</option>
            @endforeach
        </select>

        <div class="belongsto-{{ $class }}-{{ $uniqueId }}">
            {!! $grid->render() !!}
            <template class="empty">
                @if($grid->showDefineEmptyPage())
                    @include('admin::grid.empty-grid')
                @endif
            </template>
        </div>

        @if(\Illuminate\Support\Arr::get($help, 'position') == \Encore\Admin\Form\Field::HELP_UNDER_FIELD_POSITION)
            @include('admin::form.help-block')
        @endif
    </div>
</div>
