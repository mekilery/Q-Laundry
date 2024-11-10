<?php
namespace App\Http\Livewire\Admin\Expense;
use Livewire\Component;
use App\Models\ExpenseCategory;
use App\Models\Translation;
use Auth;
class ExpenseCategories extends Component
{
    public $expense_category_name,$expense_category_type,$categories,$search,$lang;
    public $editMode = false;
     /* validation rules */
    protected $rules = [
        'expense_category_name' => 'required',
        'expense_category_type' => 'required',
    ];
    /* called before render */
    public function mount(){

        if(Auth::user()->user_type==1)
        {
            $this->categories = ExpenseCategory::latest()->get();
        } else {
            $this->categories = ExpenseCategory::latest()->where('created_by',Auth::user()->id)->get();
        }

        if(session()->has('selected_language'))
        { /* if session has selected_language */
            $this->lang = Translation::where('id',session()->get('selected_language'))->first();
        }
        else{
            $this->lang = Translation::where('default',1)->first();
        }
    }
    /* render the page */
    public function render()
    {
        return view('livewire.admin.expense.expensecategories');
    }
    /* reset input fields */
    public function resetInputFields(){
        $this->expense_category_name = '';
        $this->expense_category_type = '';
    }
    /* store expense category details */
    public function store()
    {
        /* if editmode is false */
        if($this->editMode == false)
        {
            $this->validate();
            $category = new ExpenseCategory();
            $category->expense_category_name = $this->expense_category_name;
            $category->expense_category_type = $this->expense_category_type;
            $category->expense_category_type = $this->expense_category_type;
            $category->created_by = Auth::user()->id;
            $category->save();
            if(Auth::user()->user_type==1)
            {
                $this->categories = ExpenseCategory::latest()->get();
            } else {
                $this->categories = ExpenseCategory::latest()->where('created_by',Auth::user()->id)->get();
            }
            $this->resetInputFields();
            $this->emit('closemodal');
            $this->dispatchBrowserEvent(
                'alert', ['type' => 'success',  'message' => 'Expense Category has been created!']);
        }
    }
    /* set category type value while change the category type */
    public function changeCategoryType() {
        $this->expense_category_type = $this->expense_category_type;
    }
    /* process when update the element */
    public function updated($name,$value)
    {
        /* if the updated element is search */
        if($name == 'search' && $value != '')
        {
            if(Auth::user()->user_type==1)
        {
            
            $this->categories = ExpenseCategory::where(function($query) use ($value) { 
                $query->where('expense_category_name', 'like', '%' . $value . '%');
            })->get();   
        } else {
            $this->categories = ExpenseCategory::where('created_by',Auth::user()->id)->where(function($query) use ($value) { 
                $query->where('expense_category_name', 'like', '%' . $value . '%');
            })->get();   
        }
            
        } else {
            if(Auth::user()->user_type==1)
            {
                $this->categories = ExpenseCategory::latest()->get();
            } else {
                $this->categories = ExpenseCategory::latest()->where('created_by',Auth::user()->id)->get();
            }
        }
    }
      /* set the content to edit */
    public function edit($id)
    {
        $this->editMode = true;
        $this->category = ExpenseCategory::where('id',$id)->first();
        $this->expense_category_name = $this->category->expense_category_name;
        $this->expense_category_type = $this->category->expense_category_type;
    }
    /* update expense category*/
    public function update()
    {
        $this->validate();
        if($this->editMode == true)
        {
            $this->category->expense_category_name = $this->expense_category_name;
            $this->category->expense_category_type = $this->expense_category_type;
            $this->category->save();
            if(Auth::user()->user_type==1)
            {
                $this->categories = ExpenseCategory::latest()->get();
            } else {
                $this->categories = ExpenseCategory::latest()->where('created_by',Auth::user()->id)->get();
            }
            $this->resetInputFields();
            $this->editMode = false;
            $this->emit('closemodal');
            $this->dispatchBrowserEvent(
                'alert', ['type' => 'success',  'message' => 'Expense Category has been updated!']);
        }
    }
    /* expense category delete */
    public function delete($id)
    {   
        if (\App\Models\Expense::where('expense_category_id', $id)->doesntExist()) {
            /* if expense category has any children */
            $this->category = ExpenseCategory::where('id',$id)->delete();
            $this->dispatchBrowserEvent(
                'alert', ['type' => 'success',  'message' => 'Expense Category deleted Successfully!']);
        } else {
            /* if expense category has no child */
                $this->dispatchBrowserEvent(
                'alert', ['type' => 'error',  'message' => 'Expense Category deletion restricted!']);
        }
        if(Auth::user()->user_type==1)
        {
            $this->categories = ExpenseCategory::latest()->get();
        } else {
            $this->categories = ExpenseCategory::latest()->where('created_by',Auth::user()->id)->get();
        }
    }
}