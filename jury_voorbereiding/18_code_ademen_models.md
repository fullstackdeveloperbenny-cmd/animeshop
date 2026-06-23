# 18. Code Ademen: De Models (Data Laag) 💾

Hier ontleden we elk Model. Een "Model" is de brug tussen jouw PHP code en een tabel in de MySQL database.

## app/Models/Category.php
```php
class Category extends Model
{
    use SoftDeletes;
```
- **`class Category extends Model`**: Wij definiëren een blauwdruk `Category`. Het woord `extends Model` betekent dat deze class alle superkrachten erft van de standaard Laravel `Model` class (zoals kunnen praten met de database).
- **`use SoftDeletes;`**: Een "Trait". Dit betekent dat we een pakketje code importeren. `SoftDeletes` zorgt ervoor dat als je `->delete()` aanroept op een categorie, deze niet écht uit de database verdwijnt. Er wordt alleen een datum ingevuld in de kolom `deleted_at`. Zo kunnen we hem altijd nog terughalen (een prullenbak functie).

> [!IMPORTANT]
> **Juryvraag:** "Waarom gebruik je de `is_active` checkbox EN `SoftDeletes`? En had je `SoftDeletes` bij categorieën niet gewoon weg kunnen laten?"
> **Jouw antwoord:** "Nee, absoluut niet! Dat zou levensgevaarlijk zijn. In mijn database migratie (`create_products_table`) staat de beveiliging `$table->foreignId('category_id')->constrained()->cascadeOnDelete();`. Dit is een hard commando aan MySQL: *'Als een Categorie gedood wordt, dood dan direct al zijn Producten'*. Als ik `SoftDeletes` weglaat, en een beheerder gooit per ongeluk een categorie weg, wist de database dus in 1 seconde de halve voorraad van mijn webshop definitief! `SoftDeletes` is mijn vangnet: het voorkomt die harde MySQL-verwijdering en beschermt daarmee mijn volledige database-integriteit en ordergeschiedenis. Het is mijn airbag."
```php
    protected $fillable = ['parent_id', 'name', 'slug', 'is_active'];
```
- **`protected $fillable`**: Dit is een array (een lijst met waardes). De variabele is `protected` (het magazijn), dus Laravel kan het lezen, maar een willekeurige bezoeker niet. Het vertelt Laravel: "Je mag veilig de velden 'name' en 'slug' etc. massaal opslaan vanuit een formulier (Mass Assignment)". Alles wat NIET in deze lijst staat, wordt genegeerd als een hacker het probeert mee te sturen.

```php
    protected $casts = [
        'is_active' => 'boolean',
    ];
```
- **`protected $casts`**: Laravel bewaart in MySQL `is_active` als een `0` of een `1` (TINYINT). We zeggen hier tegen Laravel: "Zodra je dit uit de database haalt, vorm (cast) deze 0 of 1 dan automatisch om naar een échte PHP `false` of `true` (boolean)." Dat leest makkelijker in de code.

```php
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
```
- **`public function parent()`**: Dit definieert een database relatie. Het retourneert (geeft terug) een `BelongsTo` object. 
- **`$this`**: Het huidige doosje (dit specifieke object, bijv. categorie 'Truien'). 
- Dit leest als: "Deze categorie (Truien) behoort toe aan (belongsTo) een andere categorie (Kleding), en je kunt de ID daarvan vinden in de kolom `parent_id`".

```php
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
```
- **`public function children()`**: Het tegenovergestelde. "Deze categorie (Kleding) heeft vele (hasMany) kinderen, waarbij de kinderen in hún `parent_id` kolom mijn ID hebben staan."

---

## app/Models/Order.php

```php
class Order extends Model
{
    protected $fillable = [
        'user_id', 'total_amount', 'status', 'stripe_session_id', 
        'first_name', 'last_name', 'email', 'address', 'zipcode', 'city'
    ];
```
- Hier vertellen we Laravel dat we al deze adres- en factuurgegevens in bulk mogen opslaan als we een order aanmaken.

```php
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
```
- Een `Order` is geplaatst door 1 unieke klant. Daarom `belongsTo` (behoort toe aan) een User.

```php
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
```
- Eén `Order` (de factuur) kan meerdere kledingstukken bevatten. Daarom `hasMany` (heeft vele) OrderItems (factuurregels).

---

## app/Models/Variant.php

```php
class Variant extends Model
{
    protected $fillable = ['product_id', 'type', 'value', 'stock', 'price_modifier'];
```
- **`price_modifier`**: Hoeveel extra kost deze variant? (Bijvoorbeeld: XXL kost + €5.00).

```php
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
```
- Een specifieke variant (bijv. Maat S) hoort altijd bij exact één Product (bijv. het Akatsuki T-shirt).

## Conclusie over Models
Als de jury vraagt hoe Laravel weet in welke tabel hij moet zoeken:
"Laravel gebruikt **Conventies** (afspraken). Als mijn Model class `Category` heet (enkelvoud en met hoofdletter), weet Laravel automatisch dat hij in de MySQL database moet zoeken naar een tabel genaamd `categories` (meervoud, kleine letters). Als ik dat zou willen veranderen, zou ik `protected $table = 'andere_naam';` moeten toevoegen."
