# Wat gebeurt er als je een Hoofdcategorie verwijdert? 🗑️

Dit is een fantastische technische vraag van de jury: *"Stel je verwijdert de categorie 'Kleding'. Wat gebeurt er dan met de subcategorieën zoals 'Truien', en wat gebeurt er met de producten die in die categorieën zitten?"*

Omdat je SoftDeletes (een prullenbak) gebruikt in plaats van bestanden hard te wissen, moesten we hier heel slim over nadenken. Hier is jouw waterdichte antwoord:

---

## 1. Subcategorieën gaan automatisch mee de prullenbak in
Als jij op 'Verwijderen' klikt bij de hoofdcategorie 'Kleding', roept Laravel stiekem een **Model Event** aan.

Kijk maar in je `app/Models/Category.php` rond regel 67. Daar staat de `booted()` functie:
```php
static::deleting(function (Category $category) {
    foreach ($category->children as $child) {
        $child->delete(); // Zet ook de subcategorie in de prullenbak
    }
});
```
**Jury Uitleg:** *"Ik heb een `deleting` Event Listener gebouwd in mijn Category Model. Zodra Laravel voelt dat een categorie naar de prullenbak gaat, pauzeert hij even, zoekt hij alle onderliggende subcategorieën op, en gooit die netjes één voor één erachteraan de prullenbak in. Dit heet een **Cascading Soft Delete**."*

---

## 2. Maar wat gebeurt er dan met de Producten?
Nu komt de échte truc! Je producten (bijvoorbeeld een specifieke Naruto Trui) worden **NIET** verwijderd. Ze blijven gewoon veilig in je database staan.

**Vraag van de jury:** *"Maar als ze niet verwijderd worden, zien klanten dan geen onzichtbare of kapotte categorieën op je webshop?"*

**Jouw antwoord:** *"Nee, want ik bescherm mijn webshop in de `ShopController`."*

Kijk maar naar regel 24 in je `ShopController.php`:
```php
$query = Product::active()->whereHas('category')...
```

**Jury Uitleg (De Geniale Truc):** 
*"Omdat de categorie nu in de prullenbak (SoftDeleted) zit, beschouwt de database hem als 'dood'. Mijn `ShopController` gebruikt de functie `whereHas('category')`. Dit is een hele slimme functie van Laravel: hij haalt alleen producten op waarvan de gekoppelde categorie nog écht leeft. 
Zodra de categorie (of subcategorie) in de prullenbak belandt, verbergt de webshop automatisch alle producten die daarin zitten, zonder dat ik de producten zelf heb moeten weggooien! Als ik de categorie later herstel, poppen de producten vanzelf weer op in de winkel."*

### Samenvatting voor de jury:
1. Verwijder je een Hoofdcategorie? Dan triggeren **Model Events** het soft-deleten van de subcategorieën.
2. Producten worden niet gedeletet, maar verdwijnen wel automatisch uit de winkel dankzij de **`whereHas`** relatie-filter in de controller.
