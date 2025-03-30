<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ModalManager extends Component
{
    /**
     * Create a new component instance.
     *
     * @param string $editModal
     * @param array $editFields
     */
    public $listModal, $editModal, $editFields;

    public function __construct(
        $listModal = null,
        $editModal = null,
        $editFields = []
    ) {
        $this->listModal = $listModal;
        $this->editModal = $editModal;
        $this->editFields = $editFields;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal-manager', [
            'listModal' => $this->listModal,
            'editModal' => $this->editModal,
            'editFields' => $this->editFields,
        ]);
    }
}
