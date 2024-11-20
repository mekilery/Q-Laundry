<?php

namespace App\Http\Livewire\Admin\Settings;

use Livewire\Component;
use App\Models\PaymentType;
use App\Models\Translation;

class PaymentTypesSettings extends Component
{
    public $paymentTypes, $name, $is_active;

    protected $rules = [
        'name' => 'required',
        'is_active' => 'required|boolean',
    ];
    
    public function render()
    {
        return view('livewire.admin.settings.payment-types-settings');
    }

    public function mount()
    {
        $this->paymentTypes = PaymentType::all();
        if(session()->has('selected_language'))
        {   /* if session has selected language */
            $this->lang = Translation::where('id',session()->get('selected_language'))->first();
        }
        else{
            /* if session has no selected language */
            $this->lang = Translation::where('default',1)->first();
        }
    }

    public function resetFields()
    {
        $this->name = '';
        $this->is_active = 1;
    }

    public function save()
    {
        $this->validate();
        PaymentType::create([
            'name' => $this->name,
            'is_active' => $this->is_active ?? 1
        ]);
        $this->emit('closemodal');
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'New Payment Type created!']);
        $this->paymentTypes = PaymentType::all();
    }
    
    public function toggle($id)
    {
        $paymentTypes = PaymentType::find($id);
        if($paymentTypes->is_active == 1)
        {
            $paymentTypes->is_active = 0;
        }
        elseif($paymentTypes->is_active == 0)
        {
            $paymentTypes->is_active = 1;
        }
        $paymentTypes->save();
    }

    public function view($id) { 
    $this->resetFields(); 
    $this->currentPaymentType = PaymentType::find($id); 
    $this->name = $this->currentPaymentType->name; 
    $this->is_active = $this->currentPaymentType->is_active; 
    } 
    public function update() {
         $this->validate(); $this->currentPaymentType->name = $this->name; 
         $this->currentPaymentType->is_active = $this->is_active ?? 0; 
         $this->currentPaymentType->save(); $this->emit('closemodal'); 
         $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Payment Type updated!']); 
         $this->paymentTypes = PaymentType::all(); 
         
        
    }
    public function delete($id)
    {
        $paymentTypes = PaymentType::find($id);
        $paymentTypes->delete();
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Staff was deleted!']);
        $this->paymentTypes = PaymentType::all();
    }
   
}
