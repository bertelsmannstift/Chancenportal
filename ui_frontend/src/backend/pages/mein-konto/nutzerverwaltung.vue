/**
* Name: Mein-Konto - Nutzerverwaltung
* Progress: 100
*/
<template>
    <page-layout-component>
        <main class="main" slot="main">
            <container-component element="section" data-animation="fadeIn" class="my-account">
                <row-component class="info-nav__actions">
                    <col-component lg-12>
                        <breadcrumb-component :items='[{"name": "Mein Konto"}, {"name": "Nutzerverwaltung"}]'></breadcrumb-component>
                    </col-component>
                </row-component>
                <row-component>
                    <col-component lg-3 sm-12 margin-sm>
                        <my-account-menu-component activeItem="3"></my-account-menu-component>
                    </col-component>
                    <col-component lg-8 sm-12 sm-offset-0 lg-offset-1>
                        <h1>
                            Nutzerverwaltung
                        </h1>

                        <row-component class="margin-inner">
                            <col-component lg-4 sm-12 margin-inner-sm flex middle-lg>
                                <a href="#" class="my-account__add-link">neuen Benutzer anlegen</a>
                            </col-component>
                        </row-component>

                        <row-component>
                            <col-component lg-12 sm-12 margin-lg>
                                <custom-datatable sorting='[{"col": "0"}, {"col": "3"}]'>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>E-Mail</th>
                                                <th>Anbieter</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Hans Peter</td>
                                                <td>hans.peter@spielkiste-rheda.de</td>
                                                <td>Kindertageseinrichtung „Spielkiste“</td>
                                                <td>
                                                    <custom-confirm text="Soll der Benutzer wirklich gelöscht werden?">
                                                        <a href="#"><i class="icon-times-circle"></i></a>
                                                    </custom-confirm>
                                                    <a href="#"><i class="icon-pencil"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Anne Schmidt</td>
                                                <td>anne.schmidt@spielkiste-rheda.de</td>
                                                <td>Kindertageseinrichtung „Spielkiste“</td>
                                                <td>
                                                    <custom-confirm text="Soll der Benutzer wirklich gelöscht werden?">
                                                        <a href="#"><i class="icon-times-circle"></i></a>
                                                    </custom-confirm>
                                                    <a href="#"><i class="icon-pencil"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Max Mustermann</td>
                                                <td>max.mustermann@spielkiste-rheda.de</td>
                                                <td>Kindertageseinrichtung „Spielkiste“</td>
                                                <td>
                                                    <custom-confirm text="Soll der Benutzer wirklich gelöscht werden?">
                                                        <a href="#"><i class="icon-times-circle"></i></a>
                                                    </custom-confirm>
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

    export default {

        components: {
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
