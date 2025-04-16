<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ModalWrapper extends Component
{
    /**
     * Create a new component instance.
     */

    public $id;
    public $title;
    public $size;
    public $centered;
    public $scrollable;
    public $backdrop;
    public $keyboard;
    public $wrapBody;

    public function __construct(
        $id,
        $title = '',
        $size = 'md',
        $centered = true,
        $scrollable = true,
        $backdrop = true,
        $keyboard = false,
        $wrapBody = true
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->size = $size;
        $this->centered = $centered;
        $this->scrollable = $scrollable;
        $this->backdrop = $backdrop;
        $this->keyboard = $keyboard;
        $this->wrapBody = $wrapBody;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal-wrapper');
    }
}

