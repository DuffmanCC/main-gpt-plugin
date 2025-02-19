import{d as $,r as u,l as at,o as s,c,z as X,n as U,a as d,t as L,h as y,b as O,w as V,e as P,y as nt,i as D,k as _,f as W,u as h,F as N,_ as K,g as st,D as ht,E as ft,G as gt,s as H,m as Y,j as tt,H as xt,p as vt,q as bt}from"./wug-style.js";import{e as ot}from"./tools.js";function it(t,a){for(let e=0;e<t.length;e++)if(!a.includes(t[e]))return!1;return!0}function rt(t){return t.filter(a=>a.isMandatory).map(a=>a.id)}function _t(t){return/^[a-zA-Z0-9._+-]+@[a-zA-Z0-9_+-]+\.[a-zA-Z]{2,}$/.test(t)}const J=$({__name:"chat-alert",props:{type:{type:String,default:"info"},timeout:{type:Number,default:0}},setup(t){const a=t,e=u(!0);return at(()=>{a.timeout!==0&&setTimeout(()=>{e.value=!1},a.timeout)}),(o,n)=>(s(),c("div",{class:U(["tw-border-l-4 tw-p-2 tw-rounded tw-bg-white tw-border tw-text-base",{"tw-border-blue-500 ":t.type==="info","tw-border-orange-500 ":t.type==="warning","tw-border-green-500 ":t.type==="success","tw-border-red-500 ":t.type==="error","tw-hidden":!e.value}]),role:"alert"},[X(o.$slots,"default")],2))}}),Ct={class:"tw-flex tw-gap-2 tw-text-black tw-text-sm tw-items-center tw-relative"},yt=["id","name"],$t=d("svg",{class:"tw-absolute tw-w-4 tw-h-4 tw-hidden peer-checked:tw-block",xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",fill:"none",stroke:"currentColor","stroke-width":"2","stroke-linecap":"round","stroke-linejoin":"round"},[d("polyline",{points:"20 6 9 17 4 12"})],-1),kt={href:"#",className:"tw-underline"},lt=$({__name:"chat-checkbox",props:{id:String,name:String,isMandatory:Boolean},emits:["accepted-campaign","update:modal-id-opened"],setup(t,{emit:a}){const e=a;return(o,n)=>(s(),c("label",Ct,[d("input",{id:`campaign-${t.id}`,name:`campaign-${t.id}`,type:"checkbox",onChange:n[0]||(n[0]=i=>e("accepted-campaign",t.id)),class:"!tw-appearance-none tw-peer before:!tw-hidden !tw-w-4 !tw-h-4 !tw-border !tw-border-black !tw-rounded-none !tw-bg-white"},null,40,yt),$t,d("div",{class:"tw-flex tw-gap-2",onClick:n[1]||(n[1]=i=>e("update:modal-id-opened",t.id))},[d("a",kt,L(t.name),1)]),d("span",{class:U({"tw-text-red-500 tw-text-xs":t.isMandatory,"tw-hidden":!t.isMandatory})}," (mandatory) ",2)]))}}),At=["disabled"],ct=$({__name:"chat-button",props:{disabled:Boolean},emits:["click"],setup(t,{emit:a}){const e=a;return(o,n)=>(s(),c("button",{class:"tw-text-sm tw-uppercase tw-px-4 tw-py-3 tw-rounded-xl tw-text-white tw-transition-all tw-duration-300 tw-shadow-button tw-bg-blue-500 hover:tw-bg-blue-600 active:tw-bg-blue-700 tw-no-underline disabled:tw-opacity-50 disabled:tw-cursor-not-allowed",onClick:n[0]||(n[0]=i=>e("click")),disabled:t.disabled},[X(o.$slots,"default")],8,At))}}),Mt=["id","name"],Ft={key:0,className:"tw-text-xl"},It={className:"tw-flex tw-justify-end"},dt=$({__name:"chat-form",props:{title:String,disabled:Boolean,accept:Function,id:String},emits:["submit"],setup(t,{emit:a}){const e=a;return(o,n)=>(s(),c("form",{id:t.id,name:t.id,className:"tw-flex tw-flex-col tw-gap-2 tw-text-black",onSubmit:n[0]||(n[0]=nt(i=>e("submit"),["prevent"]))},[t.title?(s(),c("div",Ft,L(t.title),1)):y("",!0),X(o.$slots,"default"),d("div",It,[O(ct,{disabled:t.disabled,type:"submit"},{default:V(()=>[P("Accept")]),_:1},8,["disabled"])])],40,Mt))}}),Et={className:"tw-flex tw-flex-col tw-gap-1"},St=$({__name:"chat-ai-chat-form",emits:["form-accepted"],setup(t,{emit:a}){const e=D("setModalIdOpen"),o=D("chatGptData");if(!o)throw new Error("chatGptData is undefined");const{aiChatCampaigns:n}=o,i=u([]),r=u(!1),l=a;function w(I){const b=i.value.indexOf(I);b===-1?i.value=[...i.value,I]:i.value.splice(b,1),it(rt(n),i.value.map(E=>E.toString()))?r.value=!0:r.value=!1}function m(){l("form-accepted",i.value)}return(I,b)=>(s(),_(J,{type:"info"},{default:V(()=>[O(dt,{id:"ai-chat-campaigns-form",title:"Ai Chat Campaigns",disabled:!r.value,onSubmit:m},{default:V(()=>[d("div",Et,[(s(!0),c(N,null,W(h(n),C=>(s(),_(lt,{key:C.id,id:C.id,name:C.name,isMandatory:C.isMandatory,onAcceptedCampaign:w,"onUpdate:modalIdOpened":h(e)},null,8,["id","name","isMandatory","onUpdate:modalIdOpened"]))),128))])]),_:1},8,["disabled"])]),_:1}))}}),Bt=async({ajaxUrl:t,action:a,queryField:e,aiChatterId:o,message:n,aiChatId:i,nonce:r,onMessageChunk:l})=>{const w=new FormData;w.append("action",a),w.append(`data[${e}]`,n),w.append("data[aiChatterId]",o),w.append("security",r),i&&w.append("data[aiChatId]",i.toString());try{const m=await fetch(t,{method:"POST",body:w});if(!m.body)throw new Error("No se pudo leer el cuerpo de la respuesta.");const I=m.body.getReader(),b=new TextDecoder;let C="";for(;;){const{done:E,value:S}=await I.read();if(E)break;const k=b.decode(S,{stream:!0});l(k)}return C}catch(m){throw console.error("Error en la petición:",m),m}},Dt=({ajaxUrl:t,action:a,nonce:e,aiChatCampaigns:o,campaignIds:n})=>{const i=new FormData;return i.append("action",a),i.append(`data[${o}][]`,n.join(",")),i.append("security",e),fetch(t,{method:"POST",body:i}).then(r=>r.ok?r.json():r.text().then(l=>{throw new Error(l)})).catch(r=>{throw r})},Lt=({ajaxUrl:t,action:a,nonce:e,msg:o,aiChatId:n,role:i})=>{const r=new FormData;return r.append("action",a),r.append("data[aiChatMessage]",JSON.stringify({role:i,content:o})),r.append("data[aiChatId]",(n==null?void 0:n.toString())??""),r.append("security",e),fetch(t,{method:"POST",body:r}).then(l=>l.ok?l.json():l.text().then(w=>{throw new Error(w)})).catch(l=>{throw l})},Ot=({ajaxUrl:t,action:a,nonce:e,fields:o,campaignIds:n,aiChatterId:i,aiChatId:r})=>{const l=new FormData;return l.append("action",a),l.append("security",e),l.append("data[fields]",o),l.append("data[campaignIds]",n.join(",")),l.append("data[aiChatterId]",i),l.append("data[aiChatId]",r),fetch(t,{method:"POST",body:l}).then(w=>w.ok?w.json():w.text().then(m=>{throw new Error(m)})).catch(w=>{throw w})},jt={class:"tw-flex tw-flex-col tw-gap-1 tw-relative tw-pb-4 tw-text-base"},qt={class:"tw-flex tw-gap-2 tw-items-center"},Tt={key:0,class:"tw-text-red-500 tw-text-xs"},zt=["type","name","id","aria-errormessage"],Vt={key:0,id:"`${id}-error`",class:"tw-text-red-500 tw-text-xs tw-absolute tw-bottom-0"},Gt=$({__name:"chat-input-field",props:{label:String,type:String,id:String,required:Boolean,handleFilledField:Function},setup(t){const a=t,{handleFilledField:e,id:o,required:n}=a,i=u(""),r=u(null);function l(m){const b=m.target.value.trim();i.value=b,w(b)}function w(m){return!m&&n?(r.value="This fields is required",e(o,""),!0):o==="email"&&!_t(m)?(r.value="Please enter a valid email address",e(o,""),!0):(r.value=null,e(o,m),!1)}return(m,I)=>(s(),c("label",jt,[d("div",qt,[P(L(t.label)+" ",1),h(n)?(s(),c("span",Tt,"(required)")):y("",!0)]),d("input",{type:t.type,name:h(o),id:h(o),class:"tw-border tw-border-gray-300 tw-rounded tw-px-2 tw-py-1",onInput:l,"aria-errormessage":`${h(o)}-error`},null,40,zt),r.value?(s(),c("div",Vt,L(r.value),1)):y("",!0)]))}}),Ht={class:"tw-flex tw-flex-col tw-gap-1 tw-relative tw-pb-4 tw-text-base"},Nt={class:"tw-flex tw-gap-2 tw-items-center"},Ut={key:0,class:"tw-text-red-500 tw-text-xs"},Qt=["name","id","aria-errormessage"],Pt=["id"],Rt=$({__name:"chat-textarea-field",props:{label:String,id:String,required:Boolean,handleFilledField:Function},setup(t){const a=t,e=u(""),o=u(null);function n(r){r.preventDefault();const l=r.target;e.value=l.value}function i(){if(!e.value&&a.required){o.value="This fields is required";return}e.value&&(a.handleFilledField(a.id,e.value),o.value=null)}return(r,l)=>(s(),c("label",Ht,[d("div",Nt,[P(L(t.label)+" ",1),t.required?(s(),c("span",Ut,"(required)")):y("",!0)]),d("textarea",{name:t.id,id:t.id,class:"tw-border tw-border-gray-300 tw-rounded tw-px-2 tw-py-1 tw-min-h-[100px]",onChange:n,onBlur:i,"aria-errormessage":`${t.id}-error`},null,40,Qt),d("div",{id:`${t.id}-error`,class:"tw-text-red-500 tw-text-xs tw-absolute tw-bottom-0"},L(o.value),9,Pt)]))}}),Zt={key:1,className:"tw-flex tw-flex-col tw-gap-1"},Jt=$({__name:"chat-ai-contact-form",setup(t){const a=D("chatGptData");if(!a)throw new Error("Missing dependencies");const e=D("setModalIdOpen"),o=D("setAllowChatInput"),n=D("aiChatId"),i=D("setIsAcceptedAiContactForm"),r=D("setErrorMessage"),{aiContactCampaigns:l,formFields:w,ajaxUrl:m,ajaxActionCreateAiContact:I,nonceAiContact:b,aiChatterId:C,allowAiContactCampaigns:E,afterFormMessageError:S}=a,k=u([]),A=u(!1),B=u(!1),f=u(null),g=u({name:"",email:"",phone:"",message:""});function j(x){const G=k.value.indexOf(x);G===-1?k.value=[...k.value,x]:k.value.splice(G,1),it(rt(l),k.value.map(z=>z.toString()))?B.value=!0:B.value=!1}function q(x,G){g.value={...g.value,[x]:G},w.filter(z=>z.required&&z.active).every(z=>g.value[z.label.toLowerCase()])?A.value=!0:A.value=!1}async function Q(){if(n)try{const x=await Ot({ajaxUrl:m,action:I,nonce:b,fields:JSON.stringify(g),campaignIds:k.value,aiChatterId:C,aiChatId:n});f.value=x,i(!0),o(!1),r("")}catch{o(!1),r(S)}}const R=w.filter(x=>x.active),Z=R.filter(x=>x.type!=="textarea"),T=R.find(x=>x.type==="textarea");return at(()=>{(l.length===0||!E)&&(B.value=!0)}),(x,G)=>(s(),_(J,{type:"info",class:"tw-mb-4"},{default:V(()=>[O(dt,{title:"Ai Contact Form",disabled:!B.value||!A.value,onSubmit:Q},{default:V(()=>[(s(!0),c(N,null,W(h(Z),M=>(s(),_(Gt,{key:M.label,label:M.label,type:M.type,id:M.label.toLowerCase(),required:M.required,handleFilledField:q},null,8,["label","type","id","required"]))),128)),h(T)?(s(),_(Rt,{key:0,label:h(T).label,id:h(T).label.toLowerCase(),required:h(T).required,handleFilledField:q},null,8,["label","id","required"])):y("",!0),h(E)?(s(),c("div",Zt,[(s(!0),c(N,null,W(h(l),M=>(s(),_(lt,{key:M.id,id:M.id,name:M.name,isMandatory:M.isMandatory,onAcceptedCampaign:j,"onUpdate:modalIdOpened":h(e)},null,8,["id","name","isMandatory","onUpdate:modalIdOpened"]))),128))])):y("",!0)]),_:1},8,["disabled"])]),_:1}))}}),Wt=["innerHTML"],et=$({__name:"chat-bot-message",props:{isExpanded:Boolean,message:String},setup(t){return(a,e)=>(s(),c("div",{class:U(["chat-message tw-text-base tw-gap-4 tw-flex tw-flex-col tw-from-blue-400 tw-to-blue-500 tw-self-end tw-rounded-b-2xl tw-rounded-tl-2xl tw-bg-gradient-to-b tw-px-6 tw-pt-1 tw-pb-2 tw-text-white",{"max-w-[700px]":t.isExpanded,"max-w-[414px]":!t.isExpanded}]),innerHTML:t.message},null,10,Wt))}}),Kt={},Xt={xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 512 512",fill:"currentColor"},Yt=d("path",{d:"M16.1 260.2c-22.6 12.9-20.5 47.3 3.6 57.3L160 376V479.3c0 18.1 14.6 32.7 32.7 32.7c9.7 0 18.9-4.3 25.1-11.8l62-74.3 123.9 51.6c18.9 7.9 40.8-4.5 43.9-24.7l64-416c1.9-12.1-3.4-24.3-13.5-31.2s-23.3-7.5-34-1.4l-448 256zm52.1 25.5L409.7 90.6 190.1 336l1.2 1L68.2 285.7zM403.3 425.4L236.7 355.9 450.8 116.6 403.3 425.4z"},null,-1),te=[Yt];function ee(t,a){return s(),c("svg",Xt,te)}const ae=K(Kt,[["render",ee]]),ne=["disabled"],se={class:"tw-w-10 tw-h-10 tw-border tw-rounded-full tw-border-gray-400 tw-flex tw-justify-center tw-items-center !tw-bg-white disabled:tw-opacity-30 disabled:tw-cursor-not-allowed focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-blue-500"},oe=$({__name:"chat-footer",props:{allowChatInput:{type:Boolean},aiChatId:{},remainingQuestions:{}},emits:["update:remaining-questions","update:messages","update:error-message"],setup(t,{emit:a}){const e=D("chatGptData");if(!e)throw new Error("chatGptData is undefined");const o=D("setAllowChatInput");if(!o)throw new Error("setAllowChatInput is undefined");const{ajaxUrl:n,ajaxActionChatBot:i,nonceChatBot:r,queryField:l,aiChatterId:w,ajaxActionRecordAiChat:m,nonceAiChat:I}=e,b=t,C=a,E=u(!1),S=u(""),k=u("");async function A(){if(E.value=!0,!!S.value){k.value="",B(S.value,"user");try{await Bt({ajaxUrl:n,action:i,queryField:l,aiChatterId:w,message:S.value,aiChatId:b.aiChatId,nonce:r,onMessageChunk:f=>{k.value+=f,C("update:messages",{message:f,type:"system"})}}),B(k.value,"system")}catch(f){console.error("🚀 ~ handleSubmit ~ error:",f);const g=ot(f);C("update:error-message",g)}finally{E.value=!1,S.value=""}}}function B(f,g){g==="system"&&C("update:remaining-questions",b.remainingQuestions-1),b.aiChatId&&Lt({ajaxUrl:n,action:m,nonce:I,msg:f,aiChatId:b.aiChatId,role:g}),b.remainingQuestions===0&&o(!1),C("update:messages",{message:f,type:g})}return(f,g)=>(s(),c("form",{class:"tw-flex tw-mb-6 sm:tw-mb-0 tw-gap-2",onSubmit:nt(A,["prevent"]),name:"chat-footer"},[st(d("input",{type:"text",id:"message","onUpdate:modelValue":g[0]||(g[0]=j=>S.value=j),disabled:E.value||!f.allowChatInput,class:"tw-grow tw-align-center !tw-border-gray-400 tw-flex !tw-rounded-full !tw-border !tw-px-6 !tw-pt-1 !tw-pb-2 !tw-text-base tw-shadow-lg disabled:tw-opacity-30 disabled:tw-cursor-not-allowed focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-blue-500"},null,8,ne),[[ht,S.value]]),d("button",se,[O(ae,{class:"tw-w-6 tw-h-6 tw-text-gray-400"})])],32))}}),ie={},re={xmlns:"http://www.w3.org/2000/svg",fill:"currentColor",viewBox:"0 0 512 512"},le=d("path",{d:"M200 32H56C42.7 32 32 42.7 32 56V200c0 9.7 5.8 18.5 14.8 22.2s19.3 1.7 26.2-5.2l40-40 79 79-79 79L73 295c-6.9-6.9-17.2-8.9-26.2-5.2S32 302.3 32 312V456c0 13.3 10.7 24 24 24H200c9.7 0 18.5-5.8 22.2-14.8s1.7-19.3-5.2-26.2l-40-40 79-79 79 79-40 40c-6.9 6.9-8.9 17.2-5.2 26.2s12.5 14.8 22.2 14.8H456c13.3 0 24-10.7 24-24V312c0-9.7-5.8-18.5-14.8-22.2s-19.3-1.7-26.2 5.2l-40 40-79-79 79-79 40 40c6.9 6.9 17.2 8.9 26.2 5.2s14.8-12.5 14.8-22.2V56c0-13.3-10.7-24-24-24H312c-9.7 0-18.5 5.8-22.2 14.8s-1.7 19.3 5.2 26.2l40 40-79 79-79-79 40-40c6.9-6.9 8.9-17.2 5.2-26.2S209.7 32 200 32z"},null,-1),ce=[le];function de(t,a){return s(),c("svg",re,ce)}const ue=K(ie,[["render",de]]),we={},me={xmlns:"http://www.w3.org/2000/svg",fill:"currentColor",viewBox:"0 0 512 512"},pe=d("path",{d:"M456 224H312c-13.3 0-24-10.7-24-24V56c0-9.7 5.8-18.5 14.8-22.2s19.3-1.7 26.2 5.2l40 40L442.3 5.7C446 2 450.9 0 456 0s10 2 13.7 5.7l36.7 36.7C510 46 512 50.9 512 56s-2 10-5.7 13.7L433 143l40 40c6.9 6.9 8.9 17.2 5.2 26.2s-12.5 14.8-22.2 14.8zm0 64c9.7 0 18.5 5.8 22.2 14.8s1.7 19.3-5.2 26.2l-40 40 73.4 73.4c3.6 3.6 5.7 8.5 5.7 13.7s-2 10-5.7 13.7l-36.7 36.7C466 510 461.1 512 456 512s-10-2-13.7-5.7L369 433l-40 40c-6.9 6.9-17.2 8.9-26.2 5.2s-14.8-12.5-14.8-22.2V312c0-13.3 10.7-24 24-24H456zm-256 0c13.3 0 24 10.7 24 24V456c0 9.7-5.8 18.5-14.8 22.2s-19.3 1.7-26.2-5.2l-40-40L69.7 506.3C66 510 61.1 512 56 512s-10-2-13.7-5.7L5.7 469.7C2 466 0 461.1 0 456s2-10 5.7-13.7L79 369 39 329c-6.9-6.9-8.9-17.2-5.2-26.2s12.5-14.8 22.2-14.8H200zM56 224c-9.7 0-18.5-5.8-22.2-14.8s-1.7-19.3 5.2-26.2l40-40L5.7 69.7C2 66 0 61.1 0 56s2-10 5.7-13.7L42.3 5.7C46 2 50.9 0 56 0s10 2 13.7 5.7L143 79l40-40c6.9-6.9 17.2-8.9 26.2-5.2s14.8 12.5 14.8 22.2V200c0 13.3-10.7 24-24 24H56z"},null,-1),he=[pe];function fe(t,a){return s(),c("svg",me,he)}const ge=K(we,[["render",fe]]),xe=$({__name:"chat-maximize-button",props:{isExpanded:Boolean},emits:["expand-chat"],setup(t,{emit:a}){const e=a;function o(n){n.stopPropagation(),e("expand-chat")}return(n,i)=>(s(),c("button",{onClick:i[0]||(i[0]=r=>e("expand-chat")),class:"tw-absolute tw-top-2 sm:-tw-top-12 tw-left-0 tw-hidden sm:tw-block"},[O(ue,{onClick:o,class:U(["tw-h-6 tw-w-6 sm:tw-w-10 sm:tw-h-10 tw-text-blue-500",{"tw-block":!t.isExpanded,"tw-hidden":t.isExpanded}])},null,8,["class"]),O(ge,{onClick:o,class:U(["tw-h-6 tw-w-6 sm:tw-w-10 sm:tw-h-10 tw-text-blue-500",{"tw-block":t.isExpanded,"tw-hidden":!t.isExpanded}])},null,8,["class"])]))}}),ve={class:"tw-fixed tw-z-40 tw-inset-0 tw-w-full tw-h-full tw-bg-black tw-justify-center tw-items-center tw-flex tw-bg-opacity-50",tabindex:"-1"},be={class:"tw-bg-white tw-rounded tw-w-full tw-max-w-lg tw-min-w-md tw-h-96 tw-flex tw-flex-col"},_e={class:"tw-p-4 tw-border-b"},Ce=["innerHTML"],ye={class:"tw-flex tw-justify-end tw-border-t tw-p-4"},$e=$({__name:"chat-modal",props:{id:String,name:String,content:String,isVisible:Boolean},emits:["close-modal"],setup(t,{emit:a}){const e=a;function o(n){e("close-modal",n)}return(n,i)=>st((s(),c("div",ve,[d("div",be,[d("header",_e,L(t.name),1),d("main",{class:"tw-grow tw-p-4 tw-overflow-y-scroll",innerHTML:t.content},null,8,Ce),d("footer",ye,[O(ct,{onClick:i[0]||(i[0]=r=>o(t.id))},{default:V(()=>[P("Close")]),_:1})])])],512)),[[ft,t.isVisible]])}}),ke={},Ae={xmlns:"http://www.w3.org/2000/svg","xmlns:xlink":"http://www.w3.org/1999/xlink",width:"413",height:"413",viewBox:"0 0 413 413"},Me=gt('<defs><linearGradient id="hall-9000-gradient" x1="1" y1="1" x2="0.081" y2="0.124" gradientUnits="objectBoundingBox"><stop offset="0" stop-color="#6d86d6"></stop><stop offset="1" stop-color="#48c4ee"></stop></linearGradient></defs><rect fill="url(#hall-9000-gradient)" width="413" height="413" rx="206.5"></rect><circle fill="#fff" cx="74.189" cy="74.189" r="74.189" transform="translate(131.178 134.023)"></circle><circle fill="#fff" cx="35.382" cy="35.382" r="35.382" transform="translate(278.414 96.358)"></circle><path fill="#fff" d="M132.445,0C61.11,0,2.9,58.209,2.9,129.545S61.11,259.089,132.445,259.089,261.989,200.88,261.989,129.545,203.78,0,132.445,0Zm0,245.393A115.848,115.848,0,1,1,248.293,129.545,115.932,115.932,0,0,1,132.445,245.393Z" transform="translate(72.922 76.955)"></path>',5),Fe=[Me];function Ie(t,a){return s(),c("svg",Ae,Fe)}const Ee=K(ke,[["render",Ie]]),Se=$({__name:"chat-open-button",props:{isOpen:Boolean},emits:["open-chat"],setup(t,{emit:a}){const e=a;return(o,n)=>(s(),c("button",{onClick:n[1]||(n[1]=i=>e("open-chat")),class:"tw-fixed tw-bottom-2 tw-right-2 sm:tw-bottom-6 sm:tw-right-6 tw-z-20"},[O(Ee,{class:"tw-w-8 tw-h-8 sm:tw-w-16 sm:tw-h-16 tw-rounded-full tw-duration-300 hover:tw-rotate-90",onClick:n[0]||(n[0]=i=>e("open-chat"))})]))}}),Be={class:"tw-absolute sm:-tw-top-12 tw-right-0 tw-items-center tw-justify-center tw-gap-2 tw-rounded-2xl tw-bg-white tw-pl-2 tw-pr-4 tw-shadow-lg tw-hidden sm:tw-flex"},De=d("div",{class:"tw-bg-blue-500 tw-h-8 tw-w-8 tw-rounded-full"},null,-1),Le=d("div",{class:"tw-relative -tw-top-1 tw-text-2xl"},"tokens left",-1),Oe={class:"tw-relative -tw-top-1 tw-text-4xl tw-font-bold"},je=d("div",{class:"tw-absolute tw-bottom-2 tw-left-4 sm:tw-hidden"}," {ramainingQuestions} tokens left ",-1),qe=$({__name:"chat-tokens",props:{ramainingQuestions:Number},setup(t){return(a,e)=>(s(),c(N,null,[d("div",Be,[De,Le,d("div",Oe,L(t.ramainingQuestions),1)]),je],64))}}),Te=["innerHTML"],ze=$({__name:"chat-user-message",props:{isExpanded:Boolean,message:String},setup(t){return(a,e)=>(s(),c("div",{class:U(["tw-from-gray-200 tw-text-base tw-to-gray-300 tw-border-gray-400 tw-text-gray-700 tw-rounded-t-2xl tw-rounded-br-2xl tw-border tw-bg-gradient-to-t tw-px-6 tw-pt-1 tw-pb-2",{"max-w-[700px]":t.isExpanded,"max-w-[414px]":!t.isExpanded}]),innerHTML:t.message},null,10,Te))}}),Ve=$({__name:"chat-gpt",setup(t){const a=D("chatGptData");if(!a)throw new Error("chatGptData is undefined");const{isActive:e,initMessage:o,campaigns:n,limitChat:i,hasAiChat:r,ajaxUrl:l,ajaxActionCreateAiChat:w,nonceAiChat:m,aiChatCampaignsField:I,beforeFormMessage:b,questionsLimit:C,aiChatCampaigns:E,afterFormMessageSuccess:S,allowAiChatCampaigns:k}=a,A=u(!1),B=u(null),f=u(!1),g=u(C),j=u(null),q=u(!1),Q=u(!1),R=u(!1),Z=u([]),T=u(null),x=u(null);H("aiChatId",j),H("setAiChatId",p=>{j.value=p}),H("setModalIdOpen",p=>{B.value=p}),H("setIsAcceptedAiChatForm",p=>{Q.value=p}),H("setIsAcceptedAiContactForm",p=>{R.value=p}),H("setAllowChatInput",p=>{q.value=p}),H("setErrorMessage",p=>{x.value=p});async function G(p){try{const v=await Dt({ajaxUrl:l,action:w,nonce:m,aiChatCampaigns:I,campaignIds:p});j.value=v.aiChatId,Q.value=!0,q.value=!0}catch(v){console.log(v),x.value=ot(v)}}Y(A,()=>{A.value&&!j.value&&r&&!k&&(G([]),q.value=!0),A.value&&!r&&(Q.value=!0,q.value=!0)});const M=tt(()=>!Q.value&&r&&E.length>0),z=tt(()=>g.value===0&&!R.value&&i);function wt(p){G(p)}function mt(p){if(!p.message.includes("[DONE]"))if(p.type==="system"){const v=Z.value.at(-1);v&&v.type==="system"?v.message+=p.message:Z.value.push({message:p.message,type:"system"})}else Z.value.push({message:p.message,type:"user"})}function pt(){T.value&&(T.value.scrollTop=T.value.scrollHeight)}return Y(g,()=>{g.value===0&&(q.value=!1)}),xt(()=>{pt()}),(p,v)=>(s(),c(N,null,[h(e)?(s(),c("div",{key:0,class:U(["tw-inset-0 tw-w-full tw-h-full tw-bg-black tw-justify-center tw-items-center tw-flex tw-bg-opacity-70 tw-z-20",{"tw-hidden":!A.value,"tw-fixed":A.value}])},[d("div",{class:U(["tw-relative tw-flex tw-flex-col tw-text-xl tw-w-full tw-h-full tw-min-h-full tw-p-4 sm:tw-p-6 tw-border-2 sm:tw-border-gray-300 sm:tw-rounded-3xl tw-shadow-card tw-bg-white",{"sm:tw-h-5/6 sm:tw-w-[900px] sm:tw-min-h-[600px] tw-mx-4":f.value,"sm:tw-h-4/6 sm:tw-w-[537px] sm:tw-min-h-[500px]":!f.value}])},[d("main",{class:"tw-flex tw-flex-grow tw-flex-col tw-gap-3 sm:tw-gap-7 tw-overflow-y-auto tw-mb-4",ref_key:"chatContainer",ref:T},[M.value?(s(),_(St,{key:0,onFormAccepted:wt})):y("",!0),Q.value?(s(),_(et,{key:1,message:h(o),isExpanded:f.value},null,8,["message","isExpanded"])):y("",!0),(s(!0),c(N,null,W(Z.value,F=>(s(),c(N,null,[F.type==="user"?(s(),_(ze,{key:0,message:F.message},null,8,["message"])):(s(),_(et,{key:1,message:F.message,isExpanded:f.value},null,8,["message","isExpanded"]))],64))),256)),z.value?(s(),_(J,{key:2,type:"warning"},{default:V(()=>[P(L(h(b)),1)]),_:1})):y("",!0),z.value?(s(),_(Jt,{key:3})):y("",!0),R.value?(s(),_(J,{key:4,type:"success"},{default:V(()=>[P(L(h(S)),1)]),_:1})):y("",!0),x.value?(s(),_(J,{key:5,type:"error"},{default:V(()=>[P(L(x.value),1)]),_:1})):y("",!0)],512),O(oe,{allowChatInput:q.value,aiChatId:j.value,remainingQuestions:g.value,"onUpdate:remainingQuestions":v[0]||(v[0]=F=>g.value=F),"onUpdate:messages":mt,"onUpdate:errorMessage":v[1]||(v[1]=F=>x.value=F)},null,8,["allowChatInput","aiChatId","remainingQuestions"]),h(i)?(s(),_(qe,{key:0,ramainingQuestions:g.value},null,8,["ramainingQuestions"])):y("",!0),O(xe,{isExpanded:f.value,onExpandChat:v[2]||(v[2]=F=>f.value=!f.value)},null,8,["isExpanded"])],2)],2)):y("",!0),h(e)?(s(!0),c(N,{key:1},W(h(n),F=>(s(),_($e,{name:F.name,content:F.content,id:F.id,isVisible:F.id===B.value,onCloseModal:v[3]||(v[3]=He=>B.value=null)},null,8,["name","content","id","isVisible"]))),256)):y("",!0),h(e)?(s(),_(Se,{key:2,onClick:v[4]||(v[4]=F=>A.value=!A.value),isOpen:A.value},null,8,["isOpen"])):y("",!0)],64))}});let ut={};ut=window.chat_gpt.data;const Ge=vt({setup(){H("chatGptData",ut)},render:()=>bt(Ve)});Ge.mount("#main_chat_gpt");
