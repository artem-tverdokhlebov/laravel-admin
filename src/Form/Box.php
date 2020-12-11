<?php

namespace Encore\Admin\Form;

use Encore\Admin\Form;
use Illuminate\Support\Collection;

class Box
{
    /**
     * @var Form
     */
    protected $form;

    /**
     * @var int
     */
    protected $offset = 0;

    public $offsets = null;

    /**
     * Tab constructor.
     *
     * @param Form $form
     */
    public function __construct(Form $form)
    {
        $this->form = $form;
        $this->offsets = new Collection();
    }

    /**
     * Append a box section.
     *
     * @param string $title
     * @param \Closure $content
     * @param bool $collapse
     *
     * @return \Encore\Admin\Widgets\Box
     */
    public function append($title, \Closure $content, $collapse = false)
    {
        $start = $this->form->fields()->count();

        call_user_func($content, $this->form);

        $fields = clone $this->form->fields();

        $all = $fields->toArray();

        foreach ($this->form->rows as $row) {
            $rowFields = array_map(function ($field) {
                return $field['element'];
            }, $row->getFields());

            $match = false;

            foreach ($rowFields as $field) {
                if (($index = array_search($field, $all)) !== false) {
                    if (!$match) {
                        $fields->put($index, $row);
                    } else {
                        $fields->pull($index);
                    }

                    $match = true;
                }
            }
        }

        $end = $fields->count();

        $box = new \Encore\Admin\Widgets\Box($title);

        $box->style('info');
        $box->collapsable();

        if ($collapse) {
            $box->collapse();
        }

        $this->offsets->push([
            'box' => $box, 'start' => $start, 'end' => $end
        ]);

        $this->offset = $fields->count();

        return $box;
    }

    /**
     * Get offsets.
     *
     * @return Collection
     */
    public function getOffsets()
    {
        return $this->offsets;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return $this->offsets->isEmpty();
    }
}
