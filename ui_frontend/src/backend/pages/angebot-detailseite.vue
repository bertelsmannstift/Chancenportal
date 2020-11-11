/**
* Name: Angebots-Detailseite
* Progress: 100
* Jira: BSTCP-26
*/
<template>
    <page-layout-component>
        <main class="main" slot="main">
            <container-component element="section" data-animation="fadeIn" class="article-detail article-detail--cat-1 article-detail--offer">
                <row-component class="info-nav__actions">
                    <col-component lg-6>
                        <a href="" class="info-nav__backlink">zurück</a>
                    </col-component>
                    <col-component lg-6 end-lg>
                        <custom-sharer><span class="info-nav__share">Teilen</span></custom-sharer>
                    </col-component>
                </row-component>

                <row-component class="margin-inner">
                    <col-component lg-6 sm-12 margin-inner-sm center-lg flex-col>
                        <h2 class="article-detail__subheadline">Beratung &amp; Unterstützung</h2>
                        <h1 class="article-detail__headline">Elternstart-Café NRW</h1>
                    </col-component>
                    <col-component lg-6 sm-12 end-lg middle-lg start-sm flex>
                        <button-component href="mailto:kontakt@spielkiste-rheda.de">Anbieter kontaktieren</button-component>
                    </col-component>
                </row-component>
                <row-component class="end-lg margin-inner-sm">
                    <col-component lg-12 sm-12 start-lg>
                        <div class="article-detail__teaser">

                            <custom-image-shuffle>
                                <div style="display:none;">
                                    <img src="/img/dummy/bg-detail.png" alt="">
                                    <span class="image__copyright">Copyright 1</span>
                                </div>
                                <div style="display:none;">
                                    <img src="/img/dummy/angebotdetail_01.jpg" alt="">
                                    <span class="image__copyright">Copyright 2</span>
                                </div>
                                <div style="display:none;">
                                    <img src="/img/dummy/angebotdetail_02.jpg" alt="">
                                    <span class="image__copyright">Copyright 3</span>
                                </div>
                            </custom-image-shuffle>
                        </div>
                        <div class="article-detail__teaser-info">

                            <row-component>

                                <col-component lg-12 flex-row>
                                    <div class="icon">
                                        <i class="icon-calendar"></i> ab Montag, 29.01.2018
                                    </div>
                                    <div class="icon">
                                        <i class="icon-clock-o"></i> 09:15 - 10:45 Uhr
                                    </div>
                                    <div class="icon">
                                        <i class="icon-map-marker"></i> Nordstr. 37, 33378 Rheda-Wiedenbrück
                                    </div>
                                </col-component>
                            </row-component>
                        </div>
                    </col-component>
                </row-component>
                <row-component>
                    <col-component lg-12>
                        <menu-component :mobile="false" :items="[{title: 'Über das Angebot', href: '#', active: true},{title: 'Über den Anbieter', href: '#anbieter-kontakt'}]" theme="tab"></menu-component>
                    </col-component>
                </row-component>
                <row-component>
                    <col-component lg-8 sm-12 margin-inner-sm>
                        <div class="article-detail__text margin-inner">
                            <div>
                                Einmal in der Woche wollen wir die Zeit nutzen, um uns in gemütlicher Runde über die Kinder, ihre Entwicklung und alles was Eltern in dieser Zeit bewegt auszutauschen.
                                Die Kinder haben hierbei die Möglichkeit, erste Kontakte zu Gleichaltrigen zu knüpfen, zusammen auf kleinen Bewegungsbaustellen aktiv zu werden oder gemeinsam mit Mama oder Papa kreativ zu sein.
                                Wenn bei den Eltern Bedarf besteht, zu bestimmten Themen Beratung von außerhalb einzuladen, ist dies kein Problem.
                                Für Getränke und den passenden Spielraum zum Bewegen und Spaß haben sorgen wir!

                            </div>

                            <div class="article-detail__media">
                                <iframe width="100%" height="415" src="https://www.youtube.com/embed/7Cy1BP4-uzg" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                <div class="article-detail__media-text">{{loremIpsum(5)}}</div>
                            </div>

                            <div class="article-detail__content_image">
                                <img src="/img/dummy/bg-detail.png" alt="">
                                <span class="image__copyright">Copyright 3</span>
                            </div>
                        </div>
                        <div class="article-detail__list">
                            <h4 class="article-detail__list-headline">Weitere Informationen</h4>

                            <dl>
                                <dt>Format</dt>
                                <dd>Kurs</dd>
                                <dt>Max. Teilnehmeranzahl</dt>
                                <dd>10 Eltern-Kind Paare</dd>
                                <dt>Kosten</dt>
                                <dd>kostenfrei</dd>
                                <dt>Zugang (Offen / mit Mitgliedschaft)</dt>
                                <dd>Offen</dd>
                            </dl>
                        </div>
                    </col-component>
                    <col-component lg-3 sm-12 md-4 md-offset-0 lg-offset-1 sm-offset-0>
                        <div class="article-detail__infos">
                            <div class="article-detail__infos-block">
                                <h3>Weitere Termine</h3>

                                <div>
                                    <div class="icon">
                                        <i class="icon-calendar"></i>
                                        ab Montag, 29.01.2018 wöchentlich
                                    </div>
                                </div>
                                <div>
                                    <div class="icon">
                                        <i class="icon-clock-o"></i>
                                        09:15 - 10:45 Uhr
                                    </div>
                                </div>
                            </div>
                            <div class="article-detail__infos-block">
                                <h3>Ort</h3>

                                <div>
                                    <div class="icon">
                                        <i class="icon-map-marker"></i>
                                        Nordstr. 37<br/>
                                        33378 Rheda-Wiedenbrück<br/>
                                        Atelier
                                    </div>
                                </div>
                            </div>
                            <div class="article-detail__infos-block">
                                <h3>Alter / Zielgruppe</h3>

                                <div>
                                    <div class="icon">
                                        <i class="icon-user"></i>
                                        Eltern / Kind, 0-3 Jahre
                                    </div>
                                </div>
                            </div>
                        </div>
                    </col-component>
                </row-component>
            </container-component>
            <container-component element="section">
                <div class="article-detail__offer-box">
                    <row-component>
                        <col-component lg-5 md-6 sm-12 margin-inner-sm margin-inner-md>
                            <h3 id="anbieter-kontakt">Adresse und Kontakt</h3>
                            <div class="flex-row">
                                <div class="article-detail__img__center">
                                    <div class="article-detail__img">
                                        <img src="/img/logos/die2logofinale3-1-750x410.jpg"/>
                                    </div>
                                </div>
                                <div class="article-detail__imgtext">
                                    <div><strong>Familienzentrum Die Zwei</strong></div>
                                    <div>Kita Spielkiste e.v.</div>
                                </div>
                            </div>
                        </col-component>
                        <col-component lg-4 md-6 sm-12 margin-inner-md>
                            <h3>Ihre Ansprechpartnerin</h3>
                            <div class="flex-row">
                                <div class="article-detail__img__center">
                                    <div class="article-detail__img article-detail__img--profile">
                                        <img src="/img/svg/ansprechpartner.svg"/>
                                    </div>
                                </div>
                                <div class="article-detail__imgtext">
                                    <div><strong>Melanie D’Ambrosio</strong></div>
                                    <div>Erzieherin/ Leitung</div>
                                    <div>Tel. 05242 – 49350</div>
                                    <div>E-Mail <a href="mailto:kontakt@spielkiste-rheda.de">kontakt@spielkiste-rheda.de</a></div>
                                </div>
                            </div>
                        </col-component>
                        <col-component lg-3 md-12 end-lg middle-lg flex start-md>
                            <div>
                                <button-component href="mailto:info@uandi.com">Anbieter kontaktieren</button-component>
                                <div><a href="/anbieter-detailseite.html" class="article-detail__link">Zum Anbieter</a></div>
                            </div>
                        </col-component>
                    </row-component>
                </div>
                <div class="article-detail__offer-box-bottom">
                    <row-component>
                        <col-component lg-12 center-lg>
                            <strong>In Kooperation mit: </strong> Familienzentrum Die Zwei
                        </col-component>
                    </row-component>
                </div>
            </container-component>
            <container-component element="section" id="angebote" data-animation="fadeIn">
                <h1>Ähnliche Angebote</h1>
                <row-component class="margin-inner">
                    <col-component lg-3 sm-12 md-6 margin-inner-sm margin-inner-md>
                        <kachel-component title="Spielend in Bewegung bleiben" date="01.07.2018" text2=" " text="Lust auf eine Spiel- und Bewegungsbaustelle für Eltern mit Kindern im Alter von 1-2 Jahren?"></kachel-component>
                    </col-component>
                    <col-component lg-3 sm-12 md-6 margin-inner-sm margin-inner-md>
                        <kachel-component title="Offene Krabbelgruppe" date="20.07.2018" text2=" " text="Wöchentlicher Austausch in gemütlicher Runde"></kachel-component>
                    </col-component>
                    <col-component lg-3 sm-12 md-6 margin-inner-sm>
                        <kachel-component title="Spiel & Spaß" date="01.07.2018" text2=" " text="Lust auf eine Spiel- und Bewegungsbaustelle für Eltern mit Kindern im Alter von 1-2 Jahren?"></kachel-component>
                    </col-component>
                    <col-component lg-3 sm-12 md-6>
                        <kachel-component title="Krabbeltreff" date="20.07.2018" text2=" " text="Wöchentlicher Austausch in gemütlicher Runde"></kachel-component>
                    </col-component>
                </row-component>
                <row-component>
                    <col-component lg-12 center-lg>
                        <button-component href="/angebot-uebersicht.html">Mehr Angebote anzeigen</button-component>
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
    import ButtonComponent from "../components/ButtonComponent";
    import MenuComponent from "../components/MenuComponent";
    import KachelComponent from "../components/KachelComponent";

    export default {
        components: {
            KachelComponent,
            MenuComponent,
            ButtonComponent,
            ColComponent,
            RowComponent,
            ContainerComponent,
            PageLayoutComponent,
        },
        metaInfo: {
            title: 'Anbieter Detailseite'
        },
        name: 'AnbieterDetailseite'
    }
</script>

<style lang="scss">
    @import "../../styles/pages/article-detail";
</style>
