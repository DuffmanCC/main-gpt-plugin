import{d as i,c as a,o,n as w,a as s,b as u,t as r,f as l,_ as c,z as m}from"./style.js";const f={class:"tw:flex tw:justify-between tw:items-center tw:gap-8 tw:text-lg"},p={key:0,class:"tw:flex tw:justify-between tw:items-center"},b={class:"tw:font-normal"},y=i({__name:"metabox-header",props:{title:{},status:{default:""}},emits:["toggleAdvanced"],setup(n,{emit:d}){return(t,e)=>(o(),a("div",{class:w(["tw:flex tw:justify-between tw:items-center tw:px-8 tw:py-4 tw:rounded-t-xl tw:shadow-sm tw:border-b tw:border-gray-200",{"tw:bg-white tw:text-black":t.status==="","tw:bg-purple-700 tw:text-white!":t.status!==""}])},[s("div",f,[s("h2",{class:w(["tw:font-bold tw:text-2xl! tw:p-0!",{"tw:text-white!":t.status!==""}])},r(t.title),3),t.status?(o(),a("div",p,[e[0]||(e[0]=l(" ( ")),s("div",{class:w(["tw:w-4 tw:h-4 tw:rounded-full tw:mr-2 tw:relative tw:top-0.5",{"tw:bg-red-500":t.status==="disconnected","tw:bg-yellow-500":t.status==="connected","tw:bg-green-500":t.status==="trained"}])},null,2),s("div",b,r(t.status),1),e[1]||(e[1]=l(" ) "))])):u("",!0)])],2))}}),g={},_={class:"tw:flex tw:flex-col tw:gap-8 tw:px-8 tw:py-8 tw:rounded-b-xl tw:shadow-sm tw:bg-white tw:relative tw:@container"};function x(n,d){return o(),a("div",_,[m(n.$slots,"default")])}const v=c(g,[["render",x]]);export{y as _,v as m};
