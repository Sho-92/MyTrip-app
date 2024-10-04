<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class GuestLoginController extends Controller
{
    public function login()
    {
        // ゲストユーザーの情報を設定
        $guestUser = User::firstOrCreate(
            ['email' => 'guest@example.com'], // 仮のゲストメールアドレス
            ['name' => 'Guest User', 'password' => bcrypt('password')] // ゲストユーザーのパスワード
        );

        // ゲストユーザーとしてログイン
        Auth::login($guestUser);

        // リダイレクト処理（ホームページなど）
        return redirect()->route('home');
    }
    
}