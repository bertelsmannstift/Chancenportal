/**
* Name: Suchbox
* Progress: 99
*/
<template>
    <div>
        <custom-ajax-form :ajax="true" class="search" url="/angebot-uebersicht.html" method="get"
                          content-selector=".kachel-list__items">
            <row-component class="search__row margin-inner-sm">
                <col-component lg-6 md-12 margin-md>
                    <div class="search__label">
                        <span v-if="isProvider">Was für Anbieter suchen Sie?</span>
                        <span v-else>Was für Angebote suchen Sie?</span>
                    </div>
                    <div class="search__fields search__fields--joined">
                        <custom-dropdown :show-tag="true" id="category" :show-selected-title="true"
                                         :multiple-select="false"
                                         submit-on-change="true"
                                         :options='kategorien'></custom-dropdown>
                        <custom-input css-class="search__input" id="offers" show-tag="true" submit-on-change="true" placeholder="Suchbegriff"></custom-input>
                    </div>
                </col-component>
                <col-component lg-6 md-12>
                    <div class="search__label">
                        Wo suchen Sie?
                    </div>
                    <div class="search__fields search__fields--submit">
                        <custom-dropdown allow-group-selection="false" :show-tag="true" class="search__dropdown--full" id="location"
                                         :show-selected-title="true"
                                         :multiple-select="true" placeholder="Alle Ortsteile"
                                         :options='orte'></custom-dropdown>
                        <button-component class="search__submit" element="button" type="submit">Suchen
                        </button-component>
                    </div>
                    <custom-trigger class="search__trigger" toggle-class="search__fields--showhide" selector="#hidden-box" more="+ Mehr anzeigen"
                                    less="- Weniger anzeigen"></custom-trigger>
                </col-component>
            </row-component>
            <row-component>
                <col-component lg-12>
                    <div id="hidden-box" class="search__fields search__fields--showhide">

                        <custom-dropdown id="date" :show-selected-title="true" placeholder="Zeit / Zeitraum">
                            <div class="search__fields__layer">
                                <custom-radio :is-checked="true" id="timerange"
                                              disabled-selector="#from_date,#to_date"
                                              show-selector="#to_date,#from_date,.search__fields__dates,.search__fields__seperator"
                                              hide-selector="#single_date,.search__fields__weekdays" name="dateType" value="1"
                                              label="Zeitraum"></custom-radio>

                                <custom-radio id="singledate" name="dateType"
                                              disabled-selector="#single_date"
                                              show-selector=".search__fields__dates,#single_date"
                                              hide-selector="#from_date,#to_date,.search__fields__seperator,.search__fields__weekdays"
                                              value="2" label="Festes Datum"></custom-radio>

                                <div class="search__fields__dates">

                                    <custom-datepicker submit-on-change="true" :show-tag="true" id="from_date" name="dates[]"
                                                       placeholder="Von" end-date="#to_date"></custom-datepicker>

                                    <div class="search__fields__seperator">-</div>

                                    <custom-datepicker submit-on-change="true" :show-tag="true" start-date="#from_date" id="to_date" name="dates[]"
                                                       placeholder="Bis"></custom-datepicker>

                                    <custom-datepicker submit-on-change="true" :show-tag="true" id="single_date" name="dates[]"
                                                       placeholder="Datum"></custom-datepicker>
                                </div>

                                <custom-radio id="days" name="dateType" hide-selector=".search__fields__dates" show-selector=".search__fields__weekdays"
                                              disabled-selector="#montag,#dienstag,#mittwoch,#donnerstag,#freitag,#samstag,#sontag"
                                              value="3" label="Nur an bestimmten Wochentagen"></custom-radio>

                                <div class="search__fields__weekdays">
                                    <custom-select submit-on-change="true" :show-tag="true" label="Mo." value="1" show-tag="true" :is-disabled="true"
                                                   id="montag"></custom-select>
                                    <custom-select submit-on-change="true" :show-tag="true" label="Di." value="1" show-tag="true" :is-disabled="true"
                                                   id="dienstag"></custom-select>
                                    <custom-select :show-tag="true" label="Mi." value="1" show-tag="true" :is-disabled="true"
                                                   id="mittwoch"></custom-select>
                                    <custom-select :show-tag="true" label="Do." value="1" show-tag="true" :is-disabled="true"
                                                   id="donnerstag"></custom-select>
                                    <custom-select :show-tag="true" label="Fr." value="1" show-tag="true" :is-disabled="true"
                                                   id="freitag"></custom-select>
                                    <custom-select :show-tag="true" label="Sa." value="1" show-tag="true" :is-disabled="true"
                                                   id="samstag"></custom-select>
                                    <custom-select :show-tag="true" label="So." value="1" show-tag="true" :is-disabled="true"
                                                   id="sontag"></custom-select>
                                </div>
                            </div>
                        </custom-dropdown>

                        <custom-dropdown submit-on-change="true" allow-group-selection="false" id="age" :show-tag="true" :show-selected-title="true" show-tag="true"
                                         placeholder="Alter / Zielgruppe" :multiple-select="true"
                                         :options='zielgruppen'></custom-dropdown>

                        <custom-select submit-on-change="true" label="Barrierefrei" :show-tag="true" value="barrierefrei" show-tag="true"
                                       id="barrierefrei"></custom-select>

                        <custom-select submit-on-change="true" label="Kostenfrei" :show-tag="true" value="kostenfrei" show-tag="true"
                                       id="kostenfrei"></custom-select>

                    </div>
                </col-component>
            </row-component>
        </custom-ajax-form>

        <row-component v-if="showTags" class="search__tags">
            <col-component lg-4 sm-12 flex middle-lg>
                <div>
                    <div class="search__tabs">
                        <div class="search__tab search__tab--active" data-toggle-class="search__tab--active" data-toggle-items=".search__offers,.search__providers" data-toggle-show=".search__offers">
                            <strong>Angebote (<span class="search__count">12</span>)</strong>
                        </div>
                        <div class="search__tab" data-toggle-class="search__tab--active" data-toggle-items=".search__offers,.search__providers" data-toggle-show=".search__providers">
                            <strong>Anbieter (<span class="search__count">23</span>)</strong>
                        </div>
                    </div>
                </div>
            </col-component>
            <col-component lg-8 sm-12 flex middle-lg>
                <custom-active-filter :hide-delete-all="true"></custom-active-filter>
            </col-component>
        </row-component>
    </div>
