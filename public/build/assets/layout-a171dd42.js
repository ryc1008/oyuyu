import{m as n}from"./vuex-ab0c87e4.js";import{n as i}from"./app-f4f25d77.js";import"./axios-4a70c6fc.js";import"./vue-27ef7f4b.js";import"./async-validator-33e353d7.js";import"./babel-runtime-69a8a51d.js";import"./vue-router-b30a8712.js";import"./vue-cookie-6191409e.js";import"./tiny-cookie-20745a96.js";import"./vue-axios-c4ba63d4.js";import"./qs-68262ff1.js";import"./side-channel-4ad99da8.js";import"./get-intrinsic-bd2830fd.js";import"./has-symbols-e8f3ca0e.js";import"./has-proto-f7d0b240.js";import"./function-bind-22e7ee79.js";import"./has-26d28e02.js";import"./call-bind-e5c1c8b0.js";import"./object-inspect-2769fc76.js";import"./element-ui-3130f6a7.js";import"./resize-observer-polyfill-abe38d2e.js";import"./throttle-debounce-83204b99.js";import"./babel-helper-vue-jsx-merge-props-f37b6d04.js";import"./normalize-wheel-3e66c890.js";import"./deepmerge-1ee2baff.js";import"./nprogress-d48da9fa.js";import"./moment-fbc5633a.js";/* empty css                     */import"./element-tiptap-376f8dc6.js";import"./tiptap-6f0a2729.js";import"./prosemirror-state-d26f883c.js";import"./prosemirror-model-2d5d1d45.js";import"./orderedmap-1b52af60.js";import"./prosemirror-transform-7d6a52dd.js";import"./prosemirror-view-329e6b0d.js";import"./prosemirror-dropcursor-5184b87b.js";import"./prosemirror-gapcursor-d7df0b38.js";import"./prosemirror-keymap-a3c7cf8f.js";import"./w3c-keyname-a25e4cc1.js";import"./prosemirror-commands-9594733f.js";import"./prosemirror-inputrules-2a9a1b7b.js";import"./tiptap-utils-79441358.js";import"./tiptap-extensions-2e008a14.js";import"./tiptap-commands-9ba0d5a0.js";import"./prosemirror-schema-list-587b3b24.js";import"./highlight.js-9f6fcca9.js";import"./fault-8318a74e.js";import"./format-7101f815.js";import"./prosemirror-tables-c55e9af7.js";import"./prosemirror-history-420343bb.js";import"./rope-sequence-5ceeafee.js";import"./prosemirror-utils-e4018d71.js";import"./mavon-editor-7772d28a.js";const m={computed:{...n({breadcrumb:r=>r.breadcrumb})},data:function(){return{user:null,datetime:null,timer:null}},created(){this.user=JSON.parse(this.$cookie.get("user")),this.clock(),this.timer=setInterval(this.clock,1e3)},beforeDestroy(){clearInterval()},methods:{logout(){this.$store.dispatch("userLogout").then(()=>{this.$func.success("正在退出登录......").then(()=>{this.$router.push({name:"login"})})})},clock(){let r=new Date().toLocaleString("zh",{year:"numeric",month:"numeric",day:"numeric"}),t=new Date().toLocaleString("zh",{hour:"numeric",minute:"numeric",second:"numeric"}),[e,a,s]=r.split("/");this.datetime=`${e}年${a.padStart(2,"0")}月${s.padStart(2,"0")}日 ${t}`}}};var c=function(){var t=this,e=t._self._c;return e("header",{staticClass:"header",attrs:{id:"header"}},[t._m(0),e("div",{staticClass:"header-breadcrumb"},[e("el-breadcrumb",{attrs:{separator:"/"}},[e("el-breadcrumb-item",{attrs:{to:{name:"main"}}},[t._v("系统首页")]),t._l(t.breadcrumb,function(a,s){return e("el-breadcrumb-item",{key:this},[e("span",{class:t.breadcrumb.length==s+1?"header-title current":"header-title"},[t._v(t._s(a.title))])])})],2)],1),t.user?e("div",{staticClass:"header-user"},[e("div",{staticStyle:{"padding-right":"30px",color:"#2461EF"}},[t._v(t._s(t.datetime))]),e("div",{staticClass:"avatar"},[e("img",{attrs:{src:"/image/admin/"+t.user.avatar+".jpg",alt:""}})]),e("div",{staticClass:"nickname"},[t._v(t._s(t.user.nickname))]),e("div",{staticClass:"logout",on:{click:function(a){return t.logout()}}},[e("i",{staticClass:"fa fa-power-off"}),t._v(" 退出")])]):t._e()])},p=[function(){var r=this,t=r._self._c;return t("div",{staticClass:"header-logo"},[r._v(" 捕鱼"),t("span",[r._v("游戏")])])}],u=i(m,c,p,!1,null,null,null,null);const _=u.exports,d={computed:{...n({active:r=>r.active,isCollapse:r=>r.isCollapse,routers:r=>r.routers})},created(){},methods:{collapse(){this.isCollapse?this.$store.dispatch("setState",{isCollapse:!1}):this.$store.dispatch("setState",{isCollapse:!0})}}};var v=function(){var t=this,e=t._self._c;return e("div",[e("el-menu",{staticClass:"menu",attrs:{"default-active":t.active,collapse:t.isCollapse,"background-color":"transparent","text-color":"#222b45",router:!0,"unique-opened":!0,"active-text-color":"#fff"}},[e("el-menu-item",{attrs:{index:"/main"}},[e("i",{staticClass:"fa fa-home fa-icon"}),e("span",{attrs:{slot:"title"},slot:"title"},[t._v("系统首页")])]),t._l(t.routers,function(a,s){return a.children&&a.children.length?e("el-submenu",{key:"index_"+s,attrs:{index:"index_"+s}},[e("template",{slot:"title"},[e("i",{staticClass:"fa-icon",class:a.meta.icon}),e("span",[t._v(t._s(a.meta.title))])]),e("el-menu-item-group",t._l(a.children,function(o,l){return o.meta.show?e("el-menu-item",{key:l+1,attrs:{index:o.path}},[e("i",{staticClass:"fa fa-icon fa-angle-right"}),t._v(t._s(o.meta.title)+" ")]):t._e()}),1)],2):t._e()})],2),e("div",{class:t.isCollapse?"menu-collapse is-collapse":"menu-collapse"},[e("i",{staticClass:"fa fa-dedent",attrs:{alt:"折叠菜单",title:"折叠菜单"},on:{click:t.collapse}})])],1)},f=[],h=i(d,v,f,!1,null,null,null,null);const C=h.exports,g={data:function(){return{start:new Date().getFullYear()-2,end:new Date().getFullYear()+2}}};var $=function(){var t=this,e=t._self._c;return e("div",{staticClass:"footer"},[t._v(" © "+t._s(t.start)+"-"+t._s(t.end)+" Powered By Management System ")])},b=[],k=i(g,$,b,!1,null,null,null,null);const x=k.exports,y={components:{vHeader:_,vMenu:C,vFooter:x},computed:{...n({isCollapse:r=>r.isCollapse})}};var S=function(){var t=this,e=t._self._c;return e("div",{staticClass:"board"},[e("v-header"),e("v-menu"),e("div",{class:t.isCollapse?"main main-collapse":"main"},[e("transition",{attrs:{name:"slide-fade",mode:"out-in"}},[e("keep-alive",[e("router-view")],1)],1)],1),e("v-footer")],1)},w=[],F=i(y,S,w,!1,null,null,null,null);const Ft=F.exports;export{Ft as default};
