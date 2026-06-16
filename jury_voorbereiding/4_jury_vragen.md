# Vragen die de Jury ZEKER gaat stellen (en jouw antwoorden!)

Oefen deze vragen alsof je een interview doet.

---

### Vraag 1: "Waarom heb je gekozen voor Tailwind CSS en niet voor standaard CSS of Bootstrap?"
**Jouw antwoord:**
"Tailwind is een 'utility-first' framework. In plaats van apart heen en weer te switchen tussen mijn HTML en een CSS bestand, kan ik direct in mijn Blade views stijlen toepassen (`flex`, `bg-red-500`, etc). Het zorgt ervoor dat mijn design veel sneller iteratief gebouwd kon worden en het eindresultaat is makkelijk responsive te maken zonder honderden regels custom media-queries te typen."

### Vraag 2: "Wat gebeurt er als je Stripe webhook faalt of als de stroom uitvalt tijdens een betaling?"
**Jouw antwoord:**
"In de `ProcessCheckoutAction` gebruiken we `DB::transaction()`. Dit betekent dat het Order én alle bijbehorende OrderItems eerst succesvol in de database moeten worden weggeschreven voordat Laravel de wijziging écht doorvoert. Bovendien krijgt een order standaard de status `pending`. Pas als we van Stripe het signaal `success` krijgen na de redirect (of via een webhook), zetten we de status op `paid`. Als Stripe faalt, blijft de order `pending` en is er geen geld kwijt of data verloren."

### Vraag 3: "Je hebt een GitHub login gebouwd. Hoe voorkom je dat iemand met hetzelfde mailadres twee accounts krijgt?"
**Jouw antwoord:**
"Ik heb dit opgelost in de `SocialAccountService`. Als iemand inlogt met GitHub, kijkt het script eerst of die specifieke GitHub-ID al bestaat. Zo niet, dan kijkt het of het *e-mailadres* van dat GitHub account al in onze `users` tabel staat. Als dat zo is, koppelen we het nieuwe Social-account aan de *bestaande* gebruiker. Pas als geen van beide bestaat, maken we een compleet nieuwe gebruiker aan. Zo voorkomen we dubbele profielen!"

### Vraag 4: "Hoe heb je voorkomen dat de database te traag wordt bij het inladen van het productoverzicht?"
**Jouw antwoord:**
"Twee dingen: Ten eerste gebruik ik Paginatie (`paginate(12)`). Er worden nooit meer dan 12 producten tegelijk uit de database getrokken. Ten tweede gebruik ik 'Eager Loading' via `Product::with(['category', 'primaryImage'])`. Als ik dit niet deed, zou Laravel het 'N+1 query probleem' krijgen en voor elk van de 12 producten opnieuw een database call doen om de foto op te halen. Nu gebeurt alles in slechts 2 zeer efficiënte queries."

### Vraag 5: "Is je applicatie veilig tegen hackers? (Security)"
**Jouw antwoord:**
"Ja. Laravel beschermt standaard tegen SQL Injection omdat we de ORM (Eloquent) gebruiken in plaats van ruwe SQL. Ook is elk formulier beschermd met `@csrf` (Cross-Site Request Forgery) tokens. Daarnaast gebruiken we de `EnsureUserIsAdmin` middleware om te voorkomen dat een klant die simpelweg `/admin` in de url typt toegang krijgt tot het beheerpaneel. Alle user-input wordt gevalideerd via Form Requests voordat het de database raakt."
