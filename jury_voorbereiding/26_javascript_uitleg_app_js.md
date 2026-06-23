# JavaScript Uitleg (app.js) 📜

Als de jury vraagt: *"Kan je me eens uitleggen wat er in je `app.js` gebeurt?"*, raak dan niet in paniek. Het ziet er misschien ingewikkeld uit, maar het bestaat eigenlijk maar uit **twee simpele blokken**. 

Hier is de uitleg in "mensentaal", precies zoals je het aan de jury kunt vertellen.

---

## Blok 1: De Live Search (AJAX)

Dit blok zorgt ervoor dat de producten live updaten als je typt in de zoekbalk.

**De Code & Jouw Uitleg:**

`document.addEventListener('DOMContentLoaded', function() {`
*"Dit betekent simpelweg: wacht tot de hele HTML pagina is ingeladen voordat je dit script start. Anders probeert Javascript een zoekbalk aan te passen die nog niet bestaat."*

`const searchInput = document.getElementById('liveSearchInput');`
*"Hier pakken we de zoekbalk vast uit de HTML, zodat Javascript weet waarnaar hij moet luisteren."*

`let debounceTimer;`
`searchInput.addEventListener('keyup', function(e) {`
`clearTimeout(debounceTimer);`
*"We luisteren naar een 'keyup' (wanneer de gebruiker een toets loslaat). Maar we bouwen een 'debounceTimer' in. Elke keer als de gebruiker typt, resetten we de klok. We wachten altijd 300 milliseconden nadat hij stopt met typen."*

`debounceTimer = setTimeout(() => {`
*"Dit is die wachttijd van 300ms. Pas als de klant écht klaar is met typen, voeren we de code hieronder uit, om de server niet te overbelasten met database-queries voor elke losse letter."*

`const url = new URL(window.location.href);`
`url.searchParams.set('search', query);`
`url.searchParams.delete('page');`
*"Hier maken we de nieuwe URL aan (bijv: `?search=naruto`). En heel belangrijk: we wissen de `?page=` parameter, om de beruchte pagination-bug te voorkomen. We willen altijd op pagina 1 beginnen met zoeken!"*

`window.history.pushState({}, '', url);`
*"Dit past de URL aan in de adresbalk van de browser, zónder de pagina te herladen."*

`fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })`
*"Dit is de kern! Via `fetch()` sturen we onzichtbaar een verzoek naar Laravel. Met de `X-Requested-With` header vertellen we Laravel: 'Hey, dit is een AJAX verzoek, stuur me alsjeblieft alleen het kleine HTML-blokje met producten terug, niet de hele pagina'."*

`.then(response => response.text())`
`.then(html => { productGridContainer.innerHTML = html; })`
*"Zodra we het antwoord van Laravel krijgen, pakken we het ruwe HTML-blokje uit, en plakken we het ín de container op onze pagina (`innerHTML`). De nieuwe producten staan nu op het scherm!"*

---

## Blok 2: Dynamische Prijs (Detailpagina)

Dit blokje zorgt ervoor dat de prijs op het scherm mee-verandert als je een andere variant (maat) kiest.

**De Code & Jouw Uitleg:**

`const variantSelect = document.getElementById('variant');`
`const displayPrice = document.getElementById('display-price');`
*"We pakken hier het dropdown-menu met de maten vast, én de grote prijs die we aan de klant laten zien."*

`const basePriceHtml = displayPrice.innerHTML;`
*"We slaan de originele, standaard prijs even op in het geheugen. Voor als de klant later toch weer 'Kies een optie' selecteert."*

`variantSelect.addEventListener('change', function() {`
*"We luisteren naar een 'change' event: telkens als de klant een andere maat aanklikt in de dropdown..."*

`const selectedOption = this.options[this.selectedIndex];`
`const newPrice = parseFloat(selectedOption.getAttribute('data-price')).toFixed(2).replace('.', ',');`
*"...dan kijken we welke optie hij exact heeft gekozen. Ik heb de prijs van die maat stiekem in de HTML gezet (als een `data-price` attribuut). Javascript haalt die prijs eruit, zorgt dat het altijd 2 cijfers na de komma heeft, en vervangt de punt door een Europese komma."*

`displayPrice.innerHTML = newPrice;`
*"En tot slot updaten we het grote prijskaartje op het scherm met dat nieuwe bedrag!"*
