<?php

namespace App\Http\Livewire\Admin\Staff;

use App\Models\Translation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Staff extends Component
{
    
    public $name,$phone,$email,$password,$address,$is_active,$staffs,$staff,$search='';
    public function render()
    {
        $query = User::where('user_type',2);
        if($this->search != '')
        {
            $query->where('name','like','%'.$this->search.'%');
        }
        if(session()->has('selected_language'))
        {   /*if session has selected language */
            $this->lang = Translation::where('id',session()->get('selected_language'))->first();
        }
        else{
            /* if session has no selected language */
            $this->lang = Translation::where('default',1)->first();
        }
        $this->staffs =$query->get();
        return view('livewire.admin.staff.staff');
    }
    public function resetFields()
    {
        $this->name = '';
        $this->phone = '';
        $this->email = '';
        $this->password = '';
        $this->address = '';
        $this->is_active = 1;
        $this->staff = null;
    }
    public function save()
    {
        $this->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|unique:users',
            'password'=> 'required'
        ]);
        User::create([
            'name'  => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'password'  => Hash::make($this->password),
            'user_type' => 2,
            'is_active' => $this->is_active ?? 0
        ]);
        $this->emit('closemodal');
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Staff was created!']);
    }

    public function toggle($id)
    {
        $staff = User::find($id);
        if($staff->is_active == 1)
        {
            $staff->is_active = 0;
        }
        elseif($staff->is_active == 0)
        {
            $staff->is_active = 1;
        }
        $staff->save();
    }

    public function view($id)
    {
        $this->resetFields();
        $this->staff = User::find($id);
        $this->name = $this->staff->name;
        $this->email = $this->staff->email;
        $this->phone = $this->staff->phone;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|unique:users,email,'.$this->staff->id,
        ]);
        $this->staff->name = $this->name;
        $this->staff->email = $this->email;
        $this->staff->phone = $this->phone;
        $this->staff->is_active = $this->is_active ?? 0;
        if($this->password != '')
        {
            $this->staff->password = Hash::make($this->password);
        }
        $this->staff->save();
        $this->emit('closemodal');
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Staff was updated!']);
    }

    public function delete($id)
    {
        $staff = User::find($id);
        $staff->delete();
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Staff was deleted!']);
    }
}
