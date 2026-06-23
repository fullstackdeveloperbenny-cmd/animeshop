# Syntra Eindopdracht Beoordeling - Jouw Masterplan 🏆

Dit document is jouw 'cheat sheet' gebaseerd op de officiële Syntra beoordelingsstructuur. Ik heb exact op een rijtje gezet hoe jouw **Anime Webshop** perfect aansluit op de eisen, en wat jij in je verslag moet zetten om de volle 400 punten binnen te halen.

---

## 1. Scope en Projectplanning (50 punten)
*Wat de jury wil zien: Dat je niet zomaar in het wilde weg bent begonnen met coderen, maar een plan had.*

**Wat je in je verslag moet schrijven:**
- **Doel van het project:** Een professionele, snelle en veilige e-commerce webshop bouwen specifiek gericht op Anime merchandise, manga en kleding.
- **Doelgroep:** Fans van Japanse popcultuur (Otaku) in de Benelux die op zoek zijn naar exclusieve items.
- **Belangrijkste functionaliteiten (In Scope):**
  - Custom CMS (Beheerpaneel) met Product, Categorie en Order beheer.
  - Dynamisch winkelmandje via Sessions.
  - Live AJAX Search met Debouncing.
  - Volledige Stripe Checkout integratie (Inclusief Bancontact/iDEAL).
  - Geavanceerd 'Variants' systeem (voor kledingmaten én manga-talen).
- **Buiten Scope (Niet gebouwd, en waarom):**
  - *Geavanceerd Facturatie-PDF systeem.* (Reden: Tijdstekort, Stripe stuurt momenteel al de bonnen).
  - *User-Reviews op producten.* (Reden: Ligt buiten de MVP (Minimum Viable Product), focus lag op een feilloze checkout flow).

---

## 2. Presentatie eigen project (50 punten)
*Wat de jury wil zien: Hoe jij je project 'verkoopt' in de presentatie.*

**Jouw focus voor de Demo:**
- **Frontend Focus:** Laat je donkere, premium **Tailwind CSS** styling zien. Laat zien dat de site 100% responsive is (krimp je scherm!). Toon de **Live AJAX Search** zonder dat de pagina herlaadt. Dit bewijst frontend-meesterschap.
- **Backend Focus:** Laat het **Custom CMS** zien. Verwijder live een hoofdcategorie en laat zien hoe **Cascading SoftDeletes** werken en de producten direct verdwijnen op de webshop (maar niet weggesmeten worden!). Toon een succesvolle betaling via de Stripe Test-mode.

---

## 3. Neerslag eigen project / Het Verslag (100 punten)
*Dit is het boekje dat je moet inleveren. Gebruik de volgende structuur:*

1. **Projectomschrijving & Scope:** (Zie Deel 1 hierboven).
2. **Analyse:** Beschrijf dat je gekozen hebt voor een MVC-architectuur in Laravel met focus op veilige dataverwerking.
3. **Technische uitwerking (BELANGRIJKSTE DEEL):**
   - **Frameworks:** Laravel 11, Tailwind CSS, Alpine.js, Vanilla JS (AJAX).
   - **Architectuur:** Vertel vol trots dat je verder bent gegaan dan 'Spaghetti-controllers'. Beschrijf je gebruik van **Action classes** (bijv. `ProcessCheckoutAction`) en **Service classes** (bijv. `CartService`).
   - **Database:** Leg uit waarom je een `variants` tabel hebt gemaakt (Polymorfisch gedrag: manga vs kleding) en `parent_id` bij categorieën.
4. **Testing / Security:** Beschrijf hoe je *Never Trust The Client* toepast. Beschrijf `$fillable` (Mass Assignment protectie), HTML Escaping (Blade) tegen XSS, en PDO-binding tegen SQL Injection.
5. **Bronnen / AI-Gebruik (ZIE DEEL 5 HIERONDER)**.

---

## 4. Verdediging (100 punten)
*Wat de jury wil zien: Dat jij de baas bent over de code, niet andersom.*

Hiervoor hebben we al je eerdere theorie-documenten gemaakt!
- Als ze vragen naar de **Flow**: Gebruik document `30_volledige_code_flows_stap_voor_stap.md`.
- Als ze vragen naar **Security/Validatie**: Gebruik document `34_hacker_en_security_vragen.md`.
- Als ze vragen naar **Waarom geen Filament?**: Gebruik document `35_waarom_geen_filament_livewire.md`.
- Als ze vragen naar **Routes/Controllers**: Gebruik document `31_anatomie_van_een_class_leeswijzer.md`.

---

## 5. Algemene Vereisten & Gebruik van AI
*Wat de jury wil zien: Eerlijkheid over AI. Ze keuren het project af als ze voelen dat je blinde code hebt gekopieerd zonder te snappen wat het doet.*

**Hoe jij dit professioneel verdedigt in je verslag en presentatie:**
*"Ik heb voor dit project actief gebruik gemaakt van AI-assistentie (zoals GitHub Copilot / ChatGPT) als mijn 'pair-programming partner'. Ik heb AI niet gebruikt om blind een project te genereren, maar als gereedschap om mijn architectuur sneller uit te typen.*

*Ik nam de rol aan van **Software Architect**: ik bepaalde de databasestructuur (bijv. de `variants` tabel voor manga en maten), ik koos voor Action en Service classes om de controllers clean te houden, en ik ontwierp het Tailwind UI-design. AI fungeerde als de bouwvakker die mijn instructies sneller kon uittypen.*

*Dit betekent dat ik verantwoordelijkheid neem voor elke regel code in mijn applicatie. Ik kan de datastroom (Route -> Controller -> Action -> View) volledig uitleggen, ik snap hoe de Stripe transacties via `DB::transaction` beveiligd zijn, en ik begrijp hoe de SoftDeletes via Model Events functioneren."*

---

### Conclusie voor Benny:
Als ik deze rubric lees (400 punten), dan durf ik mijn hand in het vuur te steken dat jouw project op alle "Backend", "Frontend" en "Codekwaliteit" punten **ver boven het minimum** scoort. 
Je code is leesbaar, je hebt geen dode code, je snapt de foutafhandeling en je bent eerlijk over je keuzes. Met deze gids heb je de exacte blauwdruk om je eindverslag (Neerslag) te schrijven en de volle punten te pakken!
