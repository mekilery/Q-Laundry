<?php
namespace App\Http\Livewire\Components;
use Livewire\Component;
use App\Models\Translation;
class Header extends Component
{
    public $languages,$lang;
    /* render the page */
    public function render()
    {
        return view('livewire.components.header');
    }
    /* process before render */
    public function mount()
    {
        $this->languages = Translation::where('is_active',1)->pluck('name','id');
        if(session()->has('selected_language'))
        {
            $this->lang = Translation::where('id',session()->get('selected_language'))->first();
        }
        else{
            $this->lang = Translation::where('default',1)->first();
        }
    }
    /* change the language */
    public function changeLanguage($id)
    {
        $language = Translation::where('id',$id)->first();
        session()->put('selected_language',$language->id);
        $this->emit('reloadpage');
    }
}