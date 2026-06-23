# De Anatomie van je JavaScript (AJAX) 🔬

Als de jury vraagt: *"Hoe werkt die Live Search balk van jou zonder dat de pagina flikkert of herlaadt?"*, dan vragen ze naar jouw **AJAX** (Asynchronous JavaScript and XML) code.

Hier is jouw eigen code uit `resources/js/app.js` letterlijk woord-voor-woord ontleed.

---

## 1. De Wachtkamer (Voordat we beginnen)

```javascript
document.addEventListener('DOMContentLoaded', function() {
```
- **`document` (VERPLICHT):** Dit is jouw hele webpagina (alle HTML bij elkaar).
- **`addEventListener` (VERPLICHT):** Dit vertelt de browser: *"Zet je oren open en luister naar iets wat gaat gebeuren."*
- **`'DOMContentLoaded'` (VERPLICHT):** Dit is het specifieke moment waarop gewacht wordt. Vertaald: *"Wacht totdat alle HTML plaatjes, knoppen en tekst volledig op het scherm getekend zijn, vóórdat je ook maar iets van dit script probeert uit te voeren."* Dit voorkomt dat je JavaScript een zoekbalk probeert te vinden die nog niet is ingeladen.

## 2. De Doelwitten Zoeken

```javascript
const searchInput = document.getElementById('liveSearchInput');
```
- **`const` (VERPLICHT):** Een 'constante' variabele. Je zegt hier: "Ik maak een doosje dat nooit meer van inhoud mag veranderen."
- **`searchInput` (ZELF VERZONNEN):** De naam van jouw doosje.
- **`getElementById` (VERPLICHT):** De browser gaat op zoek naar precies één stukje HTML dat `id="liveSearchInput"` heeft.

## 3. Luisteren naar Toetsaanslagen

```javascript
searchInput.addEventListener('keyup', function(e) {
```
- **`'keyup'` (VERPLICHT):** Het moment dat een bezoeker een letter typt en de toets weer *loslaat*.
- **`function(e)` (VERPLICHT CONCEPT):** De functie die wordt uitgevoerd. Die `e` (Event) bevat stiekem alle informatie over wat er net gebeurd is (bijv. wélke letter er is ingetypt).

## 4. Debouncing (Jouw 10/10 Jury Trucje!)

```javascript
clearTimeout(debounceTimer);
debounceTimer = setTimeout(() => { ... }, 300);
```
- **Jury Uitleg:** *"Als iemand het woord 'Naruto' typt (6 letters), wil ik niet dat mijn browser 6 keer razendsnel achter elkaar een blinde paniek-aanval uitvoert naar de server. Met `clearTimeout` wis ik telkens de timer als hij nóg een letter typt. Pas als hij **300 milliseconden** stopt met typen (hij pauzeert), mag de code in de `setTimeout` pas écht naar de server bellen. Dit bespaart 80% van mijn serverkosten en heet 'Debouncing'."*

## 5. De URL Bouwen

```javascript
const query = e.target.value;
const url = new URL(window.location.href);
url.searchParams.set('search', query);
```
- **`e.target.value`:** Haalt uit de zoekbalk EXACT de letters die er nu in staan (bijv. "Goku").
- **`new URL(...)`:** Pakt de huidige link bovenaan in je browser.
- **`set('search', query)`:** Plakt daar onzichtbaar `?search=Goku` achteraan.

## 6. De Grote Vangst (Fetch)

```javascript
fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
```
- **`fetch` (VERPLICHT):** De moderne manier in JavaScript om de server op te bellen in de achtergrond.
- **`'X-Requested-With': 'XMLHttpRequest'` (JURY GOUD!):** *"Hiermee fluister ik tegen Laravel: 'Psst, dit is geen normale bezoeker, dit is een robot (AJAX)'. Hierdoor weet de ShopController dat hij géén volledige webpagina moet terugsturen (met headers en footers), maar alléén de kale HTML blokjes van de producten."*

## 7. Het Resultaat op het Scherm Plakken

```javascript
.then(response => response.text())
.then(html => {
    productGridContainer.innerHTML = html;
})
```
- **`.then` (VERPLICHT):** Vertaald: *"Wacht rustig tot de server antwoord geeft (dit kan een seconde duren), en als hij dat doet... dan:"*
- **`response.text()`:** Vertaal de wartaal van de server naar leesbare tekst (HTML).
- **`innerHTML = html`:** Pak de grote "doos" op je website waar de producten in staan (`productGridContainer`) en gooi de oude inhoud genadeloos weg. Plak daar exact deze fonkelnieuwe HTML blokjes voor in de plaats. 

En voilà, de producten zijn vernieuwd zonder dat de webpagina ook maar één keer hoefde te flikkeren of te herladen!
