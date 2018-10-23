# Basis-Plattform für Chancenportal

Dieses Projekt stellt die Basisinstallation einer TYPO3-basierten Plattform zur Veröffentlichung kommunaler Angebote 
für Bürger dar. Die Plattform wurde als Zusammenarbeit der Bertelsmann Stiftung, u+i interact, SYSPONS, sowie der 
Stadt Rheda-Wiedenbrück entwickelt.  

## Funktionen

Die Zielgruppen können durch einen einfachen Einstieg über eine Suche oder über das Stöbern durch die aktuellen Angebote die breite Vielfalt der lokalen Unterstützungs-, Beratungs- und Betreuungsangebote einsehen und Kontakt zu dem jeweiligen Anbieter aufnehmen. Von der Recherche nach einer geeigneten Schule, über die Suche nach Betreuungsmöglichkeiten in Ferienzeiten, bis hin zur Beratung von jungen Eltern ist eine große Vielfalt an Angeboten abgedeckt.

Die Suche ist örtlich (Eingabe von Postleitzahl und Umkreis der Suche), zeitlich (Angabe eines Datums oder Zeitraums), über vordefinierte Kategorien, über klickbare Filterkriterien und eine freie Begriffssuche möglich. Angebote werden auf einer Karte und tabellarisch angezeigt. Es gibt zudem einen einzelnen Bereich für die Suche und Anzeige der diversen Anbieter.

Angebote und Anbieter bekommen jeweils eine eigene Seite, auf der alle Informationen strukturiert dargestellt werden. Neben Texten und Bildern können auch Videos angezeigt werden. Zudem findet der Besucher hier die Kontaktdaten der Anbieter und Ansprechpartner. Über einen Kontaktbutton können die Anbieter direkt per Mail angeschrieben werden. Zudem erfahren die Nutzer, in welchen Institutionen und Organisationen sie möglicherweise mitwirken, an welchen regelmäßigen Stammtischen sie teilnehmen oder wo sie ggf. eine Spende abgeben können.

Zusätzlich zur Zielgruppe der Eltern, Kinder und Multiplikatoren hat das Chancenportal auch einen hohen Wert für die einzelnen Anbieter. Jeder Anbieter hat die Chance, sich über ein Profil in dem Portal darzustellen und somit auf sich und seine Angebote aufmerksam zu machen. Der Anbieter kann seine Angebote verwalten und hat so einen immer aktuellen Überblick seines Portfolios. Die Oberfläche, auf der sich der Anbieter in seinem Nutzerkonto bewegt, ist nutzerfreundlich gestaltet, sodass sich die Anbieter hier gut und einfach zurechtfinden. Sie können sich über das Portal selbstständig registrieren und werden anschließend von einer zentralen Redaktionsstelle in der Kommunalverwaltung freigegeben.
  
Eine dritte Zielgruppe, die Nutzen aus dem Webportal ziehen kann, sind die Planer der jeweiligen Kommunen. Diese können über einen eigenen Zugang unterschiedliche Auswertungen in dem Portal vornehmen, um so die Bedürfnisse der Zielgruppe besser zu erkennen und die Angebotsvielfalt überblicken und auswerten zu können. Die Auswertungen beinhalten unter anderem die Identifikation von Unter- bzw. Überangeboten einzelner Aktivitäten oder für bestimmte Gruppen (beispielsweise Angebote für Kinder mit Rollstuhl) in bestimmten Stadtteilen. Außerdem kann ausgewertet werden, welche Angebote von den Nutzern oft gesucht und angeklickt werden oder welche Kategorie am meisten ausgewählt wird.

Das Chancenportal vereint somit eine Lösung für die unterschiedlichen Bedürfnisse der oben genannten Zielgruppen: Einfachere Abstimmung zwischen den Akteuren, zielgerichtetes Auffinden von Angeboten und Mitwirkungsmöglichkeiten, einen aktuellen Überblick über das kommunale Angebot für die Jugendhilfeplaner und Kommunalverwaltungen.

## Hintergrund und Technik

Die Plattform wurde in einer Zusammenarbeit von Bertelsmann Stiftung, der Stadt Rheda-Wiedenbrück als Pilot-Kommune, 
u+i interact sowie der SYSPONS GmbH entwickelt. Sie wird unter einer Open Source Lizenz veröffentlich, so dass die 
technologische Basis auch von anderen Städten und Gemeinden eingesetzt werden kann.

Das Chancenportal ist als Erweiterung für das TYPO3 CMS entwickelt worden, sodass die Inhalte und gespeicherten Daten
 durch eine Redaktion eingesehen und bearbeitet werden können. Eine Kommune, die sich dazu entscheidet, das Portal bei 
 sich zu installieren und zu betreiben, hat die Möglichkeit, die Oberfläche mit geringem Aufwand optisch anzupassen. Der Einsatz ist dabei nicht auf den Bereich der Kinder- und Jugendarbeit begrenzt sondern für alle Bereiche offen, in denen eine Vielzahl von Anbietern und Angebote existieren und ein Überblick ermöglicht werden soll.

## Installation

Das Repository enthält sämtliche Daten, um eine Basisplattform lauffähig zu machen:
* Anwendungscode
* Definierte Abhängigkeiten
* Datenbankdump (TYPO3, Extensions, Anwendungsdaten)

### Systemanforderungen

* die Anwendung setzt PHP in Version 7.1 voraus
* `ssconvert` muss für die Konvertierung von CSV zu Excel installiert sein: https://linux.die.net/man/1/ssconvert
* `composer` muss für die Installation der PHP-Abhängigkeiten installiert sein: https://getcomposer.org/
* darüber hinaus gelten die Anforderungen von TYPO3: https://typo3.org/cms/requirements/

### Step-by-step

Zur Installation sind folgende Schritte notwendig:

1. Repository klonen: `git clone git@github.com:bertelsmannstift/Chancenportal.git`
2. Abhängigkeiten über [composer](https://getcomposer.org/) installieren: `composer install`
3. Datenbankdump `/database/chancenportal.sql` in eine MySQL oder MariaDB laden
4. Konfiguration der Datenbank in der Datei `.env` vornehmen

## TYPO3 Login

Folgendes Standardpasswort ist gesetzt und muss nach der Installation geändert werden:

Benutzer: admin
Password: @hGjMZRjktL7u&

## Anpassung

Die Basisplattform kann über Farbwerte und den Austausch von Logos an das jeweilige Design der Kommune o.ä. angepasst
 werden. Folgende Änderungen sind vorgesehen:

* Tausch des Hauptlogos
* Anpassung der Hauptfarben im Portal
* Anpassung der Kategoriefarben
* Austausch des Favicons in `web/favicons/` (https://www.favicon-generator.org/)

## Bildmaterial

Als Platzhalter wurden Bilder der folgenden Fotografen verwendet:
  
* Kai Pilger on Unsplash
* Roman Kraft on Unsplash
* Matthew Kane on Unsplash