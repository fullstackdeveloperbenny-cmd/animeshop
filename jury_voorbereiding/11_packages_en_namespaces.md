# Packages, Namespaces en "Uses" Uitgelegd

Dit is een van de moeilijkste onderwerpen voor beginners om uit te leggen, maar na dit document snap je het!

## 1. Wat betekent `namespace App\Mail;`?
Helemaal bovenaan je bestanden zie je `namespace ...` staan.
**Juryvraag:** *"Wat doet een namespace?"*
**Jouw antwoord:** *"Stel je voor dat je op een feestje bent en je roept: 'Hey Jeroen!'. Er kijken ineens vier mensen om, want ze heten allemaal Jeroen. Hoe los je dat op? Je gebruikt hun achternaam: 'Hey Jeroen Peeters!'. In Laravel gebeurt exact hetzelfde. We hebben vaak bestanden die een simpele naam hebben, zoals `User` of `Controller`. Als een extern pakketje (zoals Stripe) óók een bestand meebrengt dat `User` heet, raakt PHP in de war en crasht de boel. Een 'namespace' is eigenlijk de **achternaam** van een bestand. Door bovenaan `namespace App\Models;` te zetten, vertel je PHP: de officiële, volledige naam van dit bestand is vanaf nu `App\Models\User`. Zo kunnen er oneindig veel bestanden met dezelfde voornaam bestaan, zonder dat ze met elkaar botsen!"*

## 2. Wat betekenen al die `use ...` regels?
*(Bijvoorbeeld: `use Illuminate\Bus\Queueable;` of `use App\Models\Product;`)*
**Wat is het?** Als jij in jouw `ShopController` het woord `Product` typt, weet PHP niet wat een Product is. Met het woordje `use` **importeer** je dat bestand. Je vertelt PHP eigenlijk: *"Als ik in dit document over 'Product' praat, bedoel ik het bestand dat op het adres `App\Models\Product` woont."*

## 3. Voorbeelden van "Uses" in jouw `ContactMessageMail.php`
Je vroeg me specifiek naar de code in je Mail bestand. Laten we ze lijn per lijn uitleggen:

- `use Illuminate\Bus\Queueable;`
  - **Wat is het?** Een Trait (zie encyclopedie).
  - **Wat doet het?** Mails versturen duurt vaak 1 à 2 seconden. We willen niet dat onze bezoeker naar een ladend scherm staart. `Queueable` zorgt ervoor dat we deze mail op de achtergrond kunnen zetten in een "Wachtrij" (Queue). Laravel stuurt hem dan pas als hij even tijd heeft, terwijl de bezoeker direct de "Bedankt!" pagina ziet.

- `use Illuminate\Mail\Mailable;`
  - **Wat is het?** De basis-klasse voor álle emails in Laravel.
  - **Wat doet het?** Jouw `ContactMessageMail` "erft" (`extends Mailable`) al zijn krachten van deze klasse. Jouw class hoeft dus zelf niet uit te vinden hoe een SMTP-server of internet-protocol werkt; `Mailable` heeft die code al in zich.

- `use Illuminate\Mail\Mailables\Envelope;`
  - **Wat is het?** Het letterlijke "Envelopje" van de email.
  - **Wat doet het?** In deze functie (verder in het bestand) definieer je wie de afzender is en wat het *Onderwerp* (Subject) is van de mail.

- `use Illuminate\Mail\Mailables\Content;`
  - **Wat is het?** De "Inhoud" van de email.
  - **Wat doet het?** Hier vertel je Laravel welke Blade-view (bijv. `emails.contact`) hij moet gebruiken om de tekst en het design van de mail te renderen.

- `use Illuminate\Queue\SerializesModels;`
  - **Wat is het?** Een Trait voor databeheer.
  - **Wat doet het?** Als we een Model (zoals een hele `User`) meegeven aan de email en we zetten hem op de achtergrond, zou dat te veel geheugen kosten. `SerializesModels` pakt dat gigantische User-model, verplettert het tot alleen een ID-nummertje, en pakt het later weer uit als de mail echt verstuurd wordt. Extreem slim!

## 4. Geïnstalleerde Packages (Libraries)
**Juryvraag:** *"Welke externe libraries (packages) heb je gebruikt en waarom?"*
**Jouw antwoord:** *"In plaats van het wiel zelf opnieuw uit te vinden, heb ik professionele packages gebruikt via Composer (de package manager van PHP):"*

1. **Laravel Breeze (Blade):**
   - *Waarom?* Dit gaf me direct een veilig, door de community getest authenticatie-systeem (Login, Registratie, Wachtwoord vergeten). Dat zelf bouwen is zéér onveilig.

3. **Stripe PHP (`stripe/stripe-php`):**
   - *Waarom?* De officiële package van betaalprovider Stripe. Hiermee praten we via de API met hun servers om veilige Checkout Sessies op te zetten.
4. **Intervention Image (`intervention/image`):**
   - *Waarom?* Een geweldige package om foto's bij te snijden (resizen). Als een admin een gigantische foto van 5MB uploadt, kan deze package hem omzetten en kleiner maken (WebP) zodat de webshop snel blijft.
5. **Tailwind CSS (Frontend via npm):**
   - *Waarom?* Een CSS framework dat via "utility-classes" werkt. Hiermee kon ik razendsnel dit dark-mode design bouwen zonder constant tussen HTML en CSS bestanden te moeten wisselen.
