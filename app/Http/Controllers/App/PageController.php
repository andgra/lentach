<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin as Admin;
use App\Http\Controllers\User as User;
use Illuminate\Support\Facades\Cookie;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $re = redirect();
        if ((int)(request()->get('viewer_type')) > 1) {
            $re = $re->route('admin.news.index');
        } else {
            $re = $re->route('user.news.create');
        }

        return $re->cookie(
            'vk-api',
            serialize(request()->all())
            , 3600
        );


    }
}
