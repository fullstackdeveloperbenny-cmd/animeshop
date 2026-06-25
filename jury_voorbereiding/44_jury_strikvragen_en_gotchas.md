# Jury Strikvragen & Gotchas (De Ultieme Verdediging)

Tijdens de verdediging zal de jury (en specifiek het Hoofd IT) proberen om gaten in jouw kennis te vinden. Ze stellen vragen waarbij het lijkt alsof er iets mis is met je code, of ze proberen je in de val te lokken met 'hacker' scenario's.

Als je deze 7 "Strikvragen" kunt pareren met de theorie hieronder, garandeer ik je dat ze sprakeloos zijn.

---

### Strikvraag 1: Het ID in de URL (Insecure Direct Object Reference)
**De Jury zegt:** *"Benny, ik zie dat de 'Toevoegen aan Winkelmand' knop verwijst naar `/cart/add/18`. Als ik via Inspecteren die 18 verander in een 19, kan ik zomaar dingen manipuleren! Waarom heb je dat nummer niet verborgen? Is jouw website nu lek?"*

**Jouw Defensie:** 
"Absoluut niet. Je moet in theorie onderscheid maken tussen **Publieke Data** en **Privé Data**.
- Een product in een webshop is Publieke Data. Iedereen mag alle producten zien en kopen. Als jij via Inspecteren de 18 in een 19 verandert, voeg je simpelweg product 19 toe aan je *eigen* winkelmandje. Dat is geen datalek, dat is gewoon online winkelen. Als je 9999 typt, gooit de backend veilig een 404 Error (Product Not Found).
- Echter, bij Bestellingen (Privé Data) mag dit NIET. Als iemand daar de URL verandert van `/mijn-bestellingen/5` naar `/mijn-bestellingen/6` (IDOR kwetsbaarheid), blokkeer ik dit keihard in de `CustomerController`. Daar controleer ik: `if ($order->user_id !== Auth::id())`. Is het niet jouw bestelling? Dan krijg je een **403 Forbidden** foutmelding!"

---

### Strikvraag 2: De CSRF Token verwijderen
**De Jury zegt:** *"Ik zie in jouw broncode een onzichtbaar veld genaamd `_token` (gegenereerd door `@csrf`). Waar dient dat precies voor? Wat gebeurt er als ik dat verwijder en toch je formulier opstuur?"*

**Jouw Defensie:**
"Dat beschermt tegen **Cross-Site Request Forgery (CSRF)**. Het voorkomt dat een hacker een nagemaakt formulier op een ándere website zet en daarmee uit mijn naam (terwijl ik ingelogd ben) acties uitvoert op mijn webshop.
Dat onzichtbare token is een unieke 'geheime handdruk' tussen mijn formulier en de Laravel server. Als je de `@csrf` weghaalt, faalt de handdruk. Laravel weigert het formulier dan pertinent en gooit direct een **419 Page Expired** error."

---

### Strikvraag 3: De Kwaadaardige Klant (XSS)
**De Jury zegt:** *"Ik maak een account aan, en vul als voornaam in: `<script>alert('Gehackt')</script>`. Als jij inlogt als beheerder om mijn bestelling te bekijken, krijg jij dan een hacker pop-up op je scherm?"*

**Jouw Defensie:**
"Nee, daar heb ik **Blade** voor. Binnen Laravel gebruik ik in mijn HTML altijd dubbele accolades `{{ $user->name }}`. Dit zorgt automatisch voor **HTML Escaping**. Blade pakt het gevaarlijke javascript op, stript de functionaliteit eraf, en print het als domme, onschuldige, platte tekst op mijn beeldscherm. Mijn backend en browser zijn veilig tegen deze Cross-Site Scripting (XSS) aanval."

---

### Strikvraag 4: De "Verwijderde" Categorie
**De Jury zegt:** *"Ik klik in jouw Dashboard op 'Verwijder Categorie'. Hij verdwijnt mooi. Maar als ik rechtstreeks in je MySQL (phpMyAdmin) kijk, staat de rij er gewoon nog! Ben je de `DELETE` query vergeten te typen?"*

**Jouw Defensie:**
"Nee, dat is een bewuste database-architectuur keuze: de **SoftDeletes** trait. Als ik een Categorie of Product hard zou weggooien (Hard Delete), zou ik mijn hele database kunnen breken (Cascade on Delete problemen). Denk aan oude bestellingen van klanten: als een klant gisteren een Boek heeft gekocht, en ik gooi het Boek vandaag definitief weg, is zijn bestelhistorie corrupt. Door een Soft Delete (een `deleted_at` timestamp) te gebruiken, verbergt Laravel het product op de website, maar klopt mijn boekhouding en database integriteit nog voor de 100%."

---

### Strikvraag 5: Wachtwoorden in de Source Code
**De Jury zegt:** *"Ik heb jouw code op GitHub bekeken. Je gebruikt Stripe en een Database, maar ik kan helemaal nergens jouw wachtwoorden of geheime Stripe API Keys vinden in je code. Hoe werkt de website dan? En wie is er eigenlijk verantwoordelijk als de webserver toch gehackt wordt?"*

**Jouw Defensie:**
"Geheime sleutels slaan we op in het **`.env`** bestand. Dat bestand staat in de `.gitignore`, waardoor Git weigert het naar GitHub te sturen. Op de Live Server log ik handmatig in, en typ ik dáár eenmalig het `.env` bestand in. De wachtwoorden reizen dus nooit via het internet en de browser ziet ze al helemaal nooit.
En als er tóch een datalek is? Dan spreken we over het *Shared Responsibility Model*. Als de fysieke server wordt gehackt, is de Hosting (bijv. Combell) verantwoordelijk. Maar als ik een fout in mijn Laravel code schrijf (bijv. door wachtwoorden in de code te plakken), dan ben ík verantwoordelijk."

---

### Strikvraag 6: De Overvolle Webshop (N+1 Probleem)
**De Jury zegt:** *"Leuk, die 50 Manga boeken. Maar wat als je shop groeit naar 10.000 boeken? Crasht jouw server dan niet als een klant naar de Catalogus surft omdat hij alles tegelijk moet inladen?"*

**Jouw Defensie:**
"Daar heb ik de backend tegen gewapend. Ten eerste gebruik ik **Pagination**: ik laad slechts (bijvoorbeeld) 12 producten per pagina via Laravel's ingebouwde paginator. 
Daarnaast gebruik ik in mijn querie de `->with('images')` functie. Dit is **Eager Loading**. Hiermee voorkom ik het befaamde *N+1 query probleem*. In plaats van 10.000 losse kleine queries af te vuren naar de database voor elke foto apart, haalt Laravel alles in maximaal 2 grote, efficiënte queries op."

---

### Strikvraag 7: De Vergeten Routes
**De Jury zegt:** *"In je Beheerderspaneel kan ik Categorieën bekijken, maken, bewerken en verwijderen. Maar in je `web.php` staat maar één regel: `Route::resource('categories', CategoryController::class)->except(['show']);`. Ben je je andere routes soms vergeten?"*

**Jouw Defensie:**
"Zeker niet. Dat is de kracht van Laravel. `Route::resource` genereert onder de motorkap volautomatisch alle 7 benodigde routes voor een volledige **CRUD** applicatie, en koppelt deze aan de juiste methodes in mijn Controller. 
Ik heb er specifiek `->except(['show'])` aan vastgeplakt omdat een categorie bij mij zó klein is (alleen een naam en slug), dat het bouwen van een compleet losse, lege Detailpagina pure onzin zou zijn voor de User Experience van een beheerder. Door de `show` route te blokkeren hou ik mijn code schoon."
