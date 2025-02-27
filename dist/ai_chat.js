import{d as $,i as B,r as m,l as D,o as a,c as o,b as s,w as _,F as f,f as p,k as w,a as n,u as t,h,t as V,p as M,q as N,s as L}from"./wug-style.js";import{b as S,_ as E,c as v}from"./a-text.vue_vue_type_script_setup_true_lang.js";import{_ as F,m as H,a as I}from"./metabox-body.js";import{_ as j}from"./a-textarea.vue_vue_type_script_setup_true_lang.js";import{a as q}from"./tools.js";const z={class:"tw:font-arboria"},J={class:"tw:flex tw:flex-col tw:gap-2"},O={key:1,class:"tw:flex tw:flex-col tw:gap-2"},P=n("div",{class:"tw:font-semibold tw:text-gray-700 tw:text-lg"}," Messages ",-1),R={class:"chat-message tw:max-w-xl tw:border tw:rounded-md tw:p-2 tw:bg-gray-300 tw:overflow-y-auto tw:max-h-72"},W={class:"tw:flex"},G={class:"tw:pr-2 tw:font-bold"},K=["innerHTML"],Q=$({__name:"ai-chat",setup(X){const c=B("aiChatData");if(!c)throw new Error("aiChatData is undefined");const{timestamp:x,timestampValue:y,campaigns:C,campaignsValue:b,messages:T,messagesValue:u}=c,i=m([]),l=m(!0);function k(r){i.value=i.value.filter(d=>d.id!==r)}function A(r){return r.replace(/<img/g,'<img class="tw:w-48 tw:h-auto tw:rounded"')}return D(()=>{q(i,"info","These fields are readonly",0)}),(r,d)=>(a(),o("div",z,[s(F,{title:"AI Chat",hasAdvanced:!1}),s(H,null,{default:_(()=>[s(S,{class:"tw:top-2"},{default:_(()=>[(a(!0),o(f,null,p(i.value,e=>(a(),w(E,{key:e.id,type:e.type,message:e.message,time:e.time,onClose:Y=>k(e.id)},null,8,["type","message","time","onClose"]))),128))]),_:1}),n("div",J,[s(I,{onText:"Plain text",offText:"html",type:"switch",size:"lg",value:l.value,onSwitch:d[0]||(d[0]=e=>l.value=!l.value)},null,8,["value"]),l.value?(a(),w(j,{key:0,id:t(T),label:"Messages",value:JSON.stringify(t(u)),readonly:""},null,8,["id","value"])):h("",!0),l.value?h("",!0):(a(),o("div",O,[P,n("div",R,[(a(!0),o(f,null,p(t(u),e=>(a(),o("div",W,[n("div",G,V(e.role)+":",1),n("div",{innerHTML:A(e.content)},null,8,K)]))),256))])]))]),s(v,{id:t(x),label:"Timestamp",value:t(y),readonly:""},null,8,["id","value"]),s(v,{id:t(C),label:"Campaigns",value:t(b),readonly:""},null,8,["id","value"])]),_:1})]))}});let g={};g=window.ai_chat.data;const U=M({setup(){L("aiChatData",g)},render:()=>N(Q)});U.mount("#main_ai_chat");
