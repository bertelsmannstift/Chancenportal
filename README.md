# Chancenportal
Datenbank und Landkarte der Angebote und Anbieter zur Unterstützung von Benachteiligten

## Hintergrund und Zweck des Portals
Das „Chancenportal“ wurde im Rahmen des Projekts „Synergien vor Ort“ der Bertelsmann Stiftung entwickelt. Das Projekt hatte zum Ziel, die Zusammenarbeit zwischen Zivilgesellschaft, Verwaltung und Bürgern in den Handlungsfeldern Kinder- und Jugendarbeit, Flüchtlingshilfe und Seniorenarbeit zu untersuchen und zu verbessern. Ein zentraler Befund des Projekts lag darin, dass es in vielen Kommunen in den genannten Bereichen an einem Überblick über Angebote und Anbieter fehlt, ohne den eine bessere Zusammenarbeit nur begrenzt realisierbar ist.
Das „Chancenportal“ dient dem Zweck, einen umfassenden Überblick über Angebote und Anbieter für soziale Leistungen im lokalen Raum herzustellen (insbesondere in den Bereichen Kinder- und Jugendarbeit, Bildung, Seniorenarbeit und Flüchtlingshilfe). Konkret sollen im Portal unterstützende Angebote von nicht gewinnorientierten Anbietern eingestellt werden. Die Stiftung verfolgt damit ausschließlich und unmittelbar gemeinnützige Zwecke, darunter die in § 2 Abs. 2 b und f ihrer Satzung genannte Förderung zeitgemäßer und wirkungsvoller Strukturen sowie innovative Modelle von Führung und Organisationen zur Erbringung öffentlicher Leistungen. Das Portal hat dabei mehrere Nutzergruppen im Blick, die einen unterschiedlichen Mehrwert durch das Portal erhalten sollen.
Für die Zielgruppe (Kinder, Eltern, Senioren, Menschen mit Behinderungen, Geflüchtete etc.) aber auch vermittelnde Akteure (Lehrer, Betreuer, Sozial- und Sonderpädagogen) soll das Portal vor allem das zielsichere Finden passender Angebote ermöglichen. Für Anbieter (öffentliche, freie Träger, Initiativen, Vereine) soll sie eine Möglichkeit bieten, Angebote an zentraler Stelle darzustellen und damit die jeweilige Zielgruppe besser zu erreichen. Für Planer auf Seiten der Träger und der Kommunalverwaltung soll sie einen Überblick über die Angebotslandschaft herstellen, der ein Auffinden von Überangeboten und Angebotslücken erleichtert, um neue Angebote darauf anzupassen, Kooperationspartner zu finden und die Angebotslandschaft beispielsweise im Rahmen der Jugendhilfeplanung besser auszubalancieren.
Ergänzend zum Portal wurde eine praxisorientierte Handlungsanleitung für kommunale Vertreter/innen erstellt, die Empfehlungen gibt, wie der Einführungsprozess inhaltlich begleitet werden kann (Durchführung einer Bestandsaufnahme von Anbietern und Angeboten für ein Handlungsfeld, Überzeugung von relevanten Stakeholdern und Bewerbung des Portals bei den Zielgruppen). 

## Kernfunktionen des Portals
Das Portal stellt im Kern eine Datenbank über Angebote und Anbieter dar, die durch den Nutzer  durchsucht und umfangreich gefiltert werden können. Der Nutzer kann über das Portal via mail-to Funktion einen Anbieter zu einem Angebot kontaktieren. 
Die Eingabe der Daten zu Angeboten und Anbietern kann durch eine zentrale Redaktion sowie durch Nutzer erfolgen, die sich als Anbieter registriert haben und durch den Betreiber als solche qualifiziert und freigeschaltet wurden. Anbieter können zudem weitere Personen in ihrer Organisation freischalten, um Daten einzupflegen. Alle Anbieterbeschreibungen und Angebote müssen durch den Betreiber in Rolle der Redaktion freigeschaltet werden sowohl bei der Ersteinstellung als auch bei der Anpassung. Der Betreiber trägt damit Sorge dafür, dass nur solche Angebote und Darstellungen auf dem Portal ausgegeben werden, die dem Ziel des Portals entsprechen und den Nutzungsbedingungen nicht zuwiderlaufen. Hierfür kann er sich auch über die Nutzungsbedingungen das Recht einräumen, beispielsweise diskriminierende, kommerziell werbende oder dem Zweck nicht dienliche Inhalte nicht freizugeben, abzuändern oder auch nachträglich zu entfernen. 

## Hintergrund und Technik

Die Plattform wird durch die Bertelsmann Stiftung herausgegeben und wurde durch u+i interact im Auftrag der Bertelsmann Stiftung erstellt. Am Konzept der Plattform haben zudem die Stadt Rheda-Wiedenbrück als Pilot-Kommune sowie die SYSPONS GmbH mitgewirkt. Sie wird unter einer Open Source Lizenz veröffentlich, so dass die technologische Basis auch von anderen Städten und Gemeinden eingesetzt werden kann.

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
* Für den Import von Daten aus Excel-Dateien wird die Software [PhpSpreadsheet](https://github.com/PHPOffice/PhpSpreadsheet), für die die folgenden Systemanforderungen erfüllt werden müssen: [PhpSpreadsheet Systemanforderungen] (https://phpspreadsheet.readthedocs.io/en/latest/#software-requirements)
* `composer` muss für die Installation der PHP-Abhängigkeiten installiert sein: [https://getcomposer.org/](https://getcomposer.org/). Eine alternative, aber nicht empfohlene Art der Installation für Shared Web-Hoster wird weiter unten unter dem Punkt "Step-by-step - Web-Hosting" beschrieben.
* darüber hinaus gelten die Anforderungen von TYPO3: https://typo3.org/cms/requirements/
* Symlinks erstellbar (Composer Installation)
* Unix / Linux Betriebssystem
* Das Document-Root sollte anpassbar sein, denn es muss auf den `web` Ordner gesetzt werden (Composer Installation)
 
Darüber hinaus empfehlen wir einen Root-Server / vServer zu benutzen, da Sie bei einfachen Web-Hosting-Angeboten meist nicht die erforderlichen Aktionen für die Installation ausführen können.
Eine Anleitung für die Installation auf einfachen Web-Hosting-Angeboten finden Sie unter "Step-by-step - Web-Hosting".

### Step-by-step - Root-Server / vServer

Zur Installation sind folgende Schritte notwendig:

1. Repository klonen: `git clone git@github.com:bertelsmannstift/Chancenportal.git`
2. Abhängigkeiten über [composer](https://getcomposer.org/) installieren: `composer install`
3. Datenbankdump `/database/chancenportal.sql` in eine MySQL oder MariaDB laden
4. Setzen des Webroots auf den Ordner `web`
5. Konfiguration der Datenbank in der Datei `.env` vornehmen

Je nach gesetzter `TYPO3_CONTEXT` Umgebungsvariable wird die entsprechende Konfigurationsdatei aus dem Ordner 
`configuration` geladen. Sie überschreibt die Standard-Konfiguration aus der Datei `LocalConfiguration.php`.
Das bedeutet, dass eventuelle Änderungen im TYPO3 Installtool durch diese Datei überschrieben werden können.

### Step-by-step - Web-Hosting

1. Laden Sie [TYPO3 8.x](https://get.typo3.org/8/zip) herunter
2. Extrahieren Sie den Inhalt und laden Sie die Dateien auf Ihren Server, z. B. per (S)FTP oder SCP. Beachten Sie ggf. auch die offiziellen TYPO3-Hinweise zur Installation: [Install TYPO3 Without Composer](https://docs.typo3.org/typo3cms/InstallationGuide/QuickInstall/GetAndUnpack/Index.html)
3. Laden Sie die aktuelle Chancenportal-Anwendung herunter [Chancenportal](https://github
.com/bertelsmannstift/Chancenportal/archive/master.zip)
4. Extrahieren Sie das Zip-Archiv und laden Sie den Inhalt des Ordners `web` auf Ihren Server
5. Laden Sie ebenfalls den Inhalt des Ordners `packages` auf Ihren Server in den Ordner `typo3conf/ext` hoch
6. Laden Sie das Paket [PHPOffice/PhpSpreadsheet](https://github.com/PHPOffice/PhpSpreadsheet/archive/1.6.0.zip) herunter und kopieren Sie den Inhalt des Archivs nach `typo3conf/ext/chancenportal/Vendor/PhpSpreadsheet`
7. Laden Sie das Paket [Simple Cache PSR](https://github.com/php-fig/simple-cache/archive/1.0.1.zip) herunter und kopieren Sie den Inhalt des Archivs nach `typo3conf/ext/chancenportal/Vendor/psr/simple-cache`
6. Ihre Datenbank wird in der Datei `typo3conf/LocalConfiguration.php` konfiguriert (Details zur Datenbank und den 
Zugangsdaten sollten im Backend Ihres Providers zu finden sein)
7. Importieren Sie den Datenbankdump (`/database/chancenportal.sql`) in eine neue MySQL- oder MariaDB-Datenbank
8. Melden Sie sich am TYPO3 Backend an `https://www.example.org/typo3`
9. Installieren und aktivieren Sie folgende Extensions im TYPO3 Backend:
	* [flux](https://extensions.typo3.org/extension/flux/) (Version 8.2.1)
	* [pagenotfoundhandling](https://extensions.typo3.org/extension/pagenotfoundhandling/) (Version 2.4.6)
	* [realurl](https://extensions.typo3.org/extension/realurl/) (Version 2.4.0)
	* [typoscript_rendering](https://extensions.typo3.org/extension/typoscript_rendering/) (Version 2.1.0)
 	* [vhs](https://extensions.typo3.org/extension/vhs/) (Version 4.4.0)

## TYPO3 Login

Folgende Standardpasswörter sind gesetzt und müssen nach der Installation geändert werden!

### TYPO3 Backend
Benutzer: admin<br>
Password: @hGjMZRjktL7u&

### TYPO3 Installtool
Passwort: Kfisdfi39mf(!

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
