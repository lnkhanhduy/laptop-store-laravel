<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Redirect;
use Session;
use App\Models\User;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Social;
use Mail;

session_start();
class UserController extends Controller
{
    use UtilitiesTrait;

    public function show_page_home()
    {
        $banner = Banner::where('banner_status', 1)->orderBy('banner_id', 'DESC')->get();
        $new_product = Product::where('product_status', 1)->whereRaw('CAST(product_quantity AS SIGNED) > CAST(product_sold AS SIGNED)')->orderBy('product_id', 'DESC')->limit(8)->get();
        return view('user.home.home', [
            'banner' => $banner,
            'new_product' => $new_product
        ]);
    }

    public function show_page_search(Request $request)
    {
        return view('user.product.search_product', [
            'keyword' => $request->search_keyword
        ]);
    }

    public function show_page_product_user()
    {
        return view('user.product.show_product');
    }

    public function show_page_contact()
    {
        return view('user.contact.contact');
    }

    public function show_page_login()
    {
        if(Session::get('user_id')) {
            return Redirect::to('/');
        }
        return view('user.account.login');
    }

    public function show_page_forgot_password()
    {
        if(Session::get('user_id')) {
            return Redirect::to('/');
        }
        return view('user.account.forgot_password');
    }

    public function generateRandomCode($length = 6)
    {
        $randomCode = '';
        for ($i = 0; $i < $length; $i++) {
            $randomCode .= rand(0, 9);
        }

        return $randomCode;
    }

    public function forgot_password(Request $request)
    {
        $request->validate(
            ['email' => 'required|exists:tbl_user,user_email',
        ],
            ['email.exists' => 'Không tìm thấy email!',
        ]
        );

        $user_account = User::where('user_email', $request->email)->first();
        if($user_account) {
            $to_email = $user_account->user_email;
            $reset_code = $this->generateRandomCode();
            $user_account->reset_code = $reset_code;
            $user_account->save();
            $data = array('code' => $reset_code, 'name' => $user_account->full_name);

            Mail::send('user.account.send_mail', $data, function ($message) use ($to_email) {
                $message->to($to_email)->subject('Mã xác nhận đặt lại mật khẩu');
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });

            return $this->successResponse($user_account, 'Gửi email đặt lại mật khẩu thành công!', 200);
        }
    }

    public function reset_password(Request $request)
    {
        $request->validate([
            'reset_code' => 'required|exists:tbl_user,reset_code',
            'email' => 'required|exists:tbl_user,user_email',
        ], [
            'code.exists' => 'Mã xác nhận không chính xác!',
        ]);

        $user = User::where('user_email', $request->email)->where('reset_code', $request->reset_code)->where('updated_at', '>=', now()->subMinutes(5))->first();

        if($user) {
            $user->user_password = md5('123456');
            $user->reset_code = '';
            $user->save();

            return $this->successResponse($user, 'Đặt lại mật khẩu thành công!', 200);
        } else {
            return $this->errorResponse('Mã xác nhận không chính xác!', 422);
        }
    }

    public function login_account_user(Request $request)
    {
        $request->validate([
            'email_login' => 'required|exists:tbl_user,user_email',
            'password_login' => 'required|min:6',
        ]);

        $user = User::where('user_email', $request->email_login)->where('user_password', md5($request->password_login))->first();

        if($user == null) {
            return $this->errorResponse('Sai email hoặc mật khẩu!', 400);
        }

        Session::put('user_name', $user->full_name);
        Session::put('user_id', $user->user_id);

        return $this->successResponse($user, 'Đăng nhập tài khoản thành công!', 200);

    }

    public function register_account_user(Request $request)
    {
        $request->validate([
               'name_register' => 'required',
               'email_register' => 'required|unique:tbl_user,user_email',
               'password_register' => 'required|min:6',
               'confirm_password_register' => 'required|same:password_register',
        ], [
               'email_register.unique' => 'Email đã được sử dụng!',
        ]);

        $user = new User();
        $user->full_name = $request->name_register;
        $user->user_email = $request->email_register;
        $user->user_password = md5($request->password_register);
        $user->reset_code = '';
        $user->save();

        Session::put('user_name', $request->name_register);
        Session::put('user_id', $user->user_id);
        Session::put('message', "Đăng ký tài khoản thành công!");

        return $this->successResponse($user, 'Đăng ký tài khoản thành công!', 200);
    }

    public function change_password_user(Request $request)
    {
        $user = User::find(Session::get('user_id'));
        $user->user_password = md5($request->password);
        $user->save();

        return $this->successResponse($user, 'Đổi mật khẩu thành công!', 200);
    }

    //Login facebook
    public function login_facebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback_facebook()
    {
        $provider = Socialite::driver('facebook')->user();
        $account = Social::where('provider', 'facebook')->where('provider_user_id', $provider->getId())->first();

        if($account) {
            $account_user = User::where('user_id', $account->user_id)->first();
            Session::put('user_name', $account_user->full_name);
            Session::put('user_id', $account_user->user_id);
            return Redirect::to('/');
        } else {
            $new_account = new Social([
                'provider_user_id' => $provider->getId(),
                'provider' => 'facebook',
            ]);

            $email = User::where('user_email', $provider->getEmail())->first();

            if(!$email) {
                $new_account_social = User::create([
                    'user_name' => $provider->getName(),
                    'user_email' => $provider->getEmail(),
                    'user_password' => '',
                    'reset_code' => '',
                ]);
            }

            $new_account->login()->associate($new_account_social);
            $new_account->save();

            $account_user = User::where('user_id', $account->user)->first();
            Session::put('user_name', $account_user->full_name);
            Session::put('user_id', $account_user->user_id);
            return Redirect::to('/');
        }
    }

    //Login google
    public function login_google()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback_google()
    {
        $provider = Socialite::driver('google')->stateless()->user();
        $account = Social::where('provider', 'google')->where('provider_user_id', $provider->id)->first();

        if ($account) {
            $account_user = User::where('user_id', $account->user_id)->first();
            Session::put('user_name', $account_user->full_name);
            Session::put('user_id', $account_user->user_id);
            return Redirect::to('/');
        } else {
            $account_social = new Social([
                'provider_user_id' => $provider->id,
                'provider' => 'google',
            ]);

            $user = USer::where('user_email', $provider->email)->first();

            if (!$user) {
                $new_account_social = User::create([
                    'full_name' => $provider->name,
                    'user_email' => $provider->email,
                    'user_password' => '',
                    'reset_code' => '',
                ]);
            } else {
                $new_account_social = $user;
            }

            $account_social->login()->associate($new_account_social);
            $account_social->save();

            $account_user = User::where('user_id', $new_account_social->user_id)->first();
            Session::put('user_name', $account_user->full_name);
            Session::put('user_id', $account_user->user_id);
            return Redirect::to('/');
        }
    }

    public function logout_account_user()
    {
        Session::put('user_name', null);
        Session::put('user_id', null);
        return Redirect::to('/');
    }
}
