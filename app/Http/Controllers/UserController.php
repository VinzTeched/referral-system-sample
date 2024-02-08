<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //
    public function deposit() {
        $commissionType = 'interest';
        $user = User::find($usr);
        $amount = 200;
        levelCommission($user->id, $amount, $commissionType);
    }

   
}
