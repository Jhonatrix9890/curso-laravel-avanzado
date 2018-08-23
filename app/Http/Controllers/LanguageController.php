<?php

namespace App\Http\Controllers;

use Config;

class LanguageController extends Controller
{
    public function switchLang($lang)
    {
        if (in_array($lang, Config::get('app.available_locale'))) {
            $url = url()->previous();
            $url_explode = explode("/", $url);
            $url_explode[3] = $lang;
            $redir = implode('/', $url_explode);

            return redirect()->to($redir);
        } else {
            return back();
        }
    }
}
