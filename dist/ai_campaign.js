import{d as C,c as m,o,p as I,n as P,z as j,i as E,r as g,A as R,e as s,w as v,a as p,F as b,g as _,k as y,u as r,f as N,t as F,q as G,s as q,x as L}from"./style.js";import{b as O,_ as W,c as x}from"./a-text.vue_vue_type_script_setup_true_lang.js";import{_ as H}from"./a-checkbox.vue_vue_type_script_setup_true_lang.js";import{_ as J}from"./a-switch.vue_vue_type_script_setup_true_lang.js";import{_ as K}from"./a-textarea.vue_vue_type_script_setup_true_lang.js";import{_ as Q,m as U}from"./metabox-body.js";import{c as X}from"./constants.js";const Y=C({__name:"a-pill",props:{selected:{type:Boolean},size:{default:"md"},color:{default:"blue"}},emits:["selected"],setup(A,{emit:u}){const c=u,w=()=>{c("selected")};return(n,d)=>(o(),m("button",{class:P(["tw:text-sm tw:uppercase tw:px-4 tw:border-2 tw:transition-all tw:duration-300 tw:shadow-button tw:transparant tw:hover:text-white tw:cursor-pointer",{"tw:text-brand-blue tw:border-blue-500 tw:hover:bg-blue-500":n.color==="blue","tw:text-purple-700 tw:border-purple-700 tw:hover:bg-purple-700":n.color==="purple","tw:bg-blue-500 tw:text-white!":n.selected&&n.color==="blue","tw:bg-purple-700 tw:text-white!":n.selected&&n.color==="purple","tw:rounded-full tw:py-1":n.size==="md","tw:rounded-lg tw:py-2":n.size==="lg"}]),onClick:I(w,["prevent"])},[j(n.$slots,"default")],2))}}),Z={class:"tw:font-arboria"},ee={class:"tw:flex tw:flex-col tw:gap-2"},te={class:"tw:flex tw:items-center tw:gap-4"},ae={class:"tw:flex tw:gap-8"},ne=C({__name:"ai-campaign",setup(A){const u=E("aiCampaignData");if(!u)throw new Error("aiCampaignData is undefined");const{duration:c,durationValue:w,interest:n,interestValue:d,gdprText:k,gdprTextValue:$,isActive:D,isActiveValue:M,isMandatory:V,isMandatoryValue:B}=u,f=g([]),i=g(d===""?[]:d.split(", ")),a=R({duration:w,interest:d,gdprText:$,isActive:M,isMandatory:B});function T(l){f.value=f.value.filter(t=>t.id!==l)}function S(l){if(i.value.includes(l)){i.value=i.value.filter(t=>t!==l),a.interest=i.value.join(", ");return}i.value=[...i.value,l],a.interest=i.value.join(", ")}return(l,t)=>(o(),m("div",Z,[s(Q,{title:"AI Campaign",hasAdvanced:!1}),s(U,null,{default:v(()=>[s(O,{class:"tw:top-2"},{default:v(()=>[(o(!0),m(b,null,_(f.value,e=>(o(),y(W,{key:e.id,type:e.type,message:e.message,time:e.time,onClose:z=>T(e.id)},null,8,["type","message","time","onClose"]))),128))]),_:1}),s(x,{id:r(c),label:"Duration",type:"number",help:"6-72 months",value:a.duration,onInput:t[0]||(t[0]=e=>a.duration=e),onEnter:t[1]||(t[1]=e=>a.duration=e),min:6,max:72},null,8,["id","value"]),s(x,{id:r(n),label:"Interest",placeholder:"marketing, operational, 3rd party marketing...",help:"Comma separated list of interests.",value:a.interest,onInput:t[2]||(t[2]=e=>a.duration=e),onEnter:t[3]||(t[3]=e=>a.duration=e)},null,8,["id","value"]),s(K,{id:r(k),label:"GDPR text",help:"The text of the GDPR campaign.",value:a.gdprText,onInput:t[4]||(t[4]=e=>a.gdprText=e)},null,8,["id","value"]),p("div",ee,[t[7]||(t[7]=p("div",{class:"tw:uppercase"},"Presets",-1)),p("div",te,[(o(!0),m(b,null,_(r(X),e=>(o(),y(Y,{onSelected:z=>S(e),selected:i.value.includes(e)},{default:v(()=>[N(F(e),1)]),_:2},1032,["onSelected","selected"]))),256))])]),p("div",ae,[s(J,{id:r(D),value:a.isActive,label:"Active",onSwitch:t[5]||(t[5]=e=>a.isActive=e)},null,8,["id","value"]),s(H,{id:r(V),value:a.isMandatory,position:"col",label:"Mandatory",onChange:t[6]||(t[6]=e=>a.isMandatory=e)},null,8,["id","value"])])]),_:1})]))}});let h={};h=window.ai_campaign.data;const ie=G({setup(){L("aiCampaignData",h)},render:()=>q(ne)});ie.mount("#main_ai_campaign");
