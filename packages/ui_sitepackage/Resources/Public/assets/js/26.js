(window.webpackJsonp=window.webpackJsonp||[]).push([[26],{562:function(t,e,i){"use strict";
/*!
 * Cropper.js v1.4.3
 * https://fengyuanchen.github.io/cropperjs
 *
 * Copyright 2015-present Chen Fengyuan
 * Released under the MIT license
 *
 * Date: 2018-10-24T13:07:15.032Z
 */function a(t){return(a="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t})(t)}function n(t,e){for(var i=0;i<e.length;i++){var a=e[i];a.enumerable=a.enumerable||!1,a.configurable=!0,"value"in a&&(a.writable=!0),Object.defineProperty(t,a.key,a)}}function o(t){return function(t){if(Array.isArray(t)){for(var e=0,i=new Array(t.length);e<t.length;e++)i[e]=t[e];return i}}(t)||function(t){if(Symbol.iterator in Object(t)||"[object Arguments]"===Object.prototype.toString.call(t))return Array.from(t)}(t)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance")}()}var r="undefined"!=typeof window,h=r?window:{},s="".concat("cropper","-crop"),c="".concat("cropper","-disabled"),d="".concat("cropper","-hidden"),l="".concat("cropper","-hide"),p="".concat("cropper","-invisible"),m="".concat("cropper","-modal"),u="".concat("cropper","-move"),g="".concat("cropper","Action"),f="".concat("cropper","Preview"),v=h.PointerEvent?"pointerdown":"touchstart mousedown",w=h.PointerEvent?"pointermove":"touchmove mousemove",b=h.PointerEvent?"pointerup pointercancel":"touchend touchcancel mouseup",x=/^(?:e|w|s|n|se|sw|ne|nw|all|crop|move|zoom)$/,y=/^data:/,M=/^data:image\/jpeg;base64,/,C=/^(?:img|canvas)$/i,D={viewMode:0,dragMode:"crop",initialAspectRatio:NaN,aspectRatio:NaN,data:null,preview:"",responsive:!0,restore:!0,checkCrossOrigin:!0,checkOrientation:!0,modal:!0,guides:!0,center:!0,highlight:!0,background:!0,autoCrop:!0,autoCropArea:.8,movable:!0,rotatable:!0,scalable:!0,zoomable:!0,zoomOnTouch:!0,zoomOnWheel:!0,wheelZoomRatio:.1,cropBoxMovable:!0,cropBoxResizable:!0,toggleDragModeOnDblclick:!0,minCanvasWidth:0,minCanvasHeight:0,minCropBoxWidth:0,minCropBoxHeight:0,minContainerWidth:200,minContainerHeight:100,ready:null,cropstart:null,cropmove:null,cropend:null,crop:null,zoom:null},B=Number.isNaN||h.isNaN;function k(t){return"number"==typeof t&&!B(t)}function T(t){return void 0===t}function E(t){return"object"===a(t)&&null!==t}var W=Object.prototype.hasOwnProperty;function N(t){if(!E(t))return!1;try{var e=t.constructor,i=e.prototype;return e&&i&&W.call(i,"isPrototypeOf")}catch(t){return!1}}function H(t){return"function"==typeof t}function z(t,e){if(t&&H(e))if(Array.isArray(t)||k(t.length)){var i,a=t.length;for(i=0;i<a&&!1!==e.call(t,t[i],i,t);i+=1);}else E(t)&&Object.keys(t).forEach(function(i){e.call(t,t[i],i,t)});return t}var L=Object.assign||function(t){for(var e=arguments.length,i=new Array(e>1?e-1:0),a=1;a<e;a++)i[a-1]=arguments[a];return E(t)&&i.length>0&&i.forEach(function(e){E(e)&&Object.keys(e).forEach(function(i){t[i]=e[i]})}),t},O=/\.\d*(?:0|9){12}\d*$/;function Y(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:1e11;return O.test(t)?Math.round(t*e)/e:t}var X=/^(?:width|height|left|top|marginLeft|marginTop)$/;function R(t,e){var i=t.style;z(e,function(t,e){X.test(e)&&k(t)&&(t+="px"),i[e]=t})}function S(t,e){if(e)if(k(t.length))z(t,function(t){S(t,e)});else if(t.classList)t.classList.add(e);else{var i=t.className.trim();i?i.indexOf(e)<0&&(t.className="".concat(i," ").concat(e)):t.className=e}}function A(t,e){e&&(k(t.length)?z(t,function(t){A(t,e)}):t.classList?t.classList.remove(e):t.className.indexOf(e)>=0&&(t.className=t.className.replace(e,"")))}function I(t,e,i){e&&(k(t.length)?z(t,function(t){I(t,e,i)}):i?S(t,e):A(t,e))}var j=/([a-z\d])([A-Z])/g;function U(t){return t.replace(j,"$1-$2").toLowerCase()}function P(t,e){return E(t[e])?t[e]:t.dataset?t.dataset[e]:t.getAttribute("data-".concat(U(e)))}function q(t,e,i){E(i)?t[e]=i:t.dataset?t.dataset[e]=i:t.setAttribute("data-".concat(U(e)),i)}var $=/\s\s*/,Q=function(){var t=!1;if(r){var e=!1,i=function(){},a=Object.defineProperty({},"once",{get:function(){return t=!0,e},set:function(t){e=t}});h.addEventListener("test",i,a),h.removeEventListener("test",i,a)}return t}();function Z(t,e,i){var a=arguments.length>3&&void 0!==arguments[3]?arguments[3]:{},n=i;e.trim().split($).forEach(function(e){if(!Q){var o=t.listeners;o&&o[e]&&o[e][i]&&(n=o[e][i],delete o[e][i],0===Object.keys(o[e]).length&&delete o[e],0===Object.keys(o).length&&delete t.listeners)}t.removeEventListener(e,n,a)})}function F(t,e,i){var a=arguments.length>3&&void 0!==arguments[3]?arguments[3]:{},n=i;e.trim().split($).forEach(function(e){if(a.once&&!Q){var o=t.listeners,r=void 0===o?{}:o;n=function(){delete r[e][i],t.removeEventListener(e,n,a);for(var o=arguments.length,h=new Array(o),s=0;s<o;s++)h[s]=arguments[s];i.apply(t,h)},r[e]||(r[e]={}),r[e][i]&&t.removeEventListener(e,r[e][i],a),r[e][i]=n,t.listeners=r}t.addEventListener(e,n,a)})}function J(t,e,i){var a;return H(Event)&&H(CustomEvent)?a=new CustomEvent(e,{detail:i,bubbles:!0,cancelable:!0}):(a=document.createEvent("CustomEvent")).initCustomEvent(e,!0,!0,i),t.dispatchEvent(a)}function K(t){var e=t.getBoundingClientRect();return{left:e.left+(window.pageXOffset-document.documentElement.clientLeft),top:e.top+(window.pageYOffset-document.documentElement.clientTop)}}var G=h.location,V=/^(https?:)\/\/([^:/?#]+):?(\d*)/i;function _(t){var e=t.match(V);return e&&(e[1]!==G.protocol||e[2]!==G.hostname||e[3]!==G.port)}function tt(t){var e="timestamp=".concat((new Date).getTime());return t+(-1===t.indexOf("?")?"?":"&")+e}function et(t){var e=t.rotate,i=t.scaleX,a=t.scaleY,n=t.translateX,o=t.translateY,r=[];k(n)&&0!==n&&r.push("translateX(".concat(n,"px)")),k(o)&&0!==o&&r.push("translateY(".concat(o,"px)")),k(e)&&0!==e&&r.push("rotate(".concat(e,"deg)")),k(i)&&1!==i&&r.push("scaleX(".concat(i,")")),k(a)&&1!==a&&r.push("scaleY(".concat(a,")"));var h=r.length?r.join(" "):"none";return{WebkitTransform:h,msTransform:h,transform:h}}function it(t,e){var i=t.pageX,a=t.pageY,n={endX:i,endY:a};return e?n:L({startX:i,startY:a},n)}var at=Number.isFinite||h.isFinite;function nt(t){var e=t.aspectRatio,i=t.height,a=t.width,n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"contain",o=function(t){return at(t)&&t>0};if(o(a)&&o(i)){var r=i*e;"contain"===n&&r>a||"cover"===n&&r<a?i=a/e:a=i*e}else o(a)?i=a/e:o(i)&&(a=i*e);return{width:a,height:i}}var ot=String.fromCharCode;var rt=/^data:.*,/;function ht(t){var e,i=new DataView(t);try{var a,n,o;if(255===i.getUint8(0)&&216===i.getUint8(1))for(var r=i.byteLength,h=2;h+1<r;){if(255===i.getUint8(h)&&225===i.getUint8(h+1)){n=h;break}h+=1}if(n){var s=n+10;if("Exif"===function(t,e,i){var a,n="";for(i+=e,a=e;a<i;a+=1)n+=ot(t.getUint8(a));return n}(i,n+4,4)){var c=i.getUint16(s);if(((a=18761===c)||19789===c)&&42===i.getUint16(s+2,a)){var d=i.getUint32(s+4,a);d>=8&&(o=s+d)}}}if(o){var l,p,m=i.getUint16(o,a);for(p=0;p<m;p+=1)if(l=o+12*p+2,274===i.getUint16(l,a)){l+=8,e=i.getUint16(l,a),i.setUint16(l,1,a);break}}}catch(t){e=1}return e}var st={render:function(){this.initContainer(),this.initCanvas(),this.initCropBox(),this.renderCanvas(),this.cropped&&this.renderCropBox()},initContainer:function(){var t=this.element,e=this.options,i=this.container,a=this.cropper;S(a,d),A(t,d);var n={width:Math.max(i.offsetWidth,Number(e.minContainerWidth)||200),height:Math.max(i.offsetHeight,Number(e.minContainerHeight)||100)};this.containerData=n,R(a,{width:n.width,height:n.height}),S(t,d),A(a,d)},initCanvas:function(){var t=this.containerData,e=this.imageData,i=this.options.viewMode,a=Math.abs(e.rotate)%180==90,n=a?e.naturalHeight:e.naturalWidth,o=a?e.naturalWidth:e.naturalHeight,r=n/o,h=t.width,s=t.height;t.height*r>t.width?3===i?h=t.height*r:s=t.width/r:3===i?s=t.width/r:h=t.height*r;var c={aspectRatio:r,naturalWidth:n,naturalHeight:o,width:h,height:s};c.left=(t.width-h)/2,c.top=(t.height-s)/2,c.oldLeft=c.left,c.oldTop=c.top,this.canvasData=c,this.limited=1===i||2===i,this.limitCanvas(!0,!0),this.initialImageData=L({},e),this.initialCanvasData=L({},c)},limitCanvas:function(t,e){var i=this.options,a=this.containerData,n=this.canvasData,o=this.cropBoxData,r=i.viewMode,h=n.aspectRatio,s=this.cropped&&o;if(t){var c=Number(i.minCanvasWidth)||0,d=Number(i.minCanvasHeight)||0;r>1?(c=Math.max(c,a.width),d=Math.max(d,a.height),3===r&&(d*h>c?c=d*h:d=c/h)):r>0&&(c?c=Math.max(c,s?o.width:0):d?d=Math.max(d,s?o.height:0):s&&(c=o.width,(d=o.height)*h>c?c=d*h:d=c/h));var l=nt({aspectRatio:h,width:c,height:d});c=l.width,d=l.height,n.minWidth=c,n.minHeight=d,n.maxWidth=1/0,n.maxHeight=1/0}if(e)if(r>(s?0:1)){var p=a.width-n.width,m=a.height-n.height;n.minLeft=Math.min(0,p),n.minTop=Math.min(0,m),n.maxLeft=Math.max(0,p),n.maxTop=Math.max(0,m),s&&this.limited&&(n.minLeft=Math.min(o.left,o.left+(o.width-n.width)),n.minTop=Math.min(o.top,o.top+(o.height-n.height)),n.maxLeft=o.left,n.maxTop=o.top,2===r&&(n.width>=a.width&&(n.minLeft=Math.min(0,p),n.maxLeft=Math.max(0,p)),n.height>=a.height&&(n.minTop=Math.min(0,m),n.maxTop=Math.max(0,m))))}else n.minLeft=-n.width,n.minTop=-n.height,n.maxLeft=a.width,n.maxTop=a.height},renderCanvas:function(t,e){var i=this.canvasData,a=this.imageData;if(e){var n=function(t){var e=t.width,i=t.height,a=t.degree;if(90==(a=Math.abs(a)%180))return{width:i,height:e};var n=a%90*Math.PI/180,o=Math.sin(n),r=Math.cos(n),h=e*r+i*o,s=e*o+i*r;return a>90?{width:s,height:h}:{width:h,height:s}}({width:a.naturalWidth*Math.abs(a.scaleX||1),height:a.naturalHeight*Math.abs(a.scaleY||1),degree:a.rotate||0}),o=n.width,r=n.height,h=i.width*(o/i.naturalWidth),s=i.height*(r/i.naturalHeight);i.left-=(h-i.width)/2,i.top-=(s-i.height)/2,i.width=h,i.height=s,i.aspectRatio=o/r,i.naturalWidth=o,i.naturalHeight=r,this.limitCanvas(!0,!1)}(i.width>i.maxWidth||i.width<i.minWidth)&&(i.left=i.oldLeft),(i.height>i.maxHeight||i.height<i.minHeight)&&(i.top=i.oldTop),i.width=Math.min(Math.max(i.width,i.minWidth),i.maxWidth),i.height=Math.min(Math.max(i.height,i.minHeight),i.maxHeight),this.limitCanvas(!1,!0),i.left=Math.min(Math.max(i.left,i.minLeft),i.maxLeft),i.top=Math.min(Math.max(i.top,i.minTop),i.maxTop),i.oldLeft=i.left,i.oldTop=i.top,R(this.canvas,L({width:i.width,height:i.height},et({translateX:i.left,translateY:i.top}))),this.renderImage(t),this.cropped&&this.limited&&this.limitCropBox(!0,!0)},renderImage:function(t){var e=this.canvasData,i=this.imageData,a=i.naturalWidth*(e.width/e.naturalWidth),n=i.naturalHeight*(e.height/e.naturalHeight);L(i,{width:a,height:n,left:(e.width-a)/2,top:(e.height-n)/2}),R(this.image,L({width:i.width,height:i.height},et(L({translateX:i.left,translateY:i.top},i)))),t&&this.output()},initCropBox:function(){var t=this.options,e=this.canvasData,i=t.aspectRatio||t.initialAspectRatio,a=Number(t.autoCropArea)||.8,n={width:e.width,height:e.height};i&&(e.height*i>e.width?n.height=n.width/i:n.width=n.height*i),this.cropBoxData=n,this.limitCropBox(!0,!0),n.width=Math.min(Math.max(n.width,n.minWidth),n.maxWidth),n.height=Math.min(Math.max(n.height,n.minHeight),n.maxHeight),n.width=Math.max(n.minWidth,n.width*a),n.height=Math.max(n.minHeight,n.height*a),n.left=e.left+(e.width-n.width)/2,n.top=e.top+(e.height-n.height)/2,n.oldLeft=n.left,n.oldTop=n.top,this.initialCropBoxData=L({},n)},limitCropBox:function(t,e){var i=this.options,a=this.containerData,n=this.canvasData,o=this.cropBoxData,r=this.limited,h=i.aspectRatio;if(t){var s=Number(i.minCropBoxWidth)||0,c=Number(i.minCropBoxHeight)||0,d=r?Math.min(a.width,n.width,n.width+n.left,a.width-n.left):a.width,l=r?Math.min(a.height,n.height,n.height+n.top,a.height-n.top):a.height;s=Math.min(s,a.width),c=Math.min(c,a.height),h&&(s&&c?c*h>s?c=s/h:s=c*h:s?c=s/h:c&&(s=c*h),l*h>d?l=d/h:d=l*h),o.minWidth=Math.min(s,d),o.minHeight=Math.min(c,l),o.maxWidth=d,o.maxHeight=l}e&&(r?(o.minLeft=Math.max(0,n.left),o.minTop=Math.max(0,n.top),o.maxLeft=Math.min(a.width,n.left+n.width)-o.width,o.maxTop=Math.min(a.height,n.top+n.height)-o.height):(o.minLeft=0,o.minTop=0,o.maxLeft=a.width-o.width,o.maxTop=a.height-o.height))},renderCropBox:function(){var t=this.options,e=this.containerData,i=this.cropBoxData;(i.width>i.maxWidth||i.width<i.minWidth)&&(i.left=i.oldLeft),(i.height>i.maxHeight||i.height<i.minHeight)&&(i.top=i.oldTop),i.width=Math.min(Math.max(i.width,i.minWidth),i.maxWidth),i.height=Math.min(Math.max(i.height,i.minHeight),i.maxHeight),this.limitCropBox(!1,!0),i.left=Math.min(Math.max(i.left,i.minLeft),i.maxLeft),i.top=Math.min(Math.max(i.top,i.minTop),i.maxTop),i.oldLeft=i.left,i.oldTop=i.top,t.movable&&t.cropBoxMovable&&q(this.face,g,i.width>=e.width&&i.height>=e.height?"move":"all"),R(this.cropBox,L({width:i.width,height:i.height},et({translateX:i.left,translateY:i.top}))),this.cropped&&this.limited&&this.limitCanvas(!0,!0),this.disabled||this.output()},output:function(){this.preview(),J(this.element,"crop",this.getData())}},ct={initPreview:function(){var t=this.crossOrigin,e=this.options.preview,i=t?this.crossOriginUrl:this.url,a=document.createElement("img");if(t&&(a.crossOrigin=t),a.src=i,this.viewBox.appendChild(a),this.viewBoxImage=a,e){var n=e;"string"==typeof e?n=this.element.ownerDocument.querySelectorAll(e):e.querySelector&&(n=[e]),this.previews=n,z(n,function(e){var a=document.createElement("img");q(e,f,{width:e.offsetWidth,height:e.offsetHeight,html:e.innerHTML}),t&&(a.crossOrigin=t),a.src=i,a.style.cssText='display:block;width:100%;height:auto;min-width:0!important;min-height:0!important;max-width:none!important;max-height:none!important;image-orientation:0deg!important;"',e.innerHTML="",e.appendChild(a)})}},resetPreview:function(){z(this.previews,function(t){var e=P(t,f);R(t,{width:e.width,height:e.height}),t.innerHTML=e.html,function(t,e){if(E(t[e]))try{delete t[e]}catch(i){t[e]=void 0}else if(t.dataset)try{delete t.dataset[e]}catch(i){t.dataset[e]=void 0}else t.removeAttribute("data-".concat(U(e)))}(t,f)})},preview:function(){var t=this.imageData,e=this.canvasData,i=this.cropBoxData,a=i.width,n=i.height,o=t.width,r=t.height,h=i.left-e.left-t.left,s=i.top-e.top-t.top;this.cropped&&!this.disabled&&(R(this.viewBoxImage,L({width:o,height:r},et(L({translateX:-h,translateY:-s},t)))),z(this.previews,function(e){var i=P(e,f),c=i.width,d=i.height,l=c,p=d,m=1;a&&(p=n*(m=c/a)),n&&p>d&&(l=a*(m=d/n),p=d),R(e,{width:l,height:p}),R(e.getElementsByTagName("img")[0],L({width:o*m,height:r*m},et(L({translateX:-h*m,translateY:-s*m},t))))}))}},dt={bind:function(){var t=this.element,e=this.options,i=this.cropper;H(e.cropstart)&&F(t,"cropstart",e.cropstart),H(e.cropmove)&&F(t,"cropmove",e.cropmove),H(e.cropend)&&F(t,"cropend",e.cropend),H(e.crop)&&F(t,"crop",e.crop),H(e.zoom)&&F(t,"zoom",e.zoom),F(i,v,this.onCropStart=this.cropStart.bind(this)),e.zoomable&&e.zoomOnWheel&&F(i,"wheel mousewheel DOMMouseScroll",this.onWheel=this.wheel.bind(this)),e.toggleDragModeOnDblclick&&F(i,"dblclick",this.onDblclick=this.dblclick.bind(this)),F(t.ownerDocument,w,this.onCropMove=this.cropMove.bind(this)),F(t.ownerDocument,b,this.onCropEnd=this.cropEnd.bind(this)),e.responsive&&F(window,"resize",this.onResize=this.resize.bind(this))},unbind:function(){var t=this.element,e=this.options,i=this.cropper;H(e.cropstart)&&Z(t,"cropstart",e.cropstart),H(e.cropmove)&&Z(t,"cropmove",e.cropmove),H(e.cropend)&&Z(t,"cropend",e.cropend),H(e.crop)&&Z(t,"crop",e.crop),H(e.zoom)&&Z(t,"zoom",e.zoom),Z(i,v,this.onCropStart),e.zoomable&&e.zoomOnWheel&&Z(i,"wheel mousewheel DOMMouseScroll",this.onWheel),e.toggleDragModeOnDblclick&&Z(i,"dblclick",this.onDblclick),Z(t.ownerDocument,w,this.onCropMove),Z(t.ownerDocument,b,this.onCropEnd),e.responsive&&Z(window,"resize",this.onResize)}},lt={resize:function(){var t=this.options,e=this.container,i=this.containerData,a=Number(t.minContainerWidth)||200,n=Number(t.minContainerHeight)||100;if(!(this.disabled||i.width<=a||i.height<=n)){var o,r,h=e.offsetWidth/i.width;if(1!==h||e.offsetHeight!==i.height)t.restore&&(o=this.getCanvasData(),r=this.getCropBoxData()),this.render(),t.restore&&(this.setCanvasData(z(o,function(t,e){o[e]=t*h})),this.setCropBoxData(z(r,function(t,e){r[e]=t*h})))}},dblclick:function(){this.disabled||"none"===this.options.dragMode||this.setDragMode(function(t,e){return t.classList?t.classList.contains(e):t.className.indexOf(e)>-1}(this.dragBox,s)?"move":"crop")},wheel:function(t){var e=this,i=Number(this.options.wheelZoomRatio)||.1,a=1;this.disabled||(t.preventDefault(),this.wheeling||(this.wheeling=!0,setTimeout(function(){e.wheeling=!1},50),t.deltaY?a=t.deltaY>0?1:-1:t.wheelDelta?a=-t.wheelDelta/120:t.detail&&(a=t.detail>0?1:-1),this.zoom(-a*i,t)))},cropStart:function(t){if(!this.disabled){var e,i=this.options,a=this.pointers;t.changedTouches?z(t.changedTouches,function(t){a[t.identifier]=it(t)}):a[t.pointerId||0]=it(t),e=Object.keys(a).length>1&&i.zoomable&&i.zoomOnTouch?"zoom":P(t.target,g),x.test(e)&&!1!==J(this.element,"cropstart",{originalEvent:t,action:e})&&(t.preventDefault(),this.action=e,this.cropping=!1,"crop"===e&&(this.cropping=!0,S(this.dragBox,m)))}},cropMove:function(t){var e=this.action;if(!this.disabled&&e){var i=this.pointers;t.preventDefault(),!1!==J(this.element,"cropmove",{originalEvent:t,action:e})&&(t.changedTouches?z(t.changedTouches,function(t){L(i[t.identifier]||{},it(t,!0))}):L(i[t.pointerId||0]||{},it(t,!0)),this.change(t))}},cropEnd:function(t){if(!this.disabled){var e=this.action,i=this.pointers;t.changedTouches?z(t.changedTouches,function(t){delete i[t.identifier]}):delete i[t.pointerId||0],e&&(t.preventDefault(),Object.keys(i).length||(this.action=""),this.cropping&&(this.cropping=!1,I(this.dragBox,m,this.cropped&&this.options.modal)),J(this.element,"cropend",{originalEvent:t,action:e}))}}},pt={change:function(t){var e,i=this.options,a=this.canvasData,n=this.containerData,o=this.cropBoxData,r=this.pointers,h=this.action,s=i.aspectRatio,c=o.left,l=o.top,p=o.width,m=o.height,u=c+p,g=l+m,f=0,v=0,w=n.width,b=n.height,x=!0;!s&&t.shiftKey&&(s=p&&m?p/m:1),this.limited&&(f=o.minLeft,v=o.minTop,w=f+Math.min(n.width,a.width,a.left+a.width),b=v+Math.min(n.height,a.height,a.top+a.height));var y=r[Object.keys(r)[0]],M={x:y.endX-y.startX,y:y.endY-y.startY},C=function(t){switch(t){case"e":u+M.x>w&&(M.x=w-u);break;case"w":c+M.x<f&&(M.x=f-c);break;case"n":l+M.y<v&&(M.y=v-l);break;case"s":g+M.y>b&&(M.y=b-g)}};switch(h){case"all":c+=M.x,l+=M.y;break;case"e":if(M.x>=0&&(u>=w||s&&(l<=v||g>=b))){x=!1;break}C("e"),(p+=M.x)<0&&(h="w",c-=p=-p),s&&(m=p/s,l+=(o.height-m)/2);break;case"n":if(M.y<=0&&(l<=v||s&&(c<=f||u>=w))){x=!1;break}C("n"),m-=M.y,l+=M.y,m<0&&(h="s",l-=m=-m),s&&(p=m*s,c+=(o.width-p)/2);break;case"w":if(M.x<=0&&(c<=f||s&&(l<=v||g>=b))){x=!1;break}C("w"),p-=M.x,c+=M.x,p<0&&(h="e",c-=p=-p),s&&(m=p/s,l+=(o.height-m)/2);break;case"s":if(M.y>=0&&(g>=b||s&&(c<=f||u>=w))){x=!1;break}C("s"),(m+=M.y)<0&&(h="n",l-=m=-m),s&&(p=m*s,c+=(o.width-p)/2);break;case"ne":if(s){if(M.y<=0&&(l<=v||u>=w)){x=!1;break}C("n"),m-=M.y,l+=M.y,p=m*s}else C("n"),C("e"),M.x>=0?u<w?p+=M.x:M.y<=0&&l<=v&&(x=!1):p+=M.x,M.y<=0?l>v&&(m-=M.y,l+=M.y):(m-=M.y,l+=M.y);p<0&&m<0?(h="sw",l-=m=-m,c-=p=-p):p<0?(h="nw",c-=p=-p):m<0&&(h="se",l-=m=-m);break;case"nw":if(s){if(M.y<=0&&(l<=v||c<=f)){x=!1;break}C("n"),m-=M.y,l+=M.y,p=m*s,c+=o.width-p}else C("n"),C("w"),M.x<=0?c>f?(p-=M.x,c+=M.x):M.y<=0&&l<=v&&(x=!1):(p-=M.x,c+=M.x),M.y<=0?l>v&&(m-=M.y,l+=M.y):(m-=M.y,l+=M.y);p<0&&m<0?(h="se",l-=m=-m,c-=p=-p):p<0?(h="ne",c-=p=-p):m<0&&(h="sw",l-=m=-m);break;case"sw":if(s){if(M.x<=0&&(c<=f||g>=b)){x=!1;break}C("w"),p-=M.x,c+=M.x,m=p/s}else C("s"),C("w"),M.x<=0?c>f?(p-=M.x,c+=M.x):M.y>=0&&g>=b&&(x=!1):(p-=M.x,c+=M.x),M.y>=0?g<b&&(m+=M.y):m+=M.y;p<0&&m<0?(h="ne",l-=m=-m,c-=p=-p):p<0?(h="se",c-=p=-p):m<0&&(h="nw",l-=m=-m);break;case"se":if(s){if(M.x>=0&&(u>=w||g>=b)){x=!1;break}C("e"),m=(p+=M.x)/s}else C("s"),C("e"),M.x>=0?u<w?p+=M.x:M.y>=0&&g>=b&&(x=!1):p+=M.x,M.y>=0?g<b&&(m+=M.y):m+=M.y;p<0&&m<0?(h="nw",l-=m=-m,c-=p=-p):p<0?(h="sw",c-=p=-p):m<0&&(h="ne",l-=m=-m);break;case"move":this.move(M.x,M.y),x=!1;break;case"zoom":this.zoom(function(t){var e=L({},t),i=[];return z(t,function(t,a){delete e[a],z(e,function(e){var a=Math.abs(t.startX-e.startX),n=Math.abs(t.startY-e.startY),o=Math.abs(t.endX-e.endX),r=Math.abs(t.endY-e.endY),h=Math.sqrt(a*a+n*n),s=(Math.sqrt(o*o+r*r)-h)/h;i.push(s)})}),i.sort(function(t,e){return Math.abs(t)<Math.abs(e)}),i[0]}(r),t),x=!1;break;case"crop":if(!M.x||!M.y){x=!1;break}e=K(this.cropper),c=y.startX-e.left,l=y.startY-e.top,p=o.minWidth,m=o.minHeight,M.x>0?h=M.y>0?"se":"ne":M.x<0&&(c-=p,h=M.y>0?"sw":"nw"),M.y<0&&(l-=m),this.cropped||(A(this.cropBox,d),this.cropped=!0,this.limited&&this.limitCropBox(!0,!0))}x&&(o.width=p,o.height=m,o.left=c,o.top=l,this.action=h,this.renderCropBox()),z(r,function(t){t.startX=t.endX,t.startY=t.endY})}},mt={crop:function(){return!this.ready||this.cropped||this.disabled||(this.cropped=!0,this.limitCropBox(!0,!0),this.options.modal&&S(this.dragBox,m),A(this.cropBox,d),this.setCropBoxData(this.initialCropBoxData)),this},reset:function(){return this.ready&&!this.disabled&&(this.imageData=L({},this.initialImageData),this.canvasData=L({},this.initialCanvasData),this.cropBoxData=L({},this.initialCropBoxData),this.renderCanvas(),this.cropped&&this.renderCropBox()),this},clear:function(){return this.cropped&&!this.disabled&&(L(this.cropBoxData,{left:0,top:0,width:0,height:0}),this.cropped=!1,this.renderCropBox(),this.limitCanvas(!0,!0),this.renderCanvas(),A(this.dragBox,m),S(this.cropBox,d)),this},replace:function(t){var e=arguments.length>1&&void 0!==arguments[1]&&arguments[1];return!this.disabled&&t&&(this.isImg&&(this.element.src=t),e?(this.url=t,this.image.src=t,this.ready&&(this.viewBoxImage.src=t,z(this.previews,function(e){e.getElementsByTagName("img")[0].src=t}))):(this.isImg&&(this.replaced=!0),this.options.data=null,this.uncreate(),this.load(t))),this},enable:function(){return this.ready&&this.disabled&&(this.disabled=!1,A(this.cropper,c)),this},disable:function(){return this.ready&&!this.disabled&&(this.disabled=!0,S(this.cropper,c)),this},destroy:function(){var t=this.element;return t.cropper?(t.cropper=void 0,this.isImg&&this.replaced&&(t.src=this.originalUrl),this.uncreate(),this):this},move:function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:t,i=this.canvasData,a=i.left,n=i.top;return this.moveTo(T(t)?t:a+Number(t),T(e)?e:n+Number(e))},moveTo:function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:t,i=this.canvasData,a=!1;return t=Number(t),e=Number(e),this.ready&&!this.disabled&&this.options.movable&&(k(t)&&(i.left=t,a=!0),k(e)&&(i.top=e,a=!0),a&&this.renderCanvas(!0)),this},zoom:function(t,e){var i=this.canvasData;return t=(t=Number(t))<0?1/(1-t):1+t,this.zoomTo(i.width*t/i.naturalWidth,null,e)},zoomTo:function(t,e,i){var a=this.options,n=this.canvasData,o=n.width,r=n.height,h=n.naturalWidth,s=n.naturalHeight;if((t=Number(t))>=0&&this.ready&&!this.disabled&&a.zoomable){var c=h*t,d=s*t;if(!1===J(this.element,"zoom",{ratio:t,oldRatio:o/h,originalEvent:i}))return this;if(i){var l=this.pointers,p=K(this.cropper),m=l&&Object.keys(l).length?function(t){var e=0,i=0,a=0;return z(t,function(t){var n=t.startX,o=t.startY;e+=n,i+=o,a+=1}),{pageX:e/=a,pageY:i/=a}}(l):{pageX:i.pageX,pageY:i.pageY};n.left-=(c-o)*((m.pageX-p.left-n.left)/o),n.top-=(d-r)*((m.pageY-p.top-n.top)/r)}else N(e)&&k(e.x)&&k(e.y)?(n.left-=(c-o)*((e.x-n.left)/o),n.top-=(d-r)*((e.y-n.top)/r)):(n.left-=(c-o)/2,n.top-=(d-r)/2);n.width=c,n.height=d,this.renderCanvas(!0)}return this},rotate:function(t){return this.rotateTo((this.imageData.rotate||0)+Number(t))},rotateTo:function(t){return k(t=Number(t))&&this.ready&&!this.disabled&&this.options.rotatable&&(this.imageData.rotate=t%360,this.renderCanvas(!0,!0)),this},scaleX:function(t){var e=this.imageData.scaleY;return this.scale(t,k(e)?e:1)},scaleY:function(t){var e=this.imageData.scaleX;return this.scale(k(e)?e:1,t)},scale:function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:t,i=this.imageData,a=!1;return t=Number(t),e=Number(e),this.ready&&!this.disabled&&this.options.scalable&&(k(t)&&(i.scaleX=t,a=!0),k(e)&&(i.scaleY=e,a=!0),a&&this.renderCanvas(!0,!0)),this},getData:function(){var t,e=arguments.length>0&&void 0!==arguments[0]&&arguments[0],i=this.options,a=this.imageData,n=this.canvasData,o=this.cropBoxData;if(this.ready&&this.cropped){t={x:o.left-n.left,y:o.top-n.top,width:o.width,height:o.height};var r=a.width/a.naturalWidth;if(z(t,function(e,i){t[i]=e/r}),e){var h=Math.round(t.y+t.height),s=Math.round(t.x+t.width);t.x=Math.round(t.x),t.y=Math.round(t.y),t.width=s-t.x,t.height=h-t.y}}else t={x:0,y:0,width:0,height:0};return i.rotatable&&(t.rotate=a.rotate||0),i.scalable&&(t.scaleX=a.scaleX||1,t.scaleY=a.scaleY||1),t},setData:function(t){var e=this.options,i=this.imageData,a=this.canvasData,n={};if(this.ready&&!this.disabled&&N(t)){var o=!1;e.rotatable&&k(t.rotate)&&t.rotate!==i.rotate&&(i.rotate=t.rotate,o=!0),e.scalable&&(k(t.scaleX)&&t.scaleX!==i.scaleX&&(i.scaleX=t.scaleX,o=!0),k(t.scaleY)&&t.scaleY!==i.scaleY&&(i.scaleY=t.scaleY,o=!0)),o&&this.renderCanvas(!0,!0);var r=i.width/i.naturalWidth;k(t.x)&&(n.left=t.x*r+a.left),k(t.y)&&(n.top=t.y*r+a.top),k(t.width)&&(n.width=t.width*r),k(t.height)&&(n.height=t.height*r),this.setCropBoxData(n)}return this},getContainerData:function(){return this.ready?L({},this.containerData):{}},getImageData:function(){return this.sized?L({},this.imageData):{}},getCanvasData:function(){var t=this.canvasData,e={};return this.ready&&z(["left","top","width","height","naturalWidth","naturalHeight"],function(i){e[i]=t[i]}),e},setCanvasData:function(t){var e=this.canvasData,i=e.aspectRatio;return this.ready&&!this.disabled&&N(t)&&(k(t.left)&&(e.left=t.left),k(t.top)&&(e.top=t.top),k(t.width)?(e.width=t.width,e.height=t.width/i):k(t.height)&&(e.height=t.height,e.width=t.height*i),this.renderCanvas(!0)),this},getCropBoxData:function(){var t,e=this.cropBoxData;return this.ready&&this.cropped&&(t={left:e.left,top:e.top,width:e.width,height:e.height}),t||{}},setCropBoxData:function(t){var e,i,a=this.cropBoxData,n=this.options.aspectRatio;return this.ready&&this.cropped&&!this.disabled&&N(t)&&(k(t.left)&&(a.left=t.left),k(t.top)&&(a.top=t.top),k(t.width)&&t.width!==a.width&&(e=!0,a.width=t.width),k(t.height)&&t.height!==a.height&&(i=!0,a.height=t.height),n&&(e?a.height=a.width/n:i&&(a.width=a.height*n)),this.renderCropBox()),this},getCroppedCanvas:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{};if(!this.ready||!window.HTMLCanvasElement)return null;var e=this.canvasData,i=function(t,e,i,a){var n=e.aspectRatio,r=e.naturalWidth,h=e.naturalHeight,s=e.rotate,c=void 0===s?0:s,d=e.scaleX,l=void 0===d?1:d,p=e.scaleY,m=void 0===p?1:p,u=i.aspectRatio,g=i.naturalWidth,f=i.naturalHeight,v=a.fillColor,w=void 0===v?"transparent":v,b=a.imageSmoothingEnabled,x=void 0===b||b,y=a.imageSmoothingQuality,M=void 0===y?"low":y,C=a.maxWidth,D=void 0===C?1/0:C,B=a.maxHeight,k=void 0===B?1/0:B,T=a.minWidth,E=void 0===T?0:T,W=a.minHeight,N=void 0===W?0:W,H=document.createElement("canvas"),z=H.getContext("2d"),L=nt({aspectRatio:u,width:D,height:k}),O=nt({aspectRatio:u,width:E,height:N},"cover"),X=Math.min(L.width,Math.max(O.width,g)),R=Math.min(L.height,Math.max(O.height,f)),S=nt({aspectRatio:n,width:D,height:k}),A=nt({aspectRatio:n,width:E,height:N},"cover"),I=Math.min(S.width,Math.max(A.width,r)),j=Math.min(S.height,Math.max(A.height,h)),U=[-I/2,-j/2,I,j];return H.width=Y(X),H.height=Y(R),z.fillStyle=w,z.fillRect(0,0,X,R),z.save(),z.translate(X/2,R/2),z.rotate(c*Math.PI/180),z.scale(l,m),z.imageSmoothingEnabled=x,z.imageSmoothingQuality=M,z.drawImage.apply(z,[t].concat(o(U.map(function(t){return Math.floor(Y(t))})))),z.restore(),H}(this.image,this.imageData,e,t);if(!this.cropped)return i;var a=this.getData(),n=a.x,r=a.y,h=a.width,s=a.height,c=i.width/Math.floor(e.naturalWidth);1!==c&&(n*=c,r*=c,h*=c,s*=c);var d=h/s,l=nt({aspectRatio:d,width:t.maxWidth||1/0,height:t.maxHeight||1/0}),p=nt({aspectRatio:d,width:t.minWidth||0,height:t.minHeight||0},"cover"),m=nt({aspectRatio:d,width:t.width||(1!==c?i.width:h),height:t.height||(1!==c?i.height:s)}),u=m.width,g=m.height;u=Math.min(l.width,Math.max(p.width,u)),g=Math.min(l.height,Math.max(p.height,g));var f=document.createElement("canvas"),v=f.getContext("2d");f.width=Y(u),f.height=Y(g),v.fillStyle=t.fillColor||"transparent",v.fillRect(0,0,u,g);var w=t.imageSmoothingEnabled,b=void 0===w||w,x=t.imageSmoothingQuality;v.imageSmoothingEnabled=b,x&&(v.imageSmoothingQuality=x);var y,M,C,D,B,k,T=i.width,E=i.height,W=n,N=r;W<=-h||W>T?(W=0,y=0,C=0,B=0):W<=0?(C=-W,W=0,B=y=Math.min(T,h+W)):W<=T&&(C=0,B=y=Math.min(h,T-W)),y<=0||N<=-s||N>E?(N=0,M=0,D=0,k=0):N<=0?(D=-N,N=0,k=M=Math.min(E,s+N)):N<=E&&(D=0,k=M=Math.min(s,E-N));var H=[W,N,y,M];if(B>0&&k>0){var z=u/h;H.push(C*z,D*z,B*z,k*z)}return v.drawImage.apply(v,[i].concat(o(H.map(function(t){return Math.floor(Y(t))})))),f},setAspectRatio:function(t){var e=this.options;return this.disabled||T(t)||(e.aspectRatio=Math.max(0,t)||NaN,this.ready&&(this.initCropBox(),this.cropped&&this.renderCropBox())),this},setDragMode:function(t){var e=this.options,i=this.dragBox,a=this.face;if(this.ready&&!this.disabled){var n="crop"===t,o=e.movable&&"move"===t;t=n||o?t:"none",e.dragMode=t,q(i,g,t),I(i,s,n),I(i,u,o),e.cropBoxMovable||(q(a,g,t),I(a,s,n),I(a,u,o))}return this}},ut=h.Cropper,gt=function(){function t(e){var i=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};if(function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}(this,t),!e||!C.test(e.tagName))throw new Error("The first argument is required and must be an <img> or <canvas> element.");this.element=e,this.options=L({},D,N(i)&&i),this.cropped=!1,this.disabled=!1,this.pointers={},this.ready=!1,this.reloading=!1,this.replaced=!1,this.sized=!1,this.sizing=!1,this.init()}return function(t,e,i){e&&n(t.prototype,e),i&&n(t,i)}(t,[{key:"init",value:function(){var t,e=this.element,i=e.tagName.toLowerCase();if(!e.cropper){if(e.cropper=this,"img"===i){if(this.isImg=!0,t=e.getAttribute("src")||"",this.originalUrl=t,!t)return;t=e.src}else"canvas"===i&&window.HTMLCanvasElement&&(t=e.toDataURL());this.load(t)}}},{key:"load",value:function(t){var e=this;if(t){this.url=t,this.imageData={};var i=this.element,a=this.options;if(a.rotatable||a.scalable||(a.checkOrientation=!1),a.checkOrientation&&window.ArrayBuffer)if(y.test(t))M.test(t)?this.read(function(t){var e=t.replace(rt,""),i=atob(e),a=new ArrayBuffer(i.length),n=new Uint8Array(a);return z(n,function(t,e){n[e]=i.charCodeAt(e)}),a}(t)):this.clone();else{var n=new XMLHttpRequest,o=this.clone.bind(this);this.reloading=!0,this.xhr=n,n.ontimeout=o,n.onabort=o,n.onerror=o,n.onprogress=function(){"image/jpeg"!==n.getResponseHeader("content-type")&&n.abort()},n.onload=function(){e.read(n.response)},n.onloadend=function(){e.reloading=!1,e.xhr=null},a.checkCrossOrigin&&_(t)&&i.crossOrigin&&(t=tt(t)),n.open("GET",t),n.responseType="arraybuffer",n.withCredentials="use-credentials"===i.crossOrigin,n.send()}else this.clone()}}},{key:"read",value:function(t){var e=this.options,i=this.imageData,a=ht(t),n=0,r=1,h=1;if(a>1){this.url=function(t,e){for(var i=[],a=new Uint8Array(t);a.length>0;)i.push(ot.apply(void 0,o(a.subarray(0,8192)))),a=a.subarray(8192);return"data:".concat(e,";base64,").concat(btoa(i.join("")))}(t,"image/jpeg");var s=function(t){var e=0,i=1,a=1;switch(t){case 2:i=-1;break;case 3:e=-180;break;case 4:a=-1;break;case 5:e=90,a=-1;break;case 6:e=90;break;case 7:e=90,i=-1;break;case 8:e=-90}return{rotate:e,scaleX:i,scaleY:a}}(a);n=s.rotate,r=s.scaleX,h=s.scaleY}e.rotatable&&(i.rotate=n),e.scalable&&(i.scaleX=r,i.scaleY=h),this.clone()}},{key:"clone",value:function(){var t,e,i=this.element,a=this.url;this.options.checkCrossOrigin&&_(a)&&((t=i.crossOrigin)?e=a:(t="anonymous",e=tt(a))),this.crossOrigin=t,this.crossOriginUrl=e;var n=document.createElement("img");t&&(n.crossOrigin=t),n.src=e||a,this.image=n,n.onload=this.start.bind(this),n.onerror=this.stop.bind(this),S(n,l),i.parentNode.insertBefore(n,i.nextSibling)}},{key:"start",value:function(){var t=this,e=this.isImg?this.element:this.image;e.onload=null,e.onerror=null,this.sizing=!0;var i=h.navigator&&/(Macintosh|iPhone|iPod|iPad).*AppleWebKit/i.test(h.navigator.userAgent),a=function(e,i){L(t.imageData,{naturalWidth:e,naturalHeight:i,aspectRatio:e/i}),t.sizing=!1,t.sized=!0,t.build()};if(!e.naturalWidth||i){var n=document.createElement("img"),o=document.body||document.documentElement;this.sizingImage=n,n.onload=function(){a(n.width,n.height),i||o.removeChild(n)},n.src=e.src,i||(n.style.cssText="left:0;max-height:none!important;max-width:none!important;min-height:0!important;min-width:0!important;opacity:0;position:absolute;top:0;z-index:-1;",o.appendChild(n))}else a(e.naturalWidth,e.naturalHeight)}},{key:"stop",value:function(){var t=this.image;t.onload=null,t.onerror=null,t.parentNode.removeChild(t),this.image=null}},{key:"build",value:function(){if(this.sized&&!this.ready){var t=this.element,e=this.options,i=this.image,a=t.parentNode,n=document.createElement("div");n.innerHTML='<div class="cropper-container" touch-action="none"><div class="cropper-wrap-box"><div class="cropper-canvas"></div></div><div class="cropper-drag-box"></div><div class="cropper-crop-box"><span class="cropper-view-box"></span><span class="cropper-dashed dashed-h"></span><span class="cropper-dashed dashed-v"></span><span class="cropper-center"></span><span class="cropper-face"></span><span class="cropper-line line-e" data-cropper-action="e"></span><span class="cropper-line line-n" data-cropper-action="n"></span><span class="cropper-line line-w" data-cropper-action="w"></span><span class="cropper-line line-s" data-cropper-action="s"></span><span class="cropper-point point-e" data-cropper-action="e"></span><span class="cropper-point point-n" data-cropper-action="n"></span><span class="cropper-point point-w" data-cropper-action="w"></span><span class="cropper-point point-s" data-cropper-action="s"></span><span class="cropper-point point-ne" data-cropper-action="ne"></span><span class="cropper-point point-nw" data-cropper-action="nw"></span><span class="cropper-point point-sw" data-cropper-action="sw"></span><span class="cropper-point point-se" data-cropper-action="se"></span></div></div>';var o=n.querySelector(".".concat("cropper","-container")),r=o.querySelector(".".concat("cropper","-canvas")),h=o.querySelector(".".concat("cropper","-drag-box")),s=o.querySelector(".".concat("cropper","-crop-box")),c=s.querySelector(".".concat("cropper","-face"));this.container=a,this.cropper=o,this.canvas=r,this.dragBox=h,this.cropBox=s,this.viewBox=o.querySelector(".".concat("cropper","-view-box")),this.face=c,r.appendChild(i),S(t,d),a.insertBefore(o,t.nextSibling),this.isImg||A(i,l),this.initPreview(),this.bind(),e.initialAspectRatio=Math.max(0,e.initialAspectRatio)||NaN,e.aspectRatio=Math.max(0,e.aspectRatio)||NaN,e.viewMode=Math.max(0,Math.min(3,Math.round(e.viewMode)))||0,S(s,d),e.guides||S(s.getElementsByClassName("".concat("cropper","-dashed")),d),e.center||S(s.getElementsByClassName("".concat("cropper","-center")),d),e.background&&S(o,"".concat("cropper","-bg")),e.highlight||S(c,p),e.cropBoxMovable&&(S(c,u),q(c,g,"all")),e.cropBoxResizable||(S(s.getElementsByClassName("".concat("cropper","-line")),d),S(s.getElementsByClassName("".concat("cropper","-point")),d)),this.render(),this.ready=!0,this.setDragMode(e.dragMode),e.autoCrop&&this.crop(),this.setData(e.data),H(e.ready)&&F(t,"ready",e.ready,{once:!0}),J(t,"ready")}}},{key:"unbuild",value:function(){this.ready&&(this.ready=!1,this.unbind(),this.resetPreview(),this.cropper.parentNode.removeChild(this.cropper),A(this.element,d))}},{key:"uncreate",value:function(){this.ready?(this.unbuild(),this.ready=!1,this.cropped=!1):this.sizing?(this.sizingImage.onload=null,this.sizing=!1,this.sized=!1):this.reloading?(this.xhr.onabort=null,this.xhr.abort()):this.image&&this.stop()}}],[{key:"noConflict",value:function(){return window.Cropper=ut,t}},{key:"setDefaults",value:function(t){L(D,N(t)&&t)}}]),t}();L(gt.prototype,st,ct,dt,lt,pt,mt),e.a=gt},563:function(t,e,i){}}]);