(()=>{"use strict";const e=window.wp.element,t=window.wp.blockEditor,l=window.wp.blocks,o=window.wp.components,n=window.wp.coreData,s=window.wp.i18n,r=JSON.parse('{"u2":"brtled/post-views"}');(0,l.registerBlockType)(r.u2,{edit(l){let{attributes:r,setAttributes:a,context:{postId:i,postType:w}}=l,c=null;if(w&&i){const[e]=(0,n.useEntityProp)("postType",w,"meta",i);c=e._views}return null==c?(0,e.createElement)("div",(0,t.useBlockProps)(),(0,s.__)("文章浏览量","brtled")):(0,e.createElement)("div",(0,t.useBlockProps)(),(0,e.createElement)(t.InspectorControls,{key:"setting"},(0,e.createElement)(o.PanelBody,null,(0,e.createElement)(o.ToggleControl,{checked:r.hasLabel,onChange:e=>a({hasLabel:e}),label:(0,s.__)("显示文本","brtled")}))),c+(r.hasLabel&&" "+(0,s.__)("阅读","brtled")))},save:()=>null})})();