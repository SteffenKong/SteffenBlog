<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin;
use App\Tools\Loader;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{

    protected $adminModel;

    public function __construct()
    {
        $this->adminModel = Loader::singleton(Admin::class);
    }

    public function index(Request $request) {

    }


    public function add() {
        return view('/Admin/admin/add');
    }

    public function doAdd(AdminAddRequest $request) {

    }

    public function update() {
        return view('/Admin/admin/edit');
    }

    public function edit(AdminEditRequest $request) {

    }

    public function delete(Request $request) {

    }

    public function deleteAll(Request $request) {

    }
}
