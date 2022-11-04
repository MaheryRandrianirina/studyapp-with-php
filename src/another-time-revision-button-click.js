import { loadContent } from "./home"
import { createDialog, removeDialog } from "./stopRevision"
import xhr from "./xhr"

export default function anotherTimeRevisionButtonClick(e){
    let clickedElement = e.target
    let dialog = createDialog("another-time-revision-modal", `
    <div class='new-datetime'>
        <div class='new-date-container'>
            <label for='new-date'>Nouvelle date :<label>
            <input type='date' name='date' id='new-date'>
        </div>
        <div class='new-time-container'>
            <label for='new-time'>Heure<label>
            <input type='time' name='time' id='new-time'>
        </div>
    </div>
    <p>Toutes les révisions ultérieures seront repoussées !</p>
    <button class='ok'>OK</button><button class='no'>Annuler</button>
    `)

    let ok = dialog.querySelector('.ok')
    let no = dialog.querySelector('.no')
    
    ok.addEventListener('click', ()=>{
        xhr([{
            name: "subject-id",
            value: parseInt(clickedElement.nextElementSibling.innerHTML)
        },{
            name: "calendar-id",
            value: parseInt(clickedElement.nextElementSibling.nextElementSibling.innerHTML)
        }, {
            name: "date",
            value: document.querySelector('#new-date').value
        }, {
            name: "time",
            value: document.querySelector('#new-time').value
        }, {
            name: "current-time",
            value: parseInt(clickedElement.nextElementSibling.nextElementSibling.nextElementSibling.innerHTML)
        }], {
            method: "POST",
            url: "/save-revision-for-another-time",
            openDialog: true
        })

        removeDialog({
            dialog: dialog,
            body: document.body
        }, "removeAnotherTimeDialog")

        loadContent()
    })

    no.addEventListener('click', ()=>{
        e.target.addEventListener('click', anotherTimeRevisionButtonClick)
        removeDialog({
            dialog: dialog,
            body: document.body
        }, "removeAnotherTimeDialog")
    })
    
    clickedElement.removeEventListener('click', anotherTimeRevisionButtonClick)
}