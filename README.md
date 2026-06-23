# Anime Webshop 🎌

Dit is de eindopdracht voor de cursus Full-Stack Web Development. Het is een volledig functionele, dynamische webshop gespecialiseerd in anime merchandise (Manga's, T-shirts, Hoodies, Nendoroids en Funko Pops).

## 🚀 De Technologie Stack & Waarom

Tijdens de ontwikkeling is er extreem veel aandacht besteed aan **snelheid, veiligheid en schaalbaarheid**. Daarom is er gekozen voor de volgende "TALL" achtige stack:

*   **Laravel 13 (PHP 8.4):** Gekozen vanwege het robuuste MVC (Model-View-Controller) patroon, ingebouwde veiligheid (CSRF bescherming, SQL injection preventie) en het krachtige Eloquent ORM voor databasebeheer. Deze nieuwste, meest stabiele versie garandeert maximale performance.
*   **MySQL:** Een betrouwbare, relationele database. Gekozen omdat webshops strikte data-integriteit vereisen (bijv. Foreign Keys tussen Orders, Users en Products).
*   **Tailwind CSS:** In plaats van zware JavaScript animatie-libraries zoals GSAP te gebruiken, is er bewust gekozen voor **pure Tailwind CSS animaties en keyframes**. Dit zorgt voor prachtige effecten (zoals glow, hover-transities en het draaiende logo) *zonder* dat de website traag wordt door honderden kilobytes aan JavaScript. Performance stond hier op één!
*   **Alpine.js:** Gebruikt voor de weinige plekken waar wél JavaScript nodig was (zoals het verbergen van succes-meldingen na 2 seconden of het openen van mobiele menu's). Alpine is extreem lichtgewicht vergeleken met React of Vue.
*   **Stripe:** Geïntegreerd voor veilige betalingen. Stripe zorgt ervoor dat creditcardgegevens nooit onze eigen database raken, wat essentieel is voor de wetgeving (GDPR/PCI compliance).

## 🛠️ Installatie & Opstarten

Volg deze stappen om het project lokaal te draaien:

1.  Zorg dat je in de projectmap zit (`cd animewebshop`).
2.  Installeer de PHP packages:
    ```bash
    composer install
    ```
3.  Installeer de Node packages:
    ```bash
    npm install
    ```
4.  Kopieer het `.env.example` bestand naar `.env` en vul je database en Stripe gegevens in:
    ```bash
    cp .env.example .env
    ```
5.  Genereer een app key:
    ```bash
    php artisan key:generate
    ```
6.  Migreer en seed de database met dummy data:
    ```bash
    php artisan migrate:fresh --seed
    ```
7.  Start de applicatie:
    ```bash
    # Terminal 1: Start de vite server (voor CSS/JS compilatie)
    npm run dev

    # Terminal 2: Start de Laravel server
    php artisan serve
    ```
8.  Ga naar `http://127.0.0.1:8000` in je browser.

## 🔐 Inloggegevens voor de Jury

Na het runnen van de seeders (`php artisan migrate:fresh --seed`) kun je inloggen met de volgende accounts om de frontend of de backend te testen:

**Admin Paneel (Backend):**
*   **E-mail:** admin@anime.shop
*   **Wachtwoord:** password

**Test Klant (Frontend winkelwagen en bestellingen):**
*   **E-mail:** klant@anime.shop
*   **Wachtwoord:** password

---
*Gemaakt met toewijding, focus op detail, en een passie voor code.*
