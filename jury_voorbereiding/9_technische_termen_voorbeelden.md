# Technische Termen Uitgelegd mét Praktijkvoorbeelden

*Dit is een verdieping op de begrippenlijst. Als de jury vraagt: "Wat betekent dat en waar zit dat in jouw project?", heb je hier het letterlijke voorbeeld.*

---

## 1. Frontend & Design

### Semantische HTML
**Wat is het?** HTML tags gebruiken die beschrijven wat de inhoud is, niet alleen hoe het eruitziet.
**Voorbeeld in jouw project:** 
Als we de "Winkelwagen" link maken, gebruiken we niet zomaar een leeg blokje: `<div class="link">Winkelwagen</div>`. Dat is fout.
We gebruiken de semantisch correcte navigatie-tags. In je `admin-layout.blade.php` gebruiken we `<nav>` voor het menu en `<a>` voor links. Dit helpt zoekmachines (Google SEO) en software voor blinden om de site te "begrijpen".

### Flexbox vs Grid
**Wat is het?** Twee manieren in CSS om elementen op het scherm te positioneren.
**Voorbeeld in jouw project:**
- **Flexbox (1-dimensionaal):** In je navigatiebalk bovenaan (Header). De knoppen staan allemaal netjes op 1 rij naast elkaar. Daar gebruiken we `flex items-center gap-6`.
- **Grid (2-dimensionaal):** In je winkel (`shop.index`). We willen een raster/grid van producten. Daar gebruiken we `grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3`. We maken letterlijk kolommen en rijen, zoals een schaakbord.

### Responsive Design via Tailwind
**Wat is het?** De website past zichzelf automatisch aan op basis van het schermformaat (GSM, tablet, desktop).
**Voorbeeld in jouw project:**
Kijk naar de CSS code hierboven: `grid-cols-1 lg:grid-cols-3`.
Dit vertelt de browser: "Op een standaard (mobiel) scherm toon je 1 product per rij. Maar, is het scherm 'Large' (`lg:`), toon dan 3 producten naast elkaar." Geen gedoe met ingewikkelde CSS bestanden, gewoon direct in de HTML.

---

## 2. Backend (Laravel Architectuur)

### MVC (Model - View - Controller)
**Wat is het?** De structuur waarin het hele project is gebouwd, verdeeld in 3 logische blokken.
**Voorbeeld in jouw project:** 
Iemand wil de homepagina bekijken.
1. Het verzoek komt binnen. De **Controller** (`ShopController`) neemt het aan.
2. De Controller zegt tegen het **Model** (`Product::class`): *"Hey database, geef mij alle actieve producten."*
3. Het Model geeft de data terug aan de Controller.
4. De Controller stuurt deze data naar de **View** (`resources/views/shop/index.blade.php`).
5. De View genereert de mooie HTML met de foto's en stuurt die naar de bezoeker.

### Eloquent ORM
**Wat is het?** Een systeem van Laravel om met de database te praten alsof het gewone PHP objecten zijn, zonder ingewikkelde SQL te hoeven schrijven.
**Voorbeeld in jouw project:**
Zonder Eloquent (Rauwe SQL - Gevaarlijk voor hackers):
`$results = DB::select("SELECT * FROM products WHERE is_active = 1 AND category_id = 5");`
Met Eloquent (Jouw code - Veilig & netjes):
`$products = Product::where('is_active', true)->where('category_id', 5)->get();`

### Migrations
**Wat is het?** Een soort "Git" of versiebeheer, maar dan voor je database structuur.
**Voorbeeld in jouw project:**
Vroeger ging je naar phpMyAdmin, klikte je op "Nieuwe Tabel" en typte je alles handmatig in. Als je vriend (of de jury) je code dan wilde testen, had hij de database niet.
Nu hebben wij bestanden zoals `2026_06_12_create_products_table.php`. Hierin staat `Schema::create('products', ...)`. 
Als de jury jouw code downloadt en `php artisan migrate` typt, bouwt Laravel automatisch exact dezelfde tabellen op in hún database.

### CSRF (Cross-Site Request Forgery) Protectie
**Wat is het?** Beveiliging tegen kwaadaardige formulieren op andere websites.
**Voorbeeld in jouw project:**
Stel, een hacker maakt een link op zijn website: *animashop.test/admin/delete-all*. Als jij daar ingelogd op klikt, is alles weg.
Laravel blokkeert dit. Op AL jouw formulieren (zoals producten toevoegen of de checkout) staat de code `@csrf`. Dit is een geheime stempel. Als het formulier wordt verzonden zonder die exacte, unieke stempel, weigert de backend de aanvraag met een "419 Page Expired" foutmelding.

### Eager Loading (Het N+1 Query Probleem oplossen)
**Wat is het?** Een oplossing voor een bekende snelheids-fout (performance probleem) in databases.
**Voorbeeld in jouw project:**
In je webshop (`ShopController`) tonen we 12 producten op pagina 1.
Als we typen: `$producten = Product::all();` (Dat is 1 database query).
Dan typen we in het Blade bestand voor élk product: `<img src="{{ $product->primaryImage->path }}">`. Laravel gaat dan voor elk van de 12 producten apart terug naar de database om de foto te zoeken (Dat zijn 12 extra queries!). Totaal: 13 queries. Dit wordt super traag bij 100 producten.
**Jouw oplossing:**
Je gebruikt *Eager Loading*: `Product::with('primaryImage')->paginate(12);`
Hiermee pakt Laravel eerst alle producten (Query 1), en daarna pakt hij in één keer de foto's van *al* deze producten tegelijk (Query 2). Totaal: Slechts 2 queries, supersnel!

### Database Transactions (`DB::transaction`)
**Wat is het?** Meerdere database acties bundelen tot "Alles-of-niets".
**Voorbeeld in jouw project:**
Tijdens de Checkout slaan we eerst de `Order` op. Daarna in een loopje de 5 `OrderItems`.
Wat als de server crasht na item 3? Dan heb je een bestelling met ontbrekende producten waarvoor wel is betaald. Fout!
Door dit in `DB::transaction(function() { ... })` te wikkelen in je `ProcessCheckoutAction`, zegt Laravel: *"Zijn niet álle 6 de queries succesvol? Verwijder dan alles wat je in deze transactie al hebt opgeslagen en doe alsof er niets is gebeurd."*
