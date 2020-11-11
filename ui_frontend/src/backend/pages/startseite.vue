/**
* Name: Startseite
* Progress: 100
*/
<template>
  <page-layout-component>
    <main class="main" slot="main">

      <container-component element="section" data-animation="fadeIn">
        <row-component>
          <col-component lg-12>
            <teaser-component theme="search">
              <search-component :ajax="false"></search-component>
            </teaser-component>
          </col-component>
        </row-component>
      </container-component>

      <container-component element="section" data-animation="fadeIn" show-more="/angebot-uebersicht.html">
        <h1>Aktuelle Angebote</h1>
        <row-component>
          <col-component lg-12>
            <div class="kachel-grid">
              <div>
                <kachel-component :offer="offers[0]" :gradient="true" image="/img/dummy/Angebot_Freizeit-und-Kultur.jpg"></kachel-component>
              </div>
              <div>
                <div>
                  <kachel-component v-for="offer in offers.slice(1, 7)" :offer="offer"></kachel-component>
                </div>
              </div>
            </div>
          </col-component>
        </row-component>
      </container-component>
      <container-component element="section" data-animation="fadeIn" show-more="/anbieter-uebersicht.html">
        <h1>Auswahl einiger Anbieter</h1>
        <row-component>
          <col-component lg-3 md-6 sm-12 margin-sm margin-md>
            <border-box-component title="Caritas" text="zentrale Anlaufstelle für Menschen aller Generationen und sind Ansprechpartner für Ihre Fragen rund um die Familie."></border-box-component>
          </col-component>
          <col-component lg-3 md-6 sm-12 margin-sm margin-md>
            <border-box-component title="Familienzentrum Die Zwei" text="Unser Familienzentrum aus dem Verbund zweier Kitas betreut Kinder im Alter von 1 Jahr bis zum Schuleintritt."></border-box-component>
          </col-component>
          <col-component lg-3 md-6 sm-12 margin-sm>
            <border-box-component title="Kindertageseinrichtung „Spielkiste“ (Bitte das AWO Zentrum dafür raus nehmen)" text="Eine der größten, von Eltern getragenen Tagesstätteneinrichtungen in OWL mit über 86 Kindern"></border-box-component>
          </col-component>
          <col-component lg-3 md-6 sm-12>
            <border-box-component title="Ems-Berufskolleg" text="Das kaufmännische Berufskolleg im Kreis Gütersloh."></border-box-component>
          </col-component>
        </row-component>
      </container-component>
      <container-component element="section" data-animation="fadeIn" theme="border">
        <row-component>
          <col-component lg-9 sm-12 margin-sm>
            <h2>Sie bieten selber spannende Bildungschancen an?</h2>
            Sie bieten selbst Chancen für Familien und junge Menschen in Rheda-Wiedenbrück und möchten dieses hier
            veröffentlichen? Dann können Sie sich bei uns kostenfrei registrieren.
          </col-component>
          <col-component lg-3 sm-12 middle-lg end-lg flex-row>
            <button-component href="#" element="a" theme="full">Angebot einstellen</button-component>
          </col-component>
        </row-component>
      </container-component>
      <container-component element="section" data-animation="fadeIn">
        <h1>Über uns</h1>
        <row-component>
          <col-component lg-6 sm-12>
            <kachel-teaser-component title="Wer steckt hinter dem Portal?" text="Erfahren Sie mehr über uns und die Ziele dieses Portals für Rheda-Wiedenbrück">
              <kachel-component title="Wir stellen uns vor" image="/img/dummy/Wir-stellen-uns-vor.jpg" :showContent="false" :gradient="false"
                                theme="false"></kachel-component>
            </kachel-teaser-component>

          </col-component>
          <col-component lg-6 sm-12>
            <kachel-teaser-component title="Hilfe & Kontakt" text="Wer darf alles mitmachen? An wen richten sich die Angebote? Hier finden Sie Antworten auf die wichtigsten Fragen.">
              <kachel-component title="Wir haben die Antworten auf Ihre Fragen!" image="/img/dummy/Hilfe-und-Kontakt.jpg" :showContent="false" :gradient="false"
                                theme="false"></kachel-component>
            </kachel-teaser-component>
          </col-component>
        </row-component>
      </container-component>

      <custom-add-to-homescreen headline="lorem">
        <div vue-slot="ios">
          Lorem iOS
          <br/>
          <b>Lorem ipsum dolor</b> sit amet, <i>consetetur sadipscing elitr</i>, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
        </div>
        <div vue-slot="android">
          Lorem Android
          <br/>
          Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
        </div>
      </custom-add-to-homescreen>

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
  import offers from '../../assets/data';

  export default {
    components: {
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
    metaInfo: {
      title: 'Startseite'
    },
  created() {
    this.offers = offers;
  },
    name: 'IndexPage'
  }
</script>

<style lang="scss">
  .kachel-grid {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    margin: -10px;

    .kachel {
      margin: 10px;
      height: auto;
    }

    > div {
      &:first-child {
        width: 25%;
        flex: 0 1 auto;
        display: flex;

        @include mq('md') {
          width: 100%;
        }
      }

      &:last-child {
        width: 75%;
        flex: 0 1 auto;

        @include mq('md') {
          width: 100%;
        }
        > div {
          display: flex;
          flex-direction: row;
          flex-wrap: wrap;
          > div {
            flex: 0 1 auto;
            width: calc(33.33333333% - 20px);
            @include mq('sm') {
              width: 100%;
            }
          }
        }
      }
    }
  }
</style>
