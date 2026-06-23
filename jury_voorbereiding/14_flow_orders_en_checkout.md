# De Volledige Flow: Orders en Checkout (Stripe)

Dit is het ingewikkeldste (en meest indrukwekkende) stuk van je applicatie. Als je dit goed kunt uitleggen aan de jury, win je ongetwijfeld het respect van een Senior Developer.

## Stap 1: De Winkelwagen Service (`CartService`)
Wanneer een klant iets aan zijn winkelwagen toevoegt, roepen we de `CartService` aan.
**Waar staat het opgeslagen?**
We schrijven dit *niet* naar de database! Dat zou een enorme verspilling van database-ruimte zijn voor mensen die de site direct weer sluiten.
We slaan de winkelwagen op in een **PHP Sessie** (`session()->put()`). Een sessie is een tijdelijk geheugen op de server dat gekoppeld is aan jouw specifieke browser via een onzichtbare cookie. Als je de browser afsluit, kan de winkelwagen na een tijdje verdwijnen (afhankelijk van de configuratie).

## Stap 2: De Checkout (Gegevens Invullen)
Wanneer de klant klaar is om te betalen:
1. Hij surft naar `/checkout`. Dit is beschermd door de `auth` middleware. (Je moet ingelogd zijn).
2. Hij vult zijn Voornaam, Achternaam, Adres, etc in.
3. Hij klikt op "Afrekenen".
4. Het formulier gaat naar de `CheckoutController@process`.
5. Net zoals bij de Mail, gaat dit eerst door een poortwachter: de `CheckoutProcessRequest`. Alleen als het e-mailadres écht een e-mail is, mag hij door.

## Stap 3: De ProcessCheckoutAction (Het Magische Brein)
Hier gebeurt alles tegelijk. Omdat dit extreem belangrijk is, gebruiken we `DB::transaction()`.

**Wat is een DB Transactie?**
Stel je voor dat het opslaan in de database uit 3 stappen bestaat:
1. Maak een `Order` aan (met het adres).
2. Maak 5 `OrderItems` aan voor de 5 manga's in het mandje.
3. Bereken het totaalbedrag.
Wat als de stroom uitvalt tijdens stap 2? Dan heeft de klant wel een bestelling (Order), maar staan zijn producten er niet in. Met een DB Transactie zegt Laravel tegen MySQL: *"Zet het nog niet écht vast. Wacht tot ál mijn commando's klaar zijn. Als er 1 crasht, doe dan alsof er niets is gebeurd (Rollback)."*

**De status is "Pending"**
De bestelling staat nu veilig in de database, maar met de status `pending` (in afwachting). De klant heeft immers nog niet betaald!

## Stap 4: Stripe Checkout (De Bank)
Nadat de order in de database is gezet, maakt de `ProcessCheckoutAction` direct een verbinding met de servers van **Stripe** (via de Stripe API / externe package).
1. We vertellen Stripe: *"Maak een nieuwe betaalsessie aan. De prijs is €50. Het Order-ID uit mijn database is 12."*
2. Stripe geeft ons een linkje (een URL) terug.
3. We sturen de klant (Redirect) vanaf onze webshop naar de website van Stripe.
4. De klant voert op het beveiligde scherm van Stripe zijn Bancontact/Visa gegevens in. Dit is 100% veilig, wij zien nóóit een creditcardnummer in onze database.

## Stap 5: De Terugkeer (Success of Cancel)
Wanneer Stripe de betaling heeft goedgekeurd, stuurt Stripe de klant terug naar onze website. (De `success_url`).
In onze webshop vangen we hem op in `CheckoutController@success`.

Daar doen we het volgende:
1. We pakken de `Order` (Nummer 12) uit de database.
2. We veranderen de status van `pending` naar `paid`.
3. We maken de sessie van de winkelwagen leeg (`CartService->clear()`), want hij heeft immers betaald.
4. We sturen (op de achtergrond) de bevestigingsmail met het overzicht van zijn aankoop.
5. De klant ziet de "Bedankt voor je bestelling" pagina.

*Als de klant bij Stripe op "Annuleren" klikt, keert hij terug naar de `cancel_url`. De winkelwagen blijft vol, en in onze database blijft Order 12 gewoon voor altijd op `pending` staan.*
