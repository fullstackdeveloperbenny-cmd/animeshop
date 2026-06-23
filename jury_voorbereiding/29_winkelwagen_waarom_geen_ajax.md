# Waarom flitst de Winkelwagen? (Geen AJAX / Livewire) 🛒

Als je de hoeveelheid van een product in je winkelwagen aanpast, zul je zien dat de pagina heel kort 'flitst' (een zogenaamde Page Reload). 

De jury zal waarschijnlijk vragen waarom dit zo is, zeker omdat je bij de zoekbalk (Live Search) wél hebt laten zien dat je onderdelen kunt updaten zónder de pagina te herladen (via AJAX).

Dit document bevat jouw professionele verdediging voor deze architectuurkeuze.

---

## De Vraag van de Jury
*"Hé, als ik mijn winkelwagen update, herlaadt de hele pagina. Waarom heb je hier geen Livewire of AJAX gebruikt, net zoals bij je zoekbalk?"*

## Jouw Professionele Antwoord (Systeem Architectuur)

"Daar heb ik heel bewust voor gekozen vanuit het oogpunt van **stabiliteit en risicobeheer**.

In een webshop zijn de winkelwagen en het afrekenproces (de checkout) de absolute kern van het bedrijf. Als dat niet werkt, verliest het bedrijf direct omzet. 

Technologieën zoals AJAX of Livewire zijn fantastisch voor de gebruikerservaring, maar ze leunen zwaar op Javascript. Als er een fout optreedt in de browser van de klant (bijvoorbeeld door een adblocker, een oude browser, of een haperende internetverbinding), breekt Javascript en kan de klant zijn winkelwagen niet meer updaten of afrekenen.

Daarom hanteer ik in dit project de volgende architectuur:
1. **Leuke extra's (zoals de Live Search):** Hier gebruik ik AJAX. Als Javascript daar onverhoopt faalt, is dat niet erg. De bezoeker kan nog steeds navigeren via de menubalk.
2. **Kritieke processen (Winkelwagen & Betalingen):** Hier gebruik ik robuuste, klassieke HTTP-requests (Formulier POST/PATCH acties). 

Door de winkelwagen via een klassiek formulier naar de server te sturen, garandeer ik dat de prijzen en de voorraad-check 100% veilig op de backend (Laravel) gebeuren. Ik sluit het risico op haperende Javascript uit op het moment dat het er écht toe doet. Die korte flits van het herladen neem ik graag voor lief in ruil voor maximale stabiliteit en zekerheid."
