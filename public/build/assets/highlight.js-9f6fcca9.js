function ne(e){return e instanceof Map?e.clear=e.delete=e.set=function(){throw new Error("map is read-only")}:e instanceof Set&&(e.add=e.clear=e.delete=function(){throw new Error("set is read-only")}),Object.freeze(e),Object.getOwnPropertyNames(e).forEach(function(t){var i=e[t];typeof i=="object"&&!Object.isFrozen(i)&&ne(i)}),e}var _e=ne,Ve=ne;_e.default=Ve;class ge{constructor(t){t.data===void 0&&(t.data={}),this.data=t.data,this.isMatchIgnored=!1}ignoreMatch(){this.isMatchIgnored=!0}}function P(e){return e.replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/"/g,"&quot;").replace(/'/g,"&#x27;")}function L(e,...t){const i=Object.create(null);for(const c in e)i[c]=e[c];return t.forEach(function(c){for(const E in c)i[E]=c[E]}),i}const Xe="</span>",fe=e=>!!e.kind;class qe{constructor(t,i){this.buffer="",this.classPrefix=i.classPrefix,t.walk(this)}addText(t){this.buffer+=P(t)}openNode(t){if(!fe(t))return;let i=t.kind;t.sublanguage||(i=`${this.classPrefix}${i}`),this.span(i)}closeNode(t){fe(t)&&(this.buffer+=Xe)}value(){return this.buffer}span(t){this.buffer+=`<span class="${t}">`}}class ie{constructor(){this.rootNode={children:[]},this.stack=[this.rootNode]}get top(){return this.stack[this.stack.length-1]}get root(){return this.rootNode}add(t){this.top.children.push(t)}openNode(t){const i={kind:t,children:[]};this.add(i),this.stack.push(i)}closeNode(){if(this.stack.length>1)return this.stack.pop()}closeAllNodes(){for(;this.closeNode(););}toJSON(){return JSON.stringify(this.rootNode,null,4)}walk(t){return this.constructor._walk(t,this.rootNode)}static _walk(t,i){return typeof i=="string"?t.addText(i):i.children&&(t.openNode(i),i.children.forEach(c=>this._walk(t,c)),t.closeNode(i)),t}static _collapse(t){typeof t!="string"&&t.children&&(t.children.every(i=>typeof i=="string")?t.children=[t.children.join("")]:t.children.forEach(i=>{ie._collapse(i)}))}}class Ye extends ie{constructor(t){super(),this.options=t}addKeyword(t,i){t!==""&&(this.openNode(i),this.addText(t),this.closeNode())}addText(t){t!==""&&this.add(t)}addSublanguage(t,i){const c=t.root;c.kind=i,c.sublanguage=!0,this.add(c)}toHTML(){return new qe(this,this.options).value()}finalize(){return!0}}function Je(e){return new RegExp(e.replace(/[-/\\^$*+?.()|[\]{}]/g,"\\$&"),"m")}function C(e){return e?typeof e=="string"?e:e.source:null}function Ze(...e){return e.map(i=>C(i)).join("")}function Qe(...e){return"("+e.map(i=>C(i)).join("|")+")"}function et(e){return new RegExp(e.toString()+"|").exec("").length-1}function tt(e,t){const i=e&&e.exec(t);return i&&i.index===0}const nt=/\[(?:[^\\\]]|\\.)*\]|\(\??|\\([1-9][0-9]*)|\\./;function it(e,t="|"){let i=0;return e.map(c=>{i+=1;const E=i;let p=C(c),M="";for(;p.length>0;){const r=nt.exec(p);if(!r){M+=p;break}M+=p.substring(0,r.index),p=p.substring(r.index+r[0].length),r[0][0]==="\\"&&r[1]?M+="\\"+String(Number(r[1])+E):(M+=r[0],r[0]==="("&&i++)}return M}).map(c=>`(${c})`).join(t)}const rt=/\b\B/,Re="[a-zA-Z]\\w*",re="[a-zA-Z_]\\w*",se="\\b\\d+(\\.\\d+)?",xe="(-?)(\\b0[xX][a-fA-F0-9]+|(\\b\\d+(\\.\\d*)?|\\.\\d+)([eE][-+]?\\d+)?)",Me="\\b(0b[01]+)",st="!|!=|!==|%|%=|&|&&|&=|\\*|\\*=|\\+|\\+=|,|-|-=|/=|/|:|;|<<|<<=|<=|<|===|==|=|>>>=|>>=|>=|>>>|>>|>|\\?|\\[|\\{|\\(|\\^|\\^=|\\||\\|=|\\|\\||~",at=(e={})=>{const t=/^#![ ]*\//;return e.binary&&(e.begin=Ze(t,/.*\b/,e.binary,/\b.*/)),L({className:"meta",begin:t,end:/$/,relevance:0,"on:begin":(i,c)=>{i.index!==0&&c.ignoreMatch()}},e)},H={begin:"\\\\[\\s\\S]",relevance:0},lt={className:"string",begin:"'",end:"'",illegal:"\\n",contains:[H]},ct={className:"string",begin:'"',end:'"',illegal:"\\n",contains:[H]},Ne={begin:/\b(a|an|the|are|I'm|isn't|don't|doesn't|won't|but|just|should|pretty|simply|enough|gonna|going|wtf|so|such|will|you|your|they|like|more)\b/},z=function(e,t,i={}){const c=L({className:"comment",begin:e,end:t,contains:[]},i);return c.contains.push(Ne),c.contains.push({className:"doctag",begin:"(?:TODO|FIXME|NOTE|BUG|OPTIMIZE|HACK|XXX):",relevance:0}),c},ot=z("//","$"),ut=z("/\\*","\\*/"),gt=z("#","$"),ft={className:"number",begin:se,relevance:0},ht={className:"number",begin:xe,relevance:0},dt={className:"number",begin:Me,relevance:0},pt={className:"number",begin:se+"(%|em|ex|ch|rem|vw|vh|vmin|vmax|cm|mm|in|pt|pc|px|deg|grad|rad|turn|s|ms|Hz|kHz|dpi|dpcm|dppx)?",relevance:0},Et={begin:/(?=\/[^/\n]*\/)/,contains:[{className:"regexp",begin:/\//,end:/\/[gimuy]*/,illegal:/\n/,contains:[H,{begin:/\[/,end:/\]/,relevance:0,contains:[H]}]}]},bt={className:"title",begin:Re,relevance:0},_t={className:"title",begin:re,relevance:0},Rt={begin:"\\.\\s*"+re,relevance:0},xt=function(e){return Object.assign(e,{"on:begin":(t,i)=>{i.data._beginMatch=t[1]},"on:end":(t,i)=>{i.data._beginMatch!==t[1]&&i.ignoreMatch()}})};var F=Object.freeze({__proto__:null,MATCH_NOTHING_RE:rt,IDENT_RE:Re,UNDERSCORE_IDENT_RE:re,NUMBER_RE:se,C_NUMBER_RE:xe,BINARY_NUMBER_RE:Me,RE_STARTERS_RE:st,SHEBANG:at,BACKSLASH_ESCAPE:H,APOS_STRING_MODE:lt,QUOTE_STRING_MODE:ct,PHRASAL_WORDS_MODE:Ne,COMMENT:z,C_LINE_COMMENT_MODE:ot,C_BLOCK_COMMENT_MODE:ut,HASH_COMMENT_MODE:gt,NUMBER_MODE:ft,C_NUMBER_MODE:ht,BINARY_NUMBER_MODE:dt,CSS_NUMBER_MODE:pt,REGEXP_MODE:Et,TITLE_MODE:bt,UNDERSCORE_TITLE_MODE:_t,METHOD_GUARD:Rt,END_SAME_AS_BEGIN:xt});function Mt(e,t){e.input[e.index-1]==="."&&t.ignoreMatch()}function Nt(e,t){t&&e.beginKeywords&&(e.begin="\\b("+e.beginKeywords.split(" ").join("|")+")(?!\\.)(?=\\b|\\s)",e.__beforeBegin=Mt,e.keywords=e.keywords||e.beginKeywords,delete e.beginKeywords,e.relevance===void 0&&(e.relevance=0))}function wt(e,t){Array.isArray(e.illegal)&&(e.illegal=Qe(...e.illegal))}function Ot(e,t){if(e.match){if(e.begin||e.end)throw new Error("begin & end are not supported with match");e.begin=e.match,delete e.match}}function yt(e,t){e.relevance===void 0&&(e.relevance=1)}const mt=["of","and","for","in","not","or","if","then","parent","list","value"],At="keyword";function we(e,t,i=At){const c={};return typeof e=="string"?E(i,e.split(" ")):Array.isArray(e)?E(i,e):Object.keys(e).forEach(function(p){Object.assign(c,we(e[p],t,p))}),c;function E(p,M){t&&(M=M.map(r=>r.toLowerCase())),M.forEach(function(r){const a=r.split("|");c[a[0]]=[p,vt(a[0],a[1])]})}}function vt(e,t){return t?Number(t):kt(e)?0:1}function kt(e){return mt.includes(e.toLowerCase())}function St(e,{plugins:t}){function i(r,a){return new RegExp(C(r),"m"+(e.case_insensitive?"i":"")+(a?"g":""))}class c{constructor(){this.matchIndexes={},this.regexes=[],this.matchAt=1,this.position=0}addRule(a,u){u.position=this.position++,this.matchIndexes[this.matchAt]=u,this.regexes.push([u,a]),this.matchAt+=et(a)+1}compile(){this.regexes.length===0&&(this.exec=()=>null);const a=this.regexes.map(u=>u[1]);this.matcherRe=i(it(a),!0),this.lastIndex=0}exec(a){this.matcherRe.lastIndex=this.lastIndex;const u=this.matcherRe.exec(a);if(!u)return null;const g=u.findIndex((S,W)=>W>0&&S!==void 0),R=this.matchIndexes[g];return u.splice(0,g),Object.assign(u,R)}}class E{constructor(){this.rules=[],this.multiRegexes=[],this.count=0,this.lastIndex=0,this.regexIndex=0}getMatcher(a){if(this.multiRegexes[a])return this.multiRegexes[a];const u=new c;return this.rules.slice(a).forEach(([g,R])=>u.addRule(g,R)),u.compile(),this.multiRegexes[a]=u,u}resumingScanAtSamePosition(){return this.regexIndex!==0}considerAll(){this.regexIndex=0}addRule(a,u){this.rules.push([a,u]),u.type==="begin"&&this.count++}exec(a){const u=this.getMatcher(this.regexIndex);u.lastIndex=this.lastIndex;let g=u.exec(a);if(this.resumingScanAtSamePosition()&&!(g&&g.index===this.lastIndex)){const R=this.getMatcher(0);R.lastIndex=this.lastIndex+1,g=R.exec(a)}return g&&(this.regexIndex+=g.position+1,this.regexIndex===this.count&&this.considerAll()),g}}function p(r){const a=new E;return r.contains.forEach(u=>a.addRule(u.begin,{rule:u,type:"begin"})),r.terminatorEnd&&a.addRule(r.terminatorEnd,{type:"end"}),r.illegal&&a.addRule(r.illegal,{type:"illegal"}),a}function M(r,a){const u=r;if(r.isCompiled)return u;[Ot].forEach(R=>R(r,a)),e.compilerExtensions.forEach(R=>R(r,a)),r.__beforeBegin=null,[Nt,wt,yt].forEach(R=>R(r,a)),r.isCompiled=!0;let g=null;if(typeof r.keywords=="object"&&(g=r.keywords.$pattern,delete r.keywords.$pattern),r.keywords&&(r.keywords=we(r.keywords,e.case_insensitive)),r.lexemes&&g)throw new Error("ERR: Prefer `keywords.$pattern` to `mode.lexemes`, BOTH are not allowed. (see mode reference) ");return g=g||r.lexemes||/\w+/,u.keywordPatternRe=i(g,!0),a&&(r.begin||(r.begin=/\B|\b/),u.beginRe=i(r.begin),r.endSameAsBegin&&(r.end=r.begin),!r.end&&!r.endsWithParent&&(r.end=/\B|\b/),r.end&&(u.endRe=i(r.end)),u.terminatorEnd=C(r.end)||"",r.endsWithParent&&a.terminatorEnd&&(u.terminatorEnd+=(r.end?"|":"")+a.terminatorEnd)),r.illegal&&(u.illegalRe=i(r.illegal)),r.contains||(r.contains=[]),r.contains=[].concat(...r.contains.map(function(R){return Tt(R==="self"?r:R)})),r.contains.forEach(function(R){M(R,u)}),r.starts&&M(r.starts,a),u.matcher=p(u),u}if(e.compilerExtensions||(e.compilerExtensions=[]),e.contains&&e.contains.includes("self"))throw new Error("ERR: contains `self` is not supported at the top-level of a language.  See documentation.");return e.classNameAliases=L(e.classNameAliases||{}),M(e)}function Oe(e){return e?e.endsWithParent||Oe(e.starts):!1}function Tt(e){return e.variants&&!e.cachedVariants&&(e.cachedVariants=e.variants.map(function(t){return L(e,{variants:null},t)})),e.cachedVariants?e.cachedVariants:Oe(e)?L(e,{starts:e.starts?L(e.starts):null}):Object.isFrozen(e)?L(e):e}var Lt="10.7.3";function Bt(e){return!!(e||e==="")}function It(e){const t={props:["language","code","autodetect"],data:function(){return{detectedLanguage:"",unknownLanguage:!1}},computed:{className(){return this.unknownLanguage?"":"hljs "+this.detectedLanguage},highlighted(){if(!this.autoDetect&&!e.getLanguage(this.language))return console.warn(`The language "${this.language}" you specified could not be found.`),this.unknownLanguage=!0,P(this.code);let c={};return this.autoDetect?(c=e.highlightAuto(this.code),this.detectedLanguage=c.language):(c=e.highlight(this.language,this.code,this.ignoreIllegals),this.detectedLanguage=this.language),c.value},autoDetect(){return!this.language||Bt(this.autodetect)},ignoreIllegals(){return!0}},render(c){return c("pre",{},[c("code",{class:this.className,domProps:{innerHTML:this.highlighted}})])}};return{Component:t,VuePlugin:{install(c){c.component("highlightjs",t)}}}}const Dt={"after:highlightElement":({el:e,result:t,text:i})=>{const c=he(e);if(!c.length)return;const E=document.createElement("div");E.innerHTML=t.value,t.value=Pt(c,he(E),i)}};function te(e){return e.nodeName.toLowerCase()}function he(e){const t=[];return function i(c,E){for(let p=c.firstChild;p;p=p.nextSibling)p.nodeType===3?E+=p.nodeValue.length:p.nodeType===1&&(t.push({event:"start",offset:E,node:p}),E=i(p,E),te(p).match(/br|hr|img|input/)||t.push({event:"stop",offset:E,node:p}));return E}(e,0),t}function Pt(e,t,i){let c=0,E="";const p=[];function M(){return!e.length||!t.length?e.length?e:t:e[0].offset!==t[0].offset?e[0].offset<t[0].offset?e:t:t[0].event==="start"?e:t}function r(g){function R(S){return" "+S.nodeName+'="'+P(S.value)+'"'}E+="<"+te(g)+[].map.call(g.attributes,R).join("")+">"}function a(g){E+="</"+te(g)+">"}function u(g){(g.event==="start"?r:a)(g.node)}for(;e.length||t.length;){let g=M();if(E+=P(i.substring(c,g[0].offset)),c=g[0].offset,g===e){p.reverse().forEach(a);do u(g.splice(0,1)[0]),g=M();while(g===e&&g.length&&g[0].offset===c);p.reverse().forEach(r)}else g[0].event==="start"?p.push(g[0].node):p.pop(),u(g.splice(0,1)[0])}return E+P(i.substr(c))}const de={},Q=e=>{console.error(e)},pe=(e,...t)=>{console.log(`WARN: ${e}`,...t)},y=(e,t)=>{de[`${e}/${t}`]||(console.log(`Deprecated as of ${e}. ${t}`),de[`${e}/${t}`]=!0)},ee=P,Ee=L,be=Symbol("nomatch"),Ct=function(e){const t=Object.create(null),i=Object.create(null),c=[];let E=!0;const p=/(^(<[^>]+>|\t|)+|\n)/gm,M="Could not find the language '{}', did you forget to load/include a language module?",r={disableAutodetect:!0,name:"Plain text",contains:[]};let a={noHighlightRe:/^(no-?highlight)$/i,languageDetectRe:/\blang(?:uage)?-([\w-]+)\b/i,classPrefix:"hljs-",tabReplace:null,useBR:!1,languages:null,__emitter:Ye};function u(n){return a.noHighlightRe.test(n)}function g(n){let s=n.className+" ";s+=n.parentNode?n.parentNode.className:"";const d=a.languageDetectRe.exec(s);if(d){const _=k(d[1]);return _||(pe(M.replace("{}",d[1])),pe("Falling back to no-highlight mode for this block.",n)),_?d[1]:"no-highlight"}return s.split(/\s+/).find(_=>u(_)||k(_))}function R(n,s,d,_){let N="",B="";typeof s=="object"?(N=n,d=s.ignoreIllegals,B=s.language,_=void 0):(y("10.7.0","highlight(lang, code, ...args) has been deprecated."),y("10.7.0",`Please use highlight(code, options) instead.
https://github.com/highlightjs/highlight.js/issues/2277`),B=n,N=s);const m={code:N,language:B};j("before:highlight",m);const A=m.result?m.result:S(m.language,m.code,d,_);return A.code=m.code,j("after:highlight",A),A}function S(n,s,d,_){function N(l,o){const h=I.case_insensitive?o[0].toLowerCase():o[0];return Object.prototype.hasOwnProperty.call(l.keywords,h)&&l.keywords[h]}function B(){if(!f.keywords){w.addText(x);return}let l=0;f.keywordPatternRe.lastIndex=0;let o=f.keywordPatternRe.exec(x),h="";for(;o;){h+=x.substring(l,o.index);const b=N(f,o);if(b){const[O,K]=b;if(w.addText(h),h="",G+=K,O.startsWith("_"))h+=o[0];else{const We=I.classNameAliases[O]||O;w.addKeyword(o[0],We)}}else h+=o[0];l=f.keywordPatternRe.lastIndex,o=f.keywordPatternRe.exec(x)}h+=x.substr(l),w.addText(h)}function m(){if(x==="")return;let l=null;if(typeof f.subLanguage=="string"){if(!t[f.subLanguage]){w.addText(x);return}l=S(f.subLanguage,x,!0,ue[f.subLanguage]),ue[f.subLanguage]=l.top}else l=V(x,f.subLanguage.length?f.subLanguage:null);f.relevance>0&&(G+=l.relevance),w.addSublanguage(l.emitter,l.language)}function A(){f.subLanguage!=null?m():B(),x=""}function v(l){return l.className&&w.openNode(I.classNameAliases[l.className]||l.className),f=Object.create(l,{parent:{value:f}}),f}function T(l,o,h){let b=tt(l.endRe,h);if(b){if(l["on:end"]){const O=new ge(l);l["on:end"](o,O),O.isMatchIgnored&&(b=!1)}if(b){for(;l.endsParent&&l.parent;)l=l.parent;return l}}if(l.endsWithParent)return T(l.parent,o,h)}function $e(l){return f.matcher.regexIndex===0?(x+=l[0],1):(Z=!0,0)}function Ge(l){const o=l[0],h=l.rule,b=new ge(h),O=[h.__beforeBegin,h["on:begin"]];for(const K of O)if(K&&(K(l,b),b.isMatchIgnored))return $e(o);return h&&h.endSameAsBegin&&(h.endRe=Je(o)),h.skip?x+=o:(h.excludeBegin&&(x+=o),A(),!h.returnBegin&&!h.excludeBegin&&(x=o)),v(h),h.returnBegin?0:o.length}function Ke(l){const o=l[0],h=s.substr(l.index),b=T(f,l,h);if(!b)return be;const O=f;O.skip?x+=o:(O.returnEnd||O.excludeEnd||(x+=o),A(),O.excludeEnd&&(x=o));do f.className&&w.closeNode(),!f.skip&&!f.subLanguage&&(G+=f.relevance),f=f.parent;while(f!==b.parent);return b.starts&&(b.endSameAsBegin&&(b.starts.endRe=b.endRe),v(b.starts)),O.returnEnd?0:o.length}function Fe(){const l=[];for(let o=f;o!==I;o=o.parent)o.className&&l.unshift(o.className);l.forEach(o=>w.openNode(o))}let $={};function oe(l,o){const h=o&&o[0];if(x+=l,h==null)return A(),0;if($.type==="begin"&&o.type==="end"&&$.index===o.index&&h===""){if(x+=s.slice(o.index,o.index+1),!E){const b=new Error("0 width match regex");throw b.languageName=n,b.badRule=$.rule,b}return 1}if($=o,o.type==="begin")return Ge(o);if(o.type==="illegal"&&!d){const b=new Error('Illegal lexeme "'+h+'" for mode "'+(f.className||"<unnamed>")+'"');throw b.mode=f,b}else if(o.type==="end"){const b=Ke(o);if(b!==be)return b}if(o.type==="illegal"&&h==="")return 1;if(J>1e5&&J>o.index*3)throw new Error("potential infinite loop, way more iterations than matches");return x+=h,h.length}const I=k(n);if(!I)throw Q(M.replace("{}",n)),new Error('Unknown language: "'+n+'"');const ze=St(I,{plugins:c});let Y="",f=_||ze;const ue={},w=new a.__emitter(a);Fe();let x="",G=0,D=0,J=0,Z=!1;try{for(f.matcher.considerAll();;){J++,Z?Z=!1:f.matcher.considerAll(),f.matcher.lastIndex=D;const l=f.matcher.exec(s);if(!l)break;const o=s.substring(D,l.index),h=oe(o,l);D=l.index+h}return oe(s.substr(D)),w.closeAllNodes(),w.finalize(),Y=w.toHTML(),{relevance:Math.floor(G),value:Y,language:n,illegal:!1,emitter:w,top:f}}catch(l){if(l.message&&l.message.includes("Illegal"))return{illegal:!0,illegalBy:{msg:l.message,context:s.slice(D-100,D+100),mode:l.mode},sofar:Y,relevance:0,value:ee(s),emitter:w};if(E)return{illegal:!1,relevance:0,value:ee(s),emitter:w,language:n,top:f,errorRaised:l};throw l}}function W(n){const s={relevance:0,emitter:new a.__emitter(a),value:ee(n),illegal:!1,top:r};return s.emitter.addText(n),s}function V(n,s){s=s||a.languages||Object.keys(t);const d=W(n),_=s.filter(k).filter(ce).map(v=>S(v,n,!1));_.unshift(d);const N=_.sort((v,T)=>{if(v.relevance!==T.relevance)return T.relevance-v.relevance;if(v.language&&T.language){if(k(v.language).supersetOf===T.language)return 1;if(k(T.language).supersetOf===v.language)return-1}return 0}),[B,m]=N,A=B;return A.second_best=m,A}function ye(n){return a.tabReplace||a.useBR?n.replace(p,s=>s===`
`?a.useBR?"<br>":s:a.tabReplace?s.replace(/\t/g,a.tabReplace):s):n}function me(n,s,d){const _=s?i[s]:d;n.classList.add("hljs"),_&&n.classList.add(_)}const Ae={"before:highlightElement":({el:n})=>{a.useBR&&(n.innerHTML=n.innerHTML.replace(/\n/g,"").replace(/<br[ /]*>/g,`
`))},"after:highlightElement":({result:n})=>{a.useBR&&(n.value=n.value.replace(/\n/g,"<br>"))}},ve=/^(<[^>]+>|\t)+/gm,ke={"after:highlightElement":({result:n})=>{a.tabReplace&&(n.value=n.value.replace(ve,s=>s.replace(/\t/g,a.tabReplace)))}};function U(n){let s=null;const d=g(n);if(u(d))return;j("before:highlightElement",{el:n,language:d}),s=n;const _=s.textContent,N=d?R(_,{language:d,ignoreIllegals:!0}):V(_);j("after:highlightElement",{el:n,result:N,text:_}),n.innerHTML=N.value,me(n,d,N.language),n.result={language:N.language,re:N.relevance,relavance:N.relevance},N.second_best&&(n.second_best={language:N.second_best.language,re:N.second_best.relevance,relavance:N.second_best.relevance})}function Se(n){n.useBR&&(y("10.3.0","'useBR' will be removed entirely in v11.0"),y("10.3.0","Please see https://github.com/highlightjs/highlight.js/issues/2559")),a=Ee(a,n)}const X=()=>{if(X.called)return;X.called=!0,y("10.6.0","initHighlighting() is deprecated.  Use highlightAll() instead."),document.querySelectorAll("pre code").forEach(U)};function Te(){y("10.6.0","initHighlightingOnLoad() is deprecated.  Use highlightAll() instead."),q=!0}let q=!1;function ae(){if(document.readyState==="loading"){q=!0;return}document.querySelectorAll("pre code").forEach(U)}function Le(){q&&ae()}typeof window<"u"&&window.addEventListener&&window.addEventListener("DOMContentLoaded",Le,!1);function Be(n,s){let d=null;try{d=s(e)}catch(_){if(Q("Language definition for '{}' could not be registered.".replace("{}",n)),E)Q(_);else throw _;d=r}d.name||(d.name=n),t[n]=d,d.rawDefinition=s.bind(null,e),d.aliases&&le(d.aliases,{languageName:n})}function Ie(n){delete t[n];for(const s of Object.keys(i))i[s]===n&&delete i[s]}function De(){return Object.keys(t)}function Pe(n){y("10.4.0","requireLanguage will be removed entirely in v11."),y("10.4.0","Please see https://github.com/highlightjs/highlight.js/pull/2844");const s=k(n);if(s)return s;throw new Error("The '{}' language is required, but not loaded.".replace("{}",n))}function k(n){return n=(n||"").toLowerCase(),t[n]||t[i[n]]}function le(n,{languageName:s}){typeof n=="string"&&(n=[n]),n.forEach(d=>{i[d.toLowerCase()]=s})}function ce(n){const s=k(n);return s&&!s.disableAutodetect}function Ce(n){n["before:highlightBlock"]&&!n["before:highlightElement"]&&(n["before:highlightElement"]=s=>{n["before:highlightBlock"](Object.assign({block:s.el},s))}),n["after:highlightBlock"]&&!n["after:highlightElement"]&&(n["after:highlightElement"]=s=>{n["after:highlightBlock"](Object.assign({block:s.el},s))})}function He(n){Ce(n),c.push(n)}function j(n,s){const d=n;c.forEach(function(_){_[d]&&_[d](s)})}function Ue(n){return y("10.2.0","fixMarkup will be removed entirely in v11.0"),y("10.2.0","Please see https://github.com/highlightjs/highlight.js/issues/2534"),ye(n)}function je(n){return y("10.7.0","highlightBlock will be removed entirely in v12.0"),y("10.7.0","Please use highlightElement now."),U(n)}Object.assign(e,{highlight:R,highlightAuto:V,highlightAll:ae,fixMarkup:Ue,highlightElement:U,highlightBlock:je,configure:Se,initHighlighting:X,initHighlightingOnLoad:Te,registerLanguage:Be,unregisterLanguage:Ie,listLanguages:De,getLanguage:k,registerAliases:le,requireLanguage:Pe,autoDetection:ce,inherit:Ee,addPlugin:He,vuePlugin:It(e).VuePlugin}),e.debugMode=function(){E=!1},e.safeMode=function(){E=!0},e.versionString=Lt;for(const n in F)typeof F[n]=="object"&&_e(F[n]);return Object.assign(e,F),e.addPlugin(Ae),e.addPlugin(Dt),e.addPlugin(ke),e};Ct({});
