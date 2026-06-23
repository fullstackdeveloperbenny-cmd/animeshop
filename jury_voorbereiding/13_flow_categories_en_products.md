# De Volledige Flow: Categorieën, Producten en de Database

Dit is de "ruggengraat" van je winkel (de Admin-kant). Hoe krijgen we een product met een foto, een maat (Variant) én een categorie veilig in de database?

## Stap 1: De Route en de Middleware
In `web.php` staat:
```php
Route::middleware(['auth', EnsureUserIsAdmin::class])->group(function () {
    Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
});
```
De admin navigeert naar `/admin/products/create`. 
Laravel checkt eerst: "Ben je ingelogd?" (`auth`). Daarna: "Ben je een admin?" (`EnsureUserIsAdmin`). Pas daarna laadt hij het formulier (`ProductController@create`).

## Stap 2: Het Opslaan in de Controller (De "Store" methode)
De admin vult alles in en klikt op "Opslaan". Het verzoek (POST) komt in `ProductController@store`.

**De Controller doet NIET de database acties!** Weet je nog, we houden Controllers 'Thin'.
De Controller doet enkel dit:
1. Controleer het formulier via `ProductRequest`.
2. Roep het "werkpaard" aan: `app(CreateProductAction::class)->execute(...)`
3. Stuur de admin terug naar het overzicht met een groen "Product succesvol aangemaakt" flash-bericht.

## Stap 3: De `CreateProductAction` (Het magische werkpaard)
*(Zorg dat je dit bestand begrijpt, dit toont aan dat je een sterke developer bent!)*
In de map `app/Actions/Products/CreateProductAction.php` gebeurt alle magie:

1. **DB Transaction:** 
   We gebruiken `DB::transaction()`. Waarom? Omdat we een product, een foto én een variant gaan opslaan. Dat zijn 3 losse database query's. Als het product wordt opgeslagen, maar daarna crasht de server bij de foto, hebben we een spook-product. Door een transactie te gebruiken, zegt Laravel: *"Pas als ALLE drie de acties 100% gelukt zijn, mag je ze écht in de database cementeren."*

2. **Opslaan in Tabellen:**
   - Eerst wordt het basisproduct opgeslagen: `Product::create(['name' => $data['name'], ...])`. 
   - Laravel geeft ons nu direct het nieuwe ID (bijv ID 12) terug.

3. **De Foto Uploaden:**
   Als de admin een foto heeft geselecteerd:
   - De server neemt het `.jpg` of `.png` bestand.
   - Omdat foto's te groot kunnen zijn (en je webshop vertragen), gebruiken we de **Intervention Image** package.
   - De Action snijdt/verkleint de foto (Resize) en converteert hem naar WebP (een super modern, lichtgewicht bestandsformaat van Google).
   - De foto wordt op de harde schijf gezet (`storage/app/public/products`).
   - Daarna slaat de Action het adres op in de tabel `product_images`: `['product_id' => 12, 'path' => 'products/naam.webp']`.

4. **De Varianten Opslaan:**
   Als het een T-shirt is met maat S, M, L:
   - De Action loopt over alle ingevoerde varianten (`foreach`).
   - Hij slaat ze op in de `variants` tabel: `['product_id' => 12, 'type' => 'maat', 'value' => 'S', 'stock' => 10]`.

## De Relaties in de Database (Models)
Hoe weten al die tabellen dat ze bij elkaar horen? Dat doen we via **Eloquent Relaties** in de mappen `app/Models/`.

- **In `Product.php`:**
  ```php
  public function category() { return $this->belongsTo(Category::class); }
  public function variants() { return $this->hasMany(Variant::class); }
  ```
  Dit is puur Engels: *"A product belongs to a category. A product has many variants."*

- **Wat als een admin een Product weggooit?**
  In de Migrations (de bestanden die de database tabellen aanmaken), hebben we aan het ID de regel `->cascadeOnDelete()` toegevoegd.
  Als de admin in het dashboard op het rode vuilnisbakje klikt, wordt Product 12 gewist. MySQL (de database) is slim genoeg om dan automatisch óók álle foto's en varianten met `product_id = 12` permanent te wissen. Zo houd je de database extreem schoon!
