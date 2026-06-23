# Code Navigatie (Follow the Data) 🗺️

Als de jury vraagt: *"Klik eens op die knop en laat zien waar de code staat"*, raak dan niet in paniek. Gebruik altijd de **4-Stappen Truc**. 

Je hoeft niet van buiten te weten wáár iets staat, zolang je het pad maar volgt:
1. **Waar gaat de klik heen?** (Kijk naar de URL of de `<form action="...">`).
2. **Open `routes/web.php`:** Zoek de URL op en kijk naar welke Controller hij wijst.
3. **Open de Controller:** Zoek de juiste functie (bijv. `store()` of `add()`). Hier wordt de input vaak gevalideerd met een FormRequest.
4. **Open de Action / Service:** Hier staat het échte werk (opslag in de database, mail versturen, etc.).

---

## De 3 Belangrijkste "Knoppen" (Spiekbriefje)

Je kunt onmogelijk alle knoppen uit je hoofd leren. Maar de jury zal 99% zeker één van deze drie kern-functies testen. Hier is het 'spoor' dat je moet volgen in je code:

### 1. De "In Winkelwagen" Knop (Frontend)
*Wanneer de klant op 'In Winkelwagen' klikt op de detailpagina.*
- **Route:** `POST /cart/add`
- **Waar te vinden in `web.php`:** Zoek naar `Route::post('/cart/add', [CartController::class, 'add'])`
- **Controller:** `CartController@add` (Hier zie je dat `CartAddRequest` de input valideert, bijv. checkt of de variant bestaat).
- **Service:** `CartService@add` (Hier wordt het product daadwerkelijk in de PHP Sessie opgeslagen).

### 2. De "Afrekenen (Stripe)" Knop (Frontend)
*Wanneer de klant zijn gegevens invult en op afrekenen klikt.*
- **Route:** `POST /checkout/process`
- **Waar te vinden in `web.php`:** Zoek naar `Route::post('/checkout/process', [CheckoutController::class, 'process'])`
- **Controller:** `CheckoutController@process` (Valideert formulier met `CheckoutProcessRequest`).
- **Action:** `ProcessCheckoutAction` (Dit is een heel belangrijk bestand! Hier zie je de `DB::transaction()`. Hier wordt de order tijdelijk opgeslagen in je database en wordt de link naar de Stripe betaalpagina gemaakt).

### 3. De "Nieuw Product Opslaan" Knop (Backend)
*Wanneer de admin een nieuw product (inclusief varianten en foto's) toevoegt.*
- **Route:** `POST /admin/products`
- **Waar te vinden in `web.php`:** Dit zit verborgen in `Route::resource('products', ProductController::class)`. Een `POST` request naar een resource route gaat standaard naar de `store()` functie.
- **Controller:** `ProductController@store` (Valideert via de extreem lange `StoreProductRequest`).
- **Action:** `CreateProductAction` (Hier zie je hoe het product wordt opgeslagen, hoe de afbeeldingen naar de hardeschijf gaan via `ProductImageService`, én hoe jouw UX-trucje met de 'Standaard Voorraad' werkt als ze geen maten invullen!).

---

**Tip voor de presentatie:**
Druk in je code editor (VS Code / PhpStorm) simpelweg op `CTRL + P` (of `CMD + P`) en typ de naam van het bestand in (bijv. `CartController`). Zo switch je razendsnel tussen bestanden en lijkt het alsof je een echte doorgewinterde hacker bent! 😎
