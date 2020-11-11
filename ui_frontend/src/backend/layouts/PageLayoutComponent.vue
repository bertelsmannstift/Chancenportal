<template>
  <div>
    <slot name="header">
      <header-component></header-component>
    </slot>

    <slot name="main">

    </slot>

    <slot name="footer">
      <footer-component></footer-component>
    </slot>

    <custom-gridviewer v-if="isProduction === false"></custom-gridviewer>
  </div>
</template>

<script>
  import FooterComponent from '../components/FooterComponent'
  import ContainerComponent from "../components/ContainerComponent";
  import HeaderComponent from "../components/HeaderComponent";
  const ENV = process.env.NODE_ENV;

  export default {
    components: {
      HeaderComponent,
      ContainerComponent,
      FooterComponent
    },
    data() {
      return {
        isProduction: false
      }
    },
    created() {
      this.isProduction = ENV === 'production';
    },
    name: 'PageLayoutComponent'
  }
</script>
