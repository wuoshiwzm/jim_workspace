yii=function(t){var e={reloadableScripts:[],clickableSelector:'a, button, input[type="submit"], input[type="button"], input[type="reset"], input[type="image"]',changeableSelector:"select, input, textarea",getCsrfParam:function(){return t("meta[name=csrf-param]").attr("content")},getCsrfToken:function(){return t("meta[name=csrf-token]").attr("content")},setCsrfToken:function(e,n){t("meta[name=csrf-param]").attr("content",e);t("meta[name=csrf-token]").attr("content",n)},refreshCsrfToken:function(){var n=e.getCsrfToken();if(n){t('form input[name="'+e.getCsrfParam()+'"]').val(n)}},confirm:function(t,e,n){if(confirm(t)){!e||e()}else{!n||n()}},handleAction:function(n){var i=n.data("method"),r=n.closest("form"),a=n.attr("href"),o=n.data("params");if(i===undefined){if(a&&a!="#"){window.location=a}else if(n.is(":submit")&&r.length){r.trigger("submit")}return}var c=!r.length;if(c){if(!a||!a.match(/(^\/|:\/\/)/)){a=window.location.href}r=t('<form method="'+i+'"></form>');r.attr("action",a);var f=n.attr("target");if(f){r.attr("target",f)}if(!i.match(/(get|post)/i)){r.append('<input name="_method" value="'+i+'" type="hidden">');i="POST"}if(!i.match(/(get|head|options)/i)){var u=e.getCsrfParam();if(u){r.append('<input name="'+u+'" value="'+e.getCsrfToken()+'" type="hidden">')}}r.hide().appendTo("body")}var s=r.data("yiiActiveForm");if(s){s.submitObject=n}if(o&&t.isPlainObject(o)){t.each(o,function(t,e){r.append('<input name="'+t+'" value="'+e+'" type="hidden">')})}var l=r.attr("method");r.attr("method",i);var d=null;if(a&&a!="#"){d=r.attr("action");r.attr("action",a)}r.trigger("submit");if(d!=null){r.attr("action",d)}r.attr("method",l);if(o&&t.isPlainObject(o)){t.each(o,function(e,n){t('input[name="'+e+'"]',r).remove()})}if(c){r.remove()}},getQueryParams:function(t){var e=t.indexOf("?");if(e<0){return{}}var n=t.substring(e+1).split("&");for(var i=0,r={};i<n.length;i++){n[i]=n[i].split("=");r[decodeURIComponent(n[i][0])]=decodeURIComponent(n[i][1])}return r},initModule:function(n){if(n.isActive===undefined||n.isActive){if(t.isFunction(n.init)){n.init()}t.each(n,function(){if(t.isPlainObject(this)){e.initModule(this)}})}},init:function(){i();n();a();r()}};function n(){t(document).ajaxComplete(function(t,e,n){var i=e.getResponseHeader("X-Redirect");if(i){window.location=i}})}function i(){t.ajaxPrefilter(function(t,n,i){if(!t.crossDomain&&e.getCsrfParam()){i.setRequestHeader("X-CSRF-Token",e.getCsrfToken())}});e.refreshCsrfToken()}function r(){var n=function(n){var i=t(this),r=i.data("method"),a=i.data("confirm");if(r===undefined&&a===undefined){return true}if(a!==undefined){e.confirm(a,function(){e.handleAction(i)})}else{e.handleAction(i)}n.stopImmediatePropagation();return false};t(document).on("click.yii",e.clickableSelector,n).on("change.yii",e.changeableSelector,n)}function a(){var n=location.protocol+"//"+location.host;var i=t("script[src]").map(function(){return this.src.charAt(0)==="/"?n+this.src:this.src}).toArray();t.ajaxPrefilter("script",function(r,a,o){if(r.dataType=="jsonp"){return}var c=r.url.charAt(0)==="/"?n+r.url:r.url;if(t.inArray(c,i)===-1){i.push(c)}else{var f=t.inArray(c,t.map(e.reloadableScripts,function(t){return t.charAt(0)==="/"?n+t:t}))!==-1;if(!f){o.abort()}}});t(document).ajaxComplete(function(n,i,r){var a=[];t("link[rel=stylesheet]").each(function(){if(t.inArray(this.href,e.reloadableScripts)!==-1){return}if(t.inArray(this.href,a)==-1){a.push(this.href)}else{t(this).remove()}})})}return e}(jQuery);jQuery(document).ready(function(){yii.initModule(yii)});