/**
* Name: Mein-Konto - Angebote
* Progress: 100
*/
<template>
    <page-layout-component>
        <main class="main" slot="main">
            <container-component element="section" data-animation="fadeIn" class="my-account">
                <row-component class="info-nav__actions">
                    <col-component lg-12>
                        <breadcrumb-component :items='[{"name": "Mein Konto"}, {"name": "Angebote"}]'></breadcrumb-component>
                    </col-component>
                </row-component>

                    <div class="my-account">
                        <row-component>
                            <col-component lg-3 sm-12 margin-sm>
                                <my-account-menu-component activeItem="4"></my-account-menu-component>
                            </col-component>
                            <col-component lg-8 sm-12 sm-offset-0 lg-offset-1>
                                <h1>
                                    Angebote
                                </h1>

                                <row-component class="margin-lg">
                                    <col-component lg-3 sm-12 margin-inner-sm flex middle-lg>
                                        <a href="#" class="my-account__download">neues Angebot anlegen</a>
                                    </col-component>
                                    <col-component lg-3 sm-12 margin-inner-sm>
                                        <button-component element="a" href="#" theme="full">Importvorlage herunterladen</button-component>
                                    </col-component>
                                    <col-component lg-3 sm-12 margin-inner-sm>
                                        <form class="upload-button__form" action="" method="post">
                                            <custom-upload-button submit="true">
                                                Neue Angebote importieren (Excel)
                                            </custom-upload-button>
                                        </form>
                                    </col-component>
                                    <col-component lg-3 sm-12>
                                        <button-component element="a" theme="full">Export aller aktuellen Angebotsdaten</button-component>
                                    </col-component>
                                </row-component>

                                <row-component class="margin-inner">
                                    <col-component lg-12>
                                        <div class="divider-top">

                                            <input-component id="filter_term" label="Suchbegriff"></input-component>
                                        </div>
                                    </col-component>
                                </row-component>

                                <row-component>
                                    <col-component lg-12 sm-12 margin-lg>
                                        <custom-datatable sorting='[{"col": "0"}, {"col": "1"}, {"col": "3"}, {"col": "4"}, {"col": "5"}]'>
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>PLZ / ORT</th>
                                                    <th>Zeitraum</th>
                                                    <th>Regeltermin</th>
                                                    <th>Status</th>
                                                    <th>Datum</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>Spielend in Bewegung bleiben</td>
                                                    <td>33378 Rheda-Wiedenbrück</td>
                                                    <td>01.01.2018 - 02.02.2018</td>
                                                    <td>Ja</td>
                                                    <td>Freigegeben</td>
                                                    <td>04.01.2018</td>
                                                    <td>
                                                        <a href="#"><i class="icon-times-circle"></i></a>
                                                        <a href="#"><i class="icon-pencil"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Offene Krabbelgruppe</td>
                                                    <td>33378 Rheda-Wiedenbrück</td>
                                                    <td>01.01.2018 - 02.02.2018</td>
                                                    <td>Ja</td>
                                                    <td>Freigegeben</td>
                                                    <td>02.02.2018</td>
                                                    <td>
                                                        <a href="#"><i class="icon-times-circle"></i></a>
                                                        <a href="#"><i class="icon-pencil"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Spiel & Spaß</td>
                                                    <td>33378 Rheda-Wiedenbrück</td>
                                                    <td>01.01.2018 - 02.02.2018</td>
                                                    <td>Ja</td>
                                                    <td>Freigegeben</td>
                                                    <td>06.02.2018</td>
                                                    <td>
                                                        <a href="#"><i class="icon-times-circle"></i></a>
                                                        <a href="#"><i class="icon-pencil"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Krabbeltreff</td>
                                                    <td>33378 Rheda-Wiedenbrück</td>
                                                    <td>01.01.2018 - 02.02.2018</td>
                                                    <td>Ja</td>
                                                    <td>Freigegeben</td>
                                                    <td>08.02.2018</td>
                                                    <td>
                                                        <a href="#"><i class="icon-times-circle"></i></a>
                                                        <a href="#"><i class="icon-pencil"></i></a>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </custom-datatable>
                                    </col-component>
                                </row-component>

                            </col-component>
                        </row-component>
                    </div>


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
            title: 'Übersicht'
        },
        name: 'MeinKontoUebersicht'
    }
</script>

<style lang="scss">
    @import "../../../styles/pages/my-account.scss";
</style>
