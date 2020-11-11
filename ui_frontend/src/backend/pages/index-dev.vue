<template>
    <div>
        <main class="main" slot="main">
            <div class="section">
                <div class="section__inner">
                    <div class="container">
                        <div id="logo">
                            <img src="/img/ui_interact.svg"/>
                        </div>
                        <div id="searchheader">
                            <custom-template-search>uandi.com Frontend-Framework</custom-template-search>
                        </div>
                        <div v-for="group in groups">
                            <div class="row" v-if="filter(group).length">
                                <div class="col-md-12">
                                    <h2 class="pb-3">{{ group }} </h2>
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th style="width: 25%">Name</th>
                                            <th style="width: 35%">Progress</th>
                                            <th style="width: 15%">Ticket</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <tr v-for="item in filter(group)" :key="item.name">
                                            <td scope="row">
                                                <div v-if="item.file">
                                                    <a :href="item.file" target="_blank">{{ item.name }}</a>
                                                </div>
                                                <div v-else-if="item.componentLink">
                                                    <a :href="item.componentLink" target="_blank">{{ item.name }}</a>
                                                </div>
                                                <div v-else>
                                                    {{ item.name }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar bg-success" role="progressbar"
                                                         :style="{'width': item.progress +'%'}"
                                                         :aria-valuenow="item.progress" aria-valuemin="0"
                                                         aria-valuemax="100">{{ item.progress }}%
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div v-if="item.jira">
                                                    <a :href="item.jira" target="_blank">{{
                                                        item.jira }}</a>
                                                </div>
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>

                        <hr>

                        <footer>
                            <p>&copy; u+i interact {{ new Date().getFullYear() }}</p>
                        </footer>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
    const path = require('path');
    const recursive = require("recursive-readdir-synchronous");
    const fs = require('fs');
    const frontend = recursive('./src/frontend/components');
    const backend = recursive('./src/backend');
    const components = frontend.concat(backend);

    export default {
        metaInfo: {
            title: 'Prototype'
        },
        name: 'IndexPrototypePage',
        data() {
            return {
                data: [],
                groups: ['Seiten', 'Komponenten']
            }
        },
        methods: {
            filter(group) {
                return this.data.filter(item => item.group === group);
            }
        },
        created() {

            function getFileInfo(file) {
                let rex = new RegExp('\\/\\*[\\s\\S]+?\\*\\/', 'ig');
                let content = fs.readFileSync(file);
                let result = rex.exec(content);
                if (result) {
                    let comment = result[0];
                    let progress = comment.match(/progress:\s*(.*)$/im);
                    progress = (progress ? parseInt(progress[1]) : 0);
                    let name = comment.match(/name:\s*(.*)$/im);
                    name = (name ? name[1] : '');
                    let jira = comment.match(/jira:\s*(.*)$/im);
                    jira = (jira ? 'https://jira.uandi.com/browse/' + jira[1] : '');

                    if(name !== '') {
                        let folderPath = path.dirname(file);
                        folderPath = folderPath.substr(folderPath.indexOf('pages') + 5, folderPath.length);
                        return {
                            name: name,
                            progress: progress,
                            jira: jira,
                            group: file.match(/\/pages\//i) ? 'Seiten' : 'Komponenten',
                            file: file.match(/\/pages\//i) ? folderPath + '/' + path.basename(file).replace(/\.vue/ig, '.html') : '',
                            component: path.basename(file).replace(/\.vue/ig, ''),
                            componentLink: (file.match(/\/frontend\//i) ? '/frontend/' : '/backend/') + path.basename(file).replace(/\.vue/ig, '') + '.vue',
                        };
                    }
                }
                return null;
            }

            let items = [];
            components.filter(file => file.match(/\.vue/ig)).forEach(file => {
                let fInfo = getFileInfo(file);
                if (fInfo) {
                    items.push(fInfo);
                }
            });

            this.data = items;
        }
    }
</script>

<style lang="scss">
    @import '~bootstrap/dist/css/bootstrap.css';

    #searchheader {
        margin: 50px 0;
    }

    #title {
        color: black !important;
    }

    #logo {
        max-width: 320px;
        width: 100%;
        height: auto;
        margin-bottom: 30px;
    }

</style>
