/**
* Name: Anbieterübersicht
* Progress: 100
* Jira: BSTCP-6
*/
<template>
    <page-layout-component>
        <main class="main" slot="main">
            <container-component element="section" data-animation="fadeIn">
                <h1>Anbieter durchsuchen</h1>
                <row-component>
                    <col-component lg-12>
                        <search-component :is-provider="true" :show-tags="true"></search-component>
                    </col-component>
                </row-component>
                <row-component>
                    <col-component>
                        <kachel-list-component :sorting="sort" :show-map="false">

                            <kachel-component title="Kindertageseinrichtung „Spielkiste“ (Bitte das AWO Zentrum dafür raus nehmen)" text="Eine der größten, von Eltern getragenen Tagesstätteneinrichtungen in OWL mit über 86 Kindern" link="/anbieter-detailseite.html"
                                              :light="true" type="image-text" image="/img/logos/logo-spielkiste.jpg" :event="true"></kachel-component>
                            <kachel-component link="/anbieter-detailseite.html" title="Familienzentrum Die Zwei"
                                              text="Unser Familienzentrum aus dem Verbund zweier Kitas betreut Kinder im Alter von 1 Jahr bis zum Schuleintritt."
                                              image="/img/logos/die2logofinale3-1-750x410.jpg" :light="true" type="image-text"
                                              :event="true"></kachel-component>
                            <kachel-component link="/anbieter-detailseite.html" title="Caritas"
                                              text="Zentrale Anlaufstelle für Menschen aller Generationen und sind Ansprechpartner für Ihre Fragen rund um die Familie."
                                              image="/img/logos/2000px-Caritas_logo.png" :light="true" type="image-text"
                                              :event="true"></kachel-component>
                            <kachel-component link="/anbieter-detailseite.html"
                                              title="Ems-Berufskolleg" text="Das kaufmännische Berufskolleg im Kreis Gütersloh."
                                              image="/img/logos/SIMONSWERK_Tuerband_Azubi_Partnerschaften_EMS_Berufskolleg.jpg" :light="true" type="image-text"
                                              :event="true"></kachel-component>
                            <kachel-component link="/anbieter-detailseite.html" title="Familienzentrum Glückskind"
                                              text="Familienzentrum mit breitem Angebot an Kursen rund um Geburt sowie mit und für Kinder(n)."
                                              image="/img/logos/slide_01_logo.png" :light="true" type="image-text"
                                              :event="true"></kachel-component>
                            <kachel-component link="/anbieter-detailseite.html" title="VHS im Stadthaus Wiedenbrück"
                                              text="Ganzheitliches Bildungs- und Kulturunternehmen"
                                              image="/img/logos/vhs-Logo.svg" :light="true" type="image-text"
                                              :event="true"></kachel-component>

                            <kachel-component link="/anbieter-detailseite.html" title="AWO Familienzentrum"
                                              image="/img/logos/logo_awo.jpg" :light="true" type="image-text"
                                              :event="true"></kachel-component>
                            <kachel-component link="/anbieter-detailseite.html"
                                              :light="true" type="image-text" :event="true"></kachel-component>
                            <kachel-component link="/anbieter-detailseite.html"
                                              :light="true" type="image-text" :event="true"></kachel-component>

                        </kachel-list-component>
                    </col-component>
                </row-component>
            </container-component>

        </main>
    </page-layout-component>
</template>

<script>
    import PageLayoutComponent from '../layouts/PageLayoutComponent.vue';
    import ContainerComponent from "../components/ContainerComponent";
    import RowComponent from "../components/RowComponent";
    import ColComponent from "../components/ColComponent";
    import KachelComponent from "../components/KachelComponent";
    import KachelTeaserComponent from "../components/KachelTeaserComponent";
    import ButtonComponent from "../components/ButtonComponent";
    import BorderBoxComponent from "../components/BorderBoxComponent";
    import TeaserComponent from "../components/TeaserComponent";
    import SearchComponent from "../components/SearchComponent";
    import KachelListComponent from "../components/KachelListComponent";

    export default {
        props: ['sorting'],
        components: {
            KachelListComponent,
            SearchComponent,
            TeaserComponent,
            BorderBoxComponent,
            ButtonComponent,
            KachelTeaserComponent,
            KachelComponent,
            ColComponent,
            RowComponent,
            ContainerComponent,
            PageLayoutComponent,
        },
        data() {
            return {
                sort: ''
            }
        },
        created() {
            this.sort = JSON.stringify(
                [
                    {
                        "id": "1",
                        "title": "A-Z",
                        "active": true
                    },
                    {
                        "id": 2,
                        "title": "Aktualität",
                        "active": false
                    }]);
        },
        metaInfo: {
            title: 'Anbieterübersicht'
        },
        name: 'IndexPage'
    }
</script>
