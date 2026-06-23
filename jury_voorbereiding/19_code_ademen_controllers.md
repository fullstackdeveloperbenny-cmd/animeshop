# 19. Code Ademen: Controllers, Services & Actions (Business Logic) ⚙️

Hier ontleden we het "brein" van je applicatie. Hoe stroomt data van de ene plek naar de andere? We gaan letter per letter door de belangrijkste bestanden.

---

## 1. app/Services/CartService.php
Een Service is een helper-bestand. In plaats van in 10 controllers de winkelwagen-code (sessions) over te typen, schrijven we het 1 keer in een Service en gebruiken we het overal. (DRY principe: Don't Repeat Yourself).

```php
public function getCart(): array
```
- **`public`**: Overal vandaan op te roepen.
- **`function getCart()`**: De naam van de actie.
- **`: array`**: Dit is een *Return Type Hint*. Het belooft aan PHP: "Ik zweer je dat de data die uit deze functie komt, een Array (lijstje) is."

```php
return session()->get('cart', []);
```
- **`session()`**: Roept de Laravel Sessie (het tijdelijke geheugen voor de bezoeker) aan.
- **`->get('cart', [])`**: Haal het vakje genaamd 'cart' op. De `[]` op het einde is de 'fallback' of 'default'. Als het vakje 'cart' nog niet bestaat (de klant bezoekt de site voor het eerst), geef dan een lege array `[]` terug zodat de applicatie niet crasht.

```php
public function add(Product $product, int $quantity, ?Variant $variant = null)
```
- **De Parameters:** Dit is de data die we in de functie "gooien" als we hem oproepen.
- **`Product $product`**: Een "Type Hint". We accepteren alleen échte Product-objecten, geen willekeurige strings.
- **`int $quantity`**: Een *integer* (geheel getal, geen kommagetal).
- **`?Variant $variant = null`**: Weer de `?`! Dit betekent: Het kan een Variant object zijn, maar als we het weglaten, wordt het `null` (leeg).

```php
$cart = $this->getCart();
```
- **`$this`**: Kijk in dit bestand.
- **`->getCart()`**: Voer de bovengenoemde functie uit. Variabele `$cart` is nu een actuele lijst met wat er al in het mandje zat.

```php
$cart[$itemKey] = [
    'product_id' => $product->id, ...
```
- **Associative Array:** We bouwen een nieuwe associatieve array op (een array met namen als sleutel, in plaats van nummertjes 0,1,2). We steken alle eigenschappen van het product (ID, prijs, afbeelding) in de cart sessie.

```php
session()->put('cart', $cart);
```
- We slaan de gewijzigde array terug op in het tijdelijke geheugen (`->put()`).

---

## 2. app/Http/Controllers/CheckoutController.php
De Controller is de "Verkeersregelaar". Een route (`web.php`) stuurt het verzoek naar een Controller. De Controller haalt data op en stuurt een webpagina (`view`) terug.

```php
class CheckoutController extends Controller
{
    public function __construct(private CartService $cartService) {}
```
- **Dependency Injection via Constructor Property Promotion**: Dit is de modernste manier van PHP 8 schrijven. In de haakjes `(...)` maken we een private variabele `$cartService` aan én vullen we hem tegelijkertijd met de CartService die Laravel voor ons klaarzet.

```php
    public function process(CheckoutProcessRequest $request, ProcessCheckoutAction $processCheckoutAction)
```
- We roepen de `process` functie op als de klant op "Betalen" klikt.
- **`CheckoutProcessRequest $request`**: Voordat deze code ook maar mag uitvoeren, verplicht Laravel dat de binnenkomende data (zoals `email`, `address`) eerst gevalideerd wordt via ons FormRequest-bestand.
- **`ProcessCheckoutAction $processCheckoutAction`**: We injecteren hier een *Action*. Waarom? Omdat de code om Stripe op te starten 30 regels lang is. Een Controller moet "slank" (thin) blijven. Dus besteden we het zware werk uit aan een externe Action.

```php
    $validated = $request->validated();
```
- **`$validated`**: Dit is een array met alle schone, correct gevalideerde data uit het afreken-formulier (zoals adres en naam). We weten 100% zeker dat er geen foute data (of hack-pogingen) in zit.

```php
    $checkoutUrl = $processCheckoutAction->execute($validated, $cartItems, $total);
```
- We sturen de data, winkelwagen-items en totaalprijs naar de Action.
- De Action praat met de Stripe API (externe server) en retourneert een `$checkoutUrl` (een link zoals `https://checkout.stripe.com/pay/...`).

```php
    return redirect($checkoutUrl);
```
- De "Verkeersregelaar" doet zijn werk: Hij leidt de browser van de bezoeker om (redirect) naar de externe website van Stripe.

---

## 3. app/Http/Controllers/Admin/ProductController.php
Hier zie je veel `CRUD` methodes (Create, Read, Update, Delete).

```php
public function index()
{
    $products = Product::with(['category', 'variants'])->latest()->paginate(10);
    return view('admin.products.index', compact('products'));
}
```
- **`Product::with(['category', 'variants'])`**: Dit heet **Eager Loading**. In de `products` lijst tonen we de categorienaam per product. Als we dit níet doen (`Product::all()`), doet Laravel het zogenaamde "N+1 probleem". Dan zou hij voor élk product apart een nieuwe database-zoekopdracht uitvoeren om de categorie op te halen. Met `with()` laadt hij alle producten + alle categorieën in slechts **2 supersnelle queries**. De jury is dol op dit soort prestatie-optimalisaties!
- **`->latest()`**: Sorteer automatisch van nieuw naar oud (order by created_at desc).
- **`->paginate(10)`**: In plaats van 1000 producten te laden en de server te laten crashen, hakken we het in paginablokjes van 10.
- **`compact('products')`**: Dit is een PHP functie die de variabele `$products` slim inpakt als een sleutel-waarde array `['products' => $products]` en naar het blade bestand (de weergave) stuurt, zodat we daar `@foreach($products as $product)` kunnen gebruiken.

Neem deze documentatie grondig door, oefen het luidop, en je zult de code echt **ademen** tijdens je verdediging!
