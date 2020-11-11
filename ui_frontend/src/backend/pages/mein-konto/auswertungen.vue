/**
* Name: Mein-Konto - Auswertungen
* Progress: 100
*/
<template>
    <page-layout-component>
        <main class="main" slot="main">
            <container-component element="section" data-animation="fadeIn" class="my-account">
                <row-component class="info-nav__actions">
                    <col-component lg-12>
                        <breadcrumb-component :items='[{"name": "Mein Konto"},{"name": "Auswertungen"}]'></breadcrumb-component>
                    </col-component>
                </row-component>

                    <row-component>
                        <col-component lg-3 sm-12 margin-sm>
                            <my-account-menu-component activeItem="7"></my-account-menu-component>
                        </col-component>
                        <col-component lg-8 sm-12 sm-offset-0 lg-offset-1>
                            <form action="" method="post" enctype="multipart/form-data" autocomplete="off">
                                <row-component class="margin-inner-lg">
                                    <col-component lg-12 sm-12 margin-sm>
                                        <h1 class="margin-small">
                                            Auswertungen
                                        </h1>
                                    </col-component>
                                </row-component>
                                <row-component class="margin-inner-lg">
                                    <col-component lg-12 sm-12>
                                        <div class="my-account__dates">

                                            <div class="my-account__label">Zeitraum:</div>
                                            <custom-datepicker :show-tag="true" id="from_date" name="dates[]"
                                                               placeholder="Von" end-date="#to_date"></custom-datepicker>

                                            <div class="my-account__seperator">-</div>

                                            <custom-datepicker :show-tag="true" start-date="#from_date" id="to_date" name="dates[]"
                                                               placeholder="Bis"></custom-datepicker>
                                        </div>
                                    </col-component>
                                </row-component>
                                <row-component class="margin-lg">
                                    <col-component lg-12 sm-12 margin-sm>
                                        <border-box-component element="div" theme="container">
                                            <row-component class="margin-inner-lg">
                                                <col-component lg-8 sm-12 flex middle-lg margin-inner-sm>
                                                    <h2 class="no-margin">
                                                        Kartenansicht
                                                    </h2>
                                                </col-component>
                                                <col-component lg-4 sm-12 margin-sm>
                                                    <custom-dropdown :show-tag="true" id="category" :show-selected-title="true"
                                                                     :multiple-select="false"
                                                                     :options="categories"></custom-dropdown>
                                                </col-component>
                                            </row-component>

                                            <custom-map height="400" show="true" api-key="AIzaSyCbXWpD1t8G6omwRJ6yecXh1KLqvk3n2tE">
                                                <div class="kachel-list__items">
                                                    <kachel-component :lat="52.8" :lng="9.5" link="/angebot-detailseite.html" :light="true" :event="true"></kachel-component>
                                                </div>
                                            </custom-map>
                                        </border-box-component>
                                    </col-component>
                                </row-component>
                                <row-component class="margin-lg">
                                    <col-component lg-12 sm-12 margin-sm>
                                        <border-box-component element="div" theme="container">
                                            <h2>Suche nach Kategorien</h2>

                                            <custom-chart :items="chartItems1"></custom-chart>
                                        </border-box-component>
                                    </col-component>
                                </row-component>
                                <row-component class="margin-lg">
                                    <col-component lg-12 sm-12 margin-sm>
                                        <border-box-component element="div" theme="container">
                                            <h2>Aufrufe der Angebote</h2>

                                            <row-component>
                                                <col-component lg-12 margin-inner-lg>
                                                    <custom-chart id="chart1" :items="chartItems2" limit="true"></custom-chart>
                                                </col-component>
                                            </row-component>
                                            <row-component>
                                                <col-component lg-12 sm-12 margin-sm flex end-lg>

                                                    <custom-trigger class-name="btn btn--primary" selector="#chart1" toggle-attr="limit" more="+ Mehr anzeigen" less="- Weniger anzeigen"></custom-trigger>
                                                </col-component>
                                            </row-component>

                                        </border-box-component>
                                    </col-component>
                                </row-component>
                                <row-component class="margin-lg">
                                    <col-component lg-12 sm-12 margin-sm>
                                        <border-box-component element="div" theme="container">
                                            <h2>Liste der Suchbegriffe</h2>

                                            <dl>
                                                <dt><strong>Suchbegriff</strong></dt>
                                                <dd><strong>Anzahl</strong></dd>
                                                <dt>Kita</dt>
                                                <dd>12</dd>
                                                <dt>Anbieter</dt>
                                                <dd>234</dd>
                                                <dt>Familien</dt>
                                                <dd>54</dd>
                                                <dt>Bildung</dt>
                                                <dd>3</dd>
                                            </dl>

                                            <dl id="terms" class="hide">

                                                <dt>Kita</dt>
                                                <dd>12</dd>
                                                <dt>Anbieter</dt>
                                                <dd>234</dd>
                                                <dt>Familien</dt>
                                                <dd>54</dd>
                                                <dt>Bildung</dt>
                                                <dd>3</dd>
                                            </dl>

                                            <row-component>
                                                <col-component lg-12 sm-12 margin-sm flex end-lg>

                                                    <custom-trigger class-name="btn btn--primary" selector="#terms" toggle-class="hide" more="+ Mehr anzeigen" less="- Weniger anzeigen"></custom-trigger>
                                                </col-component>
                                            </row-component>
                                        </border-box-component>
                                    </col-component>
                                </row-component>

                                <row-component class="margin-lg">
                                    <col-component lg-12 sm-12 margin-sm>
                                        <border-box-component element="div" theme="container">
                                            <h2>Aufrufe der Angebote</h2>

                                            <row-component>
                                                <col-component lg-12 sm-12 margin-sm>

                                                    <custom-google-chart labels='["PLZ", "Anzahl der Angebote"]' data='[["33602", "10"],["33613", "20"]]' loading="false" no-entries="Keine Einträge"></custom-google-chart>
                                                </col-component>
                                            </row-component>

                                        </border-box-component>
                                    </col-component>
                                </row-component>
                            </form>
                        </col-component>
                    </row-component>

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
    import KachelComponent from "../../components/KachelComponent";

    export default {
        components: {
            KachelComponent,
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
            this.chartItems1 = JSON.stringify([
                {"count": 120, "name": "Bildung und Betreuung"},
                {"count": 100, "name": "Beratung und Unterstützung"},
                {"count": 90, "name": "Freizeit und Kultur"},
                {"count": 50, "name": "Bildung und Betreuung"},
                {"count": 20, "name": "Gesundheit und Vorsorge"},
            ]);
            this.chartItems2 = JSON.stringify([
                {"count": 200, "name": "Ernährungsberatung"},
                {"count": 50, "name": "Einführung in die Bibliotheksbenutzung"},
                {"count": 20, "name": "Abenteuer Schnitzeljagd"},
                {"count": 10, "name": "Ehrenamt-Stammtisch"},
                {"count": 5, "name": "Kreativ-Workshop"},
            ]);
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
                        {"id": 129, "title": "Sport", "active": false},
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
                        {"id": 23, "title": "Ausbildungsförderung", "active": false}
                    ]},
            ]);

            this.angebotsTyp = JSON.stringify([
                {"id": 1, "title": "Einmaliges Angebot", "active": true},
                {"id": 2, "title": "Regelmäßiges Angebot", "active": false},
                {"id": 3, "title": "Wöchentlich Angebot", "active": false}
            ]);
        },
        name: 'Anbieterprofil'
    }
</script>

<style lang="scss">
    @import "../../../styles/pages/my-account.scss";
</style>
