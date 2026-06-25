# De Master Begrippenlijst (Terminologie) 📚

Dit is je ultieme woordenboek. Als de jury vraagt: *"Wat is de officiële term hiervoor?"*, dan vind je het hier. Deze lijst bevat álle terminologie die verwerkt zit in jouw Anime Webshop.

---

## 1. Architectuur & Ontwerppatronen
- **MVC (Model-View-Controller):** Het fundamentele patroon van Laravel. Modellen regelen data, Views tonen de HTML, Controllers regelen het verkeer daartussen.
- **Resource Controller:** Een speciale, standaard Laravel controller die automatisch wordt gegenereerd met de 7 standaard CRUD-acties (`index`, `create`, `store`, `show`, `edit`, `update`, `destroy`). Dit zorgt ervoor dat je code gestructureerd blijft en je maar 1 regel in je `routes/web.php` hoeft te typen (`Route::resource(...)`).
- **Separation of Concerns:** (Scheiding van belangen). De theorie dat een Controller zich niet mag bezighouden met ingewikkelde berekeningen, maar puur met "verkeer regelen".
- **DRY (Don't Repeat Yourself):** De regel dat je nooit twee keer exact dezelfde code mag schrijven. Oplossing: gebruik *Scopes*, *Traits* of *Services*.
- **Service Class (bv. `CartService`):** Een los bestand dat complexe bedrijfslogica bevat (zoals het berekenen van een winkelmand-totaal) om de Controller slank te houden.
- **Action Class (bv. `ProcessCheckoutAction`):** Een los bestand dat één specifieke, zware actie uitvoert (zoals het afhandelen van de betaling en bestelling). 
- **Dependency Injection:** Als je in je controller de code `public function store(Request $request)` typt. Je 'injecteert' automatisch het Request object in de functie, zodat Laravel het zware werk doet.

## 2. Database & Eloquent
- **Eloquent ORM:** Het systeem van Laravel dat database-tabellen (zoals `products`) omzet in PHP-objecten, zodat je geen rauwe SQL (zoals `SELECT * FROM`) hoeft te typen.
- **Migration:** Versiebeheer voor je database. Een script dat tabellen en kolommen bouwt.
- **Seeder:** Een script om de lege database automatisch te vullen met nep-data (dummy data) voor testdoeleinden, vaak gegenereerd via een *Factory*.
- **SoftDeletes:** De "prullenbak" techniek. Items worden niet hard uit de database verwijderd, maar krijgen een onzichtbaar `deleted_at` stempeltje.
- **Route Model Binding:** Een magisch trucje van Laravel. In plaats van in je controller zelf `Product::find($id)` te moeten typen, typ je simpelweg `public function show(Product $product)`. Laravel kijkt dan naar de URL (bijv `/shop/naruto`), zoekt zélf in de database naar het product 'naruto', en geeft het kant-en-klaar aan je functie. Kan hij het niet vinden? Dan gooit Laravel automatisch een 404 Error.
- **Mass Assignment:** Het beveiligen van je database tabellen. Gedaan met **`$fillable`** (Whitelist - alleen déze kolommen mogen aangepast worden) of `$guarded` (Blacklist).
- **Type Casting (`$casts`):** Het automatisch omzetten van ruwe database-data naar de juiste PHP datatypes. Bijv: MySQL stuurt een `0` of `1` voor een checkbox, maar door `'is_active' => 'boolean'` te gebruiken, maakt Laravel er automatisch een echte PHP `true` of `false` van.
- **Relaties (HasMany / BelongsTo):** Hoe tabellen aan elkaar plakken. `HasMany` = 1 product *heeft veel* foto's. `BelongsTo` = 1 product *behoort tot* 1 specifieke categorie (het is het "kindje" van de categorie).
- **Eager Loading (`with()`):** Het vooraf inladen van gerelateerde tabellen (zoals de categorie van een product) in één ademteug.
- **N+1 Probleem:** Een enorme performance-killer (traagheid) die ontstaat als je géén Eager Loading gebruikt en de database in een `foreach` loop 100 keer apart wordt aangesproken.
- **Scope / Local Scope:** Een herbruikbare query-filter gecentraliseerd in je Model (bijv. `Product::active()`).
- **Database Transaction (`DB::transaction`):** Het bundelen van meerdere queries in een 'Alles of Niets' (Atomicity) proces. Faalt één query? Dan voert de database een **Rollback** uit en herstelt alles.

## 3. Beveiliging (Security)
- **Never Trust The Client:** De basisregel! Vertrouw nooit wat uit de browser of de HTML komt. Haal prijzen of gevoelige data altijd opnieuw op in de Backend (Database).
- **CSRF (Cross-Site Request Forgery):** Een hack waarbij een bezoeker via een valse website een formulier op jouw site triggert. Voorkomen door de geheime Laravel `@csrf` token.
- **XSS (Cross-Site Scripting):** Een hack waarbij een bezoeker kwaadaardig JavaScript invult (bijv. in een zoekbalk). Voorkomen door Blade's automatische HTML-escaping (`{{ }}` veranderd `<` in onschuldige tekst).
- **SQL Injection:** Een hack waarbij database-commando's in zoekbalken worden getypt. Opgelost omdat Eloquent **PDO Parameter Binding** gebruikt en de input puur als tekst ziet.
- **Middleware:** De 'Uitsmijter' bij de ingang van je Route. Hij weigert ongeautoriseerde gebruikers lang voordat de Controller wordt bereikt (bijv. "Alleen admins mogen deze map in").
- **Gate / Policy:** Een hele specifieke 'Binnen-Bewaker'. Waar Middleware de hele route afschermt, controleert een Gate of Policy of jij een *specifieke actie* mag doen op een *specifiek item* (bijv. "Mag deze admin deze ene categorie wel bewerken?"). Je gebruikt in je controllers dan de code `Gate::authorize(...)`.

## 4. PHP Core Technologie
- **Namespace Import (`use` bovenaan):** Vertelt PHP in welk mapje hij een bepaald bestand moet zoeken (bijv. `use App\Models\Product`).
- **Trait (`use` binnenin de class):** Een methode om stukken code in je class te kopiëren en plakken (zoals `use SoftDeletes`), ter compensatie dat PHP geen *Multiple Inheritance* (meerdere stambomen) toestaat.
- **Enum (Enumeration):** Een class met vaste, hardgecodeerde waardes (zoals `UserRole::ADMIN`).
- **Magic Strings:** Het gevaarlijke gebruik van willekeurig getypte tekst (zoals `'admin'`). Voorkomen door Enums te gebruiken. Typefouten in Magic Strings crashen geruisloos, typefouten in Enums crashen met een foutmelding (Type Safety).

## 5. Frontend & Interface
- **AJAX (Asynchronous JavaScript and XML):** Een techniek om op de achtergrond tegen de server te praten en de webpagina te updaten, zónder dat de URL herlaadt of het scherm flikkert.
- **Debouncing:** Het inbouwen van een korte pauze (bijv. 300 milliseconden) tijdens typen, zodat je niet voor elke toetsaanslag de server lastigvalt.
- **DOM (Document Object Model):** De HTML structuur op het scherm. Als we in JS `document.getElementById` typen, zoeken we in het DOM.
- **Tailwind CSS (Utility-First CSS):** Een CSS framework waarbij je direct classes zoals `text-red-500` en `flex` in je HTML typt in plaats van losse stylesheet bestanden te maken.
