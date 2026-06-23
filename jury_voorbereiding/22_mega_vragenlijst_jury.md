# Mega Vragenlijst (De Ultieme Test) 🏆

Dit is jouw ultieme overhoor-lijst. Als je deze vragen snapt, kan de jury je **niets** meer maken. Lees het niet als een robot voor, maar probeer het concept te begrijpen.

---

## Categorie 1: Beveiliging (Security)
*De jury test altijd of je website veilig is tegen hackers.*

**1. Wat is CSRF en hoe bescherm je je daartegen?**
"CSRF (Cross-Site Request Forgery) is een aanval waarbij een hacker een gebruiker ongemerkt een formulier laat versturen op jouw site (bijv. wachtwoord wijzigen) via een andere kwaadaardige website. Ik bescherm mijn app hiertegen door `@csrf` in al mijn Blade-formulieren te zetten. Laravel genereert dan een unieke, verborgen token. Als een formulier wordt opgestuurd zónder die token (of met een foute), blokkeert Laravel het direct (419 Page Expired)."

**2. Hoe bescherm je je applicatie tegen SQL Injection?**
"Door Eloquent ORM te gebruiken in plaats van ruwe SQL queries. Als ik `Product::where('name', $input)` doe, gebruikt Laravel achter de schermen PDO parameter binding (prepared statements). Hierdoor wordt alle input van de gebruiker gezien als *tekst* en nooit als *uitvoerbare code*."

**3. Wat is XSS (Cross-Site Scripting) en hoe voorkom je dit?**
"Bij XSS probeert een hacker kwaadaardige JavaScript in je site te injecteren (bijvoorbeeld in een productbeschrijving of contactformulier), zodat dit bij andere gebruikers wordt uitgevoerd. Laravel beveiligt dit automatisch in Blade: als ik `{{ $product->description }}` gebruik, converteert Laravel alle HTML-tekens (zoals `<script>`) naar onschadelijke tekst (html entities)."

**4. Hoe worden wachtwoorden opgeslagen in jouw database?**
"Wachtwoorden worden **gehasht** (versleuteld op een manier die niet meer terug te draaien is) via het Bcrypt of Argon2 algoritme (standaard in Laravel). We slaan nooit plain-text wachtwoorden op. Zelfs ik als admin kan de wachtwoorden van mijn klanten niet lezen."

**5. Hoe zorg je dat klanten niet in het Admin-paneel komen?**
"Ik heb een `EnsureUserIsAdmin` Middleware geschreven. Deze controleert of de ingelogde gebruiker de rol `ADMIN` heeft. Als ze dat niet hebben, stuurt de middleware ze keihard terug naar de homepagina met een foutmelding (403 Forbidden). Deze middleware heb ik op alle `/admin` routes gezet."

---

## Categorie 2: Database & Performance

**6. Wat is Eloquent ORM?**
"Object-Relational Mapping. Het is Laravels systeem om met tabellen in de database te praten alsof het gewone PHP-objecten zijn. In plaats van `SELECT * FROM users` typ ik `User::all()`. Het maakt relaties leggen ook heel simpel via methodes zoals `hasMany()` en `belongsTo()`."

**7. Wat is het verschil tussen `hasMany` en `belongsTo`?**
"Ze zijn elkaars tegenovergestelde in een 1-op-veel relatie. Een Categorie **heeft meerdere** Producten (`hasMany`). Maar een specifiek Product **behoort tot** één Categorie (`belongsTo`). In de database betekent dit dat de `products` tabel een `category_id` (foreign key) heeft."

**8. Wat is het N+1 Query Probleem en hoe heb je dit opgelost?**
"Als ik 10 producten ophaal met `Product::all()`, en daarna in een Blade `foreach`-loop `{{ $product->category->name }}` aanroep, gaat Laravel voor élk van die 10 producten apart een query doen om de categorie op te halen. Dat zijn 11 queries in totaal (1 voor de producten, 10 voor de categorieën). Ik heb dit opgelost met **Eager Loading**: `Product::with('category')->get()`. Dan pakt Laravel alles in slechts 2 efficiënte queries."

**9. Wat is `DB::transaction()` en waarom gebruik je het bij het afrekenen?**
"Een database transactie zorgt ervoor dat een reeks aanpassingen als een 'alles-of-niets' pakketje wordt uitgevoerd. Bij een bestelling moet ik een `Order` opslaan én meerdere `OrderItems` aanmaken én voorraad wijzigen. Als de stroom halverwege uitvalt, wil ik niet dat er een halve order in de database staat. Als er iets misgaat in een transactie, doet Laravel een 'rollback' en wordt alles teruggedraaid alsof er nooit iets gebeurd is."

**10. Waarom gebruik je Migrations en Seeders in plaats van direct in phpMyAdmin te werken?**
"Migrations zijn versiebeheer (zoals git) voor mijn database. Als ik mijn project aan een collega of docent geef, hoeven zij alleen `php artisan migrate` te typen en de hele database-structuur wordt perfect opgebouwd. Met Seeders vul ik de lege tabellen vervolgens snel met testdata. Als ik alles in phpMyAdmin zou doorklikken, zou ik dat bij elke verhuizing opnieuw moeten doen."

---

## Categorie 3: MVC, Controllers & Architectuur

**11. Wat is MVC?**
"Model-View-Controller. Het Model (bijv. `Product`) praat met de database. De Controller (`ShopController`) is de verkeersregelaar die het verzoek aanneemt, data opvraagt bij het Model, en deze doorstuurt naar de View. De View (`show.blade.php`) is puur de HTML/Tailwind representatie voor de gebruiker."

**12. Waarom staan er FormRequests (`StoreProductRequest`) in je project in plaats van validatie in de Controller?**
"Voor Separation of Concerns (scheiding van taken) en om de Controller 'thin' (klein en overzichtelijk) te houden. De FormRequest checkt of de data klopt (bijv. 'is de prijs wel een getal?'). Als het niet klopt, wordt de gebruiker direct teruggestuurd zónder dat de Controller ooit is aangeroepen."

**13. Wat is Dependency Injection (DI)?**
"In plaats van ín mijn methode een nieuwe class aan te maken via `new CartService()`, vraag ik Laravel om hem mij te geven in de parameter van de methode: `public function index(CartService $cart)`. Laravel lost dit automatisch voor me op. Dit maakt de code veel schoner."

**14. Wat is het Action-patroon?**
"Een Action class is een heel klein bestandje dat exact 1 specifieke taak uitvoert (bijv. `CreateProductAction`). We halen de logica om een product op te slaan (inclusief varianten en foto's) uit de Controller en stoppen het in die Action. Hierdoor kan ik diezelfde logica later makkelijk hergebruiken."

---

## Categorie 4: Frontend (Blade & Tailwind)

**15. Wat is het voordeel van Tailwind CSS ten opzichte van klassieke CSS of Bootstrap?**
"Tailwind is utility-first. Ik hoef geen custom klassenamen zoals `.product-card-container` te verzinnen en losse CSS-bestanden te schrijven. Ik zet de stijlen direct op het element (`flex bg-red-500 rounded-lg`). Daardoor is mijn design sneller klaar en groeit mijn CSS-bestand niet uit tot duizenden ongebruikte regels, omdat de compiler alleen de classes meeneemt die ik daadwerkelijk gebruik."

**16. Waarom gebruik je Blade Components in plaats van `@include`?**
"Components (`<x-admin-layout>`) zijn moderner dan `@include`. Ze laten me toe om slots te gebruiken (zodat ik makkelijk de "titel" en "inhoud" kan scheiden) en ik kan direct parameters doorgeven zonder complexe arrays. Het leest ook veel meer als natuurlijke HTML."

**17. Wat doet `npm run dev` (Vite) precies?**
"Vite is een razendsnelle 'bundler'. Als ik aan het ontwikkelen ben, kijkt Vite constant naar mijn Blade-bestanden. Zodra ik ergens een nieuwe Tailwind class (bijv. `text-purple-600`) typ, voegt Vite die styling razendsnel op de achtergrond toe en ververst hij mijn browser zonder dat ik zelf op F5 hoef te drukken."
