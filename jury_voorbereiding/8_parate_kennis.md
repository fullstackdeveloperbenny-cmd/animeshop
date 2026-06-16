# Parate Kennis (Theorie Begrippenlijst)

*De jury zal ook theorievragen stellen om te controleren of je de termen snapt. Leer deze begrippen!*

## Frontend Begrippen

1. **Semantische HTML:** Het gebruik van HTML-tags die de *betekenis* van de inhoud beschrijven, niet alleen hoe het eruit ziet. Bijv. `<nav>` voor navigatie, `<article>` voor tekst, in plaats van overal `<div>` te gebruiken. Dit is cruciaal voor SEO en blinden (screenreaders).
2. **Flexbox vs Grid:** 
   - *Flexbox* gebruik je voor 1-dimensionale lay-outs (elementen netjes op een rij of onder elkaar zetten).
   - *Grid* gebruik je voor 2-dimensionale lay-outs (rijen én kolommen, zoals het productoverzicht in de shop).
3. **Responsive Design:** Een website zo bouwen dat hij er goed uitziet op elk schermformaat (mobiel, tablet, pc). We doen dit via *Media Queries* (of in Tailwind met `sm:`, `md:`, `lg:` classes).
4. **DOM Manipulatie:** Document Object Model. Dit is hoe JavaScript HTML-elementen kan selecteren en veranderen (bijv. een popup openklappen) zónder de pagina te verversen.

## Backend (Laravel) Begrippen

1. **MVC (Model-View-Controller):** De architectuur van Laravel. De *Controller* krijgt de vraag, haalt data uit het *Model* (de database), en stuurt die naar de *View* (HTML/Blade) om aan de gebruiker te tonen.
2. **Eloquent ORM:** Object-Relational Mapper. Dit zorgt ervoor dat we in PHP kunnen schrijven (`Product::where('price', '<', 10)->get()`) in plaats van ingewikkelde rauwe SQL query's te moeten schrijven. Eloquent zet onze PHP om in veilige SQL.
3. **Migrations:** Versiebeheer voor je database. Een script dat tabellen en kolommen aanmaakt (of verwijdert). Zo kan elke developer in het team exact dezelfde database-structuur opzetten via `php artisan migrate`.
4. **Seeders & Factories:** Scripts om je database te vullen met (nep) data om mee te testen. Factories genereren willekeurige data, Seeders vullen specifieke of vaste testdata in (zoals onze `ProductSeeder`).
5. **Middleware:** Een "laag" waar een request doorheen moet *voordat* het bij de Controller komt. Bijvoorbeeld: De `auth` middleware checkt of je bent ingelogd. Zo niet? Dan stuurt hij je direct naar de login-pagina.
6. **CSRF (Cross-Site Request Forgery):** Een aanval waarbij een kwaadaardige site acties uitvoert op jouw site namens een ingelogde gebruiker. Laravel beschermt hiertegen via de `@csrf` token: een unieke, verborgen code in elk formulier die Laravel controleert bij het submitten.
7. **N+1 Query Probleem:** Een fout in performantie waarbij je 1 query doet om 10 producten op te halen, en daarna in een loop nog eens 10 aparte queries doet om de foto van elk product op te halen (1 + 10 = 11 queries). Je lost dit op door *Eager Loading* (`Product::with('images')`) te gebruiken, wat het reduceert tot slechts 2 queries, ongeacht het aantal producten.
