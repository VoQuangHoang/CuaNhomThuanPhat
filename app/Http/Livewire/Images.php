<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Images extends Component
{
    // public $homeSlider = [];
    public $contents;
    public $listSlider;


    public function mount()
    {
        $this->listSlider = !empty($this->contents) ? $this->contents->list : [];
        $this->contents = array($this->contents);

    }

    public function addSlider()
    {
        $this->listSlider[] = ['url' => '', 'text' => '', 'link' => ''];
    }

    public function removeSlider($key)
    {
        unset($this->listSlider[$key]);
        $this->listSlider = array_values($this->listSlider);
    }

    public function render()
    {
        info($this->listSlider);
        return view('livewire.images');
    }
}
