/**
 * VueJs initialisations
 * Auskommentieren sofern Vue nicht benutzt wird.
 */
import "babel-polyfill";
import 'jquery';
import 'eventsource-polyfill';
import 'document-register-element'; // polyfill for IE and Firefox

import CustomDatatable from '../components/CustomDatatable.vue';
import CustomConfirm from '../components/CustomConfirm.vue';
import CustomDropdown from '../components/CustomDropdown.vue';
import CustomAjaxForm from '../components/CustomAjaxForm.vue';

require('es6-promise/auto');
require('waypoints/lib/noframework.waypoints.min');
require('./anchor-nav');
require('./validator');
require('./tab-toggle');
require('./more-less');
require('./backlink');
require('./toggle-map');

/**
 * Picturefill
 */
require('picturefill');
picturefill();

// IE11 Event Polyfill
(function () {
    function CustomEvent(event, params) {
        params = params || {bubbles: false, cancelable: false, detail: undefined};
        let evt = document.createEvent('CustomEvent');
        evt.initCustomEvent(event, params.bubbles, params.cancelable, params.detail);
        return evt;
    }

    CustomEvent.prototype = window.Event.prototype;

    window.CustomEvent = CustomEvent;
})();


import Vue from 'vue'
import vueCustomElement from 'vue-custom-element';

Vue.config.productionTip = false;

Vue.use(vueCustomElement);

Vue.customElement('custom-datatable', CustomDatatable);
Vue.customElement('custom-confirm', CustomConfirm);
Vue.customElement('custom-ajax-form', CustomAjaxForm);
Vue.customElement('custom-dropdown', CustomDropdown);

Vue.customElement('custom-preview', () => new Promise((resolve) => {
    require(['../components/CustomPreview.vue'], (lazyComponent) => resolve(lazyComponent.default));
}), {props: []});

Vue.customElement('custom-time-input', () => new Promise((resolve) => {
    require(['../components/CustomTimeInput.vue'], (lazyComponent) => resolve(lazyComponent.default));
}), {props: []});

Vue.customElement('custom-image-shuffle', () => new Promise((resolve) => {
    require(['../components/CustomImageShuffle.vue'], (lazyComponent) => resolve(lazyComponent.default));
}), {props: []});

Vue.customElement('custom-map-autocomplete', () => new Promise((resolve) => {
    require(['../components/CustomMapAutocomplete.vue'], (lazyComponent) => resolve(lazyComponent.default));
}), {props: []});

Vue.customElement('custom-upload', () => new Promise((resolve) => {
    require(['../components/CustomUpload.vue'], (lazyComponent) => resolve(lazyComponent.default));
}), {props: []});

Vue.customElement('custom-tabs', () => new Promise((resolve) => {
    require(['../components/CustomTabs.vue'], (lazyComponent) => resolve(lazyComponent.default));
}), {props: []});

Vue.customElement('custom-input', () => new Promise((resolve) => {
    require(['../components/CustomInput.vue'], (lazyComponent) => resolve(lazyComponent.default));
}), {props: []});

Vue.customElement('custom-new-line', () => new Promise((resolve) => {
    require(['../components/CustomNewLine.vue'], (lazyComponent) => resolve(lazyComponent.default));
}), {props: ['isDisabled','limit']});

Vue.customElement('custom-chart', () => new Promise((resolve) => {
    require(['../components/CustomChart.vue'], (lazyComponent) => resolve(lazyComponent.default));
}), {props: ['limit']});

Vue.customElement('custom-datepicker', () => new Promise((resolve) => {
    require(['../components/CustomDatepicker/CustomDatepicker.vue'], (lazyComponent) => resolve(lazyComponent.default));
}), {props: ['isDisabled']});

Vue.customElement('custom-map', () => new Promise((resolve) => {
    require(['../components/CustomMap.vue'], (lazyComponent) => resolve(lazyComponent.default));
}), {props: ['show']});

Vue.customElement('custom-pagination', () => new Promise((resolve) => {
    require(['../components/CustomPagination.vue'], (lazyComponent) => resolve(lazyComponent.default));
}), {props: ['show']});

Vue.customElement('custom-active-filter', () => new Promise((resolve) => {
    require(['../components/CustomActiveFilter.vue'], (lazyComponent) => resolve(lazyComponent.default));
}), {props: []});

Vue.customElement('custom-upload-button', () => new Promise((resolve) => {
    require(['../components/CustomUploadButton.vue'], (lazyComponent) => resolve(lazyComponent.default));
}), {props: []});

Vue.customElement('custom-template-search', () => new Promise((resolve) => {
    require(['../components/CustomTemplateSearch.vue'], (lazyComponent) => resolve(lazyComponent.default));
}), {props: []});

Vue.customElement('custom-menu', () => new Promise((resolve) => {
    require(['../components/CustomMenu.vue'], (lazyComponent) => resolve(lazyComponent.default));
}), {props: []});

Vue.customElement('custom-trigger', () => new Promise((resolve) => {
    require(['../components/CustomTrigger.vue'], (lazyComponent) => resolve(lazyComponent.default));
}), {props: []});

Vue.customElement('custom-sharer', () => new Promise((resolve) => {
    require(['../components/CustomSharer.vue'], (lazyComponent) => resolve(lazyComponent.default));
}), {props: []});

Vue.customElement('custom-select', () => new Promise((resolve) => {
    require(['../components/CustomSelect.vue'], (lazyComponent) => resolve(lazyComponent.default));
}), {props: ['isDisabled', 'isChecked']});

Vue.customElement('custom-radio', () => new Promise((resolve) => {
    require(['../components/CustomRadio.vue'], (lazyComponent) => resolve(lazyComponent.default));
}), {props: ['isDisabled', 'isChecked']});

Vue.customElement('custom-login-overlay', () => new Promise((resolve) => {
    require(['../components/CustomLoginOverlay.vue'], (lazyComponent) => resolve(lazyComponent.default));
}), {props: []});

Vue.customElement('custom-google-chart', () => new Promise((resolve) => {
    require(['../components/CustomGoogleChart.vue'], (lazyComponent) => resolve(lazyComponent.default));
}), {props: []});

Vue.customElement('custom-rte-input', () => new Promise((resolve) => {
    require(['../components/CustomRteInput.vue'], (lazyComponent) => resolve(lazyComponent.default));
}), {props: []});

Vue.customElement('custom-terms-and-conditions', () => new Promise((resolve) => {
    require(['../components/CustomTermsAndConditions.vue'], (lazyComponent) => resolve(lazyComponent.default));
}), {props: []});

Vue.customElement('custom-add-to-homescreen', () => new Promise((resolve) => {
    require(['../components/CustomAddToHomescreen.vue'], (lazyComponent) => resolve(lazyComponent.default));
}), {props: ['show']});

if (process.env.NODE_ENV !== 'production') {
    require('./server-hot-reload.js')
}
