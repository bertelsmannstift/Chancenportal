/**
* Name: Mein-Konto - Neues Angebot
* Progress: 100
*/
<template>
    <page-layout-component>
        <main class="main" slot="main">
            <container-component element="section" data-animation="fadeIn" class="my-account">

                <row-component class="info-nav__actions">
                    <col-component lg-12>
                        <breadcrumb-component
                            :items='[{"name": "Mein Konto"},{"name": "Neues Angebot"}]'></breadcrumb-component>
                    </col-component>
                </row-component>

                <form action="/" method="post" enctype="multipart/form-data" autocomplete="off"
                      class="form-to-validate" novalidate>
                    <row-component>
                        <col-component lg-3 sm-12 margin-sm>
                            <my-account-menu-component activeItem="5"></my-account-menu-component>
                        </col-component>
                        <col-component lg-8 sm-12 sm-offset-0 lg-offset-1>

                            <row-component class="margin-lg">
                                <col-component lg-8 sm-12 margin-sm>
                                    <h1 class="margin-small">
                                        Neues Angebot erstellen
                                    </h1>
                                </col-component>
                                <col-component lg-4 sm-12 margin-sm end-lg>
                                    <button-component element="button"
                                                      type="submit">Speichern
                                    </button-component>
                                </col-component>
                            </row-component>

                            <row-component>
                                <col-component lg-12 sm-12 margin-inner-sm>
                                    <h2>Rahmendaten</h2>
                                </col-component>
                            </row-component>

                            <row-component>
                                <col-component lg-12 sm-12>
                                    <input-component label="Name des Angebots*"
                                                     :required="true"></input-component>
                                </col-component>
                            </row-component>

                            <row-component>
                                <col-component lg-12 sm-12>
                                    <div class="input">
                                        <label class="input__label">Angebotskategorie/n*</label>
                                        <custom-dropdown id="categories"
                                                         placeholder="Bitte wählen"
                                                         name="categories"
                                                         theme="light"
                                                         :show-selected-title="true"
                                                         :multiple-select="true"
                                                         :options='categories'
                                                         :required="true"></custom-dropdown>
                                    </div>
                                </col-component>
                            </row-component>

                            <row-component>
                                <col-component lg-12 sm-12>


                                    <div class="input">

                                        <label class="input__label">Termin/e</label>
                                        <custom-dropdown name="date_type[]"
                                                         theme="light"
                                                         :show-selected-title="true"
                                                         :options='angebotsTyp'>

                                            <div vue-slot="1">
                                                <row-component>
                                                    <col-component lg-12 sm-12 margin-inner-lg>
                                                        <div class="custom-new-line-replace">
                                                            <row-component>
                                                                <col-component lg-12 sm-12 margin-inner-sm>

                                                                    <div class="my-account__timerow">
                                                                        <div class="input">
                                                                            <label class="input__label">Datum</label>
                                                                            <custom-datepicker theme="light"
                                                                                               name="dates[]"
                                                                                               value="04.06.2018"></custom-datepicker>
                                                                        </div>

                                                                        <div class="input input--time">
                                                                            <label class="input__label">Uhrzeit von</label>
                                                                            <custom-time-input name="from_date_time"></custom-time-input>
                                                                        </div>

                                                                        <div class="input input--time">
                                                                            <label class="input__label">Uhrzeit bis</label>
                                                                            <custom-time-input name="to_date_time"></custom-time-input>
                                                                        </div>
                                                                    </div>
                                                                </col-component>
                                                            </row-component>
                                                        </div>
                                                    </col-component>
                                                </row-component>
                                            </div>
                                            <div vue-slot="2">
                                                <row-component>
                                                    <col-component lg-12 sm-12 margin-inner-lg>
                                                        <div class="custom-new-line-replace">
                                                            <row-component>
                                                                <col-component lg-12 sm-12 margin-inner-sm>

                                                                    <div class="my-account__timerow">
                                                                        <div class="input">
                                                                            <label class="input__label">Start-Datum</label>
                                                                            <custom-datepicker theme="light"
                                                                                               name="dates[]"
                                                                                               value="04.06.2018"></custom-datepicker>
                                                                        </div>

                                                                        <div class="input input--time">
                                                                            <label class="input__label">Uhrzeit-Beginn</label>
                                                                            <custom-time-input name="from_date_time"></custom-time-input>
                                                                        </div>

                                                                        <div class="input">
                                                                            <label class="input__label">End-Datum</label>
                                                                            <custom-datepicker theme="light"
                                                                                               name="dates[]"
                                                                                               value="15.06.2018"></custom-datepicker>
                                                                        </div>
                                                                        <div class="input input--time">
                                                                            <label class="input__label">Uhrzeit-Ende</label>
                                                                            <custom-time-input name="to_date_time"></custom-time-input>
                                                                        </div>
                                                                    </div>
                                                                </col-component>
                                                            </row-component>
                                                        </div>
                                                    </col-component>
                                                </row-component>
                                            </div>
                                            <div vue-slot="3">
                                                <row-component>
                                                    <col-component lg-12 sm-12 margin-inner-lg>
                                                        <div class="custom-new-line-replace" limit="3">
                                                            <row-component>
                                                                <col-component lg-12 sm-12 margin-inner-sm>

                                                                    <div class="my-account__timerow">
                                                                        <div class="input">
                                                                            <label class="input__label">Start-Datum</label>
                                                                            <custom-datepicker theme="light"
                                                                                               name="dates[]"
                                                                                               value="04.06.2018"></custom-datepicker>
                                                                        </div>

                                                                        <div class="input">
                                                                            <label class="input__label">End-Datum</label>
                                                                            <custom-datepicker theme="light"
                                                                                               name="dates[]"
                                                                                               value="15.06.2018"></custom-datepicker>
                                                                        </div>
                                                                        <div class="input input--time">
                                                                            <label class="input__label">Uhrzeit von</label>
                                                                            <custom-time-input name="from_date_time"></custom-time-input>
                                                                        </div>

                                                                        <div class="input input--time">
                                                                            <label class="input__label">Uhrzeit bis</label>
                                                                            <custom-time-input name="to_date_time"></custom-time-input>
                                                                        </div>
                                                                    </div>
                                                                </col-component>
                                                            </row-component>
                                                        </div>
                                                    </col-component>
                                                </row-component>
                                            </div>
                                            <div vue-slot="4">
                                                <row-component>
                                                    <col-component lg-12 sm-12 margin-inner-sm>

                                                        <div class="my-account__timerow">
                                                            <div class="input">
                                                                <label class="input__label">Start-Datum</label>
                                                                <custom-datepicker theme="light"
                                                                                   name="dates[]"
                                                                                   value="04.06.2018"></custom-datepicker>
                                                            </div>

                                                            <div class="input">
                                                                <label class="input__label">End-Datum (optional)</label>
                                                                <custom-datepicker theme="light"
                                                                                   name="dates[]"
                                                                                   value="15.06.2018"></custom-datepicker>
                                                            </div>
                                                        </div>
                                                    </col-component>
                                                </row-component>
                                                <row-component>
                                                    <col-component lg-12 sm-12 margin-inner-sm>
                                                        <div class="my-account__timerow">

                                                            <div class="input input--time">
                                                                <label class="input__label">&nbsp;</label>
                                                                <custom-select
                                                                               label="Montag"
                                                                               theme="light"
                                                                               value="1"
                                                                               id="mo"></custom-select>
                                                            </div>

                                                            <div class="input input--time">
                                                                <label class="input__label">Uhrzeit von</label>
                                                                <custom-time-input name="from_date_time"></custom-time-input>
                                                            </div>

                                                            <div class="input input--time">
                                                                <label class="input__label">Uhrzeit bis</label>
                                                                <custom-time-input name="to_date_time"></custom-time-input>
                                                            </div>
                                                        </div>
                                                    </col-component>
                                                </row-component>
                                                <row-component>
                                                    <col-component lg-12 sm-12 margin-inner-sm>
                                                        <div class="my-account__timerow">

                                                            <div class="input input--time">
                                                                <label class="input__label">&nbsp;</label>
                                                                <custom-select
                                                                               label="Dienstag"
                                                                               theme="light"
                                                                               value="1"
                                                                               id="mo"></custom-select>
                                                            </div>

                                                            <div class="input input--time">
                                                                <label class="input__label">Uhrzeit von</label>
                                                                <custom-time-input name="from_date_time"></custom-time-input>
                                                            </div>

                                                            <div class="input input--time">
                                                                <label class="input__label">Uhrzeit bis</label>
                                                                <custom-time-input name="to_date_time"></custom-time-input>
                                                            </div>
                                                        </div>
                                                    </col-component>
                                                </row-component>
                                                <row-component>
                                                    <col-component lg-12 sm-12 margin-inner-sm>
                                                        <div class="my-account__timerow">

                                                            <div class="input input--time">
                                                                <label class="input__label">&nbsp;</label>
                                                                <custom-select
                                                                               label="Mittwoch"
                                                                               theme="light"
                                                                               value="1"
                                                                               id="mo"></custom-select>
                                                            </div>

                                                            <div class="input input--time">
                                                                <label class="input__label">Uhrzeit von</label>
                                                                <custom-time-input name="from_date_time"></custom-time-input>
                                                            </div>

                                                            <div class="input input--time">
                                                                <label class="input__label">Uhrzeit bis</label>
                                                                <custom-time-input name="to_date_time"></custom-time-input>
                                                            </div>
                                                        </div>
                                                    </col-component>
                                                </row-component>
                                                <row-component>
                                                    <col-component lg-12 sm-12 margin-inner-sm>
                                                        <div class="my-account__timerow">

                                                            <div class="input input--time">
                                                                <label class="input__label">&nbsp;</label>
                                                                <custom-select
                                                                               label="Donnerstag"
                                                                               theme="light"
                                                                               value="1"
                                                                               id="mo"></custom-select>
                                                            </div>

                                                            <div class="input input--time">
                                                                <label class="input__label">Uhrzeit von</label>
                                                                <custom-time-input name="from_date_time"></custom-time-input>
                                                            </div>

                                                            <div class="input input--time">
                                                                <label class="input__label">Uhrzeit bis</label>
                                                                <custom-time-input name="to_date_time"></custom-time-input>
                                                            </div>
                                                        </div>
                                                    </col-component>
                                                </row-component>
                                                <row-component>
                                                    <col-component lg-12 sm-12 margin-inner-sm>
                                                        <div class="my-account__timerow">

                                                            <div class="input input--time">
                                                                <label class="input__label">&nbsp;</label>
                                                                <custom-select
                                                                               label="Freitag"
                                                                               theme="light"
                                                                               value="1"
                                                                               id="mo"></custom-select>
                                                            </div>

                                                            <div class="input input--time">
                                                                <label class="input__label">Uhrzeit von</label>
                                                                <custom-time-input name="from_date_time"></custom-time-input>
                                                            </div>

                                                            <div class="input input--time">
                                                                <label class="input__label">Uhrzeit bis</label>
                                                                <custom-time-input name="to_date_time"></custom-time-input>
                                                            </div>
                                                        </div>
                                                    </col-component>
                                                </row-component>
                                            </div>

                                        </custom-dropdown>

                                        <info-box-component class="margin-inner-lg">
                                            Hinweis! - Für einen monatlichen Termin Nutzen Sie bitte die Funktion "Konkrete Daten"
                                        </info-box-component>

                                    </div>
                                </col-component>
                            </row-component>



                            <row-component>
                                <col-component lg-12 sm-12>
                                    <custom-map-autocomplete label="Adresse (Wo findet das Angebot statt?)*"
                                                             error-msg="Addresse nicht gefunden."
                                                             name="address"
                                                             value=""
                                                             api-key="AIzaSyCbXWpD1t8G6omwRJ6yecXh1KLqvk3n2tE"
                                                             :required="true"></custom-map-autocomplete>
                                </col-component>
                            </row-component>

                            <row-component>
                                <col-component lg-12 sm-12>
                                    <input-component
                                        label="Zusatzinformationen Angebotsort (z.B.Raum)"></input-component>
                                </col-component>
                            </row-component>


                            <row-component class="margin-lg">
                                <col-component lg-6 sm-12 margin-inner-sm>
                                    <div class="input">
                                        <label class="input__label">Stadtteil*</label>
                                        <custom-dropdown id="stadtteil"
                                                         name="stadtteil"
                                                         theme="light"
                                                         placeholder="Stadtteil"
                                                         :show-selected-title="true"
                                                         :required="true"
                                                         :options='stadtteile'></custom-dropdown>
                                    </div>
                                </col-component>
                                <col-component lg-6 sm-12 margin-inner-sm>
                                    <div class="input">
                                        <label class="input__label">Zielgruppe*</label>
                                        <custom-dropdown id="age"
                                                         :show-tag="true"
                                                         :show-selected-title="true"
                                                         :required="true"
                                                         show-tag="true"
                                                         placeholder="Alle Zielgruppen"
                                                         :multiple-select="true"
                                                         :options='zielgruppen'></custom-dropdown>
                                    </div>
                                </col-component>
                            </row-component>


                            <row-component>
                                <col-component lg-12 sm-12 margin-inner-sm>
                                    <h2>Über das Angebot</h2>
                                </col-component>
                            </row-component>

                            <row-component>
                                <col-component lg-12 sm-12>
                                    <input-component type="textarea"
                                                     max-length="200"
                                                     label="Kurzbeschreibung / Teaser-Text (max. 200 Zeichen)*"
                                                     :required="true"></input-component>
                                </col-component>
                            </row-component>

                            <row-component>
                                <col-component lg-12 sm-12>
                                    <custom-rte-input id="longdesc"
                                                      name="longdesc"
                                                      type="textarea"
                                                      label="Langbeschreibung"
                                                      max-height="200"></custom-rte-input>
                                </col-component>
                            </row-component>
                            <row-component>
                                <col-component lg-12 sm-12>
                                    <input-component
                                        label="Referent/en, Berufsbezeichnung oder Qualifikation"></input-component>
                                </col-component>
                            </row-component>
                            <row-component>
                                <col-component lg-12 sm-12>
                                    <input-component label="Format"></input-component>
                                </col-component>
                            </row-component>

                            <info-box-component class="margin-inner-lg">
                                Sie haben die Möglichkeit 2 Bilder je Angebot einzupflegen: Das Bühnenbild wird groß am
                                Anfang der Seite angezeigt und benötigt eine Größe von mind. 1242px x 385px.
                                Falls Sie dieses nicht einpflegen erscheint an der Stelle ein generisches Fallback-Bild,
                                passend zur Kategorie.
                                Das Content-Bild wird unterhalb der Langbeschreibung des Angebots angezeigt und entfällt
                                komplett, wenn Sie keines einfügen.
                            </info-box-component>

                            <row-component>
                                <col-component lg-12 sm-12>
                                    <custom-upload label="Bühnen-Bild (max. 1 Bild, mind. 1242px x 385px)"
                                                   name="tx_chancenportal_chancenportal[offer][contentImageContent]"
                                                   file-name="tx_chancenportal_chancenportal[offer][contentImageName]"
                                                   editor="true"
                                                   max-files-error="Es kann nur ein Bild ausgewählt werden"
                                                   max-files="1"></custom-upload>
                                </col-component>
                            </row-component>

                            <row-component>
                                <col-component lg-12 sm-12>
                                    <custom-upload label="Content-Bild (max. 1 Bild)"
                                                   max-files-error="Es kann nur ein Bild ausgewählt werden"
                                                   max-files="1"></custom-upload>
                                </col-component>
                            </row-component>

                            <row-component class="margin-lg">
                                <col-component lg-12 sm-12>
                                    <input-component label="Video-URL (YouTube) einbinden"></input-component>
                                </col-component>
                            </row-component>

                            <row-component>
                                <col-component lg-12 sm-12 margin-inner-sm>
                                    <h2>Über das Angebot</h2>
                                </col-component>
                            </row-component>

                            <row-component>
                                <col-component lg-12 sm-12>
                                    <input-component type="textarea"
                                                     max-length="200"
                                                     label="Spezf. Teilnahmebedingungen (z.B. Anmeldung erforderlich; max. 200 Zeichen)"></input-component>
                                </col-component>
                            </row-component>

                            <row-component>
                                <col-component lg-6 sm-12 margin-inner-sm>
                                    <input-component label="Kursnummer"></input-component>
                                </col-component>
                                <col-component lg-6 sm-12>
                                    <input-component label="Max. Teilnehmeranzahl"></input-component>
                                </col-component>
                            </row-component>

                            <row-component>
                                <col-component lg-6 sm-12 margin-inner-sm>
                                    <input-component label="Kosten"></input-component>
                                </col-component>
                                <col-component lg-6 sm-12 flex middle-lg margin-inner-sm>
                                    <custom-select label="kostenfrei"
                                                   theme="light"
                                                   name="all_coast_groups"
                                                   value="1"
                                                   id="all_coast_groups"></custom-select>
                                </col-component>
                            </row-component>


                            <row-component>
                                <col-component lg-12 sm-12>
                                    <div class="input">
                                        <label class="input__label">Zugang (Offen / mit Mitgliedschaft)</label>
                                        <div>
                                            <custom-radio :is-checked="true"
                                                          id="member_1"
                                                          name="member"
                                                          value="1"
                                                          theme="light"
                                                          label="Keine Angabe"></custom-radio>
                                            <custom-radio :is-checked="false"
                                                          id="member_2"
                                                          name="member"
                                                          value="2"
                                                          theme="light"
                                                          label="Offen (ohne Mitgliedschaft)"></custom-radio>
                                            <custom-radio :is-checked="false"
                                                          id="member_3"
                                                          name="member"
                                                          value="3"
                                                          theme="light"
                                                          label="Mitgliedschaft erforderlich"></custom-radio>
                                        </div>
                                    </div>
                                </col-component>
                            </row-component>

                            <row-component>
                                <col-component lg-12 sm-12>
                                    <div class="input">
                                        <label class="input__label">Barrierefrei</label>
                                        <div>
                                            <custom-radio :is-checked="true"
                                                          id="accessible_1"
                                                          name="accessible"
                                                          value="1"
                                                          theme="light"
                                                          label="Keine Angabe"></custom-radio>
                                            <custom-radio :is-checked="false"
                                                          id="accessible_2"
                                                          name="accessible"
                                                          value="2"
                                                          theme="light"
                                                          label="Ja"></custom-radio>
                                            <custom-radio :is-checked="false"
                                                          id="accessible_3"
                                                          name="accessible"
                                                          value="3"
                                                          theme="light"
                                                          label="Nein"></custom-radio>
                                        </div>
                                    </div>
                                </col-component>
                            </row-component>

                            <row-component class="margin-lg">
                                <col-component lg-6 sm-12 margin-inner-sm>
                                    <input-component label="Mitmachen (max. 100 Zeichen)"
                                                     max-length="100"></input-component>
                                </col-component>
                                <col-component lg-6 sm-12>
                                    <input-component label="Spenden (max. 100 Zeichen)"
                                                     max-length="100"></input-component>
                                </col-component>
                            </row-component>

                            <row-component>
                                <col-component lg-12 sm-12 margin-inner-sm>
                                    <h2>Anbieterinformation</h2>
                                </col-component>
                            </row-component>

                            <row-component>
                                <col-component lg-12 sm-12>
                                    <input-component label="Anbieter *"
                                                     :required="true"></input-component>
                                </col-component>
                            </row-component>

                            <row-component>
                                <col-component lg-12 sm-12>
                                    <input-component
                                        label="Zusatzinformation Anbieter (z.B. Bereich / Organisation)"></input-component>
                                </col-component>
                            </row-component>

                            <row-component class="margin-lg">
                                <col-component lg-12 sm-12>
                                    <input-component label="Name möglicher Kooperationspartner"></input-component>
                                </col-component>
                            </row-component>

                            <row-component>
                                <col-component lg-12 sm-12 margin-inner-sm>
                                    <h2>Ansprechpartner/in</h2>
                                </col-component>
                            </row-component>

                            <info-box-component class="margin-inner-lg">
                                Die Angabe spezifischer Kontaktangaben für die/den Ansprechpartner/in sind
                                freiwillig.<br/>
                                Es wird in jedem Fall einen Kontakt-Button mit der allgemeinen Anbieter Email-Adresse
                                geben.
                            </info-box-component>

                            <row-component>
                                <col-component lg-12 sm-12>
                                    <input-component label="Vorname und Name"></input-component>
                                </col-component>
                            </row-component>

                            <row-component>
                                <col-component lg-12 sm-12>
                                    <input-component label="Zuständigkeit"></input-component>
                                </col-component>
                            </row-component>


                            <row-component>
                                <col-component lg-6 sm-12 margin-inner-sm>
                                    <input-component label="Telefon"></input-component>
                                </col-component>
                                <col-component lg-6 sm-12>
                                    <input-component label="E-Mail"></input-component>
                                </col-component>
                            </row-component>

                            <row-component>
                                <col-component lg-12 sm-12 margin-lg>
                                    <custom-upload label="Foto hinzufügen (max. 1)"
                                                   max-files-error="Es kann nur ein Bild ausgewählt werden"
                                                   max-files="1"></custom-upload>
                                </col-component>
                            </row-component>


                            <row-component>
                                <col-component lg-4 sm-12 margin-inner-sm flex middle-lg>
                                    <a href="#" class="my-account__cancel-link">Angaben verwerfen</a>
                                </col-component>
                                <col-component lg-4 sm-12 margin-inner-sm>
                                    <button-component element="a"
                                                      href="#"
                                                      theme="full">Vorschau</button-component>
                                </col-component>
                                <col-component lg-4 sm-12 margin-inner-sm>
                                    <button-component element="button"
                                                      type="submit"
                                                      theme="full">
                                        Speichern
                                    </button-component>
                                </col-component>
                            </row-component>

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
            this.stadtteile = JSON.stringify([
                {"id": 1, "title": "Rheda", "active": false},
                {"id": 2, "title": "Wiedenbrück", "active": false},
                {"id": 3, "title": "St. Vit", "active": false},
                {"id": 4, "title": "Lintel", "active": false},
                {"id": 5, "title": "Batenhorst", "active": false},
                {"id": 6, "title": "Umkreis", "active": false}
            ]);
            this.types = JSON.stringify([
                {"id": "", "title": "Bitte wählen", "active": true},
                {"id": 1, "title": "Eintrag 1", "active": false},
                {"id": 2, "title": "Eintrag 2", "active": false}
            ]);
            this.categories = JSON.stringify([
                {
                    "id": 1,
                    "title": "Bildung und Betreuung",
                    "active": false,
                    items: [
                        {"id": 2, "title": "Kitas und Kinder- /Ferienbetreuung", "active": false},
                        {"id": 3, "title": "Schulen", "active": false},
                        {"id": 4, "title": "Sprachen", "active": false}
                    ]
                },
                {
                    "id": 110,
                    "title": "Beratung und Unterstützung", "active": false,
                    items: [
                        {"id": 7, "title": "Vor und nach der Geburt", "active": false},
                        {"id": 8, "title": "Leben mit Kind", "active": false},
                        {"id": 9, "title": "Beratungsstellen", "active": false},
                        {"id": 10, "title": "Finanzielle Hilfen", "active": false},
                    ]
                },
                {
                    "id": 11,
                    "title": "Freizeit und Kultur", "active": false,
                    items: [
                        {"id": 12, "title": "Kreativität, Medien und Musik", "active": false},
                        {"id": 13, "title": "Ferienangebote", "active": false}
                    ]
                },
                {
                    "id": 16,
                    "title": "Gesund leben",
                    "active": false,
                    items: [
                        {"id": 17, "title": "Gesundes Aufwachsen", "active": false},
                        {"id": 18, "title": "Ärzte und Krankenhäuser", "active": false},
                        {"id": 19, "title": "Therapeuten und Förderstellen", "active": false},
                        {"id": 129, "title": "Sport", "active": false},
                    ]
                },
                {
                    "id": 20, "title": "Übergang Schule & Beruf", "active": false,
                    items: [
                        {"id": 21, "title": "Hilfe zur Berufswahl", "active": false},
                        {"id": 22, "title": "Berufsvorbereitung", "active": false},
                        {"id": 23, "title": "Ausbildungsförderung", "active": false}
                    ]
                },
            ]);
            this.zielgruppen = JSON.stringify([
                {"id": 1, "title": "Schwangere", "active": false},
                {"id": 2, "title": "0-3 Jahre", "active": false},
                {"id": 3, "title": "4-6 Jahre", "active": false},
                {"id": 3, "title": "7-13 Jahre", "active": false},
                {"id": 4, "title": "14-18 Jahre", "active": false},
                {"id": 5, "title": "19-27 Jahre", "active": false},
                {"id": 6, "title": "Eltern", "active": false},
                {"id": 7, "title": "Eltern / Kind", "active": false},
                {"id": 8, "title": "Fachkräfte", "active": false},
                {"id": 9, "title": "Zugewanderte Menschen", "active": false},
                {"id": 10, "title": "Junge Menschen mit Förderbedarf", "active": false},
            ]);
            this.angebotsTyp = JSON.stringify([
                {"id": 0, "title": "Ohne Termin", "active": true},
                {"id": 1, "title": "Konkrete Daten", "active": false},
                {"id": 2, "title": "Zeitraum", "active": false},
                {"id": 3, "title": "Täglich", "active": false},
                {"id": 4, "title": "Wöchentlich", "active": false},
            ]);
        },
        name: 'Anbieterprofil'
    }
</script>

<style lang="scss">
    @import "../../../styles/pages/my-account.scss";
</style>
