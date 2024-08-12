<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PhoneBookController extends Controller
{
    public function index()
    {
        $users = User::with(['phone', 'emails', 'links', 'dates', 'companies'])->get();

        return view('phonebook.index', compact('users'));
    }
}

