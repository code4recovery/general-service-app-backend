<?php

namespace App\Livewire;

use Livewire\Component;

class EmailForm extends Component
{

    public $show = false;

    public $entity = null;

    public function render()
    {
        return view('livewire.email-form');
    }
}
