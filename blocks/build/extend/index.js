(()=>{var e,t={378:(e,t,r)=>{"use strict";const o=window.wp.blocks,n=window.wp.i18n;(0,o.registerBlockStyle)("core/heading",{name:"underline-heading",label:(0,n.__)("下划线标题","brtled")}),(0,o.registerBlockStyle)("core/heading",{name:"white-space-nowrap",label:(0,n.__)("禁用换行","brtled")}),(0,o.registerBlockStyle)("core/cover",{name:"height-from-backgound-image",label:(0,n.__)("背景图决定高度","brtled")}),(0,o.registerBlockStyle)("core/group",{name:"section-padding",label:(0,n.__)("区域内边距","brtled")}),(0,o.registerBlockStyle)("core/gallery",{name:"six-columns",label:(0,n.__)("强制六栏","brtled")}),(0,o.registerBlockStyle)("core/columns",{name:"justify-content-sb",label:(0,n.__)("左右对齐","brtled")}),(0,o.registerBlockStyle)("core/column",{name:"basis-auto",label:(0,n.__)("宽度自由","brtled")}),(0,o.registerBlockStyle)("core/post-template",{name:"title-in-cover",label:(0,n.__)("封面内标题","brtled")}),(0,o.registerBlockStyle)("core/post-template",{name:"article-item",label:(0,n.__)("文章通用","brtled")}),(0,o.registerBlockStyle)("core/post-template",{name:"article-grid-item",label:(0,n.__)("文章网格","brtled")}),(0,o.registerBlockStyle)("core/post-template",{name:"article-grid-item-v2",label:(0,n.__)("文章网格v2","brtled")}),(0,o.registerBlockStyle)("core/post-template",{name:"product-grid-item",label:(0,n.__)("产品网格","brtled")}),(0,o.registerBlockStyle)("core/post-template",{name:"page-grid-item",label:(0,n.__)("页面网格","brtled")}),r(866);const l={attributes:{displayLayout:{type:"flex",columns:5},layout:{type:"default"},align:"wide"},innerBlocks:[["core/post-template",{align:"wide",className:"is-style-product-grid-item"},[["core/post-featured-image",{isLink:!0}],["core/post-title",{isLink:!0}]]],["core/query-no-results"]]},i=window.wp.element,a=window.wp.blockEditor,c=window.wp.components,s=window.wp.compose;!function(){const e="brtled/product-list";(0,o.registerBlockVariation)("core/query",{name:e,title:(0,n.__)("产品列表","brtled"),description:(0,n.__)("显示产品列表","brtled"),isActive:["namespace"],category:"theme",attributes:{namespace:e,query:{perPage:5,pages:1,offset:0,postType:"product",order:"desc",orderBy:"date",author:"",search:"",exclude:[],sticky:!1,inherit:!1},...l.attributes},scope:["inserter"],innerBlocks:l.innerBlocks,allowedControls:["order","taxQuery","search"]})}(),function(){const e="brtled/section";(0,o.registerBlockVariation)("core/group",{name:e,title:(0,n.__)("区域","brtled"),description:(0,n.__)("聚合区块到一个区域里","brtled"),category:"design",attributes:{namespace:e,tagName:"section",className:"is-style-section-padding",layout:{type:"constrained"}},isActive:["namespace"],scope:["block","inserter"]})}(),function(){const e="brtled/taxonomy-post-query";(0,o.registerBlockVariation)("core/query",{name:e,title:(0,n.__)("动态分类法帖子查询","brtled"),description:(0,n.__)("根据分类法术语上下文显示对应的帖子列表","brtled"),isActive:["namespace"],category:"theme",parent:"brtled/term-query",attributes:{namespace:e,query:{perPage:10,pages:0,offset:0,postType:"product",order:"desc",orderBy:"date",author:"",search:"",exclude:[],sticky:!1,inherit:!1,useContextTaxonomy:!0},...l.attributes},scope:["inserter"],innerBlocks:l.innerBlocks,allowedControls:["order"]})}(),function(){const e="brtled/related-posts";(0,o.registerBlockVariation)("core/query",{name:e,title:(0,n.__)("相关查询","brtled"),description:(0,n.__)("查询相关的内容，如产品、文章","brtled"),isActive:["namespace"],category:"theme",icon:"grid-view",attributes:{namespace:e,query:{perPage:4,pages:1,offset:0,postType:"product",order:"desc",orderBy:"date",author:"",search:"",exclude:[],sticky:!1,inherit:!1,related:!0},displayLayout:{type:"flex",columns:4},layout:{type:"default"},align:"wide"},scope:["inserter"],innerBlocks:l.innerBlocks,allowedControls:["order"]})}(),function(){const e="brtled/query-by-id",{addFilter:t}=wp.hooks;(0,o.registerBlockVariation)("core/query",{name:e,title:(0,n.__)("ID查询","brtled"),description:(0,n.__)("查询指定ID的帖子","brtled"),isActive:["namespace"],category:"theme",attributes:{namespace:e,query:{perPage:4,pages:0,offset:0,postType:"post",order:"asc",orderBy:"post__in",author:"",search:"",postIn:[],exclude:[],sticky:!1,inherit:!1},displayLayout:{type:"flex",columns:4},layout:{type:"default"},align:"wide"},scope:["inserter"],innerBlocks:l.innerBlocks,allowedControls:[]});const r=(0,s.createHigherOrderComponent)((t=>r=>{if(r?.attributes?.namespace===e){const{query:e}=r.attributes,o=(t,o)=>{r.setAttributes({query:{...e,[t]:o}})};return(0,i.createElement)(i.Fragment,null,(0,i.createElement)(a.InspectorControls,null,(0,i.createElement)(c.PanelBody,{title:(0,n.__)("帖子ID","brtled")},(0,i.createElement)(c.TextControl,{value:e.postIn.join(","),onChange:e=>o("postIn",e.split(",")),help:(0,n.__)("多个ID使用英文逗号（,）分隔","brtled")}))),(0,i.createElement)(t,r))}return(0,i.createElement)(t,r)}),"customControls");t("editor.BlockEdit",e,r)}()},866:()=>{window.addEventListener("DOMContentLoaded",(function(){document.body.querySelectorAll(".wp-block-navigation").forEach((function(e){let{href:t,pathname:r,origin:o,search:n}=window.location,l=e.querySelector(`[href="${t}"]`);null==l&&(l=e.querySelector(`[href="${o+r+n}"]`)),null==l&&(l=e.querySelector(`[href="${o+r}"]`)),null!=l&&(l.closest(".wp-block-navigation-item")?.classList?.add("current-menu-item"),l.closest(".wp-block-navigation__container > .wp-block-navigation-item")?.classList?.add("current-menu-item"))})),document.querySelector(".wp-block-search-open")?.addEventListener("click",(function(){const e=this.parentElement.querySelector(".wp-block-search");if(null==e)return;const t="is-show";e.classList.contains(t)?e.classList.remove(t):e.classList.add(t)}));const e=()=>{const e=document.querySelector(".wp-block-navigation__responsive-container-open");return null==e?window.innerWidth>992:"none"==window.getComputedStyle(e).display},t=function(t){let r=!(arguments.length>1&&void 0!==arguments[1])||arguments[1];const o=t.querySelector(":scope > .wp-block-navigation__submenu-container");if(null!=o&&e())if(r){const e=o.parentElement.getBoundingClientRect();o.style.top=e.top+e.height+"px"}else o.style.top=null};if(document.querySelectorAll(".wp-block-navigation__container > .child-full-width").forEach((function(e){e.addEventListener("mouseenter",(function(r){r.target==e&&t(this)})),(e=>{let t=e.querySelector(":scope > a")?.getAttribute("title");if(!t)return;const r=e.querySelector(".wp-block-navigation__submenu-container");if(null!=r){const e=document.createElement("h2");e.className="has-text-align-center product-menu-item-title",e.style.fontSize="clamp(1.125rem, 1.125rem + ((1vw - 0.48rem) * 0.721), 1.5rem)",e.innerHTML=t;const o=document.createElement("li");o.className="wp-block-navigation__submenu-title",o.appendChild(e),r.prepend(o)}})(e),t(e)})),!e()){const e=document.body.querySelector(".site-header-container"),t=e?.querySelector(".wp-block-brtled-language-switcher"),r=e?.querySelector(".wp-block-navigation__responsive-container-content");null!=t&&null!=r&&r.prepend(t)}}))}},r={};function o(e){var n=r[e];if(void 0!==n)return n.exports;var l=r[e]={exports:{}};return t[e](l,l.exports,o),l.exports}o.m=t,e=[],o.O=(t,r,n,l)=>{if(!r){var i=1/0;for(d=0;d<e.length;d++){for(var[r,n,l]=e[d],a=!0,c=0;c<r.length;c++)(!1&l||i>=l)&&Object.keys(o.O).every((e=>o.O[e](r[c])))?r.splice(c--,1):(a=!1,l<i&&(i=l));if(a){e.splice(d--,1);var s=n();void 0!==s&&(t=s)}}return t}l=l||0;for(var d=e.length;d>0&&e[d-1][2]>l;d--)e[d]=e[d-1];e[d]=[r,n,l]},o.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),(()=>{var e={664:0,638:0,286:0};o.O.j=t=>0===e[t];var t=(t,r)=>{var n,l,[i,a,c]=r,s=0;if(i.some((t=>0!==e[t]))){for(n in a)o.o(a,n)&&(o.m[n]=a[n]);if(c)var d=c(o)}for(t&&t(r);s<i.length;s++)l=i[s],o.o(e,l)&&e[l]&&e[l][0](),e[l]=0;return o.O(d)},r=globalThis.webpackChunktodo_list=globalThis.webpackChunktodo_list||[];r.forEach(t.bind(null,0)),r.push=t.bind(null,r.push.bind(r))})();var n=o.O(void 0,[286],(()=>o(378)));n=o.O(n)})();