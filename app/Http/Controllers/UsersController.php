<?php

namespace App\Http\Controllers;

use App\Users;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {
        //  $this->middleware('auth:api');
    }
}
