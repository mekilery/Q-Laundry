<?php

namespace App\Http\Livewire\Update;
use Illuminate\Support\Facades\File;

use Livewire\Component;

class Updater extends Component
{
    public $status,$progress=0,$showitems = false,$errors = 0,$success;
    public function render()
    {
        return view('livewire.update.updater')
        ->extends('layouts.login_layout')
        ->section('content');
    }

    public function mount()
    {
        if(!File::exists(base_path('update')))
        {
            return redirect()->route('login');
        }
        $this->status = [];
    }

    public function update()
    {
        $this->showitems = true;
        try{
            \Artisan::call('migrate', [
                '--force'     => true,
            ]);
        }
        catch(\Exception $e)
        {
            array_push($this->status,"Failed To Migrate" );
            array_push($this->status,$e->getMessage() );
            $this->errors = $this->errors +1;
        }
        // try{
        //     \Artisan::call('db:seed');
        // }
        // catch(\Exception $e)
        // {
        //     array_push($this->status,"Seeding Failed" );
        //     array_push($this->status,$e->getMessage() );
        //     $this->errors = $this->errors +1;
        // }
        if($this->errors > 0)
        {
            array_push($this->status,"-----Errors Were Detected-----" );
        }
        else{
            array_push($this->status,"-----Updation Successful-----" );
            array_push($this->status,"Deleting Update Files." );
            unlink(base_path('update'));
            $this->success = true;
        }
    }
}