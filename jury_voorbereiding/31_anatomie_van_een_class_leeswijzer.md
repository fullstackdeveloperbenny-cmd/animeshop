# De Anatomie van een Class (Hoe lees je code?) 🔬

Als je naar een muur van code kijkt, kan dat overweldigend zijn. Maar code is eigenlijk net een kookrecept. Sommige woorden zijn **verplicht** (zoals 'oven' of 'graden'), en andere woorden mag je **zelf verzinnen** (zoals de naam van je taart).

We nemen jouw `CartService.php` als perfect voorbeeld om dit te fileren.

---

## 1. De Bovenkant: Het Adres en de Gereedschappen

```php
namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Session;
```
- **`namespace` (VERPLICHT):** Dit is het adres van je bestand. Omdat dit bestand in de map `app/Services` staat, móét dit exact kloppen. Laravel gebruikt dit om het bestand te vinden.
- **`use` (VERPLICHT):** Dit is je gereedschapskist. Je zegt hier tegen PHP: *"Let op, als ik straks het woord 'Product' typ, bedoel ik het bestand `App\Models\Product`. En als ik 'Session' typ, bedoel ik die handige kluis van Laravel."*

---

## 2. De Class en de Variabelen

```php
class CartService
{
    private string $sessionKey = 'shopping_cart';
```
- **`class CartService` (VERPLICHT):** De naam van de class moet altijd 100% identiek zijn aan de naam van je bestand (`CartService.php`).
- **`private` (VERPLICHT CONCEPT):** Dit is *Encapsulation* (Inkapseling). Je zegt hiermee: "Deze variabele is privé. Geen enkel ander bestand mag dit lezen of aanpassen, alleen deze class zelf."
- **`string` (VERPLICHT CONCEPT):** Dit heet Typehinting. We dwingen af dat hier alleen tekst in mag, geen getallen.
- **`$sessionKey` (ZELF VERZONNEN):** Dit is een variabele. We hadden dit ook `$mijn_geheime_sleutel` of `$taart_naam` mogen noemen. Het is gewoon een doosje waar we een sticker op plakken.
- **`'shopping_cart'` (ZELF VERZONNEN):** Dit is de inhoud van het doosje. We hadden ook `'winkelmandje_van_benny'` kunnen typen.

---

## 3. Wat is een Sessie (`Session`) eigenlijk?

Voor we naar de functies kijken: wat is een Sessie? 
*Uitleg:* PHP heeft geen langetermijngeheugen. Elke keer als jij op een link klikt, "vergeet" de server wie je bent. Om toch een winkelmandje bij te kunnen houden, trekt Laravel voor elke bezoeker een soort 'kluisje' open op de server. De sleutel van dat kluisje zit in een koekje (Cookie) in de browser van de klant. 
Via `Session::get()` pakken we data uit de kluis, en via `Session::put()` leggen we er iets nieuws in. Omdat we de naam `'shopping_cart'` hebben gekozen (zie hierboven), is dat de naam van het mapje in die kluis.

---

## 4. Een Functie (Method) Uitgelegd

```php
public function add(Product $product, ?int $variantId, int $quantity = 1): void
{
    $cart = $this->getCart();
```
- **`public` (VERPLICHT CONCEPT):** Deze functie is wél toegankelijk voor andere bestanden (zoals je CartController). De deuren staan open!
- **`function add` (ZELF VERZONNEN):** We noemen de actie 'add'. We hadden het ook `voegToeAanMandje` mogen noemen, zolang we in de controller dan ook maar `$this->cartService->voegToeAanMandje()` hadden getypt.
- **`Product $product` (VERPLICHT & VERZONNEN):** Hier eisen we dat er data binnenkomt. `Product` eist dat het een echt Laravel Model is. `$product` is de naam die wij eraan geven om er in deze functie mee te werken.
- **`: void` (VERPLICHT CONCEPT):** Dit betekent dat deze functie géén antwoord hoeft terug te sturen met een `return`. Hij voert gewoon acties uit en stopt dan.
- **`$this->getCart()` (SYNTAX):** Omdat `getCart()` een functie is *in dit eigen bestand*, moet je `$this->` typen. Vertaald: *"Voer de functie getCart uit die in Mijzelf staat"*. De output stoppen we in de zelf verzonnen variabele `$cart`.

---

## 5. Werken met Objecten vs Arrays

Verderop in de code zie je dit:
```php
$itemKey = $product->id;
```
- **`->` (Pijltje):** Dit gebruik je als je met een **Object** (zoals een Laravel Model) werkt. Je zegt hier: *"Pak het veldje 'id' uit het Model Product."* Dit haalt hij direct uit de database-eigenschappen.

Daarna zie je dit:
```php
$cart[$itemKey]['quantity'] += $quantity;
```
- **`[ ]` (Vierkante haakjes):** Dit gebruik je als je met een **Array** (een lijstje in PHP geheugen) werkt. Omdat we de winkelwagen hebben opgebouwd als een simpele array (geen Model), vragen we gegevens op met haakjes.
- **`+=`:** Dit is de programmeer-kortere-weg voor: tel het oude getal en het nieuwe getal bij elkaar op. (3 + 1 = 4).

---

## Samenvatting voor de Jury:
Als de jury vraagt: *"Lees deze functie eens voor?"*, dan doe je het zo:
1. "Deze functie heet `add` en is publiek bereikbaar."
2. "Hij vereist 3 stukjes data: Het product model, het variant ID, en de hoeveelheid."
3. "Allereerst trekt hij de huidige winkelwagen uit de Laravel Sessie (het kluisje van de klant)."
4. "Dan haalt hij via het pijltje (`->`) het ID uit het product model."
5. "Hij checkt of het product al in het array lijstje (`[]`) staat. Zo ja, dan telt hij de hoeveelheid op. Zo niet, dan maakt hij een nieuwe regel aan."
6. "Als laatste stopt hij de bewerkte winkelwagen array wéér terug in de Session kluis via `Session::put()`."
