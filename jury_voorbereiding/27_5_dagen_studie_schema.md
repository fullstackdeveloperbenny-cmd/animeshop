# Het 5-Dagen Aanvalsplan 🗓️

Je hebt 5 volledige dagen. Dat is **meer dan genoeg**. Echt waar. Veel studenten beginnen pas 24 uur van tevoren met hun voorbereiding. Omdat we de code al klaar hebben, hoef je alleen nog maar te "begrijpen", niet meer te bouwen. Dat scheelt 90% van de stress.

Als je dit plan volgt (maximaal 2 tot 3 uurtjes per dag, verspreid over de dag), ga je met absolute dominantie die juryruimte binnen.

---

## Dag 1: De Flow en Sneltoetsen (De "Code Navigatie")
**Doel:** Je comfortabel voelen in je editor (VS Code/PhpStorm) zonder theorie te blokken.
- **Lees:** `24_code_navigatie_spiekbriefje.md`
- **Oefening:** Open je website. Klik op de knop "In winkelwagen".
- Gebruik de sneltoets `CTRL + P` om de bestanden in deze exacte volgorde te openen:
  1. `web.php` (Zoek de route)
  2. `CartController.php` (Kijk wat hij doet)
  3. `CartService.php` (Kijk naar de logica)
- **Herhaal dit** voor "Product Toevoegen" (Admin) en "Afrekenen" (Checkout).
- *Sluit je laptop na 2 uurtjes. Je hoeft de code niet van buiten te kennen, alleen de route!*

---

## Dag 2: De Waarom-Vragen (Database & Relaties)
**Doel:** Snappen waarom de tabellen zo gebouwd zijn. De jury is geobsedeerd door databases.
- **Lees:** `17_database_diepgaand.md` en `2_waarom_deze_database.md`.
- **Oefening:** Neem een blaadje papier. Teken een vierkantje met "Product" en een vierkantje met "Variant". Waarom zit de "voorraad" (stock) in de Variant tabel en niet in de Product tabel? (Omdat een T-shirt in maat S en M verschillende voorraden heeft!).
- **De Truc:** Leer uit je hoofd hoe jij de 'Standaard Voorraad' voor manga/beeldjes hebt opgelost (verborgen Variant aanmaken). Dit is je sterkste wapen.

---

## Dag 3: De Bouncer en de Verkeersregelaars (Security & Architectuur)
**Doel:** Tonen dat je applicatie veilig is en gestructureerd.
- **Lees:** `3_design_patronen.md` en de helft van `22_mega_vragenlijst_jury.md` (Categorie 1 en 3).
- **Oefening:** Zorg dat je de volgende 3 woorden vlekkeloos kunt uitleggen in jouw eigen woorden:
  1. **CSRF** (Jouw antwoord: "Een verborgen token in elk formulier om te bewijzen dat het verzoek echt van mijn site komt en niet van een hacker.")
  2. **Middleware** (Jouw antwoord: "De buitenwipper. `EnsureUserIsAdmin` kijkt naar je rol. Geen admin? Dan mag je de backend niet in.")
  3. **Action-patroon** (Jouw antwoord: "Code om een product aan te maken uit de controller halen en in `CreateProductAction` zetten. Zodat controllers 'dun' blijven.")

---

## Dag 4: De Paradepaardjes (Jouw Unieke Features)
**Doel:** De jury imponeren met dingen die je klasgenoten niet (of minder goed) hebben.
- **Lees:** `25_live_search_ajax.md`, `26_javascript_uitleg_app_js.md`, en `23_seo_en_meta_tags.md`.
- **Oefening:** Leer het "Livewire" antwoord uit je hoofd. Als ze vragen waarom je klassieke AJAX gebruikt in plaats van Livewire, zeg je: *"Ik wil laten zien dat ik de kern van Javascript en HTTP begrijp, zonder afhankelijk te zijn van magische pakketten. Plus, het voorkomt de pagination-bug!"*
- Oefen ook hoe je in de code uitlegt dat `window.history.pushState()` de URL updatet.

---

## Dag 5: De Generale Repetitie (Hardop Praten!)
**Doel:** Je spieren trainen in het *praten* over code. Zwijgen is je grootste vijand.
- Doe alsof je moeder, kat of een teddybeer de jury is.
- **Oefening:** Open je website. Zeg hardop: *"Ik ga nu een bestelling plaatsen. Dit is een POST request."*
- Open de code en vertel hardop wat het doet. *"We zien hier de `ProcessCheckoutAction`. Ik heb hier `DB::transaction()` gebruikt zodat de betaling ofwel 100% lukt, ofwel alles wordt teruggedraaid bij een fout. Niemand verliest zo zijn geld."*
- Raak je vast in je uitleg? Zeg hardop de magische zin: *"Ik ken de exacte naam van de functie even niet meer door de zenuwen, maar ik weet dat het in mijn Controller of Service staat."*

---

**Heb vertrouwen.** Na deze 5 dagen droom jij over Controllers en Actions. Je gaat slagen. 🏆
