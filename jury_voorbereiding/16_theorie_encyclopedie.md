# 16. Theorie Encyclopedie (Van Nul Tot Held) 🎓

Dit document is jouw overlevingsgids. Hier leggen we alle tekens, symbolen en termen uit die je in de code tegenkomt. Als je weet wat deze dingen betekenen, lijkt de code opeens op een gewoon leesboek.

## 1. Wat is een `class`?
Een `class` is eigenlijk een **blauwdruk**. Stel je voor dat je auto's wilt bouwen. De `class` is de bouwtekening van de auto (waar moet het stuur, waar zitten de wielen).
```php
class Product { ... }
```
Dit betekent: We maken een blauwdruk voor een "Product". Alles wat in de `{ }` staat, behoort tot deze blauwdruk. Als we later in de code `$product = new Product();` doen, maken we een écht object op basis van die blauwdruk.

## 2. Wat is een Object en wat is een Variabele?
- **Variabele:** Een doosje waar je 1 ding in stopt. Bijvoorbeeld `$naam = "Jan";`. Het doosje heet `$naam` en de inhoud (de *data*) is de string "Jan".
- **Object:** Een grote doos met vakjes en knopjes. Een object heeft eigenschappen (*properties*) en kan dingen doen (*methods*). Bijvoorbeeld: `$product->name` (dit is data) en `$product->save()` (dit is een actie).

## 3. Wat is `public`, `protected` en `private`?
Dit noemen we **Access Modifiers**. Ze bepalen wie er aan de code mag komen.
- `public`: Iedereen mag deze functie of variabele van buitenaf aanroepen of zien. Net als de voordeur van een winkel. Iedereen mag naar binnen.
- `protected`: Alleen de class zélf, en classes die ervan erven (extends), mogen hieraan. Het magazijn van de winkel: alleen het personeel mag erin. We gebruiken dit vaak in Laravel voor dingen als `$fillable`, omdat het framework (Laravel) het magazijn moet kunnen beheren, maar een bezoeker niet.
- `private`: Alléén de class zélf mag er aan. Zelfs kinderen (extends) mogen er niet aan. Een kluis in het kantoor van de baas.

## 4. Wat is de `__construct()` functie?
Dit heet de **Constructor**. Het is een speciale functie die *automatisch* wordt uitgevoerd precies op het moment dat de class (de blauwdruk) tot leven komt (wanneer het een object wordt).
```php
public function __construct(private CartService $cartService) {}
```
Waarom doen we dit? We zeggen hier: *"Hé Laravel, als je dit bestand (bijvoorbeeld de CheckoutController) in het geheugen laadt, geef me dan direct de CartService (het winkelwagentje) mee, want die heb ik nodig."* Dit heet **Dependency Injection**. We 'injecteren' de afhankelijkheden (dependencies) direct in het object via de constructor.

## 5. Wat betekent het vraagteken `?` (Nullable)
Als je een `?` ziet voor een datatype, betekent dit dat de waarde ook `null` (niets/leeg) mag zijn.
```php
public ?string $badge;
```
Dit betekent: de variabele `$badge` moet een stukje tekst (string) zijn, óf hij mag gewoon leeg zijn (`null`). Een product *hoeft* namelijk niet altijd een badge te hebben.

In je database migraties zie je vaak `->nullable()`. Dit betekent exact hetzelfde: deze kolom mag leeg blijven in de database.

## 6. Wat is de dubbele dubbele-punt `::` (Static Methods / Facades)?
Dit zie je heel vaak: `Route::get(...)` of `Product::all()`.
Dit betekent dat we een functie aanroepen óp de blauwdruk zélf, zónder dat we er eerst een object van hebben gemaakt (`new Product()`). We noemen dit een **Static Method**.

In Laravel heet dit vaak een **Facade**. Een Facade (zoals `Mail::` of `Route::` of `DB::`) is eigenlijk een handige 'shortcut' (een voordeur) naar een complex systeem dat op de achtergrond draait. Je hoeft niet de hele postkamer op te starten, je roept gewoon `Mail::to()` aan, en Laravel regelt de rest op de achtergrond.

## 7. Wat zijn Enums (Enumerations)?
In je `app/Enums` map staat `UserRole.php`. Een Enum is een vaste lijst met keuzes.
```php
enum UserRole: string {
    case ADMIN = 'admin';
    case CUSTOMER = 'customer';
}
```
**Waarom gebruiken we dit?** Stel we typen overal in de code `"admin"`. Opeens maken we een typefout: `"adnim"`. De code crasht. Door een Enum te gebruiken (`UserRole::ADMIN->value`), weet je 100% zeker dat er nooit een typefout gemaakt kan worden, want je code-editor zal je waarschuwen als je een Enum gebruikt die niet bestaat. Het maakt je code super veilig.

