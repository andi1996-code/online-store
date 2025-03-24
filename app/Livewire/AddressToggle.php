<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Store;

class AddressToggle extends Component
{
    public $address;
    public $isLong;
    public $showFullAddress = false;

    public function mount()
    {
        $store = Store::first();
        $this->address = $store->address;
        $this->isLong = strlen($this->address) > 50;
    }

    public function toggleAddress()
    {
        $this->showFullAddress = !$this->showFullAddress;
    }

    public function render()
    {
        return view('livewire.address-toggle');
    }
}
