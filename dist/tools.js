function m(s,i){const e=[];return s.modelName===""&&e.push("You must provide a model"),s.pineconeIndex.trim()===""&&e.push("You must provide a pinecone index"),s.primerPrompt.trim()===""&&e.push("You must provide a primer prompt"),s.initMessage.trim()===""&&e.push("You must provide a initial message"),i==="always"&&s.aiChatCampaigns.length===0&&e.push("You must provide at least one AiChat campaign."),i==="configurable"&&s.allowAiChatCampaigns&&s.aiChatCampaigns.length===0&&e.push("You must provide at least one AiContact campaign."),s.limitChat&&s.questionsLimit===0&&e.push("Minimum number of messages if limit chat is enabled is 1"),s.limitChat&&s.beforeFormMessage===""&&e.push("You must provide a message to display before the form"),s.limitChat&&s.showContactForm&&!a(s.formFields)&&e.push("At least one field must be active in the contact form"),s.limitChat&&s.showContactForm&&i==="always"&&s.aiContactCampaigns.length===0&&e.push("You must provide at least one GDPR leads campaign."),s.limitChat&&s.showContactForm&&i==="configurable"&&s.allowAiContactCampaigns&&s.aiContactCampaigns.length===0&&e.push("You must provide at least one GDPR leads campaign."),e}function a(s){return Object.values(s).some(i=>i.active)}function u(s){let i=s.message;if(typeof i=="string"){const o=JSON.parse(i).message,n=o.indexOf("{");if(n!==-1){const t=o.substring(n);return JSON.parse(t).message}else return o}return i}function l(s,i,e,o=2e3){const n={id:Date.now(),type:i,message:e,time:o};s.value=[...s.value,n]}export{l as a,u as e,m as v};
