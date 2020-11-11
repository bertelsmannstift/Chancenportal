/**
* Name: Anbieter-Detailseite
* Progress: 100
* Jira: BSTCP-7
*/
<template>
    <page-layout-component>
        <main class="main" slot="main">
            <container-component element="section" data-animation="fadeIn" class="article-detail">
                <row-component class="info-nav__actions">
                    <col-component lg-6>
                        <a href="" class="info-nav__backlink">zurück</a>
                    </col-component>
                    <col-component lg-6 end-lg>
                        <a href="" class="info-nav__share">Teilen</a>
                    </col-component>
                </row-component>
                <row-component class="margin-inner">
                    <col-component lg-8 sm-12 margin-inner-sm center-lg flex-col>
                        <h1 class="article-detail__headline">Kindertageseinrichtung „Spielkiste“</h1>
                        <h2 class="article-detail__subheadline">Die Spielkiste – Ein Ort für Kinder</h2>
                    </col-component>
                    <col-component lg-4 sm-12 end-lg middle-lg start-sm flex>
                        <button-component href="mailto:kontakt@spielkiste-rheda.de">Anbieter kontaktieren</button-component>
                    </col-component>
                </row-component>
                <row-component>
                    <col-component lg-12>
                        <menu-component :mobile="false" :items="[{title: 'Über den Anbieter', href: '#', active: true},{title: 'Zu den Angeboten', href: '#angebote'}]" theme="tab"></menu-component>
                    </col-component>
                </row-component>
                <row-component>
                    <col-component lg-8 sm-12 margin-inner-sm>
                        <div class="article-detail__text">
                            <div>
                                In hellen Gruppenräumen, einer großzügigen Turnhalle, einer Spielhalle, die alle Gruppen miteinander verbindet, sowie in verschiedenen kleinräumigen Spielbereichen spielen die Kinder und fühlen sich wohl.
                                In der großen Küche wird das Mittagessen gerne unter Mitwirkung der Kinder frisch zubereitet.
                                Die Kinder werden auf ihrem Weg zu einem selbständigen und selbstbewussten Menschen begleitet von Erzieher und Erzieherinnen, Kinderpflegerinnen und Sozialpädagoginnen. Kinder und Erzieher kommen aus unterschiedlichen Kulturkreisen, so dass ein multikulturelles Zusammenleben existiert.
                                <br><br>
                                Träger der Einrichtung ist traditionell eine Elterninitiative. Eltern, deren Kinder in der Einrichtung sind, bilden die aktive (stimmberechtigte) Mitgliedschaft des Vereins „Spielkiste e.V.“ und sind Träger dieser Einrichtung. Die Mitgliedschaft und die daraus resultierenden Aufgaben sind verpflichtend. Die wichtigsten Aufgaben sind die Mitarbeit in einer Arbeitsgruppe und die Mitwirkung bei der Jahreshauptversammlung sowie die Teilnahme an den Elternabenden.
                                Darüber hinaus gibt es noch fördernde Mitglieder (nicht stimmberechtigt). Durch ihren Förderbeitrag ermöglichen Sie unter anderem die Qualität der pädagogischen Arbeit zu halten und zu verbessern, die Durchführung von besonderen Aktionen und Ausflüge der Spielkisten-Kinder, die Anschaffung von wertvollen Spielen und vielem mehr.
                                <br><br>
                                Leitbild der Kita:<br>
                                „Kinder sollten mehr spielen, als viele Kinder es heutzutage tun. Denn wenn man genügend spielt, solange man klein ist, dann trägt man Schätze mit sich herum, aus denen man später sein ganzes Leben lang schöpfen kann.“ (Astrid Lindgren)
                                In unserer Kita soll daher spielend gelernt werden für das Leben.
                                Durch familiennahe Betreuung, Begegnung mit Respekt und einer altersgerechten Bildung von Anfang an machen wir unsere Kindertageseinrichtung zu einem Ort für Kinder!
                                Wir arbeiten nach dem situationsorientierten Ansatz, sodass wir immer an den Bedürfnissen und den Interessen der Kinder orientiert arbeiten. Unsere Tagesstruktur und klaren Regeln schaffen im Alltag für die Kinder unserer Einrichtung Beständigkeit und Sicherheit.
                                Unser Familienzentrum im Verbund mit der ev. Kindertageseinrichtung „Bunte Welt“ betreut Kinder im Alter von 1 Jahr bis zum Schuleintritt.
                                Bei uns ist jeder willkommen. Integrative/inklusive Förderung von Kindern mit erhöhtem Förderbedarf ist für uns gelebter Alltag. Täglich wird für die Kinder frisch gekocht, auch für Kinder mit Allergien. Wir gehen regelmäßig in den Wald und erkunden wöchentlich naturnah das Wohnumfeld der Kita.
                               </div>

                            <div class="article-detail__categories">
                                <strong>Anbieter in Kategorien</strong>
                                <div>
                                    <button-component theme="small" className="btn--cat-1">Bildung & Betreuung</button-component>
                                </div>
                            </div>
                        </div>
                    </col-component>
                    <col-component lg-3 sm-12 md-4 md-offset-0 lg-offset-1 sm-offset-0>
                        <div class="article-detail__infos">
                            <h3>Öffnungszeiten</h3>
                            <div>
                                <div>
                                    Mo. - Fr. 12:00 - 18:00 Uhr<br/>
                                    Sa. - So. 10:00 - 14:00 Uhr
                                </div>
                            </div>

                            <h3>Kontakt</h3>
                            <div>
                                <div>
                                    0521 12345
                                </div>
                            </div>

                            <h3>Zahlen und Fakten</h3>

                            <div>
                                <strong>Engagement</strong>
                                <div>Erwünscht</div>
                            </div>
                        </div>
                    </col-component>
                </row-component>
            </container-component>
            <container-component element="section">
                <div class="article-detail__offer-box">
                    <row-component>
                        <col-component lg-5 md-6 sm-12 margin-inner-sm margin-inner-md>
                            <h3>Adresse und Kontakt</h3>
                            <div class="flex-row">
                                <div class="article-detail__img">
                                    <img src="/img/logos/logo-spielkiste.jpg"/>
                                </div>
                                <div class="article-detail__imgtext">
                                    <div><strong>Kita Spielkiste e.V. </strong></div>
                                    <div>Nordstr. 37</div>
                                    <div>33378 Rheda-Wiedenbrück</div>
                                    <br/>
                                    <div><a href="mailto:kontakt@spielkiste-rheda.de" target="_blank">kontakt@spielkiste-rheda.de</a></div>
                                    <div><a href="http://www.spielkiste-rheda.de" target="_blank">spielkiste-rheda.de</a></div>
                                </div>
                            </div>
                        </col-component>
                        <col-component lg-4 md-6 sm-12 margin-inner-md>
                            <h3>Ihre Ansprechpartnerin</h3>
                            <div class="flex-row">
                                <div class="article-detail__img article-detail__img--profile">
                                    <img src="/img/svg/ansprechpartner.svg"/>
                                </div>
                                <div class="article-detail__imgtext">
                                    <div><strong>Melanie D´Ambrosio</strong></div>
                                    <div>Einrichtungsleitung</div>
                                </div>
                            </div>
                        </col-component>
                        <col-component lg-3 md-12 sm-12 end-lg middle-lg flex start-md>
                            <button-component href="mailto:kontakt@spielkiste-rheda.de">Anbieter kontaktieren</button-component>
                        </col-component>
                    </row-component>
                </div>
            </container-component>
            <container-component element="section" id="angebote" data-animation="fadeIn">
                <h1>Alle Angebote des Anbieters</h1>
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
