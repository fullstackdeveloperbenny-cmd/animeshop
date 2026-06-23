# Hacker & Security Vragen (Jury Goud!) 🛡️

Een jury test *altijd* je kennis van beveiliging. Als je een webshop bouwt, speel je met echt geld en echte klantinformatie. Als jij kunt bewijzen dat je systeem onkraakbaar is, ben je met vlag en wimpel geslaagd.

Hier zijn de beruchtste 'Hacker' vragen (net zoals de "Inspecteren-Hack") en jouw waterdichte antwoorden.

---

### 1. De Cross-Site Scripting (XSS) Hack
**De vraag:** *"Wat gebeurt er als een gebruiker bij het afrekenen als adres dit invult: `<script>alert('Je bent gehackt!');</script>`?"*

**Jouw antwoord:**
"Dan gebeurt er helemaal niets. Laravel's Blade systeem (`{{ $adres }}`) is standaard beschermd tegen XSS-aanvallen. Voordat hij de tekst op het scherm print, voert hij automatisch een actie uit die *'HTML Escaping'* heet. Dit betekent dat hij de scherpe haakjes `<` en `>` omzet in veilige tekst (`&lt;` en `&gt;`). De browser ziet het daardoor gewoon als saaie platte tekst, en voert het niet uit als JavaScript. Alleen als ik bewust de syntax `{!! $adres !!}` had getypt (zonder escaping), zou het gevaarlijk zijn."

---

### 2. De SQL-Injection Hack
**De vraag:** *"Wat als iemand in de zoekbalk de volgende beruchte code typt om je database te vernietigen: `' OR 1=1; DROP TABLE users; --`?"*

**Jouw antwoord:**
"Ik ben hiertegen beschermd omdat ik Laravel Eloquent ORM gebruik (`Product::where(...)`) in plaats van rauwe SQL queries te schrijven. Eloquent gebruikt op de achtergrond de *'PDO Parameter Binding'* techniek van PHP. Dit betekent dat de database de ingetypte tekst héél streng behandelt als een domme tekenreeks (een String) en nóóit als uitvoerbaar SQL-commando. Hij gaat dus letterlijk op zoek naar een product dat `' OR 1=1;` heet, vindt niks, en toont een leeg scherm."

---

### 3. De IDOR Hack (Insecure Direct Object Reference)
**De vraag:** *"Stel, een klant is ingelogd en kijkt naar zijn eigen factuur. De URL is `jouw-webshop.test/orders/5`. Wat gebeurt er als hij zelf dat getal verandert in `jouw-webshop.test/orders/6` (de order van iemand anders)?"*

**Jouw antwoord:**
"Dat is een IDOR-aanval. Dat heb ik afgedekt. Als een klant een factuur wil zien, haal ik niet blind de order op. In mijn code vergelijk ik altijd: Is het ID van de ingelogde gebruiker (`auth()->id()`) wel exact gelijk aan de eigenaar van de order (`$order->user_id`)? Ook voor Categorieën en Producten gebruik ik Middleware of Policies die controleren of de bezoeker wel écht Admin-rechten heeft. De hacker krijgt direct een `403 Forbidden` (Toegang Geweigerd) error in zijn gezicht."

---

### 4. De Mass Assignment Registratie Hack
**De vraag:** *"Wat als ik tijdens het registreren van een nieuw account met 'Inspecteren' een extra veldje toevoeg: `<input type="hidden" name="role" value="admin">`. Maakt de server mij dan beheerder?"*

**Jouw antwoord:**
"Nee, absoluut niet. Mijn Model-bestanden (zoals `User.php`) zijn hiertegen beschermd met een `$fillable` array. Dit is de uitsmijter van mijn database. Zelfs al stuur je 100 extra formuliervelden naar de server, als de kolom `role` niet specifiek door mij in die `$fillable` array staat, gooit Laravel de gehackte data keihard weg voordat het de database raakt. Niemand kan zichzelf zomaar Admin maken."

---

### 5. De Virus Upload Hack
**De vraag:** *"Je beheerders kunnen foto's van producten uploaden. Wat als een gehackt Admin-account in plaats van een foto, een gevaarlijk virus-bestand (`virus.php`) probeert te uploaden om de server over te nemen?"*

**Jouw antwoord:**
"Ook in de backend vertrouw ik de bestanden niet zomaar. In mijn `StoreProductRequest` heb ik ingesteld dat een afbeelding niet alleen een maximale grootte mag hebben, maar ik gebruik de validatieregel `mimes:jpeg,png,jpg,webp`. Dit is heel belangrijk: Laravel kijkt hierbij niet naar het achtervoegsel van de bestandsnaam (wat hackers makkelijk kunnen faken door `virus.php` te hernoemen naar `virus.jpg`), maar hij kijkt naar het daadwerkelijke, diepgewortelde MIME-type van de inhoud. Een nep-foto wordt genadeloos geweigerd."
