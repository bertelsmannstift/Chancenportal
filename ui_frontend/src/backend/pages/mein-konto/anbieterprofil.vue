/**
* Name: Mein-Konto - Anbieterprofil
* Progress: 100
*/
<template>
    <page-layout-component>
        <main class="main" slot="main">
            <container-component element="section" data-animation="fadeIn" class="my-account">
                <row-component class="info-nav__actions">
                    <col-component lg-3 sm-12>
                        <breadcrumb-component :items='[{"name": "Mein Konto"},{"name": "Anbieterinformationen"}]'></breadcrumb-component>
                    </col-component>
                </row-component>
                <form action="" method="post" enctype="multipart/form-data">

                    <row-component>

                        <col-component lg-3 sm-12 margin-sm>
                            <my-account-menu-component activeItem="2"></my-account-menu-component>
                        </col-component>

                        <col-component lg-8 sm-12 sm-offset-0 lg-offset-1>
                            <div class="my-account">
                                <div class="my-account__status my-account__status--wait">
                                    <strong>Status:</strong> Freigegeben + Online
                                </div>
                                <row-component class="margin-lg">
                                    <col-component lg-8 sm-12 margin-sm>
                                        <h1 class="margin-small">
                                            Anbieterprofil
                                        </h1>
                                    </col-component>
                                    <col-component lg-4 sm-12 margin-sm end-lg>
                                        <button-component element="button" type="submit">Speichern</button-component>
                                    </col-component>
                                </row-component>

                                <row-component>
                                    <col-component lg-12 sm-12 margin-inner-sm>
                                        <h2>Über den Anbieter</h2>
                                    </col-component>
                                </row-component>

                                <row-component>
                                    <col-component lg-12 sm-12>
                                        <input-component label="Name der Organisation*"></input-component>
                                    </col-component>
                                </row-component>
                                <row-component>
                                    <col-component lg-12 sm-12>
                                        <input-component label="Unterzeile Organisation"></input-component>
                                    </col-component>
                                </row-component>
                                <row-component>
                                    <col-component lg-12 sm-12>
                                        <input-component type="textarea" max-length="200" label="Kurzbeschreibung / Teaser-Text (max.200 Zeichen)*"></input-component>
                                    </col-component>
                                </row-component>
                                <row-component>
                                    <col-component lg-12 sm-12>
                                        <custom-rte-input id="longdesc" name="longdesc" type="textarea" label="Langbeschreibung" max-length="200"></custom-rte-input>
                                    </col-component>
                                </row-component>
                                <row-component>
                                    <col-component lg-12 sm-12 margin-lg>
                                        <custom-upload label="Content-Bild hinzufügen (max. 1)" max-files-error="Es kann nur ein Bild ausgewählt werden" max-files="1"></custom-upload>
                                    </col-component>
                                </row-component>

                                <row-component>
                                    <col-component lg-12 sm-12 margin-inner-sm>
                                        <h2>Zahlen und Fakten</h2>
                                    </col-component>
                                </row-component>

                                <row-component>
                                    <col-component lg-6 sm-12>
                                        <div class="input">
                                            <label class="input__label">Art des Trägers</label>
                                            <custom-dropdown id="type" name="type" theme="light" :show-selected-title="true"
                                                             :multiple-select="false"
                                                             :options='types'></custom-dropdown>
                                        </div>
                                    </col-component>
                                    <col-component lg-6 sm-12>
                                        <input-component label="Mitarbeiterzahl" placeholder-text="150"></input-component>
                                    </col-component>
                                </row-component>

                                <row-component>
                                    <col-component lg-12 sm-12 margin-lg>
                                        <div class="input">
                                            <label class="input__label">Engagement / Mitwirkung</label>
                                            <div>
                                                <custom-radio :is-checked="true" id="participation_0" name="participation" value="" theme="light"
                                                              label="Keine Angabe"></custom-radio>
                                                <custom-radio :is-checked="false" id="participation_1" name="participation" value="1" theme="light"
                                                              label="Erwünscht"></custom-radio>
                                                <custom-radio :is-checked="false" id="participation_2" name="participation" value="2" theme="light"
                                                              label="Möglich"></custom-radio>
                                                <custom-radio :is-checked="false" id="participation_3" name="participation" value="3" theme="light"
                                                              label="Nicht möglich"></custom-radio>
                                            </div>
                                        </div>
                                    </col-component>
                                </row-component>

                                <row-component>
                                    <col-component lg-12 sm-12 margin-inner-lg>
                                        <div class="my-account__individuell-info">- Hier können Sie optional weitere Informationen zu Ihrer Organisation hinzufügen. Diese werden in der rechten Spalte unter Zahlen und Fakten ausgespielt. -</div>
                                    </col-component>
                                </row-component>

                                <custom-new-line class="margin-lg">
                                    <row-component>
                                        <col-component lg-6 sm-12>
                                            <div class="rte-margin">
                                                <input-component label="Beschriftung Label" name="label[0][name]"></input-component>
                                            </div>
                                        </col-component>
                                        <col-component lg-6 sm-12>
                                            <custom-rte-input id="label_desc" name="label_desc[0][text]" type="textarea" label="Beschriftung" min-height="100" :rte="true"></custom-rte-input>
                                        </col-component>
                                    </row-component>
                                </custom-new-line>

                                <row-component>
                                    <col-component lg-12 sm-12 margin-inner-sm>
                                        <h2>Adresse und Kontakt</h2>
                                    </col-component>
                                </row-component>

                                <row-component>
                                    <col-component lg-12 sm-12 margin-lg>
                                        <custom-upload label="Logo hinzufügen (max. 1)" max-files-error="Es kann nur ein Bild ausgewählt werden" max-files="1"></custom-upload>
                                    </col-component>
                                </row-component>


                                <row-component>
                                    <col-component lg-12 sm-12>
                                        <input-component label="Straße und Hausnr.*" :required="true"></input-component>
                                    </col-component>
                                </row-component>

                                <row-component>
                                    <col-component lg-6 sm-12>
                                        <input-component label="PLZ und Ort*" :required="true"></input-component>
                                    </col-component>
                                    <col-component lg-6 sm-12>
                                        <input-component label="E-Mail*" :required="true"></input-component>
                                    </col-component>
                                </row-component>

                                <row-component>

                                    <col-component lg-6 sm-12>
                                        <input-component label="Telefonnummer"></input-component>
                                    </col-component>
                                    <col-component lg-6 sm-12>
                                        <input-component label="2. Telefonnummer"></input-component>
                                    </col-component>
                                </row-component>
                                <row-component>
                                    <col-component lg-12>
                                        <input-component label="Website" placeholder="www.loremipsum.de"></input-component>
                                    </col-component>
                                </row-component>
                                <row-component class="margin-lg">
                                    <col-component lg-12>
                                        <input-component type="textarea" max-length="200" label="Öffnungszeiten"></input-component>
                                    </col-component>
                                </row-component>

                                <row-component>
                                    <col-component lg-12 sm-12>
                                        <h2>Ansprechpartner/in</h2>
                                    </col-component>
                                </row-component>

                                <row-component>
                                    <col-component lg-12 sm-12 margin-inner-sm>
                                        <info-box-component class="margin-inner-lg">
                                            Die Angabe spezifischer Kontaktangaben für die/den Ansprechpartner/in sind freiwillig.
                                            Es wird in jedem Fall einen Kontakt-Button mit der allgemeinen Anbieter Email-Adresse geben.
                                        </info-box-component>
                                    </col-component>
                                </row-component>

                                <row-component>
                                    <col-component lg-12 sm-12>
                                        <input-component label="Vorname und Name"></input-component>
                                    </col-component>
                                </row-component>
                                <row-component>
                                    <col-component lg-12 sm-12>
                                        <input-component label="Zuständigkeit"></input-component>
                                    </col-component>
                                </row-component>

                                <row-component>
                                    <col-component lg-6 sm-12>
                                        <input-component label="Telefon"></input-component>
                                    </col-component>
                                    <col-component lg-6 sm-12>
                                        <input-component label="E-Mail"></input-component>
                                    </col-component>
                                </row-component>

                                <row-component class="margin-lg">
                                    <col-component lg-12 sm-12 margin-lg>
                                        <custom-upload label="Profilfoto hinzufügen (max. 1)" max-files-error="Es kann nur ein Foto ausgewählt werden" max-files="1"></custom-upload>
                                    </col-component>
                                </row-component>

                                <row-component>
                                    <col-component lg-4 sm-12 margin-inner-sm flex middle-lg>
                                        <a href="#" class="my-account__cancel-link">Angaben verwerfen</a>
                                    </col-component>
                                    <col-component lg-4 sm-12 margin-inner-sm>
                                        <button-component element="a" href="#" theme="full">Vorschau</button-component>
                                    </col-component>
                                    <col-component lg-4 sm-12 margin-inner-sm>
                                        <button-component element="button" type="submit" theme="full">Speichern</button-component>
                                    </col-component>
                                </row-component>
                            </div>


                        </col-component>
                    </row-component>
                </form>
            </container-component>
        </main>
    </page-layout-component>
