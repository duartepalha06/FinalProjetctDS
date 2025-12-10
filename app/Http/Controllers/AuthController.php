<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\PasswordResetMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('products.index')->with('success', 'Login de admin realizado!');
            } else {
                return redirect()->route('shop.index')->with('success', 'Login realizado!');
            }
        }

        return back()->withErrors(['email' => 'Credenciais inválidas!'])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        return redirect()->route('auth.login')->with('success', 'Conta criada com sucesso! Faz login agora.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth.login')->with('success', 'Logout realizado!');
    }

    // Show forgot password form
    public function showForgot()
    {
        return view('auth.passwords.email');
    }

    // Send reset link
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Email não encontrado.']);
        }

        $token = Str::random(64);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => Carbon::now()]
        );

        Mail::to($request->email)->send(new PasswordResetMail($token));

        return back()->with('success', 'Enviámos um email com o link para redefinir a password (verifique o Mailtrap).');
    }

    // Show reset form
    public function showReset($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    // Reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $record = DB::table('password_resets')->where('email', $request->email)->where('token', $request->token)->first();
        if (!$record) {
            return back()->withErrors(['email' => 'Token inválido ou expirado.'])->onlyInput('email');
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Email não encontrado.'])->onlyInput('email');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('auth.login')->with('success', 'Password redefinida com sucesso! Faça login.');
    }
}
