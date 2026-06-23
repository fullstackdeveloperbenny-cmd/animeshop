**1. Scope en Projectplanning**  
*Gebruik dit document als basis voor je inleiding tijdens de presentatie en voor je geschreven neerslag.*  
**Doel van het project**  
Het doel van "AnimeShop" is het ontwikkelen van een volwaardige, veilige en gebruiksvriendelijke E-commerce applicatie gericht op de verkoop van Anime gerelateerde artikelen (Manga, kleding, poppetjes). Het project toont aan dat ik in staat ben om zowel een moderne frontend (Tailwind CSS, Responsive) als een robuuste backend (Laravel, relationele databases, Stripe betalingen) from scratch op te zetten.  
**Doelgroep**  
De primaire doelgroep bestaat uit Anime en Manga fans die op zoek zijn naar een betrouwbare, snelle en visueel aantrekkelijke webshop. De secundaire doelgroep is de beheerder (admin) die via een afgeschermd paneel eenvoudig de catalogus en bestellingen moet kunnen beheren.  
**Belangrijkste Functionaliteiten (In Scope)**  
- **Authenticatie & Autorisatie:** Standaard login/registratie. Rollen-systeem (Admin vs Klant).  
- **Productbeheer (Admin):** CRUD operaties voor producten, categorieën (met oneindige subcategorieën), varianten (maten, talen) en afbeeldingen.  
- **Winkelervaring (Frontend):** Productoverzicht met categorie-filtering, zoekfunctie en paginatie.  
- **Winkelwagen:** Sessie-gebaseerd winkelmandje.  
- **Checkout & Betaling:** Beveiligde afreken-flow geïntegreerd met Stripe (test mode).  
- **Orderbeheer:** Klanten kunnen bestellingen plaatsen, de admin kan deze inzien via een dashboard.  
**Wat bewust NIET gebouwd is (Out of Scope)**  
- *Factuurgeneratie (PDF):* Er wordt wel een bestelbevestiging via e-mail gestuurd, maar geen wettelijke PDF-factuur gegenereerd.  
**Realistische Planning & Mijlpalen**  
Tijdens de ontwikkeling is gewerkt met duidelijke mijlpalen (Fases), zoals terug te vinden in de   
1. **Fase 1-3:** Basis setup, Database ontwerp, Auth.  
2. **Fase 4-5:** Categorieën en Productbeheer (Backend/Admin paneel).  
3. **Fase 6-7:** De publieke winkelkant en winkelwagen functionaliteit.  
4. **Fase 8-9:** Checkout, Stripe integratie en Orderbeheer.  
5. **Fase 10-14:** Testing, UI/UX verbeteringen, Refactoring (FormRequests, Actions) en afronding.  
   
 Al deze mijlpalen zijn succesvol en binnen de voorziene tijd behaald.  
