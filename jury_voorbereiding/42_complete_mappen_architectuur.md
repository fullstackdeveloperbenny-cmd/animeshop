# De Complete Mappenstructuur: Waar vind je wat?

Als de jury vraagt: *"Laat me eens zien waar je de e-mails beheert?"* of *"Waar staan je beveiligingsregels?"*, dan moet je direct naar de juiste map in VS Code kunnen klikken.

Hier is de **volledige directory boom** van jouw applicatie. Ik heb het opgemaakt alsof je in de Verkenner van VS Code kijkt.

---

## 📁 `app/` (De Motor van je applicatie)
Dit is de belangrijkste map. Hierin zit 90% van jouw eigen, op maat gemaakte PHP code (de Backend).

- 📂 **`Actions/`**
  - *Waar:* `app/Actions/`
  - *Wat:* Zware, eenmalige processen (zoals `ProcessCheckoutAction`). We gebruiken dit om de Controllers dun ('Thin') te houden.
- 📂 **`Http/Controllers/`**
  - *Waar:* `app/Http/Controllers/`
  - *Wat:* De Verkeersregelaars. Ze ontvangen de URL en sturen data naar de Views. Hierin staan je `ShopController` en `CheckoutController`.
  - 📂 **`Admin/`**: De Resource Controllers voor je backend.
  - 📂 **`Auth/`**: Alle Controllers voor inloggen, registreren en wachtwoorden (ingebouwd door Laravel Breeze).
- 📂 **`Http/Middleware/`**
  - *Waar:* `app/Http/Middleware/`
  - *Wat:* De 'Voordeur Uitsmijters'. Bijvoorbeeld `EnsureUserIsAdmin`. Ze blokkeren routes voordat de Controller ooit wordt bereikt.
- 📂 **`Http/Requests/`**
  - *Waar:* `app/Http/Requests/`
  - *Wat:* De Formulier-Bewakers. Bestanden zoals `CheckoutProcessRequest`. Hierin staan al jouw strenge Form Validatie regels (zoals `'email' => 'required|email'`).
- 📂 **`Mail/`**
  - *Waar:* `app/Mail/`
  - *Wat:* De Postbode classes. Bijvoorbeeld een `OrderConfirmationMail`. Hierin vertel je Laravel wélke data (zoals de order-info) er naar de klant gemaild moet worden.
- 📂 **`Models/`**
  - *Waar:* `app/Models/`
  - *Wat:* Het Eloquent ORM. Blauwdrukken van je database (zoals `Product` en `User`). Hier schrijf je de relaties (`BelongsTo`) en beveiliging (`$fillable`).
- 📂 **`Policies/`**
  - *Waar:* `app/Policies/`
  - *Wat:* De 'Kluis-Bewakers'. Specifieke beveiliging diep in het systeem (zoals `CategoryPolicy`). Je checkt hiermee via `Gate::authorize()` of een Admin wel een specifieke actie mag uitvoeren.
- 📂 **`Providers/`**
  - *Waar:* `app/Providers/`
  - *Wat:* De opstart-scripts van Laravel. Hierin staat bijv. `AppServiceProvider`. Dit wordt als állereerste geladen als de applicatie opstart. Soms gebruik je dit om bepaalde instellingen of Gates te forceren.
- 📂 **`Services/`**
  - *Waar:* `app/Services/`
  - *Wat:* Complexe rekenmachines, zoals je `CartService`. Herbruikbare logica zodat je niet 10 keer dezelfde code (DRY principe) in je Controllers moet typen.
- 📂 **`View/Components/`**
  - *Waar:* `app/View/Components/`
  - *Wat:* De PHP-logica voor je HTML-blokken. Als je in Blade `<x-admin-layout>` typt, koppelt Laravel dat soms aan een PHP-bestand in deze map om dynamische data aan die layout te voeren.

---

## 📁 `config/` (De Instellingen)
- *Waar:* `config/`
- *Wat:* Hier staan bestanden zoals `app.php` en `database.php`. Eigenlijk pas je hier zelden iets aan, omdat de meeste instellingen uit je geheime `.env` bestand worden gehaald.

---

## 📁 `database/` (De Data Architectuur)
- 📂 **`factories/`**
  - *Wat:* De fabrieks-mallen. Hier schrijf je hoe een "nep" product eruit ziet (bijv. genereer een nep naam en nep prijs).
- 📂 **`migrations/`**
  - *Wat:* Versiebeheer voor je database. Met `php artisan migrate` creëren deze bestanden de daadwerkelijke tabellen en kolommen in MySQL.
- 📂 **`seeders/`**
  - *Wat:* De invullers. Zij gebruiken de Factories om je database met 1 druk op de knop vol te storten met honderden test-producten.

---

## 📁 `public/` (De Voordeur)
- *Waar:* `public/`
- *Wat:* Dit is de échte 'website' map voor de server. Hierin staat de uiteindelijke `index.php`. Al jouw afbeeldingen en gegenereerde CSS/JS bestanden belanden uiteindelijk hier zodat Google Chrome ze kan lezen. Geheime code mag hier nóóit staan.

---

## 📁 `resources/` (De Frontend)
Dit is wat de bezoeker uiteindelijk ziet en ervaart.

- 📂 **`css/` & `js/`**
  - *Wat:* Jouw Tailwind CSS instellingen en je ruwe Javascript (zoals je AJAX Live Search logica in `app.js`). Vite (je compiler) pakt deze bestanden en perst ze samen voor de `public` map.
- 📂 **`views/`**
  - *Wat:* Al jouw `.blade.php` bestanden (HTML).
  - *Hierin vind je submappen zoals:*
    - `auth/` (Login schermen)
    - `shop/` (Je webshop schermen)
    - `admin/` (Je beheerpaneel)
    - `components/` (Herbruikbare HTML blokjes zoals `<x-input>`)

---

## 📁 `routes/` (De Verkeersborden)
- *Waar:* `routes/web.php` & `routes/auth.php`
- *Wat:* Hier koppel je URL's (zoals `/shop` of `/login`) aan de bijbehorende Controllers. Dit is de brug tussen de URL balk in de browser en jouw PHP code.

---

## 📁 `storage/` (Het Archief)
- *Waar:* `storage/app/public/`
- *Wat:* Als een Admin een afbeelding van een nieuw product uploadt, komt dat bestand hier terecht. Omdat de map `storage` in principe verborgen is voor bezoekers, maken we een 'symlink' (`php artisan storage:link`) om de afbeeldingen toch veilig zichtbaar te maken op de website. In deze map worden ook je fout-logboeken (logs) en sessies bewaard.

---

## Samenvatting van de "Data Flow" (Hoe de mappen praten)
1. Gebruiker typt URL in ➡️ **`routes/`** vangt het op.
2. Route checkt bij **`Http/Middleware/`** of je wel binnen mag.
3. Route stuurt je door naar de **`Http/Controllers/`**.
4. Controller vraagt eventueel een **`Policies/`** om extra actie-toestemming.
5. Controller haalt data uit MySQL via het **`Models/`**.
6. Als er rekenwerk is, zet de Controller de **`Actions/`** of **`Services/`** aan het werk.
7. De Controller stuurt de verwerkte data naar de **`resources/views/`** (Blade).
8. De View toont de HTML aan de bezoeker.
