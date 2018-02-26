<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Bican\Roles\Exceptions\RoleDeniedException;
use Bican\Roles\Models\Role;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class LoginController extends Controller
{

    use AuthenticatesUsers;

    protected $redirectTo = '/backend/dashboard';


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'account';
    }

}
