/**
* Name: Icons
* Progress: 50
*/
<template>
  <page-layout-component>

    <main class="main" slot="main">
      <div class="section">
        <div class="section__inner">
          <div class="iconpreview">
            <h1>Icons</h1>
            <ul class="iconpreview__list row">
              <li v-for="icon in this.jsonIconList" class="col-xs-12 col-sm-6 col-md-2">
                <span class="iconpreview__list__icon" :class="icon"></span>
                <span>${{icon}}</span>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </main>

  </page-layout-component>
</template>


<script>
  import PageLayoutComponent from '../layouts/PageLayoutComponent.vue';
  import FooterComponent from '../components/FooterComponent.vue';

  export default {
    components: {
      PageLayoutComponent,
      FooterComponent
    },
    name: 'IconOverview',
    metaInfo: {
      title: 'Icon Overview'
    },
    methods: {},
    data() {
      return {
        jsonIconList: []
      }
    },

    created() {
      const jsonData = require('../../styles/fonts/icon-font/selection.json');
      const prefix = jsonData['preferences']['fontPref']['prefix'];

      for (var icon in jsonData['icons']) {
        this.jsonIconList.push(prefix + jsonData['icons'][icon]['properties']['name']);
      }
    }
  }
</script>


<style lang="scss">
  .iconpreview {

    &__list {
      display: flex;
      flex-wrap: wrap;
      list-style-type: none;
      padding: 0;
      margin: 0;

      &__icon {
        &:before {
          font-size: 40px;
        }
        margin-bottom: 1em;
      }
    }

    li {
      //padding: 0 0 3em;
      padding-bottom: 3em;
      display: flex;
      flex-wrap: wrap;

      > * {
        text-align: center;
        flex: 0 0 100%;
      }
    }
  }
</style>
