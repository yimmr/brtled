(()=>{"use strict";const e=window.wp.element,t=window.wp.blockEditor,l=window.wp.blocks,o=JSON.parse('{"u2":"brtled/collapse-content"}');(0,l.registerBlockType)(o.u2,{edit:()=>(0,e.createElement)("div",(0,t.useBlockProps)({className:"is-show"}),(0,e.createElement)(t.InnerBlocks,{templateLock:!1})),save:()=>(0,e.createElement)("div",t.useBlockProps.save(),(0,e.createElement)(t.InnerBlocks.Content,null))})})();