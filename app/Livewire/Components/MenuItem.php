<?php

namespace App\Livewire\Components;

use Livewire\Component;

class MenuItem extends Component
{
    public $title, $icon, $route;

    public function mount($title, $route, $icon)
    {
        $this->title = $title;
        $this->route = $route;
        $this->icon = $icon;
    }

    public function render()
    {
        return view('livewire.components.menu-item');
    }
}
