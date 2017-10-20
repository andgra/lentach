<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin as Admin;
use App\Http\Controllers\User as User;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if((int)(request()->get('viewer_type'))>1) {
        //     return (new Admin\NewsController())->index();
        // } else {
            return (new User\NewsController())->create();
        // }
    }
}
