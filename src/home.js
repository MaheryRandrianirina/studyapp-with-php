import addLine from "./addLine"
import css from "./app.scss"
import xhr from "./xhr"

const editProfilePhoto = document.querySelector('.user-profile-photo-edit')
const editProfilePhotoModal = document.querySelector('.edit-profil-photo-modal')
const menu = document.querySelectorAll('.sidebar-left i')
let content = document.querySelector('.content')
let fileData
let number
/**
 * objet XMLHttpRequest
 */
let XHR = new XMLHttpRequest()

/**
 * se charge des opérations liées au click sur les icones (menu) du sidebar à gauche
 */
function sidebarLeftIconClick(){
    let sidebarLeftIcons = document.querySelectorAll('.sidebar-left i')

    sidebarLeftIcons.forEach(icon => {
        
        icon.addEventListener('click', (e)=>{
            content.innerHTML = ""
            sidebarLeftIcons.forEach(s => {
                s.classList.remove('active-item')
            })

            if(!icon.classList.contains('active-item')){
                icon.classList.add('active-item')
            }
            loadContent()
        })
    })

}

/**
 * affiche le modal
 * @param {Event} e 
 */
function showEditProfilPhotoModal(e){
    e.preventDefault()

    XHR.onload = () => {
        const body = document.querySelector('body')
        const modal = document.createElement('div')
        modal.className = "edit-profile-photo-modal"
        
    
        body.appendChild(modal)
        modal.innerHTML = XHR.responseText
        
        const close = modal.querySelector('.close')
        const button = modal.querySelector('.editProfilePhotoBtn')
        const pickProfilePhotoIcon = document.querySelector('.pick-profile-photo')
        
        if(close !== null && button !== null){
            close.addEventListener('click', closeModal)
            pickProfilePhotoIcon.addEventListener('click', pickProfilePhoto)
            button.addEventListener('click', addNewProfilePhoto)
            //modal.parentElement.addEventListener('click', closeModal)
        }
        
        this.removeEventListener('click', showEditProfilPhotoModal)
        
    }

    XHR.open('GET', "/editProfilePhoto")
    XHR.send()
}

/**
 * Ferme le modal d'ajout de PDP
 * @param {Event} e 
 */
function closeModal(e){
    
    const modal = document.querySelector('.edit-profile-photo-modal')
    
    if(modal.nodeName === "DIV"){
        modal.classList.add('closeModal')
        modal.addEventListener('animationend', removeModal)
    }
    //else{
    //     e.stopPropagation()
    //     let editProfile = document.querySelector('.edit-profile-photo-modal')
    //     editProfile.classList.add('closeModal')
        
    // }
    
    editProfilePhoto.addEventListener('click', showEditProfilPhotoModal)
}

/**
 * supprime l'element après fermeture du modal
 * @param {Event} e 
 */
function removeModal(e){
    this.parentElement.removeChild(this)
}

/* PARTIE DU PICK*/
const pickOptions = {
    types : [
        {
          description: 'Images',
          accept: {
            'image/*': ['.png', '.jpeg', '.jpg']
          }
        },
      ],
      excludeAcceptAllOption: true,
      multiple: false
}

let fileHandle
/**
 * On pourrait ajouter une fonctionnalité pour afficher l'image à l'utilisateur
 * avant qu'il ne l'ajoute définitivement.
 * @param {Event} e 
 */
async function pickProfilePhoto(e){
    [fileHandle] = await window.showOpenFilePicker(pickOptions)
    fileData = await fileHandle.getFile()
    const imgName = fileData.name
    const span = document.querySelector('.span-for-imgname')

    //on crée la span seulement si elle n'existe pas encore
    if(span === undefined || span === null){
        const spanForImgName = document.createElement('span')
        spanForImgName.className = "span-for-imgname"
        spanForImgName.innerHTML = imgName
        e.target.parentElement.appendChild(spanForImgName)
    }else{
        span.innerHTML = ""
        span.innerHTML = imgName
    }
    
    
}

