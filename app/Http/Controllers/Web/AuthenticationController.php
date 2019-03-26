<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use Socialite;

class AuthenticationController extends Controller
{
    //重定向到第三方 OAuth 服务授权页面获取授权码
    public function getSocialRedirect($account)
    {
        try {
            return Socialite::with($account)->redirect();
        } catch (\InvalidArgumentException $e) {
            return redirect('/login');
        }
    }

    /*
     * 从第三方 OAuth 回调（这里是 Github）中获取用户信息，
     * 如果该用户在 Roast 中不存在的话将其保存到 users 表，
     * 然后手动对该用户进行登录认证操作，
     * 如果已存在的话直接进行登录操作
     * */
    public function getSocialCallback($account)
    {
        // 从第三方 OAuth 回调中获取用户信息
        $socialUser = Socialite::with($account)->user();
//        dd($socialUser);
        // 在本地 users 表中查询该用户来判断是否已存在
        $user = User::where( 'provider_id', '=', $socialUser->id )
            ->where( 'provider', '=', $account )
            ->first();
        if ($user == null) {
            // 如果该用户不存在则将其保存到 users 表
            $newUser = new User();

            $newUser->name        = $socialUser->getName();
            $newUser->email       = $socialUser->getEmail() == '' ? '' : $socialUser->getEmail();
            $newUser->avatar      = $socialUser->getAvatar();
            $newUser->password    = '';
            $newUser->provider    = $account;
            $newUser->provider_id = $socialUser->getId();

            $newUser->save();
            $user = $newUser;
        }

        // 手动登录该用户
        Auth::login($user);

        // 登录成功后将用户重定向到首页
        return redirect('/#/home');
    }

    //测试
    public function test()
    {
        $order = [
            [
                "order_count" => 17,
                "uid" => 8505,
                "order_price_sum" => 5398.6,
                "nickname" => "张海鹏",
            ],
            [
                "order_count" => 30,
                "uid" => 8506,
                "order_price_sum" => 8673.21,
                "nickname" => "myw",
            ],
            [
                "order_count" => 22,
                "uid" => 8507,
                "order_price_sum" => 2501.21,
                "nickname" => "我",
            ],
        ];
        $sale = [
            [
                "sale_count" => 4,
                "uid" => 8506,
                "sale_price_sum" => "769.20",
                "sale_number_sum" => "7",
                "nickname" => "myw",
                "total" => 5384.4,
            ],
            [
                "sale_count" => 2,
                "uid" => 8507,
                "sale_price_sum" => "96.80",
                "sale_number_sum" => "3",
                "nickname" => "我",
                "total" => 290.4,
            ],
        ];
    }
}
