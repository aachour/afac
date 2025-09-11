<?php

namespace App\Livewire\Auth;

use App\Models\User;

use Livewire\Component;

class Login extends Component
{
    public $username = '';
    public $password = '';
    public $rememberMe = false;

    public $headerStyle;


    protected $rules = [
        'username' => ['required', 'string', 'username'],
        'password' => ['required', 'string'],
    ];

    public function mount()
    {
        if(auth()->user())
        {
            return to_route('dashboard');
        }
    }

    public function login()
    {
        $validatedData = $this->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);
    
        if (auth()->attempt(['username' => $validatedData['username'], 'password' => $validatedData['password']], $this->rememberMe))
        {
            return redirect()->route('dashboard');
        }
        else
        {
            return $this->addError('username', trans('auth.failed'));
        }
    }
    

    public function render()
    {
        return view('livewire.auth.login');
    }
}
