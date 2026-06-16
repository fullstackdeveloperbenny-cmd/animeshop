# Frontend & Backend Verdediging (Jury Vragen)

## Frontend (Focus: Layout, UX, Responsive)

**1. Hoe zijn de pagina's opgebouwd en hoe pas je responsive design toe?**
*Antwoord:* "Ik gebruik Tailwind CSS. Door utility classes zoals `grid-cols-1 sm:grid-cols-2 lg:grid-cols-3` te gebruiken, weet de browser dat producten op een telefoon onder elkaar moeten staan, op een tablet in 2 kolommen, en op een groot scherm in 3. Ik gebruik Blade Components (zoals `<x-shop-layout>`) om de header en footer niet op elke pagina te moeten herhalen."

**2. Waarom bepaalde layout keuzes?**
*Antwoord:* "De Anime-doelgroep houdt van moderne, strakke, dark-mode designs. Daarom heb ik gekozen voor een zwarte achtergrond met '#ff2a42' (neon rood) als actiekleur. Ik gebruik 'glassmorphism' (transparante, wazige achtergronden via `backdrop-blur`) om het geheel een premium uitstraling te geven in plaats van een platte, standaard webshop."

**3. Hoe is de frontend gekoppeld aan de backend?**
*Antwoord:* "Alles gaat via Laravel Blade. De backend (Controller) haalt data uit de MySQL database en geeft dit als een variabele (bijv. `$products`) aan de View. In de View gebruik ik een `@foreach($products as $product)` loop om de HTML kaarten dynamisch te genereren."

---

## Backend (Focus: Database, Security, Architectuur)

**1. Hoe is de databank opgebouwd en welke relaties zijn er?**
*Antwoord:* "Het is een volledig genormaliseerde relationele database. Belangrijke relaties zijn:
- **One-to-Many:** Een `Category` heeft veel `Products`. Een `Order` heeft veel `OrderItems`.
- **One-to-Many (Polymorphic-achtig/Flexibel):** Een `Product` heeft veel `Variants` (maten/talen) en `ProductImages`.
- **Self-referencing:** Een `Category` kan een `parent_id` hebben die verwijst naar een andere `Category` om zo oneindige subcategorieën te maken."

**2. Hoe werkt de validatie?**
*Antwoord:* "Ik gebruik Laravel FormRequests. Dit betekent dat als een gebruiker een formulier instuurt (bijv. de checkout), de aanvraag éérst door de `CheckoutProcessRequest` class gaat. Hier wordt gecheckt of velden als 'email' echt een email zijn, en of verplichte velden niet leeg zijn. Pas als dit 100% klopt, mag de code in de Controller draaien."

**3. Hoe zijn fouten afgehandeld en hoe is de data veilig?**
*Antwoord:* 
- **Security:** Laravel gebruikt automatische CSRF-protectie op alle POST formulieren. Alle database queries gaan via de Eloquent ORM of Query Builder, wat beschermt tegen SQL injecties.
- **Foutafhandeling:** Voor de kritieke betaal-flow gebruik ik `DB::transaction`. Als er tijdens het opslaan van 5 producten ineens een fout optreedt, voert Laravel een 'rollback' uit, waardoor de database niet vervuild raakt met halve bestellingen.

**4. Wat doet de `EnsureUserIsAdmin` middleware?**
*Antwoord:* "Dit is een poortwachter. Elke route die begint met `/admin` zit achter deze middleware. De middleware checkt `if (auth()->user()->role === UserRole::ADMIN)`. Als de gebruiker een normale klant is (of niet is ingelogd), forceert de middleware direct een `abort(403)` of een redirect. Zo kan een klant nooit bij het beheerpaneel komen, zelfs niet als ze de URL raden."
