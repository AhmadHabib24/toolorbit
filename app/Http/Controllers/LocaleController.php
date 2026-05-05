<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    public function setLocale($lang)
    {
        if (in_array($lang, ['en', 'es', 'fr', 'ur', 'ar', 'tr'])) {
            Session::put('locale', $lang);
        }
        return redirect()->back();
    }
}
