# Neerslag Eigen Project (Schriftelijke Documentatie)

*Dit document bevat de exacte structuur zoals gevraagd in je rubric voor de "Neerslag".*

## 1. Projectomschrijving
- **Titel van het project:** AnimaShop
- **Korte samenvatting:** Een full-stack Laravel E-commerce platform voor anime merchandise.
- **Doelstelling:** Het bouwen van een veilige, performante webshop met een afgeschermd beheerpaneel en een werkende betaalflow.
- **Doelgroep:** Anime liefhebbers (klanten) en webshop-eigenaren (beheerder).
- **Probleemstelling:** Veel standaard webshops zijn visueel saai of missen een specifieke doelgroep-focus. AnimaShop biedt een op maat gemaakte, dark-mode/neon getinte winkelervaring met een robuuste backend.

## 2. Scope
*(Zie document `5_scope_en_planning.md` voor de volledige uitwerking van wat wél en niet is gebouwd, en de uitbreidingsmogelijkheden).*

## 3. Analyse
- **Functionele vereisten:** Bezoekers moeten producten kunnen zoeken, filteren en in een winkelmand plaatsen. Gebruikers moeten kunnen inloggen (ook via GitHub) en afrekenen. Admins moeten CRUD-rechten hebben over de catalogus.
- **Niet-functionele vereisten:** De site moet snel zijn (Paginatie, Eager Loading), veilig (FormRequests, CSRF, Password Hashing) en responsive (Tailwind CSS).
- **Gebruikersrollen:** `ADMIN` (toegang tot `/admin` dashboard) en `KLANT` (toegang tot winkel en checkout).

## 4. Technische uitwerking
- **Technologieën:** Laravel 11 (PHP), MySQL, Tailwind CSS, Alpine.js (indien gebruikt), Stripe API.
- **Projectstructuur:** MVC-architectuur aangevuld met specifieke design patterns zoals FormRequests (voor validatie) en Actions/Services (om controllers dun te houden).
- **Databankstructuur:** Relationele database met tabellen voor users, categories (met self-referencing `parent_id`), products, product_images, variants, orders, en order_items.
- **API’s:** Stripe (Checkout Session API voor betalingen) en GitHub (OAuth2 voor social login).

## 5. Ontwerp en UX
- **Designkeuzes:** Gekozen voor een donker thema (black/dark-gray) gecombineerd met neon rode accenten (`#ff2a42`). Dit past perfect bij het 'Anime / Gaming' thema en zorgt voor een premium uitstraling (glassmorphism effecten).
- **Responsive gedrag:** Tailwind CSS classes (`sm:`, `md:`, `lg:`) zijn overal toegepast zodat het productoverzicht transformeert van 1 kolom op mobiel naar 3 kolommen op desktop. Sidebar-navigatie en tabellen zijn mobielvriendelijk gemaakt.

## 6. Testing en kwaliteitscontrole
- **Wat werd getest:** De volledige bestelflow van A tot Z (Toevoegen aan mandje -> Checkout -> Stripe -> Database Opslag -> Bevestigingsmail).
- **Opgeloste bugs:** Het "N+1 query probleem" op de shoppagina opgelost door `with(['category', 'primaryImage'])` te gebruiken. Een filter-bug verholpen waarbij producten van subcategorieën niet toonden als men op een hoofdcategorie klikte.
- **Gekende fouten:** Momenteel geen kritieke bugs aanwezig.

## 7. Reflectie
- **Wat ging goed:** De implementatie van het Action patroon maakte de complexe checkout-logica verrassend overzichtelijk. De Tailwind styling zorgde snel voor een strak resultaat.
- **Wat was moeilijk:** De structuur bedenken voor de `variants` (maten/talen). Omdat een "maat" voor kleding anders is dan voor manga, was een flexibele tabel (`type` en `value`) noodzakelijk.
- **Wat heb ik geleerd:** Hoe belangrijk database-relaties zijn en hoe je betalingen veilig afhandelt zonder dat de order verloren gaat als de gebruiker zijn browser te vroeg sluit (`DB::transaction`).

## 8. Bronnen en hulpmiddelen
- Officiële Laravel Documentatie (Routing, Eloquent, Socialite).
- Tailwind CSS Documentatie.
- Stripe API Documentatie.
- *Vermeld hier eventueel dat je een AI-assistent hebt gebruikt als pair-programmer om complexe logica (zoals de Action classes en styling) te sparren en te structureren.*
