@if($help)
    @if(\Illuminate\Support\Arr::get($help, 'popover'))
        <span class="help-block">
            <span data-container="body" data-toggle="popover" data-placement="right" data-content="{{ \Illuminate\Support\Arr::get($help, 'text') }}">
                <i class="fa {{ \Illuminate\Support\Arr::get($help, 'icon') }}"></i>&nbsp;{!! \Illuminate\Support\Arr::get($help, 'title') !!}
            </span>
        </span>
    @else
        <span class="help-block">
            <i class="fa {{ \Illuminate\Support\Arr::get($help, 'icon') }}"></i>&nbsp;{!! \Illuminate\Support\Arr::get($help, 'text') !!}
        </span>
    @endif
@endif