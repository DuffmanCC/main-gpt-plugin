import{d as W,r as n,o,c as x,a as e,b as P,w as U,e as q,t as z,F as G,f as K,g as ge,v as he,h as O,n as H,i as se,j as oe,k as T,l as le,m as J,u as xe,p as _e,q as be,s as $e}from"./wug-style.js";import{m as ue,_ as re}from"./metabox-body.js";import{a as ke,_ as de,b as we,c as me}from"./a-text.vue_vue_type_script_setup_true_lang.js";import{_ as ae,c as Pe,a as te,u as Ce,g as ie,t as Ie,e as Me,b as Te}from"./a-select.vue_vue_type_script_setup_true_lang.js";import{p as Se}from"./constants.js";import{a as I,e as Y}from"./tools.js";const De={class:"tw:flex tw:gap-6 tw:items-center"},Ae=["name","value","aria-describedby","disabled"],Oe=["id","innerHTML"],Ue=W({__name:"a-radio-button",props:{options:{type:Array,default:()=>[{label:"",value:""}],required:!0},selectedOption:{type:[String,Number],default:"",required:!0},label:{type:String,default:""},classes:{type:String,default:""},help:{type:String,default:""},id:{type:String,default:""},disabled:{type:Boolean,default:!1}},emits:["select-option"],setup(p,{emit:k}){const y=p,C=k,r=n(y.selectedOption);function u(_){const i=_.target.value;r.value=i,C("select-option",i)}const c=`tw:flex tw:flex-col tw:gap-2 ${y.classes}`;return(_,v)=>(o(),x("fieldset",{class:H([c,"tw:disabled:cursor-not-allowed"])},[e("legend",null,[P(ke,null,{default:U(()=>[q(z(p.label),1)]),_:1})]),e("div",De,[(o(!0),x(G,null,K(p.options,i=>(o(),x("label",{key:i.value,class:"tw:flex tw:items-center tw:gap-2"},[ge(e("input",{type:"radio",name:p.id,value:i.value,"onUpdate:modelValue":v[0]||(v[0]=m=>r.value=m),onChange:v[1]||(v[1]=m=>u(m)),"aria-describedby":`${p.id}_help`,disabled:p.disabled,class:"tw:top-0.5 tw:relative"},null,40,Ae),[[he,r.value]]),q(" "+z(i.label),1)]))),128))]),p.help?(o(),x("div",{key:0,id:`${p.id}_help`,class:"tw:font-light tw:text-brand-gray-dark tw:text-sm tw:max-w-xl",innerHTML:p.help},null,8,Oe)):O("",!0)]))}}),je={class:"tw:flex tw:flex-col tw:gap-2"},Ve={class:"tw:flex tw:gap-8 tw:items-start tw:mb-4"},Re={class:"tw:flex tw:flex-col tw:gap-4 tw:w-1/4"},Ee=e("p",{class:"tw:font-light tw:text-brand-gray-dark tw:text-sm tw:max-w-xl"},[q(" More info "),e("a",{href:"https://www.pinecone.io/learn/vector-similarity/",class:"tw:text-blue-500 tw:hover:text-blue-700 tw:underline",target:"_blank"},"Vector Similarity Explained")],-1),Ne=W({__name:"ai-memory-create",emits:["createPineconIndexSuccess","createPineconIndexError"],setup(p,{emit:k}){const y=se("aiMemoryData");if(!y)throw new Error("aiMemoryData is undefined");const{ajaxActionConnectOrCreateIndex:C,ajaxUrl:r,nonceConnectOrCreateIndex:u,postId:c,aiMemory:_}=y,v=k,i=n([]),m=n(""),S=n(_.metric),M=async()=>{try{const b=await Pe(r,C,u,m.value,JSON.stringify(j.value),c);v("createPineconIndexSuccess",b.indexName),I(i,"success",`${b.message}: ${b.indexName}`)}catch(b){const f=Y(b);I(i,"error",f,0),v("createPineconIndexError","error")}finally{m.value=""}},j=oe(()=>({metric:S.value})),V=oe(()=>Se.map(b=>({value:b,label:b})));function B(b){i.value=i.value.filter(f=>f.id!==b)}return(b,f)=>(o(),T(ue,null,{default:U(()=>[P(we,{class:"tw:top-2"},{default:U(()=>[(o(!0),x(G,null,K(i.value,g=>(o(),T(de,{key:g.id,type:g.type,message:g.message,time:g.time,onClose:Q=>B(g.id)},null,8,["type","message","time","onClose"]))),128))]),_:1}),e("div",je,[e("div",Ve,[P(me,{id:"index_name",label:"Index name",help:"Index name must consist of lower case alphanumeric characters or '-', and must start and end with an alphanumeric character.",modelValue:m.value,"onUpdate:modelValue":f[0]||(f[0]=g=>m.value=g),value:m.value,onEnter:M,onInput:f[1]||(f[1]=g=>m.value=g)},null,8,["modelValue","value"]),P(ae,{onClick:M,disabled:!m.value,class:"tw:relative tw:top-8"},{default:U(()=>[q("Create")]),_:1},8,["disabled"])]),e("div",Re,[P(Ue,{id:"metric",label:"Metric",options:V.value,selectedOption:S.value,onSelectOption:f[2]||(f[2]=g=>S.value=g),help:"The distance metric to be used for similarity search. You can use 'euclidean', 'cosine', or 'dotproduct'."},null,8,["options","selectedOption"]),Ee])])]),_:1}))}}),ze={class:"tw:inline-flex tw:items-center tw:justify-center tw:overflow-hidden tw:rounded-full"},Be={class:"tw:w-20 tw:h-20"},Le=e("circle",{class:"tw:text-gray-200","stroke-width":"5",stroke:"currentColor",fill:"transparent",r:"30",cx:"40",cy:"40"},null,-1),Fe=["stroke-dashoffset"],He={class:"tw:absolute tw:text-xs tw:text-blue-700"},ce=W({__name:"a-progress",props:{percent:{type:Number,default:50}},setup(p){const k=2*Math.PI*30;return(y,C)=>(o(),x("div",ze,[(o(),x("svg",Be,[Le,e("circle",{class:"tw:text-blue-500","stroke-width":"5","stroke-dasharray":k,"stroke-dashoffset":k-p.percent/100*k,"stroke-linecap":"round",stroke:"currentColor",fill:"transparent",r:"30",cx:"40",cy:"40"},null,8,Fe)])),e("span",He,z(p.percent)+"%",1)]))}}),qe={class:"tw:grid tw:grid-cols-1 tw:@xl:grid-cols-2 tw:gap-4"},We={class:"tw:flex tw:flex-col gap-2 tw:w-full"},Ye={class:"tw:grid tw:grid-cols-3 tw:gap-4"},Je={class:"tw:rounded-md tw:h-72 tw:overflow-y-auto tw:border tw:border-gray-300 tw:shadow"},Ge={id:"select-posts"},Ke={class:"tw:px-2 tw:py-1 tw:font-bold"},Qe=["onClick","innerHTML"],Xe={class:"tw:rounded-md tw:h-72 tw:overflow-y-auto tw:border tw:border-gray-300 tw:shadow"},Ze={id:"selected-posts"},et=["innerHTML"],tt=["onClick"],at=e("div",{class:"tw:relative tw:w-8 tw:bottom-0.5"},"-",-1),st=[at],nt=W({__name:"a-relationship",props:{selectedPostsDefault:{type:Array,default:()=>[]},restUrl:String},emits:["add-post","remove-post"],setup(p,{emit:k}){const y=p,C=k,r=n(""),u=n("posts"),c=n(""),_=n(""),v=n([]),i=n(y.selectedPostsDefault),m=n(1),S=n([]),M=n([]),j=n(!1),V=n(null),B=[{value:"posts",label:"Posts"},{value:"pages",label:"Pages"},{value:"product",label:"Products"}];function b(t){g(t)||(i.value=[t,...i.value],C("add-post",t))}function f(t){i.value=i.value.filter(l=>l.id!==t.id),C("remove-post",{id:t.id})}function g(t){return i.value.find(l=>l.id===t.id)}function Q(t){return t==="product"?"Products":t==="pages"?"Pages":"Posts"}function Z(t){return t==="product"?"product":t==="pages"?"page":"post"}async function $({type:t="posts",perPage:l=10,page:a=1,taxonomy:d="",term:h="",search:L=""}){j.value=!0;let F=`${y.restUrl}${t}?page=${a}&per_page=${l}&search=${L}`;d&&h&&(F+=`&${d}=${h}`);try{const ee=(await(await fetch(F)).json()).map(X=>({id:X.id,title:X.title.rendered}));v.value=[...v.value,...ee],m.value++}catch(D){console.error(D)}finally{j.value=!1}}function R(t){return t==="category"?"categories":t==="post_tag"?"tags":t}async function E(t){let l=[],a=1;const d=R(t);for(;a<3;)try{const L=await(await fetch(`${y.restUrl}${d}?per_page=100&page=${a}`)).json();if(L.length===0)break;const F=L.filter(D=>D.count>0);l=[...l,...F.map(D=>({value:D.id,label:D.name}))],a++}catch(h){console.error(h)}M.value=l,console.log("🚀 ~ getTermsByTaxonomy ~ terms.value:",M.value)}async function N(t){const l=Z(t);try{const d=await(await fetch(`${y.restUrl}types/${l}`)).json();S.value=d.taxonomies.map(h=>({label:h,value:h}))}catch(a){console.error(a)}}return le(()=>{$({}),N(u.value)}),le(()=>{const t=new IntersectionObserver(l=>{l[0].isIntersecting&&!j.value&&$({type:u.value,perPage:10,page:m.value,taxonomy:c.value,term:_.value})});V.value&&t.observe(V.value)}),J([r,u,c,_],()=>{v.value=[],m.value=1,$({type:u.value,perPage:10,page:m.value,taxonomy:c.value,term:_.value,search:r.value})}),J(c,()=>{c.value&&(M.value=[],E(c.value))}),J(u,()=>{_.value="",c.value="",u.value&&N(u.value)}),(t,l)=>(o(),x("div",qe,[e("label",We,[P(me,{label:"Search",type:"text",onInput:l[0]||(l[0]=a=>r.value=a)})]),e("div",Ye,[P(te,{id:"post-type",options:B,label:"Post type",selectedOption:u.value,onSelectOption:l[1]||(l[1]=a=>u.value=a),disabled:u.value===""||B.length===0},null,8,["selectedOption","disabled"]),P(te,{id:"taxonomy",options:S.value,label:"Taxonomy",selectedOption:c.value,onSelectOption:l[2]||(l[2]=a=>c.value=a),disabled:u.value===""||S.value.length===0},null,8,["options","selectedOption","disabled"]),P(te,{id:"term",options:M.value,label:"Term",selectedOption:_.value,onSelectOption:l[3]||(l[3]=a=>_.value=a),disabled:c.value===""||M.value.length===0},null,8,["options","selectedOption","disabled"])]),e("div",Je,[e("ul",Ge,[e("li",null,[e("div",Ke,z(Q(u.value)),1),e("ul",null,[(o(!0),x(G,null,K(v.value,a=>(o(),x("li",{key:a.id,onClick:d=>b(a),class:H(["tw:pl-6 tw:pr-2 tw:py-1 tw:m-0",g(a)?"tw:text-gray-400 tw:cursor-default ":"tw:cursor-pointer tw:text-gray-700 tw:hover:bg-blue-400 tw:hover:text-white tw:font-normal"]),innerHTML:a.title},null,10,Qe))),128)),e("li",{ref_key:"sentinel",ref:V,class:"sentinel"},null,512)])])])]),e("div",Xe,[e("ul",Ze,[(o(!0),x(G,null,K(i.value,a=>(o(),x("li",{key:a.id,class:"tw:px-2 tw:py-1 tw:m-0 tw:flex tw:justify-between tw:items-start tw:hover:bg-blue-400 tw:hover:text-white tw:group"},[e("div",{innerHTML:a.title},null,8,et),e("button",{onClick:d=>f(a),class:"tw:hidden tw:group-hover:flex tw:w-5 tw:h-5 tw:justify-center tw:items-center tw:rounded-full tw:bg-gray-700 tw:text-white tw:hover:bg-red-600"},st,8,tt)]))),128))])])]))}}),ot=e("p",{class:"tw:text-lg! tw:m-0!"}," Search and Add WordPress posts to train this memory. ",-1),lt={class:"tw:flex tw:flex-col tw:gap-4"},rt=e("p",{class:"tw:text-lg! tw:m-0!"},"Create content from PDFs",-1),it={class:"tw:flex tw:gap-2 tw:flex-wrap tw:max-w-[40rem]"},ct={class:"tw:flex tw:grow tw:font-semibold"},ut=e("div",{class:"tw:w-36 tw:bg-gray-500 tw:text-white tw:text-center tw:py-3 tw:rounded-l-lg tw:text-sm tw:transition-all tw:duration-300 tw:shadow-button tw:no-underline tw:cursor-pointer tw:hover:bg-gray-600"}," Choose a file: ",-1),dt={class:"tw:w-full tw:border tw:border-gray-500 tw:bg-white tw:rounded-r-lg"},wt={class:"tw:flex tw:items-center tw:h-full tw:pl-4"},mt={class:"tw:text-lg! tw:m-0! tw:font-normal"},pt={class:"tw:flex tw:items-center tw:justify-end tw:gap-4"},vt={key:0,class:"tw:text-lg! tw:m-0!"},ft={key:1,class:"tw:text-lg! tw:m-0!"},yt=W({__name:"ai-memory-train",props:{indexMemory:String},emits:["upsertedVectorSuccess"],setup(p,{emit:k}){const y=se("aiMemoryData");if(!y)throw new Error("aiMemoryData is undefined");const{restUrl:C,ajaxUrl:r,ajaxActionTokenizePosts:u,ajaxActionEmbedData:c,ajaxActionEmbeddingPercentage:_,ajaxActionTokenizingPercentage:v,ajaxUpsertVector:i,ajaxActionUploadFile:m,nonceTokenizePosts:S,nonceEmbedData:M,nonceEmbeddingPercentage:j,nonceTokenizingPercentage:V,nonceUpsertVector:B,nonceUploadFile:b,postId:f,addedPosts:g}=y,Q=p,Z=k,$=n(Array.isArray(g)?g:[]),R=n(!1),E=n(!1),N=n(0),t=n(0),l=n(""),a=n(null),d=n([]),h=n("");async function L(){if($.value.length!==0){R.value=!0,t.value=0;try{h.value="tokenizing posts...";const s=await Ie(r,u,S,f,$.value);I(d,"success",s.message,0),R.value=!1}catch(s){const w=Y(s);I(d,"error",w,0),R.value=!1}}}async function F(){E.value=!0,N.value=0;try{h.value="embedding data...";const s=await Me(r,c,M,f);I(d,"success",s.message,0),E.value=!1}catch(s){const w=Y(s);I(d,"error",w,0),E.value=!1}}async function D(){try{h.value="upserting vectors to the database...";const s=await Te(r,i,B,Q.indexMemory,f);I(d,"success",s.message,0),Z("upsertedVectorSuccess","trained"),h.value="memory trained"}catch(s){const w=Y(s);I(d,"error",w,0)}}async function ne(){d.value=[],await L(),await F(),await D()}function ee(s){const w=s.target;l.value=w.value.split("\\").pop()||"",w.files&&(a.value=w.files[0])}async function X(){if(!a.value){I(d,"warning","no file selected",0);return}try{const s=await Ce(r,m,b,a.value);I(d,"success",s.message,0)}catch(s){const w=Y(s);I(d,"error",w,0)}}function ve(s){$.value=[...$.value,s]}function fe(s){$.value=$.value.filter(w=>w.id!==s.id)}function ye(s){d.value=d.value.filter(w=>w.id!==s)}return J(()=>R.value,s=>{if(!s)return;const w=setInterval(async()=>{if(t.value===100){R.value=!1,clearInterval(w);return}try{const A=await ie(r,v,V,f);t.value=parseInt(A.progress)}catch{clearInterval(w);return}},1e3)}),J(()=>E.value,s=>{if(!s)return;const w=setInterval(async()=>{if(N.value===100){E.value=!1,clearInterval(w);return}try{const A=await ie(r,_,j,f);N.value=parseInt(A.progress)}catch{clearInterval(w);return}},1e3)}),(s,w)=>(o(),T(ue,null,{default:U(()=>[P(we,{class:"tw:top-2"},{default:U(()=>[(o(!0),x(G,null,K(d.value,A=>(o(),T(de,{key:A.id,type:A.type,message:A.message,time:A.time,onClose:_t=>ye(A.id)},null,8,["type","message","time","onClose"]))),128))]),_:1}),ot,e("div",lt,[rt,e("div",it,[e("label",ct,[ut,e("div",dt,[e("div",wt,z(l.value),1)]),e("input",{class:"tw:hidden",id:"from_pdf",name:"file",type:"file",onChange:ee},null,32)]),P(ae,{onClick:X},{default:U(()=>[q("Upload")]),_:1})])]),P(nt,{onAddPost:ve,onRemovePost:fe,selectedPostsDefault:$.value,restUrl:xe(C)},null,8,["selectedPostsDefault","restUrl"]),e("p",mt," You have selected "+z($.value.length===1?"1 post.":`${$.value.length} posts.`),1),e("div",pt,[h.value!=="memory trained"?(o(),x("p",vt," It takes some time, be patient ")):O("",!0),$.value.length!==0?(o(),x("p",ft,z(h.value),1)):O("",!0),h.value==="tokenizing posts..."?(o(),T(ce,{key:2,percent:t.value},null,8,["percent"])):O("",!0),h.value==="embedding data..."?(o(),T(ce,{key:3,percent:N.value},null,8,["percent"])):O("",!0),P(ae,{onClick:ne,disabled:$.value.length===0},{default:U(()=>[q("Start training memory")]),_:1},8,["disabled"])])]),_:1}))}}),gt={class:"tw:font-arboria"},ht=W({__name:"ai-memory",setup(p){const k=se("aiMemoryData");if(!k)throw new Error("aiMemoryData is undefined");const{indexName:y,indexStatus:C}=k,r=n(y!=="undefined"?y:""),u=n(C),c=n(!1);function _(v){setTimeout(()=>{r.value=v,u.value="connected"},3e3),setTimeout(()=>{c.value=!0},2500),setTimeout(()=>{c.value=!1},3e3)}return(v,i)=>(o(),x("div",gt,[r.value?O("",!0):(o(),T(re,{key:0,class:H(["tw:transition tw:duration-500",c.value?"tw:opacity-0":"tw:opacity-100"]),title:"Create Pinecone Index",hasAdvanced:!1},null,8,["class"])),r.value?(o(),T(re,{key:1,class:H(["tw:transition tw:duration-500",c.value?"tw:opacity-0":"tw:opacity-100"]),title:r.value,status:u.value},null,8,["class","title","status"])):O("",!0),r.value?O("",!0):(o(),T(Ne,{key:2,class:H(["tw:transition tw:duration-500",c.value?"tw:opacity-0":"tw:opacity-100"]),onCreatePineconIndexSuccess:_},null,8,["class"])),r.value?(o(),T(yt,{key:3,class:H(["tw:transition tw:duration-500",c.value?"tw:opacity-0":"tw:opacity-100"]),indexMemory:r.value,onUpsertedVectorSuccess:i[0]||(i[0]=m=>u.value=m)},null,8,["class","indexMemory"])):O("",!0)]))}});let pe={};pe=window.ai_memory.data;const xt=_e({setup(){$e("aiMemoryData",pe)},render:()=>be(ht)});xt.mount("#main_ai_memory");
