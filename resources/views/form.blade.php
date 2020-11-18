<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">{{ $form->title() }}</h3>

        <div class="box-tools">
            {!! $form->renderTools() !!}
        </div>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    {!! $form->open() !!}

    <div class="box-body">
        @if(!$tabObj->isEmpty())
            @include('admin::form.tab', compact('tabObj'))
        @else
            <div class="fields-group">
                @if($form->hasRows())
                    @foreach($form->getRows() as $row)
                        {!! $row->render() !!}
                    @endforeach
                @else
                    @php $i = 0; @endphp
                    @foreach($layout->columns() as $column)
                        <div class="col-md-{{ $column->width() }}">
                            @foreach($column->fields() as $field)
                                @php
                                    foreach ($boxObj->getOffsets() as $item) {
                                        if ($item['start'] == $i && $item['end'] != $i) {
                                            ob_start();
                                        } else if ($item['start'] == $i && $item['end'] == $i) {
                                            $item['box']->content('');
                                            echo $item['box']->render();
                                        }
                                    }
                                @endphp

                                {!! $field->render() !!}

                                @php
                                    $i++;

                                    foreach ($boxObj->getOffsets() as $item) {
                                        if ($item['end'] == $i && $item['start'] != $item['end']) {
                                            $content = ob_get_clean();

                                            $item['box']->content($content);
                                            echo $item['box']->render();
                                        }
                                    }
                                @endphp
                            @endforeach
                        </div>
                    @endforeach
                @endif
            </div>
        @endif

    </div>
    <!-- /.box-body -->

    {!! $form->renderFooter() !!}

    @foreach($form->getHiddenFields() as $field)
        {!! $field->render() !!}
    @endforeach

<!-- /.box-footer -->
    {!! $form->close() !!}
</div>

