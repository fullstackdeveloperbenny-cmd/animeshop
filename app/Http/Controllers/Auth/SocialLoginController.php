<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\SocialAccountService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    /**
     * Stuur de gebruiker door naar de authenticatiepagina van de provider.
     */
    public function redirect(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Haal de gebruikersinformatie op van de provider.
     */
    public function callback(string $provider, SocialAccountService $service)
    {
        try {
            // Fix voor WAMP (cURL error 60): controleer lokaal geen SSL certificaten
            $httpClient = new \GuzzleHttp\Client([
                'verify' => app()->environment('production'),
            ]);

            $providerUser = Socialite::driver($provider)
                ->setHttpClient($httpClient)
                ->user();
            
            $user = $service->handle($providerUser, $provider);

            Auth::login($user);

            return redirect()->intended(route('shop.index', absolute: false));
        } catch (Exception $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Er ging iets mis tijdens het inloggen via ' . ucfirst($provider) . '. Probeer het nog eens.'
            ]);
        }
    }
}
