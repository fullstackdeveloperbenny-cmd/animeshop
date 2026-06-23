# Wat zijn "Scopes" in Laravel? 🔭

Een "Scope" is een techniek in Laravel om je code veel schoner en herbruikbaarder te maken. Het valt onder de categorie **Advanced Eloquent** en laat perfect zien dat je het DRY (Don't Repeat Yourself) principe snapt.

---

## 1. Het Probleem
Stel, je wilt in je webshop alleen de producten tonen die "actief" zijn (het vinkje in de backend staat aan). 

Zonder Scope schrijf je in je `ShopController` dit:
`Product::where('is_active', true)->get();`

Maar stel dat je die actieve producten óók nodig hebt op de homepagina (voor uitgelichte producten), en óók bij gerelateerde producten (upselling)... Dan typ je overal in je hele project datzelfde regeltje. 
Als je baas later zegt: *"Actieve producten moeten nu óók nog eens op voorraad zijn"*, dan moet je dat in 10 verschillende bestanden gaan opzoeken en aanpassen. Dit is foutgevoelig!

---

## 2. De Oplossing (De Scope)
Een Scope is een herbruikbare "filter" die je **één keer** in je Model (`app/Models/Product.php`) definieert. Je maakt daar een functie die verplicht begint met het woord `scope`:

```php
// In je Product.php Model
public function scopeActive($query)
{
    return $query->where('is_active', true);
}
```

Als je dat gedaan hebt, hoef je in ál je controllers alleen nog maar het korte woordje te typen:
`Product::active()->get();`

Als de regel voor "actief" in de toekomst ooit verandert, hoef je het nu maar op **1 plek** aan te passen: in het Model!

---

## 3. Waar zit dit exact in jouw project?

Ik heb dit zojuist letterlijk in je project gebouwd zodat je het aan de jury kunt laten zien!

1. Open het bestand **`app/Models/Product.php`**. 
   - Helemaal onderaan (rond regel 47) zie je de functie `public function scopeActive($query)`. Dit is de logica.
2. Open nu je **`app/Http/Controllers/ShopController.php`**.
   - Kijk op regel 23 (de index functie): daar zie je nu prachtig schoon `$query = Product::active()` staan.
   - Kijk op regel 87 (de show functie voor gerelateerde producten): daar zie je het opnieuw: `$relatedProducts = Product::active()`.

Als de jury hiernaar vraagt, antwoord je: 
*"Een Scope is een gecentraliseerde query-filter in het Model. Ik heb een `scopeActive` gemaakt in mijn Product-model. Hierdoor hoef ik niet overal in mijn Controllers hardcoded 'where is_active = true' te typen. Ik roep gewoon `Product::active()` aan. Dit houdt mijn Controllers schoon en volgt het DRY principe."*
