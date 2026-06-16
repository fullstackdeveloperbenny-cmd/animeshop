# Design Patronen (Waarom code zo geschreven is)

De jury zal checken of je zomaar code gekopieerd hebt, of dat je *begrijpt* wat je doet. Gebruik deze buzzwords!

## 1. Form Requests (Validatie)
We hadden validatie (bijv. "Prijs moet een getal zijn", "Titel is verplicht") in de Controllers staan. We hebben dit verplaatst naar losse bestanden zoals `CartAddRequest` en `CheckoutProcessRequest`.
**Jury:** *"Waarom deed je dat?"*
**Jij:** *"Dit heet 'Separation of Concerns'. Een Controller moet alleen 'verkeer regelen'. Als een Request al wordt tegengehouden omdat het formulier fout is ingevuld, hoeft de Controller niet eens wakker te worden. Ook maakt dit de Controller veel korter (Thin Controller)."*

## 2. Het Action Patroon
In plaats van de database acties in de controller uit te voeren, maken we vaak gebruik van classes zoals `ProcessCheckoutAction` of `CreateProductAction`.
**Jury:** *"Waarom een Action class in plaats van de logica in de Controller?"*
**Jij:** *"Herbruikbaarheid! Stel dat we over een jaar een Mobiele App bouwen met een eigen API Controller. Dan hoeven we de complexe code voor het afrekenen niet te kopiëren. We roepen gewoon vanuit de nieuwe API Controller dezelfde `ProcessCheckoutAction` aan. Don't Repeat Yourself (DRY)."*

## 3. Services
Net als Actions, hebben we Services zoals de `SocialAccountService` (voor GitHub login) en de `CartService`.
**Jury:** *"Wat is het verschil?"*
**Jij:** *"Een Action doet doorgaans één hele specifieke taak (bijv. CreateProduct). Een Service is breder en bundelt logica rondom een domein. De `CartService` bevat methodes om iets toe te voegen, te verwijderen, én het totaal te berekenen."*

## 4. Blade Components
Je hebt stukken code zoals de sidebar in `resources/views/components/admin-layout.blade.php` gezet.
**Jury:** *"Waarom gebruik je Components in plaats van @include?"*
**Jij:** *"Laravel Components zijn veel krachtiger dan de oude @include methode. Je kunt er gemakkelijk variabelen (zoals `$newOrdersCount`) en classes aan doorgeven. Het houdt mijn HTML extreem DRY."*
