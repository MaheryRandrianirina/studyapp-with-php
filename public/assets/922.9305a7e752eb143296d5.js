"use strict";(self.webpackChunkwebpack_demo=self.webpackChunkwebpack_demo||[]).push([[922],{922:(e,n,t)=>{t.r(n),t.d(n,{default:()=>o});var i=t(39),a=t(501),l=t(216);function o(e){var n=e.target,t=(0,a.vf)("another-time-revision-modal","\n    <div class='new-datetime'>\n        <div class='new-date-container'>\n            <label for='new-date'>Nouvelle date :<label>\n            <input type='date' name='date' id='new-date'>\n        </div>\n        <div class='new-time-container'>\n            <label for='new-time'>Heure<label>\n            <input type='time' name='time' id='new-time'>\n        </div>\n    </div>\n    <p>Toutes les révisions ultérieures seront repoussées !</p>\n    <button class='ok'>OK</button><button class='no'>Annuler</button>\n    "),r=t.querySelector(".ok"),d=t.querySelector(".no");r.addEventListener("click",(function(){(0,l.Z)([{name:"subject-id",value:parseInt(n.nextElementSibling.innerHTML)},{name:"calendar-id",value:parseInt(n.nextElementSibling.nextElementSibling.innerHTML)},{name:"date",value:document.querySelector("#new-date").value},{name:"time",value:document.querySelector("#new-time").value},{name:"current-time",value:parseInt(n.nextElementSibling.nextElementSibling.nextElementSibling.innerHTML)}],{method:"POST",url:"/save-revision-for-another-time",openDialog:!0}),(0,a.pE)({dialog:t,body:document.body},"removeAnotherTimeDialog"),(0,i.L)()})),d.addEventListener("click",(function(){e.target.addEventListener("click",o),(0,a.pE)({dialog:t,body:document.body},"removeAnotherTimeDialog")})),n.removeEventListener("click",o)}}}]);