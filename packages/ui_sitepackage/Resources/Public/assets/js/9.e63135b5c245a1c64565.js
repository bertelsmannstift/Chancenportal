(window.webpackJsonp=window.webpackJsonp||[]).push([[9],{551:function(t,e,i){"use strict";(function(t){e.a={name:"CustomNewLine",props:{linkText:{default:"weitere Zeile hinzufügen",type:String},items:{default:null,type:String},limit:{default:null,type:Number}},data:function(){return{counter:0,element:null,disabled:!1,clones:[]}},watch:{isDisabled:function(t){this.disabled=t},limit:function(t){t&&(this.clones=this.clones.splice(0,t)),this.limit&&this.clones.length>=this.limit?this.disabled=!0:this.disabled=!1}},methods:{addLine:function(){var t=this.element.replace(/\[\d\]/gi,"["+this.counter+"]");this.clones.push({id:this.counter,html:t}),this.counter++,this.limit&&this.clones.length>=this.limit?this.disabled=!0:this.disabled=!1},remove:function(t){this.clones.splice(t,1),this.counter--,this.limit&&this.clones.length>=this.limit?this.disabled=!0:this.disabled=!1}},mounted:function(){var e=this;if(this.elements=this.$slots.default?this.$slots.default:null,this.elements){this.element=t(this.$refs.slot).children().filter(":not([data-item])").get(0).outerHTML;var i=t(this.$refs.slot).children().filter("[data-item]"),s=!0,n=!1,l=void 0;try{for(var a,o=i[Symbol.iterator]();!(s=(a=o.next()).done);s=!0){var r=a.value.outerHTML.replace(/\[\d\]/gi,"["+this.counter+"]");this.clones.push({id:this.counter,html:r}),this.counter++}}catch(t){n=!0,l=t}finally{try{!s&&o.return&&o.return()}finally{if(n)throw l}}i.remove(),0===this.clones.length&&this.addLine()}setTimeout(function(){t(e.$refs.slot).find("input,textarea").val("").removeAttr("id").removeAttr("class").attr("disabled","disabled")},500),this.disabled=this.isDisabled}}}).call(this,i(16))},593:function(t,e,i){"use strict";i.r(e);var s=i(551).a,n=(i(526),i(37)),l=Object(n.a)(s,function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"custom-new-line"},[i("div",{directives:[{name:"show",rawName:"v-show",value:!1,expression:"false"}],ref:"slot",staticClass:"custom-new-line__org_clone"},[t._t("default")],2),t._v(" "),t._l(t.clones,function(e,s){return i("div",{key:e.id,staticClass:"custom-new-line__line"},[0!==s?i("a",{staticClass:"custom-new-line__removelink",attrs:{href:"#"},on:{click:function(e){e.preventDefault(),t.remove(s)}}},[i("i",{staticClass:"icon-trash-o"})]):t._e(),t._v(" "),i("div",{staticClass:"custom-new-line__clone",domProps:{innerHTML:t._s(e.html)}})])}),t._v(" "),t.disabled?t._e():i("a",{staticClass:"custom-new-line__addlink",attrs:{href:"#"},on:{click:function(e){return e.preventDefault(),t.addLine(e)}}},[i("i",{staticClass:"icon-plus"}),t._v(" "+t._s(t.linkText))])],2)},[],!1,null,null,null);l.options.__file="CustomNewLine.vue";e.default=l.exports}}]);