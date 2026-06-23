# De Volledige Code Flows (Stap-voor-Stap Spoorzoeken) 🕵️‍♂️

Dit document is je ultieme spiekbriefje om **nooit meer de weg kwijt te raken** in je eigen code. Als de jury vraagt: *"Laat eens zien hoe X werkt"*, of *"Waar zou je Y toevoegen?"*, dan volg je simpelweg deze stappen.

Elke flow in Laravel (en in jouw project) volgt bijna altijd dit vaste pad:
**Route ➡️ Controller ➡️ Validation (Request) ➡️ Action/Service ➡️ Model (Database) ➡️ Controller ➡️ View (HTML)**

Hier zijn de 4 belangrijkste flows in jouw applicatie van A tot Z uitgelegd.

---

## Flow 1: De Shop Tonen (Data Ophalen & "Eager Loading")
*Scenario: Een klant gaat naar de homepage om alle producten te zien.*

1. **De Route (`routes/web.php`):**
   - De klant typt `127.0.0.1:8000/`.
   - In `web.php` staat: `Route::get('/', [ShopController::class, 'index'])`.
   - *De route stuurt het verkeer door naar de ShopController.*

2. **De Controller (`app/Http/Controllers/ShopController.php` - functie `index`):**
   - Hier vragen we de data op aan de database met deze code: 
     `$query = Product::where('is_active', true)->whereHas('category')->with(['category', 'primaryImage']);`
   - **Jury uitleg - Wat is `with`?** *"De `with()` functie heet 'Eager Loading'. Dit voorkomt het N+1 probleem. In plaats van dat Laravel straks in het HTML bestand voor elk product apart de database moet raadplegen voor de foto en de categorie, laadt hij ze hier in één ademteug efficiënt in het geheugen."*
   - Daarna stuurt de controller de data naar de HTML met: `return view('shop.index', compact('products'))`.

3. **De View (`resources/views/shop/index.blade.php`):**
   - Hier gebruiken we een `@foreach($products as $product)` loopje.
   - De data komt direct uit de Controller. We tonen de data via `{{ $product->name }}`.

**🔧 Hoe voeg je hier iets toe? (Bv. een korte beschrijving)**
1. Maak een migratie aan om de kolom `short_description` aan de `products` tabel in MySQL toe te voegen.
2. Ga naar de view `shop/index.blade.php` en voeg `{{ $product->short_description }}` toe onder de titel. Klaar! (Omdat we Eloquent gebruiken, haalt het Model automatisch alle kolommen op).

---

## Flow 2: In Winkelwagen Stoppen (Data Verzenden & Valideren)
*Scenario: Een klant klikt op "In Winkelmandje" op een productpagina.*

1. **De View (`resources/views/shop/show.blade.php`):**
   - De HTML bevat een formulier: `<form action="{{ route('cart.add', $product->id) }}" method="POST">`.
   - Er zit een verborgen `@csrf` veld in voor veiligheid.

2. **De Route (`routes/web.php`):**
   - De URL `/cart/add/{product}` verwijst naar de `CartController@add`.

3. **De Validatie (`app/Http/Requests/Shop/CartAddRequest.php`):**
   - Voordat de Controller überhaupt mag draaien, controleert dit bestand de input!
   - **Jury uitleg:** *"In de `rules()` functie check ik of de meegestuurde `quantity` (hoeveelheid) minimaal 1 is, en of het maximaal 10 is. Ook check ik via `exists:variants,id` of de gekozen maat (S, M, L) niet door een hacker verzonnen is, maar écht in de database bestaat."*

4. **De Controller (`app/Http/Controllers/CartController.php` - functie `add`):**
   - De controller neemt de zojuist goedgekeurde (`$validated`) data aan.
   - Hij roept de Service aan: `$this->cartService->add(...)`.

5. **De Service (`app/Services/CartService.php`):**
   - **Jury uitleg:** *"Ik gebruik hier een Service om de logica te scheiden van de controller. In de service roep ik de database aan (`Product::find`) om de **echte** prijs op te halen (Never Trust The Client!). Daarna sla ik het product op in de Laravel `session()`, zodat het in het winkelmandje van deze specifieke klant blijft zitten zonder mijn database te vervuilen."*

**🔧 Hoe voeg je hier iets toe? (Bv. een Cadeauverpakking Vinkje)**
1. Voeg een checkbox toe in de HTML `show.blade.php`.
2. Voeg het veld `gift_wrap` toe in de `rules()` van `CartAddRequest`.
3. Geef het mee in de parameters in `CartController` en sla het op in de array in `CartService`.

---

## Flow 3: Checkout (Complexe Logica & Database Transacties)
*Scenario: De klant rekent af en gaat naar Stripe.*

1. **De View & Route:**
   - `<form action="/checkout/process">` gaat via `web.php` naar `CheckoutController@process`.

2. **De Controller & Validatie:**
   - `CheckoutProcessRequest` controleert of het ingevulde adres en de postcode kloppen.
   - De `CheckoutController` roept de `ProcessCheckoutAction` aan.

3. **De Action (`app/Actions/Orders/ProcessCheckoutAction.php`):**
   - **Jury uitleg:** *"Hier gebeurt het zware werk. Ik open een `DB::transaction()`. Dit betekent: Alles of Niets. Eerst maak ik de hoofd-Order aan, daarna loop ik door het winkelmandje en maak ik de `OrderItems` aan. Als de database halverwege crasht, annuleert de transactie álles. Pas als de transactie succesvol sluit, stuur ik de prijs door naar de Stripe API."*

---

## Flow 4: Backend (Product Aanmaken & UX)
*Scenario: Jij als Admin voegt een nieuwe Manga toe via het CMS.*

1. **De Route (`web.php`):**
   - In je admin-groep staat `Route::resource('products', ProductController::class)`.
   - Een POST request naar een resource-route gaat altijd naar de `store()` functie.

2. **De Validatie (`app/Http/Requests/Admin/StoreProductRequest.php`):**
   - Een gigantisch bestand dat checkt of de afbeelding wel echt een PNG of JPG is, en of de prijs wel numeriek is.

3. **De Controller (`ProductController@store`):**
   - Geeft de goedgekeurde data door aan `CreateProductAction`.

4. **De Action (`app/Actions/Products/CreateProductAction.php`):**
   - **Jury uitleg:** *"In deze Action creëer ik eerst het basisproduct. Daarna gebruik ik mijn `ProductImageService` om de geüploade bestanden naar de `/storage` map op de hardeschijf te kopiëren en hun paden op te slaan in `product_images`. Als laatste verwerk ik de varianten. Mijn slimmigheidje: als een beheerder bij een Poster 'Standaard Voorraad: 50' invult en de maten leeglaat, maakt de code onder water zelf een onzichtbare 'One Size' variant aan. Zo klopt de database altijd!"*

**🔧 Hoe voeg je hier iets toe? (Bv. een 'Merk' toevoegen aan een product)**
1. Maak een database kolom `brand` aan via een migratie.
2. Voeg een input veld `<input name="brand">` toe in `admin/products/create.blade.php`.
3. Voeg `'brand' => 'required|string'` toe aan de `StoreProductRequest`.
4. Zorg dat hij wordt meegenomen in de `Product::create()` array in je `CreateProductAction`.
