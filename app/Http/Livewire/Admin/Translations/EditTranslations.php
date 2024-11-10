<?php
namespace App\Http\Livewire\Admin\Translations;
use Livewire\Component;
use App\Models\Translation;
class EditTranslations extends Component
{
    public $data =[],$name,$is_active=1,$default,$translation,$is_rtl;
    /* render the content */
    public function render()
    {
        return view('livewire.admin.translations.edit-translations');
    }
    /* process before mount */
    public function mount($id)
    {
        $translation = Translation::where('id',$id)->first();
        /* if translation is not empty */
        if(!$translation)
        {
            abort(404);
        }
        $this->data = $translation->data;
        $this->name = $translation->name;
        $this->is_active = $translation->is_active;
        $this->default = $translation->default;
        $this->translation = $translation;
        $this->is_rtl = $translation->is_rtl;
        if(session()->has('selected_language'))
        {
            /* if the session has selected language */
            $this->lang = \App\Models\Translation::where('id',session()->get('selected_language'))->first();
        }
        else{
            /* if the session has no selected language */
            $this->lang = \App\Models\Translation::where('default',1)->first();
        }
    }
    /* save the content */
    public function save()
    {
        $this->validate([
            'name'  => 'required',
            'data.*' => 'required'
        ]);
        if($this->default && $this->translation->default == 0)
        {
            Translation::where('default',1)->update([
                'default'=> 0]
            );
        }
        /* if active is 0 */
        if(!$this->is_active)
        {
            $this->default = 0;
        }
        if($this->is_rtl == null || !$this->is_rtl)
        {
            $this->is_rtl = 0;
        }
        $this->translation->name = $this->name;
        $this->translation->data = $this->data;
        $this->translation->is_active = $this->is_active;
        $this->translation->default = $this->default;
        $this->translation->is_rtl = $this->is_rtl;
        $this->translation->save();
        return redirect('/admin/settings/translations');
    }
}