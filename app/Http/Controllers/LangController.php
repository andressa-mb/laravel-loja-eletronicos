<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LangController extends Controller
{
    public function setLang(Request $request){
        $lang = $request->lang;
        if(!in_array($lang, ['pt-BR', 'en', 'es'])){
            $lang = 'pt-BR';
        }
        App::setLocale($lang);
        session(['locale' => $lang]);
        return redirect()->back();

    }
}
