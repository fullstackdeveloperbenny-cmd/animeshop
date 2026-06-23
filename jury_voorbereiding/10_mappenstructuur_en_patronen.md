# De Laravel Mappenstructuur en Design Patronen (Uitgelegd voor de Jury)

In dit document leggen we exact uit waarom we de code verdeeld hebben over specifieke mappen. Een beginnende developer stopt alle code in één enorm `Controller` bestand. Wij hebben de code opgesplitst (Separation of Concerns). Hier is waarom:

## 1. De `app/Models/` map (Data)
*Voorbeelden: `Product.php`, `User.php`, `Order.php`*
- **Wat is het?** Een Model is de representatie van één rij in je database tabel.
- **Waarom hier?** Zodat we niet overal in onze applicatie SQL queries hoeven te schrijven. Als we een product willen aanpassen, praten we tegen het Model: `$product->update(...)`.
- **Relaties:** In de modellen leggen we relaties vast. `public function variants()` in `Product.php` vertelt Laravel dat 1 product meerdere varianten heeft (One-to-Many).

## 2. De `app/Http/Controllers/` map (Verkeersleiders)
*Voorbeelden: `ShopController.php`, `CheckoutController.php`*
- **Wat is het?** De controller is de "verkeersregelaar" van je webshop.
- **Wat doet hij?** Hij vangt het verzoek van de bezoeker op (via een Route in `web.php`), hij roept een Model of Action aan om data te halen, en hij stuurt die data naar een View (`.blade.php`).
- **Waarom mag hij niet te groot zijn?** We houden controllers "Thin" (dun). Een controller hoort niet te berekenen hoe een Stripe sessie werkt; dat doet een *Action* of *Service*.

## 3. De `app/Actions/` map (De "Werkpaarden")
*Voorbeelden: `CreateProductAction.php`, `ProcessCheckoutAction.php`*
- **Wat is het?** Een class die letterlijk maar **één specifieke actie** uitvoert.
- **Waarom hebben we deze map gemaakt?** Het verwerken van een checkout is complex: we moeten order items aanmaken, voorraad checken, en een Stripe link genereren. Als we dit in de `CheckoutController` doen, wordt die controller 500 regels lang. Door dit in een `Action` te steken, houden we de code herbruikbaar en de controller klein.
- **Encapsulation (Inkapseling):** Dit is een belangrijke programmeer-term! Het betekent dat we de ingewikkelde details (hoe we opslaan in de database) "verbergen" in de Action class. De Controller roept gewoon `process($request)` aan en hoeft niet te weten hóe het werkt, zolang het maar werkt.

## 4. De `app/Enums/` map (Vaste Waarden)
*Voorbeeld: `UserRole.php`, `OrderStatus.php`*
- **Wat is het?** Een Enum (Enumeration) is een lijst met vooraf gedefinieerde, vaste waardes.
- **Waarom gebruiken?** In de database slaan we de rol van een gebruiker op als een string, bijvoorbeeld `"admin"`. Maar als we overal in onze code `"admin"` typen, maken we snel een typfout (bijv `"admn"`). Door een Enum te gebruiken, typen we `UserRole::ADMIN->value`. Als we een typfout maken, gooit PHP direct een foutmelding voordat de website live gaat. Het voorkomt "Magic Strings".

## 5. De `app/Http/Middleware/` map (De Poortwachters)
*Voorbeeld: `EnsureUserIsAdmin.php`*
- **Wat is het?** Een beveiligingslaag waar een bezoeker doorheen moet vóórdat hij bij de Controller komt.
- **Hoe werkt het?** Als een normale klant naar `/admin/products` surft, springt de middleware ertussen: *"Ho stop, ben jij wel admin?"*. Zo niet, dan breekt hij het verzoek af met een Error 403 (Forbidden) of een redirect.

## 6. De `app/Mail/` map (E-mails sturen)
*Voorbeeld: `ContactMessageMail.php`*
- **Wat is het?** Een "Mailable" class van Laravel die bepaalt naar wie de mail gaat, wat het onderwerp (Envelope) is, en welke HTML template (Content) gebruikt wordt.
- *(We gaan hier veel dieper op in tijdens het `12_flow_mail_en_contact.md` document!)*

## 7. De `app/Providers/` map (De Startkabels)
*Voorbeeld: `AppServiceProvider.php`*
- **Wat is het?** Providers zijn de "startkabels" van Laravel. Als Laravel opstart, worden alle bestanden hierin geladen vóórdat er überhaupt een pagina wordt getoond.
- **Wat doen we ermee?** In dit project hebben we hier een `View::composer` aan toegevoegd. Dit zorgt ervoor dat *elke keer* als het admin-paneel wordt geladen, Laravel automatisch telt hoeveel nieuwe ('paid') bestellingen er zijn (`$newOrdersCount`). Zo konden we dat rode notificatie-belletje in de zijbalk maken zonder die database-query in elke losse controller te hoeven herhalen (DRY principe)!

## 8. De `app/Services/` map (Logica Groepen)
*Voorbeeld: `CartService.php`, `SocialAccountService.php`*
- **Wat is het verschil met een Action?** Een Action doet maar 1 ding (`CreateProduct`). Een Service is een groepje functies rondom 1 onderwerp.
- **Voorbeeld:** De `CartService` regelt alles rondom de winkelwagen: `add()`, `remove()`, `getTotal()`. Het is een herbruikbare gereedschapskist.

## Samenvatting voor de Jury:
**Jury:** *"Waarom is jouw code zo verdeeld over al deze mappen?"*
**Jij:** *"Om mijn applicatie onderhoudbaar en schaalbaar te houden. Door het principe van 'Separation of Concerns' heeft elk bestand maar één verantwoordelijkheid. De Controller regelt het verkeer, de Action doet de complexe berekeningen, het Model praat met de database en de Enum beveiligt mijn vaste waardes. Dat heet Object-Oriented Programming (OOP) volgens de best practices."*
