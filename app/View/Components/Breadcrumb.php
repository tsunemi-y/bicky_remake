<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Breadcrumb extends Component
{
    public $item;
    public $item2;
    public $url;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($item, $item2, $url)
    {
        $this->item = $item;
        $this->item2 = $item2;
        $this->url = $url;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.breadcrumb');
    }
}
