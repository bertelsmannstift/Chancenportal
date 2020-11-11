<template>
    <div class="custom-map" v-show="showMap">
        <div v-if="singleAddressOnly" class="custom-map__click" @click="openLink()"></div>
        <div ref="items" class="custom-map__items">
            <slot></slot>
        </div>
        <div>
            <div class="custom-map__map" ref="custom_map" :style="{'height': height ? height + 'px' : ''}"></div>
        </div>
    </div>
</template>

<script>
    import KachelComponent from "../../backend/components/KachelComponent";

    export default {
        name: 'CustomMap',
        components: {KachelComponent},
        props: ['items', 'apiKey', 'show', 'height', 'icon', 'lat', 'lng', 'link'],
        data() {
            return {
                geocoder: null,
                map: false,
                showMap: false,
                windows: [],
                marker: [],
                initialized: false,
                singleAddressOnly: false,
            }
        },
        watch: {
            show(val) {

                this.showMap = val ? true : false;

                if (this.showMap) {
                    if (this.initialized === false) {
                        this.init();
                        this.initialized = true;
                    }
                }
            }
        },
        methods: {
            openLink() {
                window.open(this.link);
            },
            initSingleMarker() {
                let icon = {
                    url: this.icon ? this.icon : '/img/svg/Icon_Ort.svg',
                    scaledSize: new google.maps.Size(20, 28), // scaled size
                    origin: new google.maps.Point(0, 0), // origin
                    anchor: new google.maps.Point(10, 28) // anchor
                };
                let lat = parseFloat(this.lat);
                let lng = parseFloat(this.lng);
                let marker = new google.maps.Marker({
                    map: this.map,
                    position: {lat: lat, lng: lng},
                    icon: icon
                });
                this.marker.push(marker);
                this.map.setCenter(new google.maps.LatLng(lat, lng));
                this.map.setZoom(14);
            },
            loaded() {
                this.marker = [];
                this.windows = [];
                this.geocoder = new google.maps.Geocoder;
                this.map = new google.maps.Map(this.$refs.custom_map, {
                    center: {lat: 52.0849347, lng: 9.6404649},
                    zoom: 8,
                    disableDefaultUI: this.singleAddressOnly
                });

                if(this.singleAddressOnly === false) {
                    this.$nextTick(() => {
                        this.createMarker();
                    });
                } else {
                    this.$nextTick(() => {
                        this.initSingleMarker();
                    });
                }
            },
            init() {
                if (typeof window.google === 'undefined' || typeof window.google.maps === 'undefined') {
                    $.getScript("https://maps.googleapis.com/maps/api/js?key=" + this.apiKey + "&libraries=geometry", () => {
                        this.loaded();
                    });
                } else {
                    this.loaded();
                }
            },
            createMarker() {
                let icon = {
                    url: this.icon ? this.icon : '/img/svg/Icon_Ort.svg',
                    scaledSize: new google.maps.Size(20, 28), // scaled size
                    origin: new google.maps.Point(0, 0), // origin
                    anchor: new google.maps.Point(10, 28) // anchor
                };

                let items = $(this.$refs.items).find('.kachel');

                if (items.length) {
                    items.each((key, item) => {
                        let $el = $(item);
                        let lat = parseFloat($el.data('lat'));
                        let lng = parseFloat($el.data('lng'));

                        if (!isNaN(lat) && !isNaN(lng)) {

                            let marker = new google.maps.Marker({
                                map: this.map,
                                position: {lat: lat, lng: lng},
                                icon: icon
                            });

                            let infowindow = new google.maps.InfoWindow({
                                content: $el.clone().wrap('<div>').parent().html()
                            });

                            this.marker.push(marker);
                            this.windows.push(infowindow);

                            marker.addListener('click', () => {

                                this.windows.forEach((window) => {
                                    window.close();
                                });

                                infowindow.open(this.map, marker);

                                // Reference to the DIV that wraps the bottom of infowindow
                                let iwOuter = $(this.$refs.custom_map).find('.gm-style-iw');
                                iwOuter.find('.kachel').show();

                                $(this.$refs.custom_map).find('div > div > div:nth-child(1) > div:nth-child(3) > div:nth-child(2) > div:nth-child(4) > div > div:nth-child(1)').remove();

                                /* Since this div is in a position prior to .gm-div style-iw.
                                 * We use jQuery and create a iwBackground variable,
                                 * and took advantage of the existing reference .gm-style-iw for the previous div with .prev().
                                */
                                let iwBackground = iwOuter.prev();

                                // Removes background shadow DIV
                                iwBackground.children(':nth-child(2)').css({'display': 'none'});

                                // Removes white background DIV
                                iwBackground.children(':nth-child(4)').css({'display': 'none'});

                                // Moves the infowindow 115px to the right.
                                iwOuter.parent().parent().css({left: '0px'});

                                // Changes the desired tail shadow color.
                                iwBackground.children(':nth-child(3)').find('div').children().css({'box-shadow': 'rgba(72, 181, 233, 0.6) 0px 1px 6px', 'z-index': '1'});

                                // Reference to the div that groups the close button elements.
                                let iwCloseBtn = iwOuter.next();

                                // Apply the desired effect to the close button
                                iwCloseBtn.css({opacity: '1', right: '29px', top: '6px', 'border-radius': '50%', 'box-shadow': 'none'});

                                // If the content of infowindow not exceed the set maximum height, then the gradient is removed.
                                if ($('.iw-content').height() < 140) {
                                    $('.iw-bottom-gradient').css({display: 'none'});
                                }

                                // The API automatically applies 0.7 opacity to the button after the mouseout event. This function reverses this event to the desired value.
                                iwCloseBtn.mouseout(function () {
                                    $(this).css({opacity: '1'});
                                });

                                setTimeout(() => {
                                    $('.kachel--light').parentsUntil('.gm-style').css('overflow', 'visible');
                                }, 500);
                            });
                        }
                    });
                }
                this.resetZoom();
            },
            setZoom() {
                this.$nextTick(() => {
                    google.maps.event.addListenerOnce(this.map, 'idle', () => {
                        this.showMap = this.show;
                        this.initialized = true;
                        // Set zoom to see all markers
                        let bounds = new google.maps.LatLngBounds();
                        for (let i = 0; i < this.marker.length; i++) {
                            bounds.extend(this.marker[i].getPosition());
                        }

                        this.map.fitBounds(bounds);
                    });
                })
            },
            resetZoom() {
                this.$nextTick(() => {
                    if(this.initialized) {
                        this.showMap = this.show;
                        this.initialized = true;
                        // Set zoom to see all markers
                        let bounds = new google.maps.LatLngBounds();
                        for (let i = 0; i < this.marker.length; i++) {
                            bounds.extend(this.marker[i].getPosition());
                        }

                        this.map.fitBounds(bounds);
                    }
                })
            }
        },
        mounted() {
            if(this.lat && this.lng) {
                this.singleAddressOnly = true;
            }

            if (this.show === true) {
                this.showMap = this.show;
                this.$forceUpdate();
                if (this.initialized === false) {
                    this.init();
                    this.initialized = true;
                }
            }
        }
    }
</script>

<style lang="scss">

    .custom-map__map {
        height: 800px;
        width: 100%;
        margin-top: 20px;
        .kachel {
            width: 450px;
            overflow: visible;
        }
    }

    .custom-map__items {
        display: none;
    }

    .gm-style-iw {
        overflow: visible !important;
        top: 15px !important;
        width: auto !important;
        height: auto !important;
        background-color: #fff !important;
        outline: none;
        box-shadow: none;
        border: 0;
        border-radius: 0;
    }

    .custom-map {
        position: relative;
    }

    .custom-map__click {
        position: absolute;
        top:0;
        left:0;
        height: 100%;
        width: 100%;
        z-index: 99;
        cursor: pointer;
    }

    @include mq(801px) {
        #show_on_map,
        custom-map {
            .kachel__category,
            .kachel__subheadline,
            .kachel__footer {
                display: none !important;
            }
            .custom-map__map .kachel {
                width: 260px;
            }
            .kachel__headline {
                font-size: 14px !important;
                line-height: 20px !important;
            }
            .kachel .kachel__inner {
                padding-top: 10px;
            }
            .kachel .kachel__content {
                padding: 0px 26px 5px 10px;
            }
            .kachel .kachel__arrow {
                right: 8px;
                bottom: 6px;
            }
            .custom-map__map .kachel__map-arrow {
                display: none;
            }
        }
        .custom-map__map {
            height: 300px;
        }
    }
</style>
