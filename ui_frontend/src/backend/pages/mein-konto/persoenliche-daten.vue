/**
* Name: Mein-Konto - Persönliche Daten
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
                        <my-account-menu-component activeItem="8"></my-account-menu-component>
                    </col-component>
                    <col-component lg-8 sm-12 sm-offset-0 lg-offset-1>
                        <row-component>
                            <col-component lg-12 sm-12 margin-inner-sm>
                                <h2>Persönliche Daten</h2>
                            </col-component>
                        </row-component>

                        <form method="post">
                            <input-component type="email" label="E-Mail" :disabled="true" value="lorem@ipsum.com"></input-component>
                            <input-component label="Organisation" :disabled="true" value="Lorem Ipsum"></input-component>

                            <input-component label="Name*"></input-component>

                            <input-component type="password" label="Ihr aktuelles Passwort"></input-component>

                            <input-component type="password" label="Ihr neues Passwort"></input-component>
                            <input-component type="password" label="Wiederholen Sie Ihr neues Passwort"></input-component>

                            <div class="flex end-lg">
                                <button-component type="submit">Speichern</button-component>
                            </div>

                            <div class="login-register__required">* Pflichtfelder</div>

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
    import InputComponent from "../../components/InputComponent";
    import ButtonComponent from "../../components/ButtonComponent";

    export default {

        components: {
            ButtonComponent,
            InputComponent,
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
            title: 'Persönliche Daten'
        },
        name: 'PersoenlicheDaten'
    }
</script>

<style lang="scss">
    @import "../../../styles/pages/my-account.scss";
</style>