/* FIN DE LA PARTIE DU PICK*/

/**
 * ajoute une nouvelle photo de profil
 * pui on ferme le modal après
 * @param {Event} e 
 */
function addNewProfilePhoto(e){
    e.preventDefault()
    let data = new FormData()

    data.append('profilePhoto', fileData)
    let progressBar = document.createElement('div')
    let body = document.querySelector('body')
    progressBar.className = "progress-bar"
    body.appendChild(progressBar)
    
    
    XHR.onreadystatechange = ()=>{
        let addWidthToProgressbar = window.innerWidth / 4
        let width = 0
        
        for(let i = 0; i < XHR.readyState; i++){
            width += addWidthToProgressbar
            progressBar.style.width = width + "px"
        }
        if(XHR.readyState === 4){
            let response = JSON.parse(XHR.responseText) 
            alert(response.message)

            setTimeout(()=>{
                body.removeChild(progressBar)
            }, 1000)
        }
        
    }
    
    XHR.open('POST', '/profilePhotoAction')
    XHR.send(data)
    closeModal()
}

/**
 * charge le contenu de la page correspondant au menu cliqué
 * @param {Event} e 
 */
export function loadContent(){
    const className = document.querySelector('.active-item').classList.value.split(" ")[2]
    //nom de la route à charger dans php
    const filename = "/" + className.replace("-logo", "") + "Content"

    XHR.onload = ()=>{
        let response = XHR.responseText
        content.innerHTML = response

        const addCalendar = content.querySelector('.add-calendar')
        const playButton = content.querySelector('.revision-play')
        const anotherTimeButton = content.querySelectorAll('.another-time-revision-button')
        
        //click to the add calendar button
        if(addCalendar !== null){
            addCalendar.addEventListener('click', addCalendarFunc)
        }
        //click to the play button
        if(playButton !== null){
            import('./play').then(module => {
                const playSubject = module.default
                playButton.addEventListener('click', playSubject)
            })
            
        }

        //click to the another-time-revision-button
        if(anotherTimeButton !== null){
            anotherTimeButton.forEach(button => {
                import('./another-time-revision-button-click').then(module => {
                    const anotherTimeRevisionButtonClick = module.default
                    button.addEventListener('click', anotherTimeRevisionButtonClick)
                })
            })
        } 
        let tbody = content.querySelector('tbody')
            
        if(tbody !== null){
            let lastSubject = tbody.lastElementChild
            let subjectDate = tbody.querySelectorAll('.subject-date')
            let status = lastSubject.querySelector('.status').innerHTML
                    
            let date = new Date()
            
            subjectDate.forEach(sd => {
                const splittedDate = sd.innerHTML.split('-')
                const day = parseInt(splittedDate[0])
                const month = splittedDate[1]
                
                if((day < date.getDate() && month <= date.getMonth()) || month < date.getMonth() + 1){
                    console.log('emploi du temps terminé')
                    //on supprime l'emploi du temps
                    xhr([], {
                        method: "GET",
                        url: "/drop-calendar"
                    })
            
                    loadContent()
                }
            })
            
        } 
    }
    
    XHR.open("GET", filename)
    XHR.send()
}

/**
 * crée un nouvel emploi du temps
 */
