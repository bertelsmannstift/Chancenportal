(window.webpackJsonp=window.webpackJsonp||[]).push([[19],{533:function(t,e,a){"use strict";(function(t){e.a={name:"CustomTermsAndConditions",props:{url:{type:String,default:null}},data:function(){return{show:!0,loading:!1}},methods:{submit:function(){var e=this;this.loading=!0,t.ajax({url:this.url,method:"POST",data:t(this.$refs.form).serialize()}).done((function(t){e.loading=!1,e.show=!1}))}}}}).call(this,a(16))},557:function(t,e,a){"use strict";a.r(e);var i=a(533).a,s=(a(513),a(37)),n=Object(s.a)(i,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("transition",{attrs:{name:"modal-fade"}},[a("div",{directives:[{name:"show",rawName:"v-show",value:t.show,expression:"show"}],ref:"modal",staticClass:"modal-backdrop"},[a("div",{staticClass:"modal",attrs:{role:"dialog","aria-labelledby":"modalTitle","aria-describedby":"modalDescription"}},[a("header",{staticClass:"modal-header",attrs:{id:"modalTitle"}},[a("strong",{staticStyle:{margin:"0 0 30px",display:"block"}},[t._v("Unsere Nutzungsbedingungen haben sich geändert. Bitte gehen Sie ans Ende dieser Seite und klicken Sie auf „Akzeptieren“ um fortzufahren.")]),t._v(" "),a("h3",{staticStyle:{"margin-bottom":"10px"}},[t._v("Nutzungsbedingungen")])]),t._v(" "),a("section",{staticClass:"modal-body",attrs:{id:"modalDescription"}},[a("form",{ref:"form",attrs:{action:"#",method:"POST"},on:{click:t.submit}},[t._t("default"),t._v(" "),a("button",{staticClass:"btn",class:{"btn--loading":t.loading},attrs:{type:"submit"}},[a("span",[t._v("Akzeptieren")])])],2)])])])])}),[],!1,null,null,null);e.default=n.exports}}]);