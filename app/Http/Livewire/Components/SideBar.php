<?php
namespace App\Http\Livewire\Components;
use Livewire\Component;
use App\Models\Translation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SideBar extends Component
{
    public $lang;
    /* render the page */
    public function render()
    {
        return view('livewire.components.side-bar');
    }
    /* process before render */
    public function mount()
    {
        if(session()->has('selected_language'))
        {
            $this->lang = Translation::where('id',session()->get('selected_language'))->first();
        }
        else{
            $this->lang = Translation::where('default',1)->first();
        }
    }
    //Perform Logout
    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/');
    }
}