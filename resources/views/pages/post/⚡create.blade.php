<?php

use Livewire\Component;

new class extends Component
{
    public string $title = '';

    public string $content='';

    public function save() 
    {
        $this->validate([
            'title'=>'required|max:255',
            'content'=>'required',
        ]);

        dd($this->title, $this->content);
    }
};
?>

<form wire:submit="save">

<label>
    Title
    <input type="text wire"model="title">
</label>

<label>
    Content
    <textarea wire:model="content" rows="5"></textarea>
</label>

<button type="submit">Save Post</button>
</form>

