<?php

namespace App\View\Components;

use Illuminate\View\Component;

class UpdateClass extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $subject;
    public function __construct($subject)
    {
        //
        $this->subject = $subject;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.update-class');
    }
}
