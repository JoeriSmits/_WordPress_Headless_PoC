### Readme

## Opstarten project

Om het WordPress-project op te starten, kun je gebruik maken van de tool Local (https://localwp.com/). Het bestand dat je nodig hebt om het project te importeren, bevindt zich in de rootmap van het project en heeft de naam wp-test.zip. Wanneer je dit bestand direct importeert in Local, kun je het project meteen opstarten. Je hebt vervolgens toegang tot de code via VSCode (of een andere code-editor naar keuze).

Zorg ervoor dat je de geïmporteerde map verwijst naar deze repository. De bestanden zouden dan direct synchroon moeten lopen, zodat je geen tijd kwijt bent aan het handmatig instellen van de projectbestanden.

Een belangrijk voordeel van deze werkwijze is dat de benodigde data automatisch wordt meegenomen uit de database, zodat je niet opnieuw alle gegevens hoeft in te vullen of configureren. Dit bespaart tijd en zorgt ervoor dat je meteen kunt werken met de juiste data.

De inloggegevens voor het project zijn:

Gebruiker: user
Wachtwoord: user

## Voortvang CMS PoC

| CMS                       | WordPress | Geimplementeerd |
|---------------------------|-----------|-----------------|
| Verschillende Content Types| ✅        | ✅              |
| Slug generation            | ✅        | ❌              |
| Parent Child relationsihip | ✅        | ✅              |
| Categories & Tags          | ✅        | ✅              |
| Versiebeheer               | ✅        | ✅              |
| Preview                    | ✅        | ❌              |
| Workflows                  | Met plugin | ❌              |
| Content Scheduling         | Met plugin  | ❌              |
| Locales                    | Twee keuzes: <br> 1) Multisite ✅ <br> 2) Met plugin (💰 verwaarloosbaar) | ❌              |
| Media library              | ✅        | ✅              |
| Image editor - Scaling     | ✅        | ❌              |
| Image Editor - Focal point | Met plugin (💰 verwaarloosbaar voor Pro versie (mobiele afbeeldingen)) | ❌              |
| Image Editor - Croppen     | ✅        | ❌              |
| Image editor - Rotation    | ✅        | ❌              |
| Image editor - Folderstructuur | Met plugin | ❌              |
| Image editor - Replace     | Met plugin | ❌              |
| Afbeelding compressie      | Met plugin | ❌              |
| Multi-site                 | ✅        | ❌              |
| Redirects                  | Met plugin, twee opties: <br> 1) Redirection (gratis) <br> 2) YOAST premium (💰 verwaarloosbaar) | ❌              |
| SEO                        | Met plugin, twee opties: <br> 1) Gratis versie <br> 2) Premium versie | ❌              |
| Formulieren                | Met plugin | ❌              |
| GraphQL Api               | Met plugin | ✅              |
| Rest Api                   | ✅        | ✅              |
| SSO Login                  | Met plugin | ❌              |
| Plugin development         | Makkelijk, wel PHP | ❌              |
| Emails                     | Met plugin | ❌              |
| Gebruikersrollen en permissies | Met plugin | ❌              |
| Gemak in opzet (hoeveel tijd zit er in het opbouwen en opzetten van het CMS) | Hangt af van de implementatie | ❌              |
| Content linking (het linken naar andere content) | ✅        | ❌              |
| Snelheid van CMS           |           | ❌              |
| Snelheid van API           |           | ❌              |
