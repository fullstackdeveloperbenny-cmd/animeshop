# 20. Web Toegankelijkheid (Accessibility) & EAA 2025 ♿

Als de jury vraagt naar UX (User Experience) of toekomstbestendigheid, is dit jouw absolute troefkaart om indruk te maken. Met deze kennis laat je zien dat je niet zomaar codeert, maar bouwt voor de échte wereld en op de hoogte bent van actuele wetgeving.

## De Europese Toegankelijkheidsrichtlijn (EAA) 2025
Op **28 juni 2025** wordt de *European Accessibility Act* van kracht. Vanaf die dag zijn e-commerce webshops in Europa wettelijk verplicht om toegankelijk te zijn voor mensen met een beperking (visueel, auditief, motorisch of cognitief). De standaard die hiervoor gebruikt wordt is **WCAG 2.1 AA** (Web Content Accessibility Guidelines). 

Als developer moet je hier nú al rekening mee houden als je een webshop bouwt.

## Hoe voldoet onze Anime Webshop hier al aan?
Hoewel het geen expliciete eis was van de schoolopdracht, hebben we tijdens het bouwen "Accessibility by Design" toegepast. Dit betekent dat we de webshop vanaf de grond op toegankelijk hebben gebouwd in plaats van dit achteraf te moeten patchen. 

Hier zijn 5 concrete voorbeelden uit onze code die je aan de jury kunt vertellen:

### 1. Screenreaders (Voor Visueel Beperkten)
Mensen die blind of slechtziend zijn, gebruiken software die de website aan hen voorleest. 
- **Semantische HTML:** We gebruiken in onze Blade templates correcte tags zoals `<nav>` (navigatie), `<aside>` (zijbalk) en `<main>` in plaats van een oneindige soep aan `<div>` tags. Hierdoor snapt de voorleessoftware direct wat de structuur van de pagina is.
- **Alt-Attributen:** Overal waar we producten inladen, staat de code `alt="{{ $product->name }}"` op de `<img>` tag. De screenreader leest hierdoor "Goku Super Saiyan T-shirt" voor, in plaats van "Bestand_001.jpg".

### 2. Toetsenbord Navigatie (Voor Motorisch Beperkten)
Mensen die geen muis kunnen gebruiken, navigeren via de `Tab`-toets.
- **Focus States:** In onze Tailwind CSS code hebben we overal `focus:ring-2 focus:ring-[#ff2a42]` toegevoegd aan formulieren, dropdowns en knoppen. Zodra iemand met de Tab-toets op een knop komt, verschijnt er een duidelijke rode gloed. Zo weet de gebruiker exact waar hij/zij zich bevindt op de webpagina.

### 3. Kleurcontrast
- Ons dark-mode design (diepzwart/grijs met felle rode accenten) heeft van nature een extreem hoog contrast. Dit is cruciaal voor mensen die kleurenblind zijn of een verminderd zicht hebben. Belangrijke elementen (zoals de "Voeg Toe Aan Loot" knop) springen er direct uit.

### 4. Gekoppelde Labels in Formulieren
- In de kassa en de login-schermen gebruiken we correcte label-koppelingen (bijvoorbeeld `<label for="email">`). Dit betekent dat als je op het wóórd "E-mailadres" klikt, je cursor automatisch in het invulvakje springt. Dit geeft gebruikers met een motorische beperking een veel groter klik-oppervlakte, wat de gebruiksvriendelijkheid enorm verhoogt.

### 5. Alpine.js Dropdowns
- De dropdowns die we in de zijbalk hebben gemaakt (die open en dicht klappen) zijn niet alleen mooi, maar voorkomen ook zogenaamde *Cognitive Overload* (te veel informatie in één keer). Mensen met autisme of een cognitieve beperking hebben baat bij een rustig menu waarbij ze alleen zien wat ze nodig hebben. 

## Conclusie voor de Jury
Je kunt je antwoord als volgt samenvatten:
*"Ik heb begrepen dat een goede developer niet alleen bouwt voor de 'gemiddelde' gebruiker. Met de komende EAA wetgeving in 2025 in het achterhoofd, heb ik ervoor gezorgd dat deze webshop semantisch correct is opgebouwd, goed werkt met screenreaders (via alt-tags en labels) en volledig navigeerbaar is met het toetsenbord (via Tailwind focus-states)."*
