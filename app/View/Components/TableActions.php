<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TableActions extends Component
{
    /**
     * Create a new component instance.
     */
    public $id, $listButton, $editButton, $deleteButton;

    public function __construct(
        $id,
        $listButton = null,
        $editButton = null,
        $deleteButton = null
    ) {
        $this->id = $id;
        $this->listButton = $listButton;
        $this->editButton = $editButton;
        $this->deleteButton = $deleteButton;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table-actions', [
            'id' => $this->id,
            'listButton' => $this->listButton,
            'editButton' => $this->editButton,
            'deleteButton' => $this->deleteButton
        ]);
    }
}
