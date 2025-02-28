import{_ as b,o as a,c as n,z as p,d as v,r as g,B as _,a as e,l as z,n as f,h as o,t as x,u as h,k as $,y as k,b as S,w as M,e as B,C}from"./wug-style.js";const N={},V={class:"tw:font-semibold tw:text-gray-700 tw:text-lg"};function T(t,c){return a(),n("div",V,[p(t.$slots,"default")])}const H=b(N,[["render",T]]),I={class:"tw:inline-flex tw:items-center tw:justify-center tw:overflow-hidden tw:rounded-full"},L={class:"tw:w-10 tw:h-10"},A=e("circle",{class:"tw:text-gray-200","stroke-width":"3",stroke:"currentColor",fill:"transparent",r:"15",cx:"20",cy:"20"},null,-1),K=["stroke-dashoffset"],y=100,j=v({__name:"a-close-animation",props:{time:{type:Number,default:1e3}},setup(t){const c=t,i=g(1),l=setInterval(()=>{i.value<=y&&(i.value+=1)},c.time/y);_(()=>{clearInterval(l)});const s=Math.PI*30;return(r,d)=>(a(),n("div",I,[(a(),n("svg",L,[A,e("circle",{class:"tw:text-gray-400","stroke-width":"3","stroke-dasharray":s,"stroke-dashoffset":s-i.value/y*s,"stroke-linecap":"round",stroke:"currentColor",fill:"transparent",r:"15",cx:"20",cy:"20"},null,8,K)]))]))}}),E={class:"tw:flex tw:gap-16 tw:items-center"},D={class:"tw:flex tw:gap-4 tw:items-center"},O={key:0,xmlns:"http://www.w3.org/2000/svg",height:"1em",viewBox:"0 0 512 512"},P=e("path",{fill:"currentcolor",d:"M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"},null,-1),U=[P],W={key:1,xmlns:"http://www.w3.org/2000/svg",height:"1em",viewBox:"0 0 512 512"},q=e("path",{fill:"currentcolor",d:"M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"},null,-1),F=[q],G={key:2,xmlns:"http://www.w3.org/2000/svg",height:"1em",viewBox:"0 0 512 512"},J=e("path",{fill:"currentcolor",d:"M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm0-384c13.3 0 24 10.7 24 24V264c0 13.3-10.7 24-24 24s-24-10.7-24-24V152c0-13.3 10.7-24 24-24zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"},null,-1),Q=[J],R={key:3,xmlns:"http://www.w3.org/2000/svg",height:"1em",viewBox:"0 0 512 512"},X=e("path",{fill:"currentcolor",d:"M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"},null,-1),Y=[X],Z={class:"tw:flex tw:items-center tw:gap-2"},tt={class:"tw:text-bray-800 tw:font-semibold tw:mr-2 tw:capitalize"},et=["innerHTML"],at=["href","target"],st={class:"tw:flex tw:gap-4"},it=v({__name:"a-alert",props:{message:String,link:{type:String,default:""},target:{type:String,default:"_self",validator:t=>["_self","_blank"].includes(t)},type:{type:String,default:"warning",validator:t=>["warning","info","success","error"].includes(t)},time:{type:Number,default:2e3}},emits:["close"],setup(t,{emit:c}){const i=t,l=g(!0),s=g(!1),{time:r}=i,d=c,m=()=>{s.value=!1,setTimeout(()=>{l.value=!1,d("close")},300)};return z(()=>{setTimeout(()=>{s.value=!0},10),r!==0&&(setTimeout(()=>{s.value=!1},r),setTimeout(()=>{l.value=!1,d("close")},r+200))}),(w,u)=>l.value?(a(),n("div",{key:0,class:f(["tw:px-4 tw:py-2 tw:flex tw:gap-4 tw:justify-between tw:items-center tw:text-sm tw:border tw:rounded-lg tw:transition tw:duration-200",{"tw:bg-amber-100 tw:border-amber-400":t.type==="warning","tw:bg-blue-100 tw:border-blue-400":t.type==="info","tw:bg-green-100 tw:border-green-400":t.type==="success","tw:bg-red-100 tw:border-red-400":t.type==="error","tw:opacity-100 tw:scale-100":s.value,"tw:opacity-0 tw:scale-50":!s.value}])},[e("div",E,[e("div",D,[e("div",{class:f(["tw:text-2xl tw:flex tw:gap-2 tw:items-center",{"tw:text-amber-700":t.type==="warning","tw:text-blue-700":t.type==="info","tw:text-green-700":t.type==="success","tw:text-red-700":t.type==="error"}])},[t.type==="warning"?(a(),n("svg",O,U)):o("",!0),t.type==="info"?(a(),n("svg",W,F)):o("",!0),t.type==="error"?(a(),n("svg",G,Q)):o("",!0),t.type==="success"?(a(),n("svg",R,Y)):o("",!0)],2),e("div",Z,[e("div",tt,x(t.type)+"! ",1),e("div",{class:"tw:text-gray-600 tw:font-normal",innerHTML:t.message},null,8,et)])]),t.link!==""?(a(),n("a",{key:0,href:t.link,class:"tw:text-brand-blue tw:w-32",target:t.target},"learn more",8,at)):o("",!0)]),e("div",st,[h(r)!==0?(a(),$(j,{key:0,time:h(r)},null,8,["time"])):o("",!0),e("button",{class:f(["tw:text-3xl tw:font-semibold tw:relative tw:-top-1",{"tw:text-amber-700":t.type==="warning","tw:text-blue-700":t.type==="info","tw:text-green-700":t.type==="success","tw:text-red-700":t.type==="error"}]),onClick:k(m,["prevent"])}," × ",2)])],2)):o("",!0)}}),nt={},lt={class:"tw:flex tw:flex-col tw:gap-2 tw:fixed tw:pr-4 tw:pt-8 tw:right-0 tw:z-10"};function rt(t,c){return a(),n("div",lt,[p(t.$slots,"default")])}const dt=b(nt,[["render",rt]]),ot=["id","name","value","onKeydown","type","disabled","placeholder","readonly","min","max","area-readonly"],wt=v({__name:"a-text",props:{label:{type:String,default:""},id:{type:String,default:""},type:{type:String,default:"text",validator:t=>["number","text","email","password"].includes(t)},value:{type:[String,Number],default:""},disabled:{type:Boolean,default:!1},help:{type:String,default:""},placeholder:{type:String,default:""},readonly:{type:Boolean,default:!1},min:Number,max:Number},emits:["input","enter"],setup(t,{emit:c}){const i=t,{id:l}=i,s=c;function r(w){const u=w.target;s("input",u.value)}function d(w){const u=w.target;s("enter",u.value)}const m=l+"_help";return(w,u)=>(a(),n("label",{class:f(["tw:flex tw:flex-col tw:gap-2",{"tw:opacity-30 tw:cursor-not-allowed":t.disabled}])},[S(H,null,{default:M(()=>[B(x(t.label),1)]),_:1}),e("input",{id:h(l),name:h(l),value:t.value,onInput:r,onKeydown:C(k(d,["prevent"]),["enter"]),type:t.type,disabled:t.disabled,class:"tw:border! tw:border-gray-300! tw:p-2! tw:text-sm! tw:max-w-xl tw:rounded-md! tw:placeholder:text-gray-400 tw:disabled:cursor-not-allowed tw:shadow tw:read-only:bg-gray-300",placeholder:t.placeholder,"aria-describedby":m,readonly:t.readonly,min:t.min,max:t.max,"area-readonly":t.readonly},null,40,ot),t.help?(a(),n("div",{key:0,id:m,class:"tw:font-light tw:text-brand-gray-dark tw:text-sm tw:max-w-xl"},x(t.help),1)):o("",!0)],2))}});export{it as _,H as a,dt as b,wt as c};
