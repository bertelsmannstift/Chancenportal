(window.webpackJsonp=window.webpackJsonp||[]).push([[10],{576:function(t,s,i){"use strict";i.r(s);var c={name:"custom-chartComponent",props:{items:"",limit:{default:!0,type:Boolean}},data:function(){return{currentItems:[],initItems:[],limitCount:2}},watch:{limit:function(t){this.currentItems=t?this.initItems.slice(0,this.limitCount):this.initItems}},mounted:function(){var t=JSON.parse(this.items),s=0;t.forEach(function(t){s+=t.count}),t.forEach(function(t){t.width=100*t.count/s}),this.initItems=t,this.currentItems=this.initItems.slice(0,this.limitCount)}},n=(i(521),i(71)),e=Object(n.a)(c,function(){var t=this,s=t.$createElement,i=t._self._c||s;return i("div",{staticClass:"custom-chart"},[t._m(0),t._v(" "),t._l(t.currentItems,function(s){return i("div",{staticClass:"custom-chart__item"},[i("div",{staticClass:"custom-chart__count"},[t._v("\n            "+t._s(s.count)+"\n        ")]),t._v(" "),i("div",{staticClass:"custom-chart__name"},[i("div",{staticClass:"custom-chart__counter"},[i("div",{staticClass:"custom-chart__counter-bar",style:{width:s.width+"%"}}),t._v(" "),i("div",{staticClass:"custom-chart__counter-text"},[t._v(t._s(s.name))])])])])})],2)},[function(){var t=this.$createElement,s=this._self._c||t;return s("div",{staticClass:"custom-chart__item custom-chart__item--header"},[s("div",{staticClass:"custom-chart__count"},[this._v("\n            Anzahl\n        ")]),this._v(" "),s("div",{staticClass:"custom-chart__name"},[this._v("\n            Kategorie\n        ")])])}],!1,null,null,null);e.options.__file="CustomChart.vue";s.default=e.exports}}]);