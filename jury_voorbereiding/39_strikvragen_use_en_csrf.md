# De 'Gemene' Terminologie Vragen (use & CSRF) 🕵️‍♂️

Tijdens een informeel gesprek met de jury kwamen deze twee extreem specifieke theorievragen naar boven. Ze testen hiermee of je écht de definities van PHP kent. Hier is je waterdichte uitleg.

---

## 1. Wat betekent het woordje `use`? (De 2 betekenissen!)

In PHP heeft het woordje `use` **twee compleet verschillende betekenissen**, afhankelijk van WAAR het staat in je bestand. Dit is de ultieme instinkvraag!

### A. De `use` Helemaal Bovenaan (Namespace Import)
Kijk bovenaan in bijna elk bestand, vóórdat de class begint:
```php
namespace App\Http\Controllers;

use App\Models\Product; // <-- DEZE USE
use Illuminate\Http\Request;

class ShopController extends Controller { ... }
```
- **Wat is dit?** Dit is een **Namespace Import**. 
- **Jury Uitleg:** *"Omdat Laravel duizenden bestanden heeft, moet ik PHP precies vertellen waar hij de bestanden kan vinden. Door bovenaan `use App\Models\Product;` te typen, importeer ik het adres van het Product model in dit bestand. Doe ik dit niet, dan crasht PHP met de fout 'Class not found'."*

### B. De `use` Binnenin de Class (De Trait)
Kijk nu naar je `Product.php` model, BINNEN de accolades van de class:
```php
class Product extends Model
{
    use SoftDeletes; // <-- DEZE USE
```
- **Wat is dit?** Dit is het aanroepen van een **Trait**.
- **Jury Uitleg:** *"In PHP kan een class maar van 1 "vader" afstammen (Single Inheritance). Mijn Product stamt af van `Model`. Maar wat nou als ik herbruikbare code wil toevoegen, zoals de prullenbak-functionaliteit (SoftDeletes)? Daarvoor gebruik ik een **Trait**. Door `use SoftDeletes;` te typen binnen de class, "kopieer en plak" ik als het ware een hele set extra functies in mijn Product, zonder de afstamming te verbreken."*

---

## 2. Wat is `@csrf` en waar staat het voor?

Je wist al heel goed dat `@csrf` je formulieren beschermt. Maar wat betekent de afkorting en hoe werkt het?

- **De volledige naam:** CSRF staat voor **Cross-Site Request Forgery** (spreek uit: *Kros-Sait Riekwest For-dzjur-rie*). 
- **De letterlijke vertaling:** Het "Vervalsen van een verzoek via een andere website".

### Hoe leg je de hack uit aan de jury?
*"Stel, een admin van mijn webshop is ingelogd op zijn account. Hij bezoekt per ongeluk een malafide website van een hacker. Op die website heeft de hacker een onzichtbaar formuliertje geplaatst dat automatisch een verzoek stuurt naar `mijn-webshop.test/admin/product/1/delete`. Omdat de admin is ingelogd, zou de browser dat zomaar uitvoeren en het product wissen!"*

### Hoe stopt `@csrf` dit?
*"Elke keer als iemand mijn website opent, genereert Laravel een uniek, geheim wachtwoord (de CSRF token) voor die specifieke sessie. Als ik `@csrf` in mijn HTML formulier zet, plakt hij dat geheime wachtwoord als een onzichtbaar veldje (`<input type="hidden">`) in het formulier. 

Als het formulier wordt verstuurd (POST, PATCH of DELETE), controleert Laravel: **"Klopt deze geheime token met de sessie?"** 
De hacker op de andere website weet dit unieke, willekeurige wachtwoord niet! Daardoor zal het onzichtbare nep-formulier van de hacker áltijd geweigerd worden met een '419 Page Expired' foutmelding. Cross-Site Request Forgery is daarmee onmogelijk gemaakt."*
