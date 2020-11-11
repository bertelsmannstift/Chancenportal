/**
* Name: Mein-Konto - Übersicht
* Progress: 100
*/
<template>
    <page-layout-component>
        <main class="main" slot="main">
            <container-component element="section" data-animation="fadeIn" class="my-account">
                <row-component class="info-nav__actions">
                    <col-component lg-12>
                        <breadcrumb-component :items='[{"name": "Mein Konto"}]'></breadcrumb-component>
                    </col-component>
                </row-component>
                <row-component>
                    <col-component lg-3 sm-12 margin-sm>
                        <my-account-menu-component activeItem="1"></my-account-menu-component>
                    </col-component>
                    <col-component lg-8 sm-12 sm-offset-0 lg-offset-1>
                        <h1 class="margin-small">
                            Willkommen, Susanne Schmidt
                        </h1>
                        <p class="margin-inner-lg">Nutzen Sie das Konto-Dashboard zur Pflege Ihrer Anbieter- und Angebotsdaten.</p>

                        <info-box-component class="margin-inner-lg">
                            Sie sind Administrator Ihrer Organisation und können das Anbieterprofil Ihrer
                            Organisation verwalten. Unter dem Menüpunkt „Nutzerverwaltung“ können Sie weitere
                            Nutzer anlegen und wahlweise zu Administratoren ernennen.
                        </info-box-component>

                        <row-component>
                            <col-component lg-6 sm-12 margin-sm margin-inner-lg>
                                <border-box-component title="Anbieterprofil Ihrer Organisation pflegen" text="Als Administrator Ihrer Organisation können Sie Ihr Anbieterprofil pflegen. Nutzen Sie die Nutzerverwaltung, um weitere Administrations-Rechte zu vergeben." theme="arrow"></border-box-component>
                            </col-component>
                            <col-component lg-6 sm-12 margin-sm margin-inner-lg>
                                <border-box-component title="Weitere Nutzer anlegen & verwalten" text="Legen Sie weitere Nutzer für Ihre Organisation an und vergeben Sie wahlweise weitere Administrationsrechte." theme="arrow"></border-box-component>
                            </col-component>


                            <col-component lg-6 sm-12 margin-sm margin-inner-lg>
                                <border-box-component title="Angebote pflegen und verwalten" text="Hier finden Sie eine Übersicht aller Angebote, die für Ihre Organisation / Ihr Anbieterprofil angelegt wurden und von Ihnen bearbeitet oder gelöscht werden können." theme="arrow"></border-box-component>
                            </col-component>

                            <col-component lg-6 sm-12 margin-sm margin-inner-lg>
                                <border-box-component title="Neues Angebot anlegen" text="Sie haben ein weiteres soziales Angebot für Pirmasens, das sie im Portal veröffentlichen wollen? Dann fühlen Sie dieses Formular aus." theme="arrow"></border-box-component>
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

    export default {

        components: {
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
