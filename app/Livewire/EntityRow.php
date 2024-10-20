<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class EntityRow extends Component
{

    public $show;

    public $entity;

    public $active;

    public $email;

    public function render()
    {
        return view('livewire.entity-row');
    }

    public function add()
    {
        $user = User::createOrFirst([
            'email' => $this->email,
        ]);

        $user->entities()->syncWithoutDetaching($this->entity);

        $user->save();

        $this->email = '';
    }

    public function remove($id)
    {

        $user = User::find($id);

        $user->entities()->detach($this->entity);

        if (!$user->entities()->count()) {
            $user->delete();
        } else {
            $user->save();
        }

        $this->show = false;
    }

}
