import{N as o,M as h,E as D}from"./tiptap-6f0a2729.js";import{t as x,a as m,b as $,n as N,s as q,m as b,c as k,u as v,r as G,p as j}from"./tiptap-commands-9ba0d5a0.js";import"./highlight.js-9f6fcca9.js";import"./fault-8318a74e.js";import{a as F,D as U}from"./prosemirror-view-329e6b0d.js";import{c as V,g as Z,d as A}from"./tiptap-utils-79441358.js";import{P as _,T as X,a as K}from"./prosemirror-state-d26f883c.js";import{t as Y,a as J,b as Q,c as ee,e as te,f as re,g as se,h as ae,m as T,s as w,i as ne,j as oe,k as le,l as ie,n as de,o as R,p as ue,q as ce}from"./prosemirror-tables-c55e9af7.js";import{h as ge,u as O,r as f,a as pe,b as me}from"./prosemirror-history-420343bb.js";import{w as y,t as I}from"./prosemirror-inputrules-2a9a1b7b.js";import{s as z,t as g,c as S,e as E}from"./prosemirror-commands-9594733f.js";import{s as he,a as H,l as L}from"./prosemirror-schema-list-587b3b24.js";class Re extends o{get name(){return"blockquote"}get schema(){return{content:"block*",group:"block",defining:!0,draggable:!1,parseDOM:[{tag:"blockquote"}],toDOM:()=>["blockquote",0]}}commands({type:e}){return()=>x(e)}keys({type:e}){return{"Ctrl->":x(e)}}inputRules({type:e}){return[y(/^\s*>\s$/,e)]}}class Se extends o{get name(){return"bullet_list"}get schema(){return{content:"list_item+",group:"block",parseDOM:[{tag:"ul"}],toDOM:()=>["ul",0]}}commands({type:e,schema:t}){return()=>m(e,t.nodes.list_item)}keys({type:e,schema:t}){return{"Shift-Ctrl-8":m(e,t.nodes.list_item)}}inputRules({type:e}){return[y(/^\s*([-+*])\s$/,e)]}}class Ee extends o{get name(){return"code_block"}get schema(){return{content:"text*",marks:"",group:"block",code:!0,defining:!0,draggable:!1,parseDOM:[{tag:"pre",preserveWhitespace:"full"}],toDOM:()=>["pre",["code",0]]}}commands({type:e,schema:t}){return()=>$(e,t.nodes.paragraph)}keys({type:e}){return{"Shift-Ctrl-\\":z(e)}}inputRules({type:e}){return[I(/^```$/,e)]}}class $e extends o{get name(){return"hard_break"}get schema(){return{inline:!0,group:"inline",selectable:!1,parseDOM:[{tag:"br"}],toDOM:()=>["br"]}}commands({type:e}){return()=>S(E,(t,r)=>(r(t.tr.replaceSelectionWith(e.create()).scrollIntoView()),!0))}keys({type:e}){const t=S(E,(r,a)=>(a(r.tr.replaceSelectionWith(e.create()).scrollIntoView()),!0));return{"Mod-Enter":t,"Shift-Enter":t}}}class Ne extends o{get name(){return"heading"}get defaultOptions(){return{levels:[1,2,3,4,5,6]}}get schema(){return{attrs:{level:{default:1}},content:"inline*",group:"block",defining:!0,draggable:!1,parseDOM:this.options.levels.map(e=>({tag:`h${e}`,attrs:{level:e}})),toDOM:e=>[`h${e.attrs.level}`,0]}}commands({type:e,schema:t}){return r=>$(e,t.nodes.paragraph,r)}keys({type:e}){return this.options.levels.reduce((t,r)=>({...t,[`Shift-Ctrl-${r}`]:z(e,{level:r})}),{})}inputRules({type:e}){return this.options.levels.map(t=>I(new RegExp(`^(#{1,${t}})\\s$`),e,()=>({level:t})))}}class Ie extends o{get name(){return"horizontal_rule"}get schema(){return{group:"block",parseDOM:[{tag:"hr"}],toDOM:()=>["hr"]}}commands({type:e}){return()=>(t,r)=>r(t.tr.replaceSelectionWith(e.create()))}inputRules({type:e}){return[N(/^(?:---|___\s|\*\*\*\s)$/,e)]}}const fe=/!\[(.+|:?)]\((\S+)(?:(?:\s+)["'](\S+)["'])?\)/;class ze extends o{get name(){return"image"}get schema(){return{inline:!0,attrs:{src:{},alt:{default:null},title:{default:null}},group:"inline",draggable:!0,parseDOM:[{tag:"img[src]",getAttrs:e=>({src:e.getAttribute("src"),title:e.getAttribute("title"),alt:e.getAttribute("alt")})}],toDOM:e=>["img",e.attrs]}}commands({type:e}){return t=>(r,a)=>{const{selection:n}=r,u=n.$cursor?n.$cursor.pos:n.$to.pos,l=e.create(t),d=r.tr.insert(u,l);a(d)}}inputRules({type:e}){return[N(fe,e,t=>{const[,r,a,n]=t;return{src:a,alt:r,title:n}})]}get plugins(){return[new _({props:{handleDOMEvents:{drop(e,t){if(!(t.dataTransfer&&t.dataTransfer.files&&t.dataTransfer.files.length))return;const a=Array.from(t.dataTransfer.files).filter(l=>/image/i.test(l.type));if(a.length===0)return;t.preventDefault();const{schema:n}=e.state,u=e.posAtCoords({left:t.clientX,top:t.clientY});a.forEach(l=>{const d=new FileReader;d.onload=c=>{const i=n.nodes.image.create({src:c.target.result}),p=e.state.tr.insert(u.pos,i);e.dispatch(p)},d.readAsDataURL(l)})}}}})]}}class He extends o{get name(){return"list_item"}get schema(){return{content:"paragraph block*",defining:!0,draggable:!1,parseDOM:[{tag:"li"}],toDOM:()=>["li",0]}}keys({type:e}){return{Enter:he(e),Tab:H(e),"Shift-Tab":L(e)}}}class Le extends o{get name(){return"ordered_list"}get schema(){return{attrs:{order:{default:1}},content:"list_item+",group:"block",parseDOM:[{tag:"ol",getAttrs:e=>({order:e.hasAttribute("start")?+e.getAttribute("start"):1})}],toDOM:e=>e.attrs.order===1?["ol",0]:["ol",{start:e.attrs.order},0]}}commands({type:e,schema:t}){return()=>m(e,t.nodes.list_item)}keys({type:e,schema:t}){return{"Shift-Ctrl-9":m(e,t.nodes.list_item)}}inputRules({type:e}){return[y(/^(\d+)\.\s$/,e,t=>({order:+t[1]}),(t,r)=>r.childCount+r.attrs.order===+t[1])]}}var M=Y({tableGroup:"block",cellContent:"block+",cellAttributes:{background:{default:null,getFromDOM(s){return s.style.backgroundColor||null},setDOMAttr(s,e){if(s){const t={style:`${e.style||""}background-color: ${s};`};Object.assign(e,t)}}}}});class Be extends o{get name(){return"table"}get defaultOptions(){return{resizable:!1}}get schema(){return M.table}commands({schema:e}){return{createTable:({rowsCount:t,colsCount:r,withHeaderRow:a})=>(n,u)=>{const l=n.tr.selection.anchor+1,d=V(e,t,r,a),c=n.tr.replaceSelectionWith(d).scrollIntoView(),i=c.doc.resolve(l);c.setSelection(X.near(i)),u(c)},addColumnBefore:()=>J,addColumnAfter:()=>Q,deleteColumn:()=>ee,addRowBefore:()=>te,addRowAfter:()=>re,deleteRow:()=>se,deleteTable:()=>ae,toggleCellMerge:()=>(t,r)=>{T(t,r)||w(t,r)},mergeCells:()=>T,splitCell:()=>w,toggleHeaderColumn:()=>ne,toggleHeaderRow:()=>oe,toggleHeaderCell:()=>le,setCellAttr:({name:t,value:r})=>ie(t,r),fixTables:()=>de}}keys(){return{Tab:R(1),"Shift-Tab":R(-1)}}get plugins(){return[...this.options.resizable?[ue()]:[],ce()]}}class Pe extends o{get name(){return"table_header"}get schema(){return M.table_header}}class We extends o{get name(){return"table_cell"}get schema(){return M.table_cell}}class qe extends o{get name(){return"table_row"}get schema(){return M.table_row}}class ve extends o{get name(){return"todo_item"}get defaultOptions(){return{nested:!1}}get view(){return{props:["node","updateAttrs","view"],methods:{onChange(){this.updateAttrs({done:!this.node.attrs.done})}},template:`
        <li :data-type="node.type.name" :data-done="node.attrs.done.toString()" data-drag-handle>
          <span class="todo-checkbox" contenteditable="false" @click="onChange"></span>
          <div class="todo-content" ref="content" :contenteditable="view.editable.toString()"></div>
        </li>
      `}}get schema(){return{attrs:{done:{default:!1}},draggable:!0,content:this.options.nested?"(paragraph|todo_list)+":"paragraph+",toDOM:e=>{const{done:t}=e.attrs;return["li",{"data-type":this.name,"data-done":t.toString()},["span",{class:"todo-checkbox",contenteditable:"false"}],["div",{class:"todo-content"},0]]},parseDOM:[{priority:51,tag:`[data-type="${this.name}"]`,getAttrs:e=>({done:e.getAttribute("data-done")==="true"})}]}}keys({type:e}){return{Enter:q(e),Tab:this.options.nested?H(e):()=>{},"Shift-Tab":L(e)}}}class Ge extends o{get name(){return"todo_list"}get schema(){return{group:"block",content:"todo_item+",toDOM:()=>["ul",{"data-type":this.name},0],parseDOM:[{priority:51,tag:`[data-type="${this.name}"]`}]}}commands({type:e,schema:t}){return()=>m(e,t.nodes.todo_item)}inputRules({type:e}){return[y(/^\s*(\[ \])\s$/,e)]}}class je extends h{get name(){return"bold"}get schema(){return{parseDOM:[{tag:"strong"},{tag:"b",getAttrs:e=>e.style.fontWeight!=="normal"&&null},{style:"font-weight",getAttrs:e=>/^(bold(er)?|[5-9]\d{2,})$/.test(e)&&null}],toDOM:()=>["strong",0]}}keys({type:e}){return{"Mod-b":g(e)}}commands({type:e}){return()=>g(e)}inputRules({type:e}){return[b(/(?:\*\*|__)([^*_]+)(?:\*\*|__)$/,e)]}pasteRules({type:e}){return[k(/(?:\*\*|__)([^*_]+)(?:\*\*|__)/g,e)]}}class Fe extends h{get name(){return"italic"}get schema(){return{parseDOM:[{tag:"i"},{tag:"em"},{style:"font-style=italic"}],toDOM:()=>["em",0]}}keys({type:e}){return{"Mod-i":g(e)}}commands({type:e}){return()=>g(e)}inputRules({type:e}){return[b(/(?:^|[^_])(_([^_]+)_)$/,e),b(/(?:^|[^*])(\*([^*]+)\*)$/,e)]}pasteRules({type:e}){return[k(/_([^_]+)_/g,e),k(/\*([^*]+)\*/g,e)]}}class Ue extends h{get name(){return"link"}get defaultOptions(){return{openOnClick:!0,target:null}}get schema(){return{attrs:{href:{default:null},target:{default:null}},inclusive:!1,parseDOM:[{tag:"a[href]",getAttrs:e=>({href:e.getAttribute("href"),target:e.getAttribute("target")})}],toDOM:e=>["a",{...e.attrs,rel:"noopener noreferrer nofollow",target:e.attrs.target||this.options.target},0]}}commands({type:e}){return t=>t.href?v(e,t):G(e)}pasteRules({type:e}){return[j(/https?:\/\/(www\.)?[-a-zA-Z0-9@:%._+~#=]{1,256}\.[a-zA-Z]{2,}\b([-a-zA-Z0-9@:%_+.~#?&//=,()!]*)/gi,e,t=>({href:t}))]}get plugins(){return this.options.openOnClick?[new _({props:{handleClick:(e,t,r)=>{const{schema:a}=e.state,n=Z(e.state,a.marks.link);n.href&&r.target instanceof HTMLAnchorElement&&(r.stopPropagation(),window.open(n.href,n.target))}}})]:[]}}class Ve extends h{get name(){return"strike"}get schema(){return{parseDOM:[{tag:"s"},{tag:"del"},{tag:"strike"},{style:"text-decoration",getAttrs:e=>e==="line-through"}],toDOM:()=>["s",0]}}keys({type:e}){return{"Mod-d":g(e)}}commands({type:e}){return()=>g(e)}inputRules({type:e}){return[b(/~([^~]+)~$/,e)]}pasteRules({type:e}){return[k(/~([^~]+)~/g,e)]}}class Ze extends h{get name(){return"underline"}get schema(){return{parseDOM:[{tag:"u"},{style:"text-decoration",getAttrs:e=>e==="underline"}],toDOM:()=>["u",0]}}keys({type:e}){return{"Mod-u":g(e)}}commands({type:e}){return()=>g(e)}}class Xe extends D{get name(){return"history"}get defaultOptions(){return{depth:"",newGroupDelay:""}}keys(){return{"Mod-z":O,"Mod-y":f,"Shift-Mod-z":f,"Mod-я":O,"Shift-Mod-я":f}}get plugins(){return[ge({depth:this.options.depth,newGroupDelay:this.options.newGroupDelay})]}commands(){return{undo:()=>O,redo:()=>f,undoDepth:()=>pe,redoDepth:()=>me}}}class Ke extends D{get name(){return"placeholder"}get defaultOptions(){return{emptyEditorClass:"is-editor-empty",emptyNodeClass:"is-empty",emptyNodeText:"Write something …",showOnlyWhenEditable:!0,showOnlyCurrent:!0}}get plugins(){return[new _({props:{decorations:({doc:e,plugins:t,selection:r})=>{const u=t.find(i=>i.key.startsWith("editable$")).props.editable()||!this.options.showOnlyWhenEditable,{anchor:l}=r,d=[],c=e.textContent.length===0;return u?(e.descendants((i,p)=>{const B=l>=p&&l<=p+i.nodeSize,P=i.content.size===0;if((B||!this.options.showOnlyCurrent)&&P){const C=[this.options.emptyNodeClass];c&&C.push(this.options.emptyEditorClass);const W=F.node(p,p+i.nodeSize,{class:C.join(" "),"data-empty-text":typeof this.options.emptyNodeText=="function"?this.options.emptyNodeText(i):this.options.emptyNodeText});d.push(W)}return!1}),U.create(e,d)):!1}}})]}}class Ye extends D{get name(){return"trailing_node"}get defaultOptions(){return{node:"paragraph",notAfter:["paragraph"]}}get plugins(){const e=new K(this.name),t=Object.entries(this.editor.schema.nodes).map(([,r])=>r).filter(r=>this.options.notAfter.includes(r.name));return[new _({key:e,view:()=>({update:r=>{const{state:a}=r;if(!e.getState(a))return;const{doc:u,schema:l,tr:d}=a,c=l.nodes[this.options.node],i=d.insert(u.content.size,c.create());r.dispatch(i)}}),state:{init:(r,a)=>{const n=a.tr.doc.lastChild;return!A({node:n,types:t})},apply:(r,a)=>{if(!r.docChanged)return a;const n=r.doc.lastChild;return!A({node:n,types:t})}}})]}}export{Re as B,Ee as C,Ne as H,ze as I,He as L,Le as O,Ke as P,Ve as S,ve as T,Ze as U,Se as a,Ge as b,Be as c,je as d,Fe as e,Ue as f,Ie as g,Xe as h,$e as i,Ye as j,Pe as k,We as l,qe as m};