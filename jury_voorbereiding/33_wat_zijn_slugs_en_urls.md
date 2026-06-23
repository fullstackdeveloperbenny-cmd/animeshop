# Wat is een Slug en hoe werken URL's? 🔗

Een gegarandeerde vraag van een technische jury is hoe je URL's (webadressen) opgebouwd zijn. In jouw webshop heb je er specifiek voor gekozen om met een **Slug** te werken voor de producten.

Hier is de letterlijke theorie.

---

## 1. Wat is een URL eigenlijk?
Een URL (Uniform Resource Locator) is simpelweg het exacte adres van een webpagina. 
Voorbeeld: `https://jouw-webshop.be/product/15`

### Hoe bouwt Laravel een URL op?
In je `routes/web.php` schrijf je dit:
`Route::get('/product/{product}', [ShopController::class, 'show']);`

- **`{product}`** is een zogenaamde "Wildcard" (een joker). Je zegt hiermee tegen Laravel: *"Alles wat de gebruiker hier typt, moet je vastpakken en aan de Controller geven."*

Als de gebruiker naar `/product/15` gaat:
1. Laravel vangt het getal `15` op.
2. Hij gooit dit in de `ShopController`.
3. De controller gaat naar de MySQL database en zegt: `SELECT * FROM products WHERE id = 15`.

---

## 2. Wat is een Slug?
Een Slug is een **leesbare, "website-vriendelijke" versie van een titel**.
Stel je product heet: `"Naruto: Shippuden - Grote Poster (Zwart)"`.
- Als je dit rechtstreeks in de URL stopt, breekt het internet. Spaties en speciale tekens mogen namelijk niet zomaar in een URL. De browser maakt daar hele lelijke tekens van zoals `%20` en `%28`.
- Een Slug is de gladgestreken versie van die titel. Alles wordt kleine letters, spaties worden streepjes (`-`) en gekke tekens verdwijnen.
- De Slug wordt dan: `naruto-shippuden-grote-poster-zwart`.

De uiteindelijke URL op jouw website wordt dus:
`https://jouw-webshop.be/product/naruto-shippuden-grote-poster-zwart`

---

## 3. Waarom gebruiken we Slugs? (De 3 Jury-Redenen)

Als de jury vraagt: *"Waarom gebruik je `product/{slug}` in plaats van gewoon `product/{id}` zoals beginners dat doen?"*

Dit zijn je 3 antwoorden:

### A. SEO (Search Engine Optimization)
"Google is heel dom. Als Google een URL scant die heet `/product/15`, heeft hij géén idee wat je verkoopt op die pagina. Als de URL heet `/product/naruto-shippuden-poster`, leest de robot van Google meteen de kernwoorden 'Naruto' en 'Poster'. Hierdoor komt mijn webshop véél hoger in de Google zoekresultaten!"

### B. User Experience (UX) en Veiligheid
"Als een klant de link kopieert en naar een vriend stuurt op WhatsApp, ziet de vriend al aan de link wat het is voordat hij klikt. Een link met alleen een ID (`/product/8892`) ziet eruit als een onbetrouwbare spam-link."

### C. Concurrentie en Business Intelligence beschermen
"Als ik ID's gebruik, en de klant ziet vandaag `/product/15` staan, en morgen ziet hij `/product/18`, dan weet hij (of een boze concurrent) exact dat ik in 24 uur precies 3 nieuwe producten heb toegevoegd. Met Slugs verberg ik hoeveel producten er in mijn database zitten en hoe snel ze toegevoegd worden, waardoor mijn bedrijfsdata veiliger is."

---

## 4. Hoe zit het dan in de database?
Een slug moet altijd **Uniek** zijn. Er mogen nooit 2 producten met exact dezelfde slug in de database zitten, anders weet de applicatie niet welke van de twee hij moet tonen!
Daarom gebeurt er bij het aanmaken van een product in jouw backend dit in de code:
`$slug = Str::slug($request->name);`
Laravel genereert daar volautomatisch de perfecte SEO-vriendelijke slug, checkt of hij al bestaat, en stopt hem permanent in de database, naast de gewone naam!
