<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TestClassBase extends Component
{
    public $classMsg;
    public $defaultMsg;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($classMsg, $defaultMsg = "変数初期値")
    {
        $this->classMsg = $classMsg;
        $this->defaultMsg = $defaultMsg;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tests.test-class-base');
    }
}
