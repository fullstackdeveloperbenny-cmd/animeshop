# Klantportaal, Registratie & Profiel Beheer 🧑‍💻

Als de jury vragen stelt over het "Mijn Account" gedeelte, de registratie of het beveiligen van inloggegevens, dan is dit jouw complete spiekbriefje.

---

## 1. Waarom is het Registratieformulier zo kort?

**Vraag van de jury:** *"Waarom vraag je tijdens het registreren niet meteen naar het adres, de postcode en de stad van de klant?"*

**Jouw antwoord:**
"Dat is een hele bewuste UX (User Experience) keuze. In de e-commerce wereld weten we dat **elk extra invulveld de conversie verlaagt**. Hoe meer je vraagt om een account aan te maken, hoe meer bezoekers gefrustreerd afhaken. 
Daarom hou ik de registratie zo kort mogelijk (enkel Naam, E-mail en Wachtwoord). Zo is de klant in 10 seconden binnen. Zijn volledige adres (straat, stad, postcode) vraag ik pas op op het moment dat het écht nodig is: tijdens het afrekenen (de checkout), of als ze dit later zelf rustig willen aanvullen in hun profiel."

---

## 2. Hoe werkt de "Remember Me" (Onthoud Mij) knop?

**Vraag van de jury:** *"Wat doet dat vinkje 'Remember Me' precies op het inlogscherm?"*

**Jouw antwoord:**
"Normaal gesproken wordt je ingelogde 'sessie' vernietigd zodra je de browser sluit. Je moet dan de volgende keer opnieuw je wachtwoord intypen. 
Als je het 'Remember Me' vinkje aanzet, genereert Laravel op de achtergrond een uniek, zwaar versleuteld koekje genaamd de `remember_web_...` cookie. Deze wordt opgeslagen in de browser van de gebruiker. 
Zelfs als de gebruiker zijn laptop dichtklapt en een week later terugkomt, ziet mijn applicatie deze cookie, valideert de versleuteling in de database, en logt de gebruiker automatisch weer in. Dit zorgt voor enorm veel gebruiksgemak."

---

## 3. Wat gebeurt er in de Database bij een Profiel Update?

**Vraag van de jury:** *"Als een klant inlogt, naar zijn profiel gaat, en daar zijn wachtwoord of adres aanpast... wat gebeurt er dan exact in de database? Blijft de oude data bestaan?"*

**Jouw antwoord:**
"Nee, de oude data wordt **volledig overschreven**. 

Zodra de klant op 'Opslaan' klikt, vuurt het formulier een `PATCH` of `PUT` request af naar de Controller. 
Op database-niveau genereert Laravel (via Eloquent ORM) een zogenaamde `UPDATE` query. Die ziet er onder de motorkap ongeveer zo uit:
`UPDATE users SET address = 'Nieuwe Straat 10', city = 'Brussel' WHERE id = 5;`

Het oude adres is daarmee permanent gewist en direct vervangen door het nieuwe. 

Als de klant specifiek zijn **wachtwoord** aanpast, gebeurt er nog een extra cruciale veiligheidsstap: 
Mijn code pakt het nieuwe wachtwoord, gooit dit door de **Bcrypt Hashing Algoritme**, en slaat enkel die onleesbare 'hash' op in de database (bijv: `$2y$10$wT...`). De database overschrijft dus de oude hash met de nieuwe hash. Zelfs ik, als beheerder van de database, kan het nieuwe wachtwoord niet lezen."