## 8. Hoe communiceren lagen met elkaar? (Parameters & Arguments)
Wanneer je data doorgeeft van de ene functie naar de andere, doe je dit via de haakjes `()`.
- **Parameter:** De definitie in de functie. Bijv: `public function add($product)` -> `$product` is de parameter.
- **Argument:** De échte data die je er in gooit. Bijv: `$cart->add($huidigProduct)` -> `$huidigProduct` is het argument.

## 9. Wat is de `->` (Object Operator)?
Als we de dubbele punt `::` gebruiken om iets direct op de class te doen, dan gebruiken we de enkele pijl `->` om iets te doen op een specifieke doos (een Object).
- `$product->name`: "Geef me de naam die in de doos $product zit."
- `$product->save()`: "Voer de actie opslaan uit op dit specifieke product doosje."

Neem dit rustig door. Als de jury een bestand opent, kun je nu precies aanwijzen wat de tekens betekenen!

---

## 10. Het "Syntax & Symbolen Spiekbriefje" 🧠

Juryleden wijzen heel graag naar een klein symbooltje in je code om te vragen: *"Wat doet dit tekentje precies?"*. Met dit overzicht ben je ze altijd een stap voor.

### 10.1 De Korte If/Else (Ternary Operator `? :`)
Soms zie je dit in je views of controllers:
`$status = $isAdmin ? 'Ja' : 'Nee';`
Dit is letterlijk een if/else statement, maar dan geplet op één regel.
- **Vraagteken (`?`)** betekent: *"Is dit waar?"* (If)
- **Dubbele punt (`:`)** betekent: *"Anders..."* (Else)
Je leest het dus als: Is hij admin? Zo ja, vul in 'Ja'. Zo nee, vul in 'Nee'.

### 10.2 Wat is `$this->` precies?
In bijna elke Controller zie je `$this->cartService` of `$this->validate()`.
`$this` is het Engelse woord voor "dit". Het betekent letterlijk: **Ikzelf**.
Als een Product zegt `$this->name`, zegt het product eigenlijk *"Mijn eigen naam"*. Omdat we met blauwdrukken (Classes) werken, weten we vooraf niet hoe het object in de toekomst gaat heten. Door `$this->` te gebruiken, weet het object áltijd dat hij tegen zichzelf praat, ongeacht hoe we hem noemen in de code.

### 10.3 De Null Safe Operator (`?->`)
In Blade zie je soms: `{{ auth()->user()?->name }}`.
Waarom staat er ineens een vraagtekentje voor de pijl?
Normaal gesproken, als we de naam vragen van een bezoeker die **niet is ingelogd** (dus de user is `null`), dan crasht PHP gigantisch met een "Trying to get property of non-object" error. 
Dat vraagtekentje is een soort airbag. Het zegt: *"Vraag de naam op, MAAR alleen als de bezoeker bestaat. Als hij niet bestaat (null is), crash dan niet, maar doe gewoon alsof je niks gezien hebt."*

### 10.4 Laravel Helpers (`bcrypt()`, `compact()`, `dd()`)
Dit zijn handige gereedschapjes (functies) die Laravel standaard meegeeft. Ze hangen niet vast aan een Class (daarom hoef je geen `->` of `::` te gebruiken).
- **`bcrypt($wachtwoord)`**: Dit versleutelt een wachtwoord (hashing). Je code gooit het wachtwoord in de blender, zodat hackers in je database nooit "wachtwoord123" zien staan, maar een onleesbare reeks tekens.
- **`compact('product')`**: Dit is een snelle manier om variabelen naar je Blade-view te sturen. Het is exact hetzelfde als `['product' => $product]`. Het pakt gewoon de variabele in een doosje in.
- **`dd($variabele)`**: Dump & Die. Dit is je beste vriend tijdens het troubleshooten. Het gooit de inhoud van de variabele op je scherm en stopt de applicatie onmiddellijk (Die). 

### 10.5 Eloquent Eager Loading (`with()`)
In je ShopController typte je `Product::with('category')->get()`.
**Dit is een klassieke jury-vraag!** Waarom gebruiken we `with()`?
Als we dat niet doen, haalt Laravel eerst 10 producten uit de database (1 query). Daarna gaat Laravel voor élk product de categorie ophalen (nog eens 10 queries). Totaal: 11 queries. Dit heet het **N+1 Probleem**.
Door `with('category')` te gebruiken (wat we 'Eager Loading' noemen), vertel je Laravel: *"Haal de producten op, en pak in diezélfde database-trip direct alle bijbehorende categorieën mee."* Hierdoor heb je maar 2 queries nodig in plaats van 11. Je webshop wordt hierdoor bliksemsnel.

### 10.6 Arrow Functions (`fn() =>`)
Soms zie je een stukje code met een pijl erin (niet de `->` maar echt `=>`).
Bijvoorbeeld bij de `DB::transaction(fn() => ... )`.
Dit is gewoon een **snelle manier om een functie te schrijven** zonder het woordje `function` of `return` te hoeven typen. Het betekent exact hetzelfde, het is gewoon om je code compacter en leesbaarder te houden.
