# Hoe werkt mijn Live AJAX Search? ⚡

Een van de coolste features op de webshop is de "Live Search". Terwijl je typt in de zoekbalk, verandert het overzicht van producten (het 'grid') onmiddellijk mee, **zonder dat de pagina hoeft te herladen**.

Als de jury vraagt: *"Hoe heb je dat flikkerende pagina-herladen voorkomen? Heb je daar Livewire voor gebruikt?"* is dit jouw moment om te shinen.

## Jouw Antwoord (De Uitleg)
"Nee, ik heb geen Livewire gebruikt. Ik heb het gebouwd via de klassieke **AJAX Partial Rendering** methode met Vanilla JavaScript. Dat is veel lichter voor de server en geeft mij volledige controle."

### Hoe werkt het onder de motorkap? (De 3 Stappen)

**1. Het JavaScript (`resources/js/app.js`)**
"In mijn JavaScript bestand heb ik een `EventListener` gezet op de zoekbalk. Zodra de gebruiker typt, doet het script het volgende:
- Het wacht eerst 300 milliseconden nadat je stopt met typen (dit heet **Debouncing**). Anders zou ik bij het woord 'Naruto' 6 losse database queries tegelijk naar de server sturen (voor N, a, r, u, t, o). Dat is slecht voor de performance.
- Na 300ms stuurt JavaScript op de achtergrond een onzichtbaar verzoek naar Laravel via de `fetch()` API. Ik voeg daar een speciale header aan toe: `X-Requested-With: XMLHttpRequest`. Daardoor weet Laravel dat dit geen normale bezoeker is, maar een AJAX request."

**2. De Laravel Backend (`ShopController@index`)**
"Normaal gesproken stuurt de `ShopController` de gehele HTML pagina (met Navbar, Footer, etc.) terug. Maar omdat ik in de Controller check: `if ($request->ajax())`, weet Laravel dat hij alleen maar het HTML-blokje met de gevonden producten hoeft terug te sturen. Ik heb de producten uit de pagina 'geknipt' en in een aparte *Partial View* (`_product-grid.blade.php`) gestopt."

**3. Het resultaat plakken (Frontend)**
"Zodra JavaScript het nieuwe blokje HTML (de partial) terugkrijgt van Laravel, pakt hij in de browser het oude producten-raster vast (`getElementById('productGridContainer')`) en vervangt hij de binnenkant (`innerHTML`) door de nieuwe data. En voilà: de pagina is geüpdatet zonder te herladen!"

---

### Bonuspunten (Extra indruk maken op de jury)

**Bonus 1: URL updaten zonder refresh**
*"Als je typt, zie je dat de URL in je browserbalk wél netjes verandert naar `?search=na`. Dit heb ik opgelost met de `window.history.pushState()` functie in JavaScript. Waarom? Omdat als iemand de zoekopdracht 'Naruto' intypt, en hij kopieert die URL om naar een vriend te sturen, dan moet die vriend exact dezelfde zoekresultaten zien als hij de link opent. Live Search mag nooit de linkjes breken!"*

**Bonus 2: De beruchte Pagination Bug gefixt**
*"Er is één gigantische bug waar veel webshops intrappen: Wat als een klant op pagina 4 van de catalogus zit (`?page=4`) en dan een compleet nieuwe zoekopdracht intypt? Normaal zoekt het systeem dan op pagina 4 naar het nieuwe woord, wat vaak resulteert in 'Geen producten gevonden'. Om dit te voorkomen heb ik in mijn Javascript de regel `url.searchParams.delete('page');` toegevoegd. Zodra de bezoeker één letter typt, wordt de pagination gereset naar pagina 1. Zo klopt de data altijd!"*
