<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PasswordResetController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email'); // crée la vue
    }

  public function sendResetLinkEmail(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email'
    ]);

    $status = Password::sendResetLink($request->only('email'));
    if ($status === Password::RESET_LINK_SENT) {
        return back()->with('success', 'Un lien de réinitialisation a été envoyé à votre adresse email.');
    }
    $errors = [
        Password::INVALID_USER => 'Aucun utilisateur trouvé avec cette adresse email.',
        Password::RESET_THROTTLED => 'Trop de tentatives. Veuillez réessayer dans quelques minutes.',
    ];

    $errorMessage = $errors[$status] ?? 'Une erreur est survenue. Veuillez réessayer.';

    return back()->withErrors(['email' => $errorMessage]);
}

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with([
            'token' => $token,
            'email' => $request->email
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => ['required','confirmed','min:8',]
        ]);

        $status = Password::reset(
            $request->only('email','password','password_confirmation','token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'password_changed_at' => now(),
                ])->save();

                // optionally: $user->setRememberToken(Str::random(60));
                // event(new PasswordReset($user));
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
