<?php

namespace Encore\Admin\Form\Field;

use Encore\Admin\Form\Field;

class Display extends Field
{
    protected $showBox = true;

    public function withoutBox() {
        $this->showBox = false;
    }

    public function render()
    {
        return parent::fieldRender([
            'showBox' => $this->showBox
        ]);
    }
}
