<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Note;

class Crud extends Component
{
	public $notes, $note, $datecreated, $note_id;
    public $isModalOpen = 0;

    public function render()
    {
    	$this->notes = Note::all();
        return view('livewire.crud');
    }

    public function create()
    {
        $this->resetCreateForm();
        $this->openModalPopover();
    }

    public function openModalPopover()
    {
        $this->isModalOpen = true;
    }

    public function closeModalPopover()
    {
        $this->isModalOpen = false;
    }

    private function resetCreateForm(){
        $this->note = '';
        $this->datecreated = '';        
    }

    public function store()
    {
        $this->datecreated = 'sadsadas';
        $this->validate([
            'note' => 'required',
            'datecreated' => 'required',            
        ]);
    
        Note::updateOrCreate(['id' => $this->note_id], [
            'note' => $this->note,
            'datecreated' => $this->datecreated,            
        ]);

        session()->flash('message', $this->note_id ? 'Note updated.' : 'Note created.');

        $this->closeModalPopover();
        $this->resetCreateForm();
    }

    public function edit($id)
    {
        $note = Note::findOrFail($id);
        $this->id = $id;
        $this->note = $note->note;
        $this->datecreated = $note->datecreated;        
    
        $this->openModalPopover();
    }

    public function delete($id)
    {
        Note::find($id)->delete();
        session()->flash('message', 'Note deleted.');
    }
}