function addCalendarFunc(e){
    number = 1
    let form = document.createElement('form')
    form.className = "create-calendar"
    form.action = "/create-calendar"
    form.method = "POST"

    let formContent = `
        <table>
            <thead>
                <tr>
                    <th>Matière</th>
                    <th>Chapitre à étudier</th>
                    <th>Date</th>
                    <th>Heure</th>
                </tr>
            </thead>
            <tbody class='calendar-creation-tbody'>
                <tr class='subject-line'>
                    <td><input type='text' name='subject-${number}' id='subject-input'></td>
                    <td><input type='text' name='chapter-${number}' id='chapter-input'></td>
                    <td><input type='date' name='date-${number}' id='date-input'></td>
                    <td><input type='time' name='hour-${number}' id='hour-input'></td>
                    <td><i class='fas fa-plus add-line'></i></td>
                    <td><i class='fas fa-check generate-calendar'></i></td>
                </tr>
            </tbody>
        </table>
        <button type='submit' class='submitBtn' id='submit-calendar'>Créer</button>
    `
    
    let addCalendar = e.target
    addCalendar.classList.add('hidden')
    addCalendar.addEventListener('animationend', ()=>{
        addCalendar.parentElement.removeChild(addCalendar)
        content.querySelector('.calendar-creation-instructions').classList.add('slide-instructions-top')
        content.appendChild(form)
        form.innerHTML = formContent

        let calendarSubmitButton = document.getElementById('submit-calendar')
        calendarSubmitButton.addEventListener('click', createCalendarButtonClick)
        addLineButtonClick()
        generateCalendarButtonClick()  

    })
    
    
    /**
     * gère l'envoi du formulaire d'emploi du temps
     * avec une requête ajax
     * @param {Event} e 
     */
    function createCalendarButtonClick(e){
        e.preventDefault()
        let data = new FormData()
        let ajax = new XMLHttpRequest()
        let inputs = document.querySelectorAll('.create-calendar input')
        let progressBar = document.createElement('div')
        let body = document.querySelector('body')
        
        progressBar.className = "progress-bar"
        body.appendChild(progressBar)

        inputs.forEach(input => {
            data.append(input.name, input.value)
        })

        ajax.onreadystatechange = ()=>{
            let addWidthToProgressbar = window.innerWidth / 4
            let width = 0
            for(let i = 0; i < ajax.readyState; i++){
                width += addWidthToProgressbar
                progressBar.style.width = width + "px"
            }

            if(ajax.readyState === 4){
                let response = JSON.parse(ajax.responseText) 
                
                if(response.success !== undefined){
                    AfterSubmitCalendar(response.success)
                }else if(response.fail !== undefined){
                    AfterSubmitCalendar(response.fail)
                }
                
                setTimeout(()=>{
                    body.removeChild(progressBar)
                }, 1000)
            }
        }


        ajax.open('POST', '/create-calendar')
        ajax.send(data)
    } 
}

/**
 * affiche ce qui doit être affiché après l'envoi du formulaire d'emploi du temps : succès ou
 * @param {String} messageToAlert 
 */
function AfterSubmitCalendar(messageToAlert){
    alert(messageToAlert)
    let createCalendarForm = document.querySelector('.create-calendar')
    createCalendarForm.parentElement.removeChild(createCalendarForm)
    loadContent()
}
export function addLineButtonFunc(e){
    addLine(number)
    //on appelle la fonction à chaque click sinon l'appel ne se fait qu'une seule fois
    addLineButtonClick()
    generateCalendarButtonClick() 
}

/**
* crée une autre ligne lors du click sur le bouton à droite
*/
function addLineButtonClick(){
    let addLineButton = document.querySelector('.add-line')
    number++
    
    addLineButton.addEventListener('click', addLineButtonFunc)      
    
}

/**
 * se charge de toutes choses liées au click sur le bouton de generation d'emploi du temps
 */
function generateCalendarButtonClick(){
    //generer un emploi du temps
    let generateCalendarButton = document.querySelector('.generate-calendar')

    if(generateCalendarButton !== null){
        import("./generateCalendar").then(module => {
            const generateCalendarFunc = module.default
            generateCalendarButton.addEventListener('click', generateCalendarFunc)
        })
        
    }
}

window.addEventListener('load', () => {
    sidebarLeftIconClick()

    if(menu !== null){
        menu.forEach(m => {
            if(m.classList.contains('active-item')){
                loadContent()
            }
        })
    }
    
    if(editProfilePhotoModal === null){
        editProfilePhoto.addEventListener('click', showEditProfilPhotoModal)
        
    }
    import('./home-responsive').then(module => {
        let HomeResponsive = new module.default
        
    })
})

    
    


