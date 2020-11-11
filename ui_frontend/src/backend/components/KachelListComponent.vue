<template>
    <div class="kachel-list">
        <row-component class="kachel-list__sorting">
            <col-component lg-6 margin-inner-md sm-12>
                <div class="flex middle-lg">
                    <strong class="kachel-list__sort">Sortieren nach: </strong>
                    <custom-dropdown form-selector=".search form" id="sort" :show-selected-title="true"
                                     :multiple="false"
                                     :options="sorting"></custom-dropdown>
                </div>
            </col-component>
            <col-component lg-6 md-12 end-lg sm-12 start-md start-sm>

                <a id="show_on_map" title="Auf Karte anzeigen" class="btn btn--primary btn--icon" data-toggle-class="btn--active" :data-toggle-show-item="'.' + className">
                    <i class="icon-map-marker"></i>
                    Auf Karte anzeigen
                </a>
            </col-component>
        </row-component>

        <custom-map ref="custom_map" :class="className" api-key="AIzaSyCbXWpD1t8G6omwRJ6yecXh1KLqvk3n2tE">
            <slot name="map"></slot>
        </custom-map>

        <div class="kachel-list__items">
            <slot name="list"></slot>
        </div>

        <custom-pagination items-per-page="10" js-pagination=".kachel-list__items"></custom-pagination>
    </div>
</template>

<script>
    import RowComponent from "./RowComponent";
    import ColComponent from "./ColComponent";
    import ButtonComponent from "./ButtonComponent";

    export default {
        props: {
            sorting: {
                default: ''
            },
            className: {
                default: 'offer-map'
            }
        },
        components: {
            ButtonComponent,
            ColComponent,
            RowComponent
        },
        data() {
            return {
                items: []
            }
        },
        created() {
            this.items = JSON.stringify([
                {
                    name: 'Kachelansicht',
                    icon: 'th-large',
                    active: true,
                    actions: [
                        {
                            selector: 'custom-map',
                            prop: {
                                "show": false
                            },
                        },
                        {
                            selector: 'custom-pagination',
                            prop: {
                                "show": true
                            },
                        }
                    ]
                },
                {
                    name: 'Auf Karte anzeigen',
                    icon: 'map-marker',
                    active: false,
                    actions: [
                        {
                            selector: 'custom-map',
                            prop: {
                                "show": true
                            },
                        },
                        {
                            selector: 'custom-pagination',
                            prop: {
                                "show": false
                            },
                        }
                    ]
                }
            ]);
        },
        name: 'KachelListComponent'
    }
</script>

<style lang="scss">
    .kachel-list {
        border-top: 1px solid $color-gray-light;
        padding-top: 20px;
        min-height: 300px;
    }

    .kachel-list__items {
        display: flex;
        flex-direction: row;
        justify-content: stretch;
        flex-wrap: wrap;
        margin: 0 -10px;

        > div, > span {
            height: auto;
            width: calc(50% - 20px);
            margin: 10px;
            flex: 0 1 auto;
            @include mq('sm') {
                width: 100%;
            }
        }
    }

    .kachel-list__sorting {
        margin-bottom: 10px;
    }

    .kachel-list__sort {
        display: inline-block;
        margin-right: 10px;
    }
</style>
