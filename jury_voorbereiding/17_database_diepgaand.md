# 17. Database Architectuur & Relaties (Deep Dive) 🗄️

De database is het hart van je applicatie. Een slechte database zorgt voor spaghetti-code. Wij hebben gekozen voor een **Extreem Genormaliseerde en Schaalbare Database**. Als de jury vraagt: *"Waarom heb je dit zo gebouwd?"*, is dit je spiekbriefje.

## 1. Waarom een `parent_id` in Categories (Adjacency List)?
Een veelgestelde juryvraag is: *"Waarom heb je geen aparte tabel `sub_categories` gemaakt?"*

**Jouw antwoord:** 
"Als ik een tabel `categories` en een tabel `sub_categories` maak, zit ik muurvast aan precies 2 niveaus. Wat als we later beslissen om nog een niveau toe te voegen? (Bijv. Kleding -> Truien -> Hoodies -> Met Rits). Dan moet ik een `sub_sub_categories` tabel maken. Dat is vreselijk voor onderhoud."

"Door een `parent_id` (een zogenaamde *Self-referencing Foreign Key* of *Adjacency List*) te gebruiken in dezelfde `categories` tabel, kan een categorie wijzen naar een andere categorie als zijn 'ouder' (parent). Hierdoor kan de boomstructuur **oneindig diep** worden zonder dat het database-schema hoeft te veranderen. Dit bewijst dat de applicatie schaalbaar (future-proof) is gebouwd."

## 2. De Relatie: Products en Variants (Waarom een aparte tabel?)
Nog een belangrijke: *"Waarom staat de prijs en de stock niet gewoon in de `products` tabel?"*

**Jouw antwoord:**
"Omdat we met Anime kleding werken. Eén T-shirt (het product) bestaat in 5 maten (S, M, L, XL, XXL). Als ik de voorraad (stock) in de `products` tabel zet, hoeveel voorraad is er dan? Kan ik dan 10 S'jes en 2 L'etjes hebben? Nee."

"We maken gebruik van een **One-to-Many (1:N)** relatie. Eén product (`products` tabel) heeft meerdere varianten (`variants` tabel). 
De `products` tabel bewaart de algemene data (Naam, Beschrijving, Basisprijs).
De `variants` tabel bewaart de specifieke data per maat of type (Stock, Extra prijs). Hierdoor weten we exact dat er nog 3 T-shirts in maat M op voorraad zijn, en 0 in maat S."

## 3. Orders en Order Items (Waarom een Tussentabel?)
*"Hoe sla je op wat iemand gekocht heeft?"*

**Jouw antwoord:**
"Dit gebeurt via een **One-to-Many (1:N)** relatie tussen `orders` en `order_items`."
- `orders`: De kassabon. Wie is de klant, wat is het totaalbedrag, is er betaald, en naar welk adres gaat het?
- `order_items`: De regeltjes op de kassabon. Wat is er gekocht, hoeveel stuks, welke variant (maat), en wat was de prijs *op dat moment*?

**Cruciale Jury Kennis:** Waarom slaan we de eenheidsprijs (`unit_price`) nog eens apart op in `order_items`, terwijl de prijs al in `products` staat?
"Stel dat ik vandaag een T-shirt verkoop voor €20. Volgende week verhoog ik de prijs naar €30 in de `products` tabel. Als ik op mijn oude factuur van vandaag kijk en de prijs uit de `products` tabel haal, lijkt het alsof de klant €30 heeft betaald. Dat is fraude! Daarom slaan we de prijs *vast* in `order_items` op het exacte moment van de aankoop (een snapshot)."

## 4. CASCADE on Delete vs SoftDeletes (De Airbag)
*"Waarom gebruik je SoftDeletes (een prullenbak) voor Categorieën en Producten? Kon je ze niet gewoon direct uit de database verwijderen?"*

**Jouw antwoord:**
"Nee, dat zou levensgevaarlijk zijn! In mijn database migraties (zoals `create_products_table`) heb ik `cascadeOnDelete()` ingesteld. Dit is een hard commando aan de MySQL database: *'Als de ouder (Categorie) wordt verwijderd, vernietig dan onmiddellijk alle kinderen (Producten) die eraan vast hangen'*. 
Als ik geen SoftDeletes had, en een beheerder gooit per ongeluk de categorie 'Kleding' weg, dan wist de database in één milliseconde de halve voorraad van mijn webshop, wat er weer voor zorgt dat bestelgeschiedenissen van klanten crashen! Door `SoftDeletes` te gebruiken (waarbij we ze in een CMS prullenbak zetten), blokkeren we de database-vernietiging en beschermen we de historische integriteit van de webshop. Het is letterlijk mijn airbag."

## 5. De Users Tabel
"We gebruiken de standaard Laravel users tabel, maar we hebben een **Role-Based Access Control (RBAC)** toegevoegd via de kolom `role` (gekoppeld aan een Enum in de code: `admin` of `customer`). Dit is veel lichter en sneller dan een complete package zoals Spatie Permission installeren voor een simpel 2-rollen systeem. Daarnaast hebben we adresvelden toegevoegd zodat de klant sneller kan afrekenen."

## 6. De Product Images
"Waarom een aparte tabel voor `product_images`? Eén product kan meerdere foto's hebben (voorkant, achterkant, detail). Door een **One-to-Many (1:N)** relatie te gebruiken met een aparte tabel, kunnen we later oneindig veel foto's aan één product hangen, en de 'is_primary' boolean gebruiken om de hoofdfoto te bepalen."

## Conclusie voor de Jury
Je database is niet zomaar in elkaar geflanst. Het is genormaliseerd (geen dubbele data), schaalbaar (Adjacency Lists voor categorieën) en robuust (prijs-snapshots in bestellingen). Dat is het kenmerk van een echte developer!
