<?php

namespace App\Services;

use App\Models\SocialAccount;
use App\Models\User;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountService
{
    /**
     * Handle the social login linking and creation process.
     */
    public function handle(ProviderUser $providerUser, string $provider): User
    {
        // 1. Kijkt of het social account al bestaat (en dus eerder is gekoppeld)
        $socialAccount = SocialAccount::where('provider', $provider)
            ->where('provider_id', $providerUser->getId())
            ->first();

        if ($socialAccount) {
            // Zorg dat we altijd het nieuwste token hebben (kan handig zijn voor API's)
            $socialAccount->update([
                'token' => $providerUser->token,
            ]);

            return $socialAccount->user;
        }

        // 2. Kijkt of het e-mailadres al bestaat in ons systeem
        $user = User::where('email', $providerUser->getEmail())->first();

        // 3. Anders -> we maken een compleet nieuw account aan
        if (! $user) {
            $user = User::create([
                // Sommige providers geven geen 'name', dan gebruiken we 'nickname'
                'name' => $providerUser->getName() ?? $providerUser->getNickname() ?? 'Gebruiker',
                'email' => $providerUser->getEmail(),
                // Wachtwoord moet gevuld zijn, dus we genereren een sterk willekeurig wachtwoord
                'password' => bcrypt(str()->random(24)),
            ]);
        }

        // Koppel het social account aan de (bestaande of zojuist aangemaakte) gebruiker
        $user->socialAccounts()->create([
            'provider' => $provider,
            'provider_id' => $providerUser->getId(),
            'token' => $providerUser->token,
        ]);

        return $user;
    }
}
