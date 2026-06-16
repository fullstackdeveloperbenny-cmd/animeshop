# Waarom deze Database Structuur?

De jury zal gegarandeerd vragen stellen over je database. Zorg dat je deze relaties kunt uitleggen!

## 1. Waarom `parent_id` bij Categorieën? (Zelf-referentie)
In de `categories` tabel zit een veld genaamd `parent_id`.
**Vraag van de jury:** *"Waarom heb je geen aparte tabel voor subcategorieën gemaakt?"*
**Jouw antwoord:** *"Door `parent_id` te gebruiken (waarbij een categorie verwijst naar het ID van een ándere categorie in dezelfde tabel), kan ik oneindig diepe structuren maken. Kledij -> Truien -> Hoodies. Als ik aparte tabellen had gebruikt, was ik beperkt tot precies 2 niveaus."*

## 2. Waarom `variants` in plaats van "Maten" vast in het Product?
**Vraag van de jury:** *"Waarom heb je de maat (S, M, L) niet gewoon als een kolom in de `products` tabel gezet?"*
**Jouw antwoord:** *"Omdat niet elk product kleding is! Manga heeft geen kledingmaat, maar een 'Taal' (NL/EN). Een poppetje heeft soms helemaal geen maat. Door een aparte `variants` tabel te maken (met `type` en `value`), is het systeem 100% flexibel. Ook heeft elke fysieke maat zijn eigen `stock` (voorraad). Je kunt immers 10 truien in maat M hebben, maar 0 in maat S."*

## 3. Waarom een aparte `order_items` tabel?
**Vraag van de jury:** *"Waarom sla je niet gewoon de product_id's op in de `orders` tabel?"*
**Jouw antwoord:** *"Een bestelling kan meerdere, totaal verschillende producten bevatten (een Trui én een Manga). Door `order_items` (een one-to-many relatie) te gebruiken, kan ik per gekocht item bijhouden wat de eenheidsprijs op dat moment was, welk product het is, en in welke variant (Maat L). Als de prijs van de trui morgen verandert, blijft mijn `order_items` tabel het historische bon-bedrag onthouden!"*

## 4. CASCADE on Delete
**Uitleg voor jezelf:** Als een Admin een `Product` verwijdert, hebben we ingesteld dat de database automatisch de foto's en varianten van dat product mee-verwijdert (`cascadeOnDelete()`). Dat voorkomt rondslingerende "wees-data" in je database. Bij Categorieën hebben we juist voor `nullOnDelete()` gekozen: als de categorie 'Kledij' per ongeluk gewist wordt, worden de T-Shirts niet gedeletet, maar vallen ze gewoon onder "Geen categorie".
