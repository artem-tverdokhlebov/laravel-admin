<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">

        @foreach($tabObj->getTabs() as $tab)
            <li {{ $tab['active'] ? 'class=active' : '' }}>
                <a href="#tab-{{ $tab['id'] }}" data-toggle="tab">
                    {{ $tab['title'] }} <i class="fa fa-exclamation-circle text-red hide"></i>
                </a>
            </li>
        @endforeach

    </ul>
    <div class="tab-content fields-group">
        @php $i = 0; @endphp
        @foreach($tabObj->getTabs() as $tab)
            <div class="tab-pane {{ $tab['active'] ? 'active' : '' }}" id="tab-{{ $tab['id'] }}">
                @foreach($tab['fields'] as $field)
                    @php
                        foreach ($boxObj->getOffsets() as $item) {
                            if ($item['start'] == $i) {
                                ob_start();
                                break;
                            }
                        }
                    @endphp

                    {!! $field->render() !!}

                    @php
                        $i++;

                        foreach ($boxObj->getOffsets() as $item) {
                           if ($item['end'] == $i) {
                               $content = ob_get_clean();

                               $item['box']->content($content);
                               echo $item['box']->render();
                               break;
                           }
                        }
                    @endphp
                @endforeach
            </div>
        @endforeach
    </div>
</div>
