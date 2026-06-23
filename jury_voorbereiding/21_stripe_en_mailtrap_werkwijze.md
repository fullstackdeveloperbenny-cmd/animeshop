# 21. Achter de Schermen: Stripe Betalingen & Mailtrap 💳✉️

Een van de meest complexe delen van een webshop is het afrekenen. De jury zal waarschijnlijk vragen hoe dit veilig gebeurt en hoe we testen of e-mails verzonden worden zonder daadwerkelijk klanten te spammen. Hier is de chronologische uitleg van onze "Checkout Flow".

## 1. Stripe (De Betalingsprovider)

### Waarom Stripe?
Stripe is de industriestandaard voor betalingen. Als we zélf creditcardgegevens of iDEAL-gegevens zouden opslaan in onze database, zouden we moeten voldoen aan extreem strenge veiligheidswetten (PCI compliance). Door Stripe te gebruiken, raakt betaalinformatie nooit onze server. Stripe regelt de veiligheid.

### Waar staat de code?
De hoofdlogica staat in: `app/Actions/Orders/ProcessCheckoutAction.php`

### Hoe werkt het? (De Chronologische Volgorde)

1. **De Klant klikt op "Afrekenen"**
   - De aanvraag komt binnen in `CheckoutController.php` bij de methode `process()`.
   - Hier valideren we eerst de ingevulde gegevens (naam, adres).

2. **We maken een "Pending" Order (De Snapshot)**
   - In de `ProcessCheckoutAction` maken we *eerst* een bestelling aan in onze database met de status `pending` (in afwachting). 
   - **Waarom in deze volgorde?** We maken de bestelling aan *vóórdat* er betaald is. Mocht de klant de betaling annuleren of zijn browser crashen bij Stripe, dan weten we tenminste dat de bestelling bestond (zo zien we "verlaten winkelwagens" in ons systeem). We slaan in `order_items` de actuele prijs van dat moment op (een snapshot). Dit gebeurt in een `DB::transaction`, wat betekent: áls de database ergens halverwege crasht, draait hij alles netjes terug.

3. **We praten met de Stripe API**
   - In diezelfde Action vertalen we onze winkelwagen naar een formaat dat Stripe begrijpt (de `line_items`).
   - *Let op:* Stripe rekent in **centen**! Daarom zie je in de code `(int) round($item['unit_price'] * 100)`. Een T-shirt van €20.00 wordt naar Stripe gestuurd als 2000.
   - We geven Stripe ook een `success_url` en een `cancel_url` mee. Zo weet Stripe precies naar welke pagina van ónze website de klant teruggestuurd moet worden na de betaling.
   
4. **De Doorverwijzing (Redirect)**
   - De actie retourneert een lange Stripe-URL. Onze Controller stuurt de klant door naar die URL (de veilige betaalpagina van Stripe).

---

## 2. Na Betaling & Mailtrap (E-mails Testen)

Zodra de klant betaalt op de Stripe pagina, stuurt Stripe hem terug naar onze `success_url`. Deze route komt uit in `CheckoutController.php` bij de methode `success()`.

### Hoe verwerken we het succes?
1. We controleren of de bestelling op `pending` staat.
2. We updaten de status in de database naar `paid`.
3. We verminderen de voorraad (stock) van de producten.
4. We maken de winkelwagen-sessie leeg.
5. **We versturen de bevestigingsmail!**

### Hoe werkt de Mail-code?
In de Controller staat deze ene simpele regel:
```php
Mail::to($order->email)->send(new OrderPaidMail($order));
```
- We geven het `Order` object mee aan een nieuwe `OrderPaidMail` class (deze staat in `app/Mail/OrderPaidMail.php`). 
- Deze Mail class koppelt de gegevens aan een mooie Blade template in `resources/views/emails/order_paid.blade.php`.

### Waarom Mailtrap?
Tijdens het ontwikkelen van een applicatie wil je niet dat echte mensen test-emails krijgen, of dat je eigen mailbox overstroomt met honderden testberichten. Mailtrap is een "Fake SMTP Server". Het vangt álle e-mails op die jouw applicatie verstuurt, zodat jij ze in een veilig dashboard kunt bekijken, zonder dat ze ooit het échte internet op gaan.

### Waar configureer je Mailtrap?
Dit staat in ons `.env` bestand, de configuratie-kluis van Laravel.
```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=jouw_mailtrap_username
MAIL_PASSWORD=jouw_mailtrap_password
```
Omdat Laravel zo slim is, kijkt de `Mail::to()` functie op de achtergrond naar dit `.env` bestand. Laravel ziet daar Mailtrap staan en stuurt de mail automatisch daarheen in plaats van naar een echte Gmail- of Outlook-server.

### Conclusie voor de jury
De flow is veilig en logisch opgebouwd:
1. Sla op wat de klant *wilt* kopen (Pending Order).
2. Laat Stripe het gevaarlijke werk doen (Betaalverwerking).
3. Vang de klant weer op na succes en voer de belofte uit (Voorraad updaten, Mailtrap mail sturen).
