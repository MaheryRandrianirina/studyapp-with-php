import createElement from "./createElement"
import xhr from "./xhr"

let body = document.body

/**
 * stop the revision if it's over
 * @param {Event} e 
 */
export function stopRevision(e)
{
    e.preventDefault()

    const stop = e.target
    let playedSubjectContainer = stop.parentElement
    
    const children = Array.from(playedSubjectContainer.children)
    
    let dialog = createDialog("dialog sure-dialog", `
    <p>Êtes-vous sûr que la revision de cette matière soit finie ?</p>
    <button class='ok'>Oui</button><button class='no'>Annuler</button>
    `)
    
    let ok = dialog.querySelector('.ok')
    let no = dialog.querySelector('.no')

    if(ok !== null && no !== null){
        ok.addEventListener('click', ()=>{
            removeDialog({
                dialog: dialog,
                body: body
            }, "removeDialog")
            //IL NOUS FAUT PASSER L'ID DE LA MATIERE DANS DATA POUR METTRE SON done = 1
            xhr([{
                name: "status",
                value: 1
            }, {
                name: "subject-id",
                value: parseInt(document.querySelector('.subject-id').innerHTML)
            }, {
                name: "calendar-id",
                value: parseInt(document.querySelector('.calendar-id').innerHTML)
            }], {
                method:"POST",
                url:"/stop-revision"
            })
            
            children.forEach(child => {
                playedSubjectContainer.removeChild(child)
            })
        })

        no.addEventListener('click', ()=>{
            console.log('no cliqué')
            removeDialog({
                dialog: dialog,
                ForAnimationend: no,
                body: body
            }, "removeDialog")
        })
    }
}

/**
 * create a dialog box
 * @param {string} className 
 * @param {string} content 
 * @returns {HTMLElement} dialog
 */
export function createDialog(className, content){
    let dialog = createElement("div", className)
    let dialogContent = content
    
    body.appendChild(dialog)
    dialog.innerHTML = dialogContent

    return dialog
}

/**
 * removes the dialog box with some animations
 * @param {{}} elements 
 */
export function removeDialog(elements = {}, animationName)
{
    elements.dialog.style.animationName = animationName
    
    elements.dialog.addEventListener('animationend', ()=>{
        elements.body.removeChild(elements.dialog)
    })
    
    
            
}