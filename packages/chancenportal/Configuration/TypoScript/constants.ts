
plugin.tx_chancenportal_chancenportal {
    view {
        # cat=plugin.tx_chancenportal_chancenportal/file; type=string; label=Path to template root (FE)
        templateRootPath = EXT:chancenportal/Resources/Private/Templates/
        # cat=plugin.tx_chancenportal_chancenportal/file; type=string; label=Path to template partials (FE)
        partialRootPath = EXT:chancenportal/Resources/Private/Partials/
        # cat=plugin.tx_chancenportal_chancenportal/file; type=string; label=Path to template layouts (FE)
        layoutRootPath = EXT:chancenportal/Resources/Private/Layouts/
    }
    persistence {
        # cat=plugin.tx_chancenportal_chancenportal//a; type=string; label=Default storage PID
        storagePid =
    }
}

## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder

plugin.tx_chancenportal_chancenportal {
    view {
        # cat=plugin.tx_chancenportal_chancenportal/file; type=string; label=Path to template root (FE)
        templateRootPath = EXT:chancenportal/Resources/Private/Templates/
        # cat=plugin.tx_chancenportal_chancenportal/file; type=string; label=Path to template partials (FE)
        partialRootPath = EXT:chancenportal/Resources/Private/Partials/
        # cat=plugin.tx_chancenportal_chancenportal/file; type=string; label=Path to template layouts (FE)
        layoutRootPath = EXT:chancenportal/Resources/Private/Layouts/
    }
    persistence {
        # cat=plugin.tx_chancenportal_chancenportal//a; type=string; label=Default storage PID
        storagePid =
    }
    settings {
        # cat=plugin.tx_chancenportal_chancenportal//a; type=boolean; label=PLZ-Filter aktivieren
        use_zip_filter = 1
        # cat=plugin.tx_chancenportal_chancenportal//a; type=string; label=E-Mail Sender
        email_sender = chancenportal@example.org
        # cat=plugin.tx_chancenportal_chancenportal//a; type=string; label=Importvorlage
        import_template_path = /fileadmin/vorlage.xlsx
        # cat=plugin.tx_chancenportal_chancenportal//a; type=string; label=ssconvert Pfad
        xls_converter = /usr/bin/ssconvert
        # cat=plugin.tx_chancenportal_chancenportal//a; type=string; label=Google Maps API Key
        google_maps_api_key =
        # cat=plugin.tx_chancenportal_chancenportal//a; type=boolean; label=Angebotsfreigabeprozess aktivieren
        activate_offer_approval = 1
        # cat=plugin.tx_chancenportal_chancenportal//a; type=boolean; label=Accountübernahme-Option aktivieren
        activate_account_takeover = 0
        # cat=plugin.tx_chancenportal_chancenportal//a; type=boolean; label=Google Translator aktivieren
        show_google_translator = 0
        # cat=plugin.tx_chancenportal_chancenportal//a; type=boolean; label=ähnliche Wörter als Suchvorschläge anzeigen
        search_show_similiar = 1
        # cat=plugin.tx_chancenportal_chancenportal//a; type=string; label=Email als User Header für Openthesaurus als Kontaktmöglichkeit (aktiviert 'Meinten Sie' Funktionilität)
        search_user_header_openthesaurus = chancenportal@example.org
    }
}