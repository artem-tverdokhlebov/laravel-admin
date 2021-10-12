<?php

namespace Encore\Admin\Form\Field;

use Encore\Admin\Form\Field;

class DateRange extends Field
{
    protected static $css = [
        '/vendor/laravel-admin/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
    ];

    protected static $js = [
        '/vendor/laravel-admin/moment/min/moment-with-locales.min.js',
        '/vendor/laravel-admin/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
    ];

    protected $format = 'YYYY-MM-DD';

    protected $disableMinMaxDate = false;

    /**
     * Column name.
     *
     * @var array
     */
    protected $column = [];

    public function __construct($column, $arguments)
    {
        $this->column['start'] = $column;
        $this->column['end'] = $arguments[0];

        array_shift($arguments);
        $this->label = $this->formatLabel($arguments);
        $this->id = $this->formatId($this->column);

        $this->options(['format' => $this->format]);
    }

    /**
     * {@inheritdoc}
     */
    public function prepare($value)
    {
        if ($value === '') {
            $value = null;
        }

        return $value;
    }

    public function disableMinMaxDate()
    {
        $this->disableMinMaxDate = true;

        return $this;
    }

    public function render()
    {
        $this->options['locale'] = array_key_exists('locale', $this->options) ? $this->options['locale'] : config('app.locale');

        $startOptions = json_encode($this->options);
        $endOptions = json_encode($this->options + ['useCurrent' => false]);

        $class = $this->getElementClassSelector();

        $scriptMinDate = ".minDate(e.date)";
        $scriptMaxDate = ".maxDate(e.date)";

        if ($this->disableMinMaxDate) {
            $scriptMinDate = '';
            $scriptMaxDate = '';
        }

        $this->script = <<<EOT
            $('{$class['start']}').datetimepicker($startOptions);
            $('{$class['end']}').datetimepicker($endOptions);
            $("{$class['start']}").on("dp.change", function (e) {
                $('{$class['end']}').data("DateTimePicker")
                {$scriptMinDate};
            });
            $("{$class['end']}").on("dp.change", function (e) {
                $('{$class['start']}').data("DateTimePicker")
                {$scriptMaxDate};
            });
EOT;

        return parent::render();
    }
}