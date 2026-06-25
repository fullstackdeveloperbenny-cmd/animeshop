# De Mappenstructuur: Jouw Laravel Architectuur

Als de jury vraagt: *"Waarom staat deze code in dít bestand en niet ergens anders?"*, dan testen ze of jij de mappenstructuur snapt. Hier is de exacte uitleg van de belangrijkste mappen in jouw project, wat erin zit, en hoe ze met elkaar praten.

---

## 1. `routes/` (Het Verkeersboekje)
- **Wat zit er in:** Je `web.php` bestand.
- **Waarom hebben we dit:** Dit is de ingang van je website. Zonder route weet de browser niet wat er moet gebeuren als de bezoeker `/shop` intypt.
- **De Link:** De route is de wegwijzer. Zodra een bezoeker een URL intypt, stuurt de Route hem direct door naar een **Controller**.

## 2. `app/Http/Controllers/` (De Verkeersregelaars)
- **Wat zit er in:** Bestanden zoals `ShopController.php` en `CheckoutController.php`.
- **Waarom hebben we dit:** Een controller is de 'spin in het web'. De controller doet geen zwaar rekenwerk, maar regelt het verkeer (Separation of Concerns).
- **De Link:** De Controller haalt de benodigde data uit de **Models**, besteedt zwaar rekenwerk uit aan **Services** of **Actions**, en stuurt de opgehaalde informatie vervolgens door naar de **Views**.

## 3. `app/Models/` (De Database Objecten)
- **Wat zit er in:** Bestanden zoals `Product.php` en `Category.php`.
- **Waarom hebben we dit:** Dit is het Eloquent ORM. Een Model is de blauwdruk van een databasetabel. Hierin stel je de beveiliging in (`$fillable` tegen Mass Assignment), en bouw je relaties op (zoals de `BelongsTo` tussen een product en een categorie).
- **De Link:** Models worden aangeroepen door Controllers of Services om veilig data uit de database op te halen zonder ruwe SQL te hoeven schrijven (voorkomt SQL Injection).

## 4. `app/Services/` (De Rekenmachines)
- **Wat zit er in:** `CartService.php`.
- **Waarom hebben we dit:** Om de Controller dun ('Thin Controller') te houden. Als je ergens complexe, *herbruikbare* logica hebt (zoals winkelmand-totalen berekenen en sessies uitlezen), stop je dat in een Service.
- **De Link:** De Controller gebruikt Dependency Injection om de Service te vragen: *"Hey, bereken dit even voor mij en geef het totaalbedrag terug."*

## 5. `app/Actions/` (De Zware Werkpaarden)
- **Wat zit er in:** `ProcessCheckoutAction.php` of `CalculateDiscountAction.php`.
- **Waarom hebben we dit:** Voor zware, *eenmalige* handelingen. De afrekening (Stripe aanroepen, transacties starten, database updaten) is gigantisch. Om te voorkomen dat de Controller 100 regels lang wordt, steken we dat proces in één overzichtelijke Actie-class.
- **De Link:** Net als een Service, wordt de Action aangeroepen door de Controller om de "vuile handen" te maken.

## 6. `resources/views/` (De Schermen)
- **Wat zit er in:** Je `.blade.php` bestanden (De HTML & Tailwind).
- **Waarom hebben we dit:** Dit is de Frontend. Dit is wat de eindgebruiker ziet in Google Chrome. Hier gebruiken we Blade logica zoals `{{ $product->name }}` om veilige tekst te tonen (escaped, tegen XSS hacks).
- **De Link:** Dit is het eindstation. De Controller stuurt de data (zoals een lijst producten) op, en de View bouwt het scherm op om te tonen aan de bezoeker.

## 7. `database/migrations/` en `database/seeders/`
- **Wat zit er in:** PHP scripts om je database in te richten (zoals `create_products_table.php`).
- **Waarom hebben we dit:** Het is versiebeheer voor je database. Als jij jouw code aan je leraar geeft, hoeft hij niet zelf tabellen in phpMyAdmin te tekenen. Hij typt `php artisan migrate --seed` en Laravel genereert direct alle juiste kolommen en vult deze met dummy-data (gegenereerd door Factories) uit je Seeders.

## 8. `app/Http/Middleware/` & `app/Policies/` (De Beveiliging)
- **Middleware (De Uitsmijter):** Staat helemaal vooraan bij de Route. Blokkeert bezoekers direct als ze niet ingelogd zijn of geen Admin rol hebben (bijv. `EnsureUserIsAdmin`).
- **Policies (De Kluis-Bewaker):** Diepe beveiliging in je applicatie. De Policy checkt via `Gate::authorize()` óf een gebruiker een *specifieke actie* mag doen op een *specifiek item* (bijv. 'Mag Admin A wel Categorie B verwijderen?').

---

## Samenvatting van de "Data Flow" (Hoe de mappen praten)

1. Gebruiker klikt op knop ➡️ **Route** vangt het op.
2. Route checkt bij de **Middleware** of je wel binnen mag.
3. Route stuurt je door naar de **Controller**.
4. Controller vraagt eventueel een **Policy/Gate** om extra toestemming.
5. Controller haalt data uit de Database via het **Model**.
6. Als er zwaar rekenwerk is, zet de Controller de **Action** of **Service** in om dit te verwerken.
7. De Controller stuurt de verwerkte data naar de **View** (Blade).
8. De View toont de prachtige HTML in de browser van de bezoeker.
