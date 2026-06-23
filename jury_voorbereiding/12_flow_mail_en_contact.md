# De Volledige Flow: E-mail en Contactformulieren

Je wilde exact weten hoe de routes lopen, en dit is een perfect onderwerp voor de jury. We gaan stap voor stap een e-mail versturen (zoals het contactformulier).

## Stap 1: De Route (`routes/web.php`)
Alles begint als de bezoeker naar `/contact` surft of op de "Verzenden" knop klikt.
In `web.php` staat:
```php
Route::get('/contact', 'contact')->name('contact'); // Toont de HTML pagina
Route::post('/contact', 'sendContactMessage')->name('contact.send'); // Ontvangt de data
```
Zodra de bezoeker op de submit-knop klikt, weet Laravel: "Aha, een POST-verzoek naar `/contact`. Ik moet de functie `sendContactMessage` in de `PageController` aanroepen."

## Stap 2: Validatie via een Form Request
In de `PageController` vangen we de data niet zomaar blind op.
```php
public function sendContactMessage(\App\Http\Requests\Shop\ContactMessageRequest $request)
```
Voordat de Controller überhaupt de e-mail mag sturen, zegt Laravel: *"Wacht even, ga eerst door de `ContactMessageRequest`."*
In dat bestand staat dat `email` een echt e-mailadres moet zijn, en `name` niet leeg mag zijn. Als de bezoeker het fout heeft ingevuld, weigert Laravel de aanvraag en stuurt de bezoeker terug met rode foutmeldingen.

## Stap 3: De Controller triggert de Mail Facade
Als alles veilig is, gaat de `PageController` aan het werk:
```php
Mail::to(config('mail.from.address'))->send(
    new \App\Mail\ContactMessageMail($validated['name'], $validated['email'], $validated['message'])
);
```
- We pakken de gevalideerde data (`$validated['name']`).
- We maken een nieuw E-mail object aan: `new ContactMessageMail()`. We geven de data hierin mee (via de *Constructor*).
- We gebruiken de `Mail` facade van Laravel om hem via SMTP (de postbode) te versturen naar de beheerder.

## Stap 4: Het Mailable Bestand (`app/Mail/ContactMessageMail.php`)
Nu zitten we in het bestand waar je de originele vraag over stelde. Hier wordt de envelop dichtgelijkt.
1. **`__construct()`:** Neemt de data (Naam, email, bericht) in ontvangst die de Controller zojuist gaf, en slaat ze op in variabelen (`$this->name = $name`).
2. **`envelope()`:** De envelop van de brief.
   ```php
   return new Envelope(
       replyTo: [$this->email], // Zodat je direct op 'Beantwoorden' kunt klikken in je mailbox!
       subject: 'Nieuw Bericht via AnimeShop',
   );
   ```
3. **`content()`:** Welk papier gebruiken we in de envelop?
   ```php
   return new Content(
       view: 'emails.contact', // Verwijst naar resources/views/emails/contact.blade.php
       with: ['name' => $this->name, 'messageContent' => $this->messageContent] // Geeft variabelen door
   );
   ```

## Stap 5: De Blade View (Het design van de brief)
Uiteindelijk opent Laravel `resources/views/emails/contact.blade.php`.
Daar staat HTML code. Laravel vervangt `{{ $name }}` door de naam die we hebben doorgegeven. Deze uiteindelijke HTML code wordt in een e-mailpakketje gestopt en via het internet (via een SMTP server) naar de beheerder verstuurd.

## Samenvatting van de flow (Om letterlijk tegen de jury te zeggen)
*"Als een gebruiker een bericht stuurt, gaat de POST request naar de Route in `web.php`. Die route roept een Controller aan. De Controller gebruikt een specifieke FormRequest om te voorkomen dat er hackers met slechte data binnenkomen. Als alles klopt, roept de Controller de Laravel `Mail` Facade aan. Deze Facade leest de instructies uit mijn Mailable class (zoals het onderwerp) en voegt de HTML uit mijn Blade View samen tot één geheel, waarna het pakketje via SMTP wordt verstuurd."*
