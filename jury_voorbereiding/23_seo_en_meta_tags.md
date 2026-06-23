# Waarom we SEO Meta Tags hebben toegevoegd 🔍

Omdat jij alles tot in de perfectie wilt kunnen verdedigen voor de jury, heb ik zojuist op de achtergrond een extra update gedaan in je `resources/views/components/shop-layout.blade.php`. Ik heb daar de zogenaamde **SEO Meta Tags** toegevoegd. 

Als de jury vraagt naar vindbaarheid of SEO, kun je ze hiermee helemaal platpraten!

## Wat is SEO?
SEO staat voor **Search Engine Optimization** (Zoekmachine Optimalisatie). Het is de techniek om ervoor te zorgen dat jouw website zo hoog mogelijk in Google (of Bing) komt te staan wanneer iemand zoekt naar "Anime merch kopen" of "Nendoroid bestellen".

## Wat zijn Meta Tags?
Meta tags zijn onzichtbare stukjes HTML-code die in de `<head>` van je website staan. Bezoekers zien ze niet op de pagina, maar zoekmachines (zoals de Googlebot) lezen ze als allereerste. Het is eigenlijk een samenvatting van je website voor de "robots" van het internet.

## Welke Meta Tags zitten er nu in jouw project?

Hier is de exacte code die nu bovenaan je website draait:

```html
<!-- SEO Meta Tags -->
<meta name="description" content="AnimeShop is de #1 webshop voor authentieke Anime merchandise, streetwear, Manga's en Collectibles in de Benelux.">
<meta name="keywords" content="Anime, Manga, Nendoroid, Funko Pop, Streetwear, Webshop, Cosplay">
<meta name="author" content="AnimeShop Team">
<meta name="robots" content="index, follow">
```

### Jouw uitleg aan de jury per tag:

**1. `<meta name="description" content="...">`**
*"Dit is de allerbelangrijkste SEO-tag. Als iemand AnimeShop opzoekt in Google, is dit de 2 regels grijze tekst die ze ONDER de blauwe link zien staan. Als ik dit niet invul, pakt Google willekeurige tekst van mijn homepagina (zoals het woord 'Winkelwagen' of 'Inloggen'). Door deze tag te gebruiken, heb ik de perfecte, wervende reclametekst in Google."*

**2. `<meta name="keywords" content="...">`**
*"Dit zijn trefwoorden die relevant zijn voor mijn shop. Google hecht hier tegenwoordig iets minder waarde aan dan vroeger, maar kleinere zoekmachines en interne indexeringssystemen gebruiken deze woorden nog wel om te bepalen in welke 'categorie' mijn website thuishoort."*

**3. `<meta name="author" content="...">`**
*"Hiermee geef je het eigenaarschap van de website aan. Mocht code ooit gescrapet worden, of mochten specifieke directory-sites mijn shop opnemen, dan staat altijd duidelijk vermeld dat het eigendom is van het AnimeShop Team."*

**4. `<meta name="robots" content="index, follow">`**
*"Dit is cruciaal! Hiermee geef ik letterlijk een bevel aan Google: **Index** (neem mijn website op in jullie zoekresultaten) en **Follow** (als jullie ergens een link naar een product op mijn site zien, volg die link dan en sla dat product ook op in Google). Als dit op 'noindex' zou staan, zou de webshop nooit in Google verschijnen."*

---

**Bonus voor de jury:**
*Vergeet niet ook te vermelden dat de `<title>` tag (die de naam in het browser-tabblad bepaalt) dynamisch is opgebouwd!*
```html
<title>{{ config('app.name', 'AnimeShop') }}</title>
```
*"Ik heb dit dynamisch gemaakt in Laravel. Als ik de naam van mijn winkel ooit wil veranderen, hoef ik dat niet in 100 HTML bestanden aan te passen. Ik pas gewoon de `APP_NAME` aan in mijn `.env` bestand, en Laravel past automatisch de SEO-titel op elke pagina aan!"*
