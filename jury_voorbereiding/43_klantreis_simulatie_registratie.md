# Klantreis Simulatie 1: De Registratie (RegisteredUserController)

Als de jury vraagt: *"Wat gebeurt er onder de motorkap als een nieuwe klant op 'Registreren' klikt?"*, dan is dit jouw spiekbriefje. Je vertelt dit als een treinreis: van de route, naar het filteren (validatie), naar de kluis (database), tot aan het slot (inloggen).

## Het Bestand: `app/Http/Controllers/Auth/RegisteredUserController.php`

### Deel 1: Het formulier tonen op het scherm
```php
public function create(): View
{
    return view('auth.register');
}
```
Als iemand in zijn browser naar `/register` surft, doet deze functie maar 1 ding: hij tekent het HTML formulier op het scherm. Het woordje `: View` vertelt aan PHP: *"Ik ga 100% zeker een HTML pagina teruggeven"*.

---

### Deel 2: Het formulier ontvangen
```php
public function store(Request $request): RedirectResponse
```
Zodra de klant in het HTML formulier op "Verzenden" klikt, komt álle data (naam, email, wachtwoord) binnen via de `$request` variabele. Het woordje `: RedirectResponse` vertelt aan PHP: *"Als ik helemaal klaar ben met deze functie, stuur ik de klant direct door naar een andere URL"*.

---

### Deel 3: De Uitsmijter (Validatie)
```php
$request->validate([
    'name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
    'password' => ['required', 'confirmed', Rules\Password::defaults()],
]);
```
Hier controleer je of de klant niet probeert te frauderen. De belangrijkste termen voor de jury:
- **`'unique:'.User::class`**: Dit checkt direct in de database-tabel `users` of dit e-mailadres niet al bestaat. Zo voorkom je dubbele accounts.
- **`'confirmed'`**: Laravel kijkt automatisch of de klant het veldje `password_confirmation` (Wachtwoord herhalen) exact hetzelfde heeft getypt als het originele wachtwoord.
- **`Rules\Password::defaults()`**: Hier laadt Laravel zijn eigen standaard veiligheidseisen in voor een wachtwoord (bijv. minimaal 8 tekens, kleine letter, hoofdletter).

---

### Deel 4: Opslaan in de database (De Kluis)
```php
$user = User::create([
    'name' => $request->name,
    'email' => $request->email,
    'password' => Hash::make($request->password),
]);
```
Dit is **Mass Assignment** (het wegschrijven naar de database).
Het belangrijkste woord hier is `Hash::make()`. Dit neemt het wachtwoord "Welkom123" van de klant, gooit het door de Bcrypt-wiskundemolen, en maakt er een veilige, onleesbare code van (`$2y$10...`) voordat het de MySQL database in gaat. We slaan wachtwoorden nóóit als platte tekst op!

---

### Deel 5: De Magie (De Megafoon)
```php
event(new Registered($user));
```
Dit is een **Event Dispatcher**. Vertaald: de code schreeuwt hier door een megafoon naar de rest van de applicatie: *"ATTENTIE IEDEREEN: We hebben een nieuwe gebruiker!"*. 
Op de achtergrond luisteren 'Listeners' hiernaar. Als een luisteraar dit hoort, zal hij bijvoorbeeld direct een Welkomst-mailtje of verificatie-link naar de klant sturen. Zo koppel je het e-mailsysteem los van je logica.

---

### Deel 6: Inloggen & Doorsturen
```php
Auth::login($user);
return redirect(route('shop.index', absolute: false));
```
- **`Auth::login`**: De klant zit in de database, dus loggen we hem direct in (het Cookie wordt gezet, de Sessie start) zodat hij niet wéér handmatig hoeft in te loggen.
- **`redirect`**: We pakken de bezoeker op en sturen hem terug naar de webshop. `absolute: false` betekent dat Laravel een schone, relatieve URL maakt (`/shop` in plaats van `https://jouwwebsite.be/shop`).