</template>


<script>
    import RowComponent from "./RowComponent";
    import ColComponent from "./ColComponent";
    import ButtonComponent from "./ButtonComponent";

    export default {
        props: {
            showTags: {
                default: false,
                type: Boolean
            },
            isProvider: {
                default: false,
                type: Boolean
            },
            ajax: {
                default: true,
                type: Boolean
            }
        },
        data() {
            return {
                kategorien: '',
                zielgruppen: '',
                orte: '',
            }
        },
        created() {
            this.kategorien = JSON.stringify([
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


            this.zielgruppen = JSON.stringify([
                {"id": 1, "title": "Schwangere", "active": false},
                {"id": 2, "title": "0-3 Jahre", "active": false},
                {"id": 3, "title": "4-6 Jahre", "active": false},
                {"id": 4, "title": "7-13 Jahre", "active": false},
                {"id": 5, "title": "14-18 Jahre", "active": false},
                {"id": 6, "title": "19-27 Jahre", "active": false},
                {"id": 7, "title": "Eltern", "active": false},
                {"id": 8, "title": "Eltern / Kind", "active": false},
                {"id": 9, "title": "Fachkräfte", "active": false},
                {"id": 10, "title": "Zugewanderte Menschen", "active": false},
                {"id": 11, "title": "Junge Menschen mit Förderbedarf", "active": false},
            ]);

            this.orte = JSON.stringify([
                {"id": 1, "title": "Rheda", "active": false},
                {"id": 2, "title": "Wiedenbrück", "active": false},
                {"id": 3, "title": "St. Vit", "active": false},
                {"id": 4, "title": "Lintel", "active": false},
                {"id": 5, "title": "Batenhorst", "active": false},
                {"id": 6, "title": "Umkreis", "active": false}
            ]);
        },
        components: {
            ButtonComponent,
            ColComponent,
            RowComponent
        },
        name: 'SearchComponent'
    }
</script>

<style lang="scss">

    .search__fields__layer {
        width: 548px;

        @include mq('sm') {
            width: 358px;
        }
        @include mq('xs') {
            width: 100%;
            padding: 15px 15px 10px !important;
        }

        custom-radio {
            margin-right: 15px;
            margin-bottom: 25px;
            display: inline-block;
        }
    }

    .search__fields__weekdays {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        custom-select {
            width: 33.3333333%;
            flex: 1 1 auto;
            margin-bottom: 12px;
            padding-left: 30px;
            display: block;
            @include mq('xs') {
                padding-left: 0px;
            }
        }
    }


    .search__fields__dates {
        display: flex;
        flex-direction: row;
        padding: 0px 0 35px;
        align-items: center;

        > custom-datepicker {
            width: 40%;
            @include mq('sm') {
                width: 100%;
            }
        }
        @include mq('sm') {
            flex-direction: column;
        }
        > :first-child {
            flex: 0 1 auto;

            @include mq('sm') {
                margin-right: 0;
            }
        }
    }

    .search__fields__seperator {
        margin: 0 8px;
    }

    .search {
        background-color: $color-gray-light;
        padding: 26px;
        width: 100%;
        position: relative;
        text-align: left;
        @include mq('md') {
            padding: 20px 15px !important;
        }

        .search__dropdown--full {
            flex: 0 1 auto;
            width: calc(100% - 160px);
            max-width: none;
            @include mq('sm') {
                width: 100%;
            }
        }
    }

    .search__tags {
        margin-top: 30px;
        margin-bottom: 0px;

        strong {
            margin-top: 10px;
            display: block;
            line-height: 2rem;
        }
        @include mq('sm') {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            > div:first-child {
                order: 1;
                margin-top: 15px;
            }
            > div:last-child {
                order: 0;
            }
        }
    }

    .search__tabs {
        display: flex;
        flex-direction: row;
        .search__tab {
            padding: 0px 20px 8px;
            background-color: $color-gray-light;
            border-radius: 5px;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
            margin-right: 10px;
            cursor: pointer;
            &.search__tab--active, &:hover {
                background-color: $color-yellow;
            }
        }
    }

    .search__trigger {
        text-align: right;
        padding: 5px 0;
    }

    .search__input {
        padding: 14px 16px;
        outline: none;
        color: #000;
        flex: 1;
        border: 1px solid #d4d4d4;
        width: 100%;
        @include mq('sm') {
            width: 100%;
        }
    }

    .search__label {
        margin-bottom: 15px;
    }

    custom-input {
        display: block;
        width: 100%;
    }

    .search__fields {
        display: flex;
        flex-wrap: nowrap;
        flex-direction: row;
        align-items: center;

        &.search__fields--showhide {
            display: none;
        }

        @include mq('sm') {
            display: block;
            flex-wrap: wrap;
            flex-direction: column;
            justify-content: flex-start;
            align-items: flex-start;

            custom-select {
                margin-bottom: 15px;
                margin-left: 20px;
            }
        }

        &--submit {
            align-items: flex-end;

            [type="submit"] {
                height: 50px;
            }
        }

        custom-dropdown {
            max-width: 214px;
            flex: 1;
            @include mq('sm') {
                width: 100%;
                margin-bottom: 15px;
                max-width: none;
            }
        }

        > * {
            margin-right: 20px;
            @include mq('sm') {
                margin-right: 0px;
            }
        }

        .search__submit {
            width: 140px;
            margin: 0;
            @include mq('sm') {
                margin-right: 0px;
            }
        }

        &.search__fields--joined {
            custom-input {
                width: calc(100% - 230px);
                @include mq('sm') {
                    width: 100%;
                }
            }
            .search__input {
                width: 100%;
            }
            > * {
                margin-right: 0px;
            }
        }
    }
</style>
