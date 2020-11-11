<template>
    <div class="input" :class="[className, {'input--error': error}]">
        <label class="input__label" v-if="label">{{label}}</label>
        <div class="input__wrapper">
            <input ref="input" @focus="geolocate()" @keydown.enter.prevent @blur="fillInAddressFromInput" class="input__field" :placeholder="placeholderText" type="text" :name="name" :required="required" v-model="inputValue" autocomplete="new-password">
            <input type="hidden" v-if="lat.toString().length" :name="nameLat" :value="lat" />
            <input type="hidden" v-if="lng.toString().length" :name="nameLng" :value="lng" />
            <input type="hidden" v-if="zip.toString().length" :name="nameZip" :value="zip" />
            <input type="hidden" v-if="city.toString().length" :name="nameCity" :value="city" />
            <input type="hidden" v-if="street.toString().length" :name="nameStreet" :value="street" />
        </div>

        <div class="input__error" v-if="error && errorMsg">
            {{errorMsg}}
        </div>
    </div>
</template>

<script>

    export default {
        name: 'CustomMapAutocomplete',
        props: {
            label: {
                default: null,
                type: String
            },
            placeholderText: {
                default: '',
                type: String
            },
            apiKey: {
                default: null,
                type: String
            },
            minHeight: {
                default: 120,
                type: [String, Number]
            },
            maxLength: {
                default: null,
                type: [String, Number]
            },
            name: {
                default: null,
                type: String
            },
            nameLat: {
                default: null,
                type: String
            },
            nameLng: {
                default: null,
                type: String
            },
            nameZip: {
                default: null,
                type: String
            },
            nameCity: {
                default: null,
                type: String
            },
            nameStreet: {
                default: null,
                type: String
            },
            value: {
                default: '',
                type: String
            },
            zipMustExists: {
                default: false,
                type: Boolean
            },
            className: {
                default: '',
                type: String
            },
            required: Boolean,
            errorMsg: {
                default: null,
                type: String
            },
        },
        data() {
            return {
                autocomplete: null,
                lat: '',
                lng: '',
                zip: '',
                city: '',
                street: '',
                inputValue: '',
                isCorrect: false,
                error: false,
            }
        },
        watch: {
            inputValue() {
                this.isCorrect = false;
            }
        },
        methods: {
            geolocate() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition((position) => {
                        let geolocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        let circle = new google.maps.Circle({
                            center: geolocation,
                            radius: position.coords.accuracy
                        });
                        this.autocomplete.setBounds(circle.getBounds());
                    });
                }
            },
            fillInAddressFromInput(e) {
                this.$nextTick(()=>{

                    if(this.isCorrect === false && e && e.target) {

                        let geocoder = new google.maps.Geocoder();
                        geocoder.geocode( {address: this.inputValue, componentRestrictions: {country: 'de'}}, (data, status) => {
                            if(data.length === 0) {
                                return;
                            }

                            this.setFieldData(data[0]);
                        });
                    }
                });
            },
            fillInAddress() {
                let place = this.autocomplete.getPlace();

                this.setFieldData(place);
            },
            setFieldData(data) {
                let zipcode = '';
                let street = '';
                let street_nr = '';
                let city = '';
                for(let j=0;j < data.address_components.length; j++){

                    for(let k=0; k < data.address_components[j].types.length; k++){
                        if(data.address_components[j].types[k] == "postal_code"){
                            zipcode = data.address_components[j].long_name;
                        }
                        if(data.address_components[j].types[k] == "route"){
                            street = data.address_components[j].long_name;
                        }
                        if(data.address_components[j].types[k] == "street_number"){
                            street_nr = data.address_components[j].long_name;
                        }
                        if(data.address_components[j].types[k] == "locality"){
                            city = data.address_components[j].long_name;
                        }
                    }
                }

                try {

                    if(this.zipMustExists === true && zipcode === '') {
                        throw new Error('Zip not found');
                    }

                    this.inputValue = data.formatted_address;
                    this.lat = data.geometry.location.lat();
                    this.lng = data.geometry.location.lng();
                    this.zip = zipcode;
                    this.city = city;
                    this.street = (street.length ? street + ' ' : '') + street_nr;
                    this.isCorrect = true;
                    this.error = false;
                } catch (e) {
                    this.inputValue = '';
                    this.lat = '';
                    this.lng = '';
                    this.zip = '';
                    this.city = '';
                    this.street = '';
                    this.isCorrect = false;
                    this.error = true;
                }
            },
            init() {

                this.inputValue = this.value;
                let input = this.$refs.input;
                let options = {
                    types: ['geocode'],
                    componentRestrictions: {country: 'de'}
                };

                this.autocomplete = new google.maps.places.Autocomplete(input, options);
                this.autocomplete.addListener('place_changed', this.fillInAddress);

                if(this.inputValue && this.inputValue.toString().trim() !== '') {
                    this.fillInAddressFromInput();
                }
            }
        },
        mounted() {
            this.inputValue = this.value;
            $.getScript("https://maps.googleapis.com/maps/api/js?key=" + this.apiKey + "&libraries=places", () => {
                this.init();
            });
        }
    }
</script>

<style lang="scss">
    .input {
        margin-bottom: 15px;
        position: relative;

        .input__wrapper {
            position: relative;
        }

        .input__label {
            display: block;
            margin-bottom: 8px;
            @include font-size(16);
        }
        .input__field {
            color: $color-black;
            border: 1px solid $color-input;
            padding: 14px 16px;
            outline: none;
            width: 100%;
        }
        textarea, .input__field--rte {
            resize: vertical;
        }
        .input__field--rte {
            overflow-x: hidden;
            overflow-y: auto;
            height: 220px;
            min-height: 220px;
        }
        &.input--error {
            .input__label {
                color: #d81018;
            }
            .input__error {
                @include font-size(14);
                color: #d81018;
                padding-top: 5px;
            }
        }
    }
</style>
