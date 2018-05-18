<?php namespace App\Http\Controllers;

use App\AgeID\PayloadHelper;

class HomeController extends Controller
{
    /**
     * Show the NSFW Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function nsfw()
    {
        return view(config('app.page_to_load'));
    }
}
