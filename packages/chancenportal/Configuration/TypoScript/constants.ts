
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
        import_template_path = /typo3conf/ext/chancenportal/Resources/Public/vorlage.xls
        # cat=plugin.tx_chancenportal_chancenportal//a; type=string; label=ssconvert Pfad
        xls_converter = /usr/bin/ssconvert
        # cat=plugin.tx_chancenportal_chancenportal//a; type=string; label=Google Maps API Key
        google_maps_api_key = AIzaSyCbXWpD1t8G6omwRJ6yecXh1KLqvk3n2tE
        # cat=plugin.tx_chancenportal_chancenportal//a; type=boolean; label=Angebotsfreigabeprozess aktivieren
        activate_offer_approval = 1
        # cat=plugin.tx_chancenportal_chancenportal//a; type=boolean; label=Accountübernahme-Option aktivieren
        activate_account_takeover = 0
        # cat=plugin.tx_chancenportal_chancenportal//a; type=boolean; label=Google Translator aktivieren
        show_google_translator = 0
    }
}
