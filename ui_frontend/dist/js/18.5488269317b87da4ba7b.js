(window.webpackJsonp=window.webpackJsonp||[]).push([[18],{525:function(t,e,i){"use strict";(function(t){e.a={name:"TemplateSearch",methods:{init:function(){t("#search-tpl").keyup((function(){var e=t.trim(t(this).val());t("tbody tr").show().filter((function(){var i=new RegExp(e,"i");return""!==e&&!i.test(t(this).text())})).hide()}))}},mounted:function(){this.init()}}}).call(this,i(16))},553:function(t,e,i){"use strict";i.r(e);var s=i(525).a,n=i(37),a=Object(n.a)(s,(function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"clearfix"},[e("h1",{staticClass:"text-muted",attrs:{id:"title"}},[this._t("default")],2),this._v(" "),this._m(0)])}),[function(){var t=this.$createElement,e=this._self._c||t;return e("nav",[e("input",{staticClass:"form-control mr-sm-2",attrs:{id:"search-tpl",type:"text",placeholder:"Search Templates"}})])}],!1,null,null,null);e.default=a.exports}}]);