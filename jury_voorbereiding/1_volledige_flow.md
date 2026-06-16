# De Volledige Applicatie Flow

Als de jury vraagt: *"Leid ons eens door het project, hoe werkt het?"*, dan is dit je gids. Vertel het als een verhaal.

## 1. De Routes (Waar komt het verzoek binnen?)
Alles begint in `routes/web.php`.
- **Publieke Routes:** Iedereen mag de shop zien (`/`, `/product/{slug}`). Deze hangen aan de `ShopController`.
- **Klant Routes (Auth):** Om iets in het winkelmandje te stoppen of af te rekenen (`/cart`, `/checkout`), moet de middleware `auth` passeren. Hierachter zitten de `CartController` en `CheckoutController`.
- **Admin Routes:** Alles onder `/admin` wordt extra afgeschermd door een eigen middleware (`EnsureUserIsAdmin`). Deze checkt of `role === UserRole::ADMIN`. De beheerder gebruikt hier `Resource Controllers` (zoals `CategoryController` en `ProductController`) voor CRUD operaties.

## 2. Het MVC Patroon
Laravel volgt het **M**odel **V**iew **C**ontroller patroon.
- **Model:** Dit is de spreekbuis naar de database (bijv. `Product.php`). Als we data nodig hebben roept de controller het model aan (`Product::with('images')->get()`).
- **View:** Dit is de HTML/Blade (bijv. `shop.index`). De controller geeft de data door aan de view, en de view toont het (via `{{ $product->name }}`).
- **Controller:** De dirigent. Neemt het verzoek (Request) in ontvangst, haalt data uit het Model, en stuurt het naar de View.

## 3. De Winkelwagen Flow
1. Een klant klikt op "Toevoegen aan winkelwagen". Dit gaat via een `POST` request naar `CartController@add`.
2. De `CartAddRequest` controleert streng of de maat en het aantal kloppen (Validatie).
3. We gebruiken geen database voor de winkelwagen, maar **Sessies** (`session()->put()`). *Waarom? Omdat we de database niet willen vervuilen met mandjes van mensen die de site na 1 minuut weer sluiten.*
4. De winkelwagen inhoud wordt beheerd door de `CartService.php`, zodat deze logica netjes gecentraliseerd is.

## 4. De Checkout Flow (Cruciaal voor de jury!)
1. De klant gaat naar afrekenen (`CheckoutController@process`).
2. De invoer (adres, etc.) wordt gecheckt door de `CheckoutProcessRequest`.
3. Vervolgens sturen we alles door naar de **`ProcessCheckoutAction`**.
4. In deze Action gebruiken we een **Database Transaction** (`DB::transaction`). *Waarom? Als de server crasht halverwege het opslaan van de 5 order-items, annuleert Laravel alles. Zo hebben we nooit halve bestellingen.*
5. Het `Order` en de `OrderItems` worden in de database gezet met status `pending`.
6. Daarna genereren we een **Stripe Session**. We vertellen Stripe precies welke producten (inclusief varianten) de klant koopt en sturen de klant naar de Stripe website.
7. Als de klant betaalt, keert hij terug naar de `success_url` (`CheckoutController@success`). Daar wordt de status naar `paid` gezet, de winkelwagen leeggemaakt en de bestellings-email verstuurd!
