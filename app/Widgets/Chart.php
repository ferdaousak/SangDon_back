<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class Chart extends AbstractWidget
{
    protected $config = [];
    public function run()
    {
        return view('widgets.chart', array_merge($this->config,[ ]));
    }

    public function shouldbeDisplayed()
    {
        return true;
    }
}
