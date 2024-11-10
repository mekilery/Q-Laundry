<?php
namespace App\Http\Livewire\Admin\Service;
use App\Models\Service;
use App\Models\ServiceDetail;
use App\Models\Translation;
use Livewire\Component;
class ServiceList extends Component
{
    public $services,$search_query,$lang;
    /* render the page */
    public function render()
    {
        return view('livewire.admin.service.service-list');
    }
    /* process before render */
    public function mount()
    {
        $this->services = Service::latest()->get();
        if(session()->has('selected_language'))
        {   /* if session has selected language */
            $this->lang = Translation::where('id',session()->get('selected_language'))->first();
        }
        else{
            /* if session has no selected language */
            $this->lang = Translation::where('default',1)->first();
        }
    }
    /* delete the service */
    public function delete($id)
    {
        try{
            $service = Service::where('id',$id)->delete();
            ServiceDetail::where('service_id',$id)->delete();
            $this->services = Service::latest()->get();
        }
        catch(\Exception $e)
        {
            $this->dispatchBrowserEvent(
                'alert', ['type' => 'error',  'message' => 'Cannot Delete Service List!']);
        }
    }
    /* process while update the content */
    public function updated($name,$value)
    {   /* if the updated element is search_query */
        if($name == 'search_query' && $value != '')
        {
            $this->services = Service::where('service_name', 'like' , '%'.$value.'%')->get();
        }
        elseif($name == 'search_query' && $value == ''){
            $this->services = Service::latest()->get();

        }
    }
}