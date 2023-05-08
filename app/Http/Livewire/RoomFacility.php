<?php

namespace App\Http\Livewire;

use Livewire\Component;

class RoomFacility extends Component
{
    public $count = 0;
    public $facilities;
    public $hotel_id;
    public $exist;
    public $old_create_room;
    public $crud;
    public $old_facilities;
    public $old_count;
    public $facilities_count;
    public $hotel_now = 0;

    public function increment(){
        $this->count++;
    }

    public function decrement(){
        if($this->count > 0){
            $this->count--;
        }else{
            if($this->old_count > 0){
                $this->old_count--;
            }else if($this->facilities_count > 0){
                $this->facilities_count--;
            }
        }
    }

    public function render()
    {
        return view('livewire.room-facility');
    }
}
