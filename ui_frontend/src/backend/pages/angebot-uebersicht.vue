/**
* Name: Angebotübersicht
* Progress: 100
* Jira: BSTCP-5
*/
<template>
    <page-layout-component>
        <main class="main" slot="main">
            <container-component element="section" data-animation="fadeIn">
                <h1>Angebote durchsuchen</h1>
                <row-component>
                    <col-component lg-12>
                        <search-component :show-tags="true"></search-component>
                    </col-component>
                </row-component>
                <row-component>
                    <col-component>
                        <div class="search__offers">
                            <kachel-list-component className="offer-map" :sorting="sorting">
                                <template slot="list">
                                    <kachel-component v-for="offer in offers" :offer="offer" :lat="52.8" :lng="9.5" link="/angebot-detailseite.html" :light="true" :event="true"></kachel-component>
                                </template>
                                <template slot="map">
                                    <kachel-component v-for="offer in offers" :offer="offer" :lat="52.8" :lng="9.5" link="/angebot-detailseite.html" :light="true" :event="true"></kachel-component>
                                </template>
                            </kachel-list-component>
                        </div>
                        <div class="search__providers">
                            <kachel-list-component className="provider-map" :sorting="sorting">
                                <div slot="list">
                                    <kachel-component v-for="offer in offers" :offer="offer" :lat="52.8" :lng="9.5" link="/angebot-detailseite.html" :light="true" :event="true"></kachel-component>
                                </div>
                                <div slot="map">
                                    <kachel-component v-for="offer in offers" :offer="offer" :lat="52.8" :lng="9.5" link="/angebot-detailseite.html" :light="true" :event="true"></kachel-component>
                                </div>
                            </kachel-list-component>
                        </div>
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
    import offers from '../../assets/data';

    export default {
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
                offers: []
            }
        },
        created() {
            this.sorting = JSON.stringify(
                [
                    {
                        "id": "1",
                        "title": "Aktualität",
                        "active": true
                    },
                    {
                        "id": 2,
                        "title": "Zuletzt eingestellt",
                        "active": false
                    }
                ]
            );

            this.offers = offers;
        },
        metaInfo: {
            title: 'Angebotsübersicht'
        },
        name: 'IndexPage'
    }
</script>
