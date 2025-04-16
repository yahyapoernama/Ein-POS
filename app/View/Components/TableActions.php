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
    public $id, $model, $listButton, $listCount, $editButton, $editUrl, $deleteButton;

    public function __construct(
        $id,
        $model = null,
        $listButton = null,
        $listCount = null,
        $editButton = null,
        $editUrl = null,
        $deleteButton = null
    ) {
        $this->id = $id;
        $this->model = $model;
        $this->listButton = $listButton;
        $this->listCount = $listCount;
        $this->editButton = $editButton;
        $this->editUrl = $editUrl;
        $this->deleteButton = $deleteButton;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table-actions', [
            'id' => $this->id,
            'model' => $this->model,
            'listButton' => $this->listButton,
            'listCount' => $this->listCount,
            'editButton' => $this->editButton,
            'editUrl' => $this->editUrl,
            'deleteButton' => $this->deleteButton
        ]);
    }
}

