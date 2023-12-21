<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Redirect;
use Session;

session_start();

class AdminController extends Controller
{
    use UtilitiesTrait;
    public function show_admin_login()
    {
        if(Session::get('admin_id')) {
            return Redirect::to('/admin');
        }
        return view('admin.login.admin_login');
    }

    public function login_admin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $account = Admin::where('admin_email', $request->email)->where('admin_password', md5($request->password))->first();

        if($account) {
            Session::put('admin_name', $account->admin_name);
            Session::put('admin_id', $account->admin_id);

            return $this->successResponse($account, 'Đăng nhập thành công', 200);
        } else {
            return $this->errorResponse('Email hoặc mật khẩu không chính xác!', 422);
        }
    }

    public function change_password(Request $request)
    {
        $admin = Admin::find(Session::get('admin_id'));
        $admin->admin_password = md5($request->password);
        $admin->save();

        return $this->successResponse($admin, 'Đổi mật khẩu thành công!', 200);
    }

    public function logout_admin()
    {
        Session::put('admin_name', null);
        Session::put('admin_id', null);
        return Redirect::to('/admin/login');
    }
}
