import{d as _,o as s,c as u,a as r,z as P,n as j,p as E,t as x,h as N,i as R,r as b,A as F,b as l,w as g,F as y,f as h,k as C,u as d,e as G,q,s as L,x as O}from"./wug-style.js";import{b as W,_ as H,c as A}from"./a-text.vue_vue_type_script_setup_true_lang.js";import{_ as J}from"./a-checkbox.vue_vue_type_script_setup_true_lang.js";import{_ as K,m as Q,a as U}from"./metabox-body.js";import{_ as X}from"./a-textarea.vue_vue_type_script_setup_true_lang.js";import{c as Y}from"./constants.js";const Z={class:"tw:flex tw:flex-col tw:gap-2"},ee={key:0,class:"tw:text-xs tw:flex tw:flex-col tw:items-end"},te=_({__name:"a-pill",props:{selected:Boolean,size:{type:String,default:"md",validator:a=>["md","lg"].includes(a)},color:{type:String,default:"blue",validator:a=>["blue","purple"].includes(a)},sec:String,day:String},emits:["selected"],setup(a,{emit:c}){const p=c,w=()=>{p("selected")};return(f,m)=>(s(),u("div",Z,[r("button",{class:j(["tw:text-sm tw:uppercase tw:px-4 tw:border-2 tw:transition-all tw:duration-300 tw:shadow-button tw:transparant tw:hover:text-white",{"tw:text-brand-blue tw:border-blue-500 tw:hover:bg-blue-500":a.color==="blue","tw:text-purple-700 tw:border-purple-700 tw:hover:bg-purple-700":a.color==="purple","tw:bg-blue-500 tw:text-white!":a.selected&&a.color==="blue","tw:bg-purple-700 tw:text-white!":a.selected&&a.color==="purple","tw:rounded-full tw:py-1":a.size==="md","tw:rounded-lg tw:py-2":a.size==="lg"}]),onClick:E(w,["prevent"])},[P(f.$slots,"default")],2),a.sec||a.day?(s(),u("div",ee,[r("div",null,x(a.sec),1),r("div",null,x(a.day),1)])):N("",!0)]))}}),ae={class:"tw:font-arboria"},ne={class:"tw:flex tw:flex-col tw:gap-2"},ie=r("div",{class:"tw:uppercase"},"Presets",-1),le={class:"tw:flex tw:items-center tw:gap-4"},se={class:"tw:flex tw:gap-8"},re=_({__name:"ai-campaign",setup(a){const c=R("aiCampaignData");if(!c)throw new Error("aiCampaignData is undefined");const{duration:p,durationValue:w,interest:f,interestValue:m,gdprText:k,gdprTextValue:S,isActive:D,isActiveValue:V,isMandatory:M,isMandatoryValue:B}=c,v=b([]),i=b(m===""?[]:m.split(", ")),n=F({duration:w,interest:m,gdprText:S,isActive:V,isMandatory:B});function T(o){v.value=v.value.filter(t=>t.id!==o)}function z(o){if(i.value.includes(o)){i.value=i.value.filter(t=>t!==o),n.interest=i.value.join(", ");return}i.value=[...i.value,o],n.interest=i.value.join(", ")}return(o,t)=>(s(),u("div",ae,[l(K,{title:"AI Campaign",hasAdvanced:!1}),l(Q,null,{default:g(()=>[l(W,{class:"tw:top-2"},{default:g(()=>[(s(!0),u(y,null,h(v.value,e=>(s(),C(H,{key:e.id,type:e.type,message:e.message,time:e.time,onClose:I=>T(e.id)},null,8,["type","message","time","onClose"]))),128))]),_:1}),l(A,{id:d(p),label:"Duration",type:"number",help:"6-72 months",value:n.duration,onInput:t[0]||(t[0]=e=>n.duration=e),onEnter:t[1]||(t[1]=e=>n.duration=e),min:6,max:72},null,8,["id","value"]),l(A,{id:d(f),label:"Interest",placeholder:"marketing, operational, 3rd party marketing...",help:"Comma separated list of interests.",value:n.interest,onInput:t[2]||(t[2]=e=>n.duration=e),onEnter:t[3]||(t[3]=e=>n.duration=e)},null,8,["id","value"]),l(X,{id:d(k),label:"GDPR text",help:"The text of the GDPR campaign.",value:n.gdprText,onInput:t[4]||(t[4]=e=>n.gdprText=e)},null,8,["id","value"]),r("div",ne,[ie,r("div",le,[(s(!0),u(y,null,h(d(Y),e=>(s(),C(te,{onSelected:I=>z(e),selected:i.value.includes(e)},{default:g(()=>[G(x(e),1)]),_:2},1032,["onSelected","selected"]))),256))])]),r("div",se,[l(U,{id:d(D),value:n.isActive,label:"Active",onSwitch:t[5]||(t[5]=e=>n.isActive=e)},null,8,["id","value"]),l(J,{id:d(M),value:n.isMandatory,position:"col",label:"Mandatory",onChange:t[6]||(t[6]=e=>n.isMandatory=e)},null,8,["id","value"])])]),_:1})]))}});let $={};$=window.ai_campaign.data;const oe=q({setup(){O("aiCampaignData",$)},render:()=>L(re)});oe.mount("#main_ai_campaign");
