<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 展示首页模板
     */
    public function index() {
        return view('/admin/index/index');
    }

    public function welcome() {
        return view('/admin/index/welcome');
    }
}
