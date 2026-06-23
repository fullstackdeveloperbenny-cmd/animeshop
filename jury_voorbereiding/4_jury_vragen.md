# Vragen die de Jury ZEKER gaat stellen (en jouw antwoorden!)

Oefen deze vragen alsof je een interview doet.

---

### Vraag 1: "Waarom heb je gekozen voor Tailwind CSS en niet voor standaard CSS of Bootstrap?"
**Jouw antwoord:**
"Tailwind is een 'utility-first' framework. In plaats van apart heen en weer te switchen tussen mijn HTML en een CSS bestand, kan ik direct in mijn Blade views stijlen toepassen (`flex`, `bg-red-500`, etc). Het zorgt ervoor dat mijn design veel sneller iteratief gebouwd kon worden en het eindresultaat is makkelijk responsive te maken zonder honderden regels custom media-queries te typen."

### Vraag 2: "Wat gebeurt er als je Stripe webhook faalt of als de stroom uitvalt tijdens een betaling?"
**Jouw antwoord:**
"In de `ProcessCheckoutAction` gebruiken we `DB::transaction()`. Dit betekent dat het Order én alle bijbehorende OrderItems eerst succesvol in de database moeten worden weggeschreven voordat Laravel de wijziging écht doorvoert. Bovendien krijgt een order standaard de status `pending`. Pas als we van Stripe het signaal `success` krijgen na de redirect (of via een webhook), zetten we de status op `paid`. Als Stripe faalt, blijft de order `pending` en is er geen geld kwijt of data verloren."

### Vraag 3: "Hoe beheer je de voorraad van een product als het product eigenlijk helemaal geen varianten (maten) heeft?"
**Jouw antwoord:**
"In mijn database structuur zit de `stock` kolom altijd in de `variants` tabel en niet bij het `product` zelf, omdat we altijd moeten weten ván welke maat we nog voorraad hebben. Maar voor een admin is dit niet altijd gebruiksvriendelijk bij producten zonder maten (zoals manga of poppetjes). Daarom heb ik voor de User Experience (UX) een simpel veld 'Standaard Voorraad' toegevoegd bovenaan het productformulier. Als de admin hier een getal invult en de varianten leeglaat, maakt de code onder water (in de `CreateProductAction`) stiekem een 'Standaard / One Size' variant aan. Zo is de code waterdicht én is het admin-paneel super simpel in gebruik!"

### Vraag 4: "Hoe heb je voorkomen dat de database te traag wordt bij het inladen van het productoverzicht?"
**Jouw antwoord:**
"Twee dingen: Ten eerste gebruik ik Paginatie (`paginate(12)`). Er worden nooit meer dan 12 producten tegelijk uit de database getrokken. Ten tweede gebruik ik 'Eager Loading' via `Product::with(['category', 'primaryImage'])`. Als ik dit niet deed, zou Laravel het 'N+1 query probleem' krijgen en voor elk van de 12 producten opnieuw een database call doen om de foto op te halen. Nu gebeurt alles in slechts 2 zeer efficiënte queries."

### Vraag 5: "Is je applicatie veilig tegen hackers? (Security)"
**Jouw antwoord:**
"Ja. Laravel beschermt standaard tegen SQL Injection omdat we de ORM (Eloquent) gebruiken in plaats van ruwe SQL. Ook is elk formulier beschermd met `@csrf` (Cross-Site Request Forgery) tokens. Daarnaast gebruiken we de `EnsureUserIsAdmin` middleware om te voorkomen dat een klant die simpelweg `/admin` in de url typt toegang krijgt tot het beheerpaneel. Alle user-input wordt gevalideerd via Form Requests voordat het de database raakt."

### Vraag 6: "Wat als een klant via 'Element Inspecteren' de prijs op de website aanpast van €250 naar €0.10 voor hij op afrekenen klikt?"
**Jouw antwoord:**
"Dan gebeurt er helemaal niets geks. Ik hanteer de gouden programmeerregel: **Never trust the client**. Formulieren in mijn webshop sturen nóóit prijzen mee naar de server. Als een klant een item toevoegt, stuurt de browser alléén het Product ID (bijv: `product_id = 5`). Mijn backend (de `CartService`) zoekt de prijs vervolgens zélf op in de beveiligde MySQL-database en slaat dit op in een server-side sessie waar de klant niet bij kan. Verandert hij de HTML met Inspecteren? Dan verandert alleen de tekst op zijn eigen schermpje, maar de server negeert dat volledig."

### Vraag 7: "Wat voorkomt dat een hacker bij het registreren een onzichtbaar veld `<input name="role" value="admin">` meestuurt en zo beheerder wordt?"
**Jouw antwoord:**
"Dit is een zogenaamde 'Mass Assignment Vulnerability'. Ik ben hiertegen beschermd omdat ik op mijn Laravel Models de `$fillable` array heb gedefinieerd. Zelfs al stuurt een hacker 100 extra velden mee naar mijn controller, Laravel filtert ze er allemaal uit en slaat in de database alléén de kolommen op die ik expliciet heb toegestaan in `$fillable` (zoals `name` en `email`)."

### Vraag 8: "Als je database gehackt en gestolen wordt, liggen al je klant-wachtwoorden dan op straat?"
**Jouw antwoord:**
"Nee. Wachtwoorden worden nooit als 'plain text' in de database opgeslagen. Laravel gebruikt standaard het ijzersterke **Bcrypt** encryptie-algoritme (of Argon2) om het wachtwoord onomkeerbaar te 'hashen'. Zelfs ik, als beheerder of database-eigenaar, kan de wachtwoorden van mijn klanten niet uitlezen of terughalen."