</template>

<script>
    import PageLayoutComponent from '../../layouts/PageLayoutComponent.vue';
    import ContainerComponent from "../../components/ContainerComponent";
    import RowComponent from "../../components/RowComponent";
    import ColComponent from "../../components/ColComponent";
    import MyAccountMenuComponent from "../../components/MyAccountMenuComponent";
    import BorderBoxComponent from "../../components/BorderBoxComponent";
    import BreadcrumbComponent from "../../components/BreadcrumbComponent";
    import InfoBoxComponent from "../../components/InfoBoxComponent";
    import ButtonComponent from "../../components/ButtonComponent";
    import InputComponent from "../../components/InputComponent";

    export default {
        components: {
            InputComponent,
            ButtonComponent,
            InfoBoxComponent,
            BreadcrumbComponent,
            BorderBoxComponent,
            MyAccountMenuComponent,
            ColComponent,
            RowComponent,
            ContainerComponent,
            PageLayoutComponent,
        },
        metaInfo: {
            title: 'Anbieterprofil'
        },
        created() {

            this.types = JSON.stringify([
                {"id": "", "title": "Bitte wählen", "active": true},
                {"id": 1, "title": "Freie Träger (Vereine/Stiftungen, etc.)", "active": false},
                {"id": 2, "title": "Öffentliche Träger", "active": false},
            ]);

            this.categories = JSON.stringify([
                {"id": "",
                    "title":
                        "Alle Kategorien",
                    "active": true
                },
                {"id": 1,
                    "title": "Bildung und Betreuung",
                    "active": false,
                    items: [
                        {"id": 2, "title": "Kitas und Kinder- /Ferienbetreuung", "active": false},
                        {"id": 3, "title": "Schulen", "active": false},
                        {"id": 4, "title": "Sprachen", "active": false}
                    ]
                },
                {"id": 110,
                    "title": "Beratung und Unterstützung", "active": false,
                    items: [
                        {"id": 7, "title": "Vor und nach der Geburt", "active": false},
                        {"id": 8, "title": "Leben mit Kind", "active": false},
                        {"id": 9, "title": "Beratungsstellen", "active": false},
                        {"id": 10, "title": "Finanzielle Hilfen", "active": false},
                    ]
                },
                {"id": 11,
                    "title": "Freizeit und Kultur", "active": false,
                    items: [
                        {"id": 12, "title": "Kreativität, Medien und Musik", "active": false},
                        {"id": 13, "title": "Ferienangebote", "active": false},
                        {"id": 129, "title": "Sport", "active": false}
                    ]
                },
                {"id": 16,
                    "title": "Gesund leben",
                    "active": false,
                    items: [
                        {"id": 17, "title": "Gesundes Aufwachsen", "active": false},
                        {"id": 18, "title": "Ärzte und Krankenhäuser", "active": false},
                        {"id": 19, "title": "Therapeuten und Förderstellen", "active": false},
                    ]
                },
                {"id": 20, "title": "Übergang Schule & Beruf", "active": false,
                    items: [
                        {"id": 21, "title": "Hilfe zur Berufswahl", "active": false},
                        {"id": 22, "title": "Berufsvorbereitung", "active": false},
                        {"id": 23, "title": "AusSportbildungsförderung", "active": false}
                    ]},
            ]);
        },
        name: 'Anbieterprofil'
    }
</script>

<style lang="scss">
    @import "../../../styles/pages/my-account.scss";
</style>
