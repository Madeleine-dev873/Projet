<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    
    /**
     * Redirection après connexion
     */
    protected function redirectTo()
    {
        return route('upload-electors'); // Assurez-vous que cette route existe dans web.php
    }

    /**
     * Constructeur du contrôleur
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Surcharge de la méthode login pour personnaliser la redirection
     */
    public function login(Request $request)
    {
        // Validation des champs
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Vérification des identifiants
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return redirect()->route('upload-electors'); // Redirection après succès
        }

        // En cas d'échec
        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect.',
        ])->onlyInput('email');
    }
    public function logout(Request $request)
{
    Auth::logout(); // Déconnecte l'utilisateur
    $request->session()->invalidate(); // Invalide la session
    $request->session()->regenerateToken(); // Régénère un token CSRF

    return redirect('/login'); // Redirige vers la page de connexion
}

}
