# Changelog

## Release 2020-07-21

### BUGFIXES
- Es wurden nicht alle aktiven Angebote auf der Anbieterseite aufgelistet 
- Wenn es nur Hauptkategorien ohne Unterkategorien git, war es möglich mehr als eine Hauptkategorie auszuwählen
- Weiterleitung nach Löschen eines Anbieters finktionierte nicht korrekt
- Automatische Umbrüche (hyphens: auto;) für die Headlines in den Kacheln wurde aktiviert.
- Textanpassungen 

**Commits**

* [https://github.com/bertelsmannstift/Chancenportal/commit/e0b9256d00f0bdb590a51af1e4acfb9e3bc3b4ea](https://github.com/bertelsmannstift/Chancenportal/commit/e0b9256d00f0bdb590a51af1e4acfb9e3bc3b4ea)


## Release 2020-05-18

### BUGFIX / FEATURE
- GeoCoding funktionierte im TYPO3 Backend aufgrund von Google API Einschränkungen nicht korrekt
- Die Möglichkeit Angebote ohne Adresse hinzuzufügen wurde implementiert

**Commits**

* [https://github.com/bertelsmannstift/Chancenportal/commit/f35f47e124e7650a783c8526e03b0c8dd843e82a](https://github.com/bertelsmannstift/Chancenportal/commit/f35f47e124e7650a783c8526e03b0c8dd843e82a)

## Release 2020-03-25

### Minor Bugfixes
Kleinere Bugfixes für den Freigabeprozess und die Auswertungsansicht.

**Commits**

* [https://github.com/bertelsmannstift/Chancenportal/commit/af45fcfdb45785e593daeb35ba2bc82dafcaeda9](https://github.com/bertelsmannstift/Chancenportal/commit/af45fcfdb45785e593daeb35ba2bc82dafcaeda9)

## Release 2020-03-03

### Performance Updates
Implementierung von Caching-Mechanismen um die Performance, insbesondere auf der Homepage, zu erhöhen.

**Commits**

* [https://github.com/bertelsmannstift/Chancenportal/commit/de8a46a65e0cf9c4b587ab215d669b206c8aa081](https://github.com/bertelsmannstift/Chancenportal/commit/de8a46a65e0cf9c4b587ab215d669b206c8aa081)
* [https://github.com/bertelsmannstift/Chancenportal/commit/7b4d852cd503c99d888ec721469c692f5a8bd7d2](https://github.com/bertelsmannstift/Chancenportal/commit/7b4d852cd503c99d888ec721469c692f5a8bd7d2)

## Release 2020-02-27

### Release für TYPO3 9.5
Mit diesem Release wurde die zugrundeliegende TYPO3-Version von TYPO3 8.7 LTS auf TYPO3 9.5 LTS geändert. TYPO3 8.7 LTS wird mit diesem Release nicht mehr unterstützt.

**Commits**

* [https://github.com/bertelsmannstift/Chancenportal/commit/0ed32946d906da996ba31c73ed574bf09478ca2b](https://github.com/bertelsmannstift/Chancenportal/commit/0ed32946d906da996ba31c73ed574bf09478ca2b)

## Release 2020-01-07

### BUGFIX: Excel Export von Angeboten
Der Excel Export von Angeboten funktionierte auf Shared Hosting Systemen nicht 

**Commits**

* [https://github.com/bertelsmannstift/Chancenportal/commit/495a285b40efa5f5755ca2bc055debd050cd6f38](https://github.com/bertelsmannstift/Chancenportal/commit/495a285b40efa5f5755ca2bc055debd050cd6f38)

### FEATURE: Entwurf speichern
Im Angebotsformular ist es nun auch möglich den aktuellen Stand als Entwurf zu speichern, ohne das Angebot direkt LIVE zu schalten, bzw. zur Freigabe einzureichen.  

**Commits**

* [https://github.com/bertelsmannstift/Chancenportal/commit/495a285b40efa5f5755ca2bc055debd050cd6f38](https://github.com/bertelsmannstift/Chancenportal/commit/495a285b40efa5f5755ca2bc055debd050cd6f38)

## Release 2019-11-04

### FEATURE: Integration von OpenThesaurus
Bei der Suche nach Angeboten, werden nun auch über OpenThesaurus gefundene Synonyme und Grundformen mit berücksichtigt.

**Commits**

* [https://github.com/bertelsmannstift/Chancenportal/commit/cf1dd455d360196ba22fcd97fd40750960df83de](https://github.com/bertelsmannstift/Chancenportal/commit/cf1dd455d360196ba22fcd97fd40750960df83de)
* [https://github.com/bertelsmannstift/Chancenportal/commit/2bc72b13138ad5eb08a0566ab34ae487cc06c9ab](https://github.com/bertelsmannstift/Chancenportal/commit/2bc72b13138ad5eb08a0566ab34ae487cc06c9ab)

### BUGFIX: Falsche Anzeige von Angebots-Starttag
An manchen Stellen wurde ein falscher Wochentag für den nächsten Angebotstermin angezeigt.

**Commits**

* [https://github.com/bertelsmannstift/Chancenportal/commit/6f7af34efd706ec34d4a77f94b5a0eb581ed67b8](https://github.com/bertelsmannstift/Chancenportal/commit/6f7af34efd706ec34d4a77f94b5a0eb581ed67b8)

### BUGFIX: Ausgabe der Postleitzahl auf der Angebots- und Anbieterdetailseite

**Commits**

* [https://github.com/bertelsmannstift/Chancenportal/commit/5558c65577ffe444a6c43eecc2c244f81cd77a0f](https://github.com/bertelsmannstift/Chancenportal/commit/5558c65577ffe444a6c43eecc2c244f81cd77a0f)