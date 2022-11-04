import createElement from "./createElement"
import xhr from "./xhr"
import {stopRevision, createDialog, removeDialog } from "./stopRevision"

const defaultTimeValue = 1490
let body = document.body
var interval
let intervalDuringPause 
let intervalOfChronometer
/**
 * la valeur du temps à t = 0 cad au début quand la revision vient de commencer
 * La véritable valeur c'est 0 mais la valeur actuelle est juste pour les tests
 * @var number 
 */
let time = defaultTimeValue 
let timeForRevisionChrono = defaultTimeValue
let timeStop = 25 // in minutes
let playButton
let playedSubjectContainer
let circular

/**
 * Launch the revision
 * @param {Event} e 
 */
export default function playSubject(e){
    e.preventDefault()

    playButton = e.target
    
    let content = document.querySelector('.content')
    let playedContainer = playButton.parentElement.parentElement
    playedSubjectContainer = createElement('div', "played-subject-container")
    let notPlayedSubjectContainer = createElement('div', "not-played-subject-container")
    let contenChildren = Array.from(content.children)
    let anotherTimeButton = document.querySelectorAll('.another-time-revision-button')
        
    contenChildren.forEach(child => {
        if(child !== playedContainer){
            content.removeChild(child)
            notPlayedSubjectContainer.appendChild(child)
            content.appendChild(notPlayedSubjectContainer)
        }else{
            playedSubjectContainer.appendChild(child)
            content.appendChild(playedSubjectContainer)
        }
        playedSubjectContainer.classList.add('active-subject')
        notPlayedSubjectContainer.classList.add('not-active-subjects')
    })

    anotherTimeButton.forEach(btn => {
        btn.style.display = "none"
    })

    let playContainer = playButton.parentElement
    let pauseButton = createElement('i', 'fas fa-pause revision-button revision-pause')
    toggleRemoveOrAppendElements(playContainer, playButton, pauseButton)
    
    let stop = createElement('i', 'fas fa-stop stop')
    playedSubjectContainer.appendChild(stop)

    if(stop !== null){
        stop.addEventListener('click', stopRevision)
    }

    myInterval()
    createChronometer(timeStop, timeForRevisionChrono)

    pauseButton.addEventListener('click', ()=>{
        clearInterval(interval)
        clearInterval(intervalOfChronometer)
        //on remet le timer à sa valeur au début
        time = defaultTimeValue
        stop.removeEventListener('click', stopRevision)
        //on déclenche ceci pour effacer le chronometre en cours même si ce n'est pas encore terminé
        
        removeChronometer(playedSubjectContainer, circular)
        
        pauseMoment(0.25)

        let otherPlayButton = createElement('i', 'fas fa-play revision-button other-revision-play')
        toggleRemoveOrAppendElements(playContainer, pauseButton, otherPlayButton)

        clickOnThePlayOnlyAfterPause({
            playContainer : playContainer,
            playButton : otherPlayButton,
            pauseButton: pauseButton
        }, myInterval, {
            timeStop: timeStop,
            timeForRevisionChrono: timeForRevisionChrono
        })

    })
    //on va peut-être utiliser le localstorage ou sessionstorage
    // la solution ci-après est est juste d'urgence avant de trouver la bonne afin de ne pas
    //faire d'autres requêtes sql
    xhr([], {
        method : "GET",
        url : "/array-calendar-content"
    })
    
    playButton.removeEventListener('click', playSubject)
}

/**
 * remove an element then append another element in the same place
 * @param {HTMLElement} parentElement 
 * @param {HTMLElement} toRemoveElement 
 * @param {HTMLElement} toAppendElement 
 */
function toggleRemoveOrAppendElements(parentElement, toRemoveElement, toAppendElement){
    parentElement.removeChild(toRemoveElement)
    parentElement.appendChild(toAppendElement)
}

/**
 * launch the pause moment specifying the duration in parameter
 * @param {int} duration pause duration in minutes
 * @return false qui indique que le moment de faire la pause est terminé
 */
function pauseMoment(duration){
    console.log("dans pauseMoment")
    let timeBegin = 0
    let pauseDuration = duration * 60
    //toggleRemoveOrAppendElements(playContainer, pauseButton, playButton)

    createChronometer(duration, timeBegin)

    intervalDuringPause = setInterval(()=>{
        timeBegin++
        if(timeBegin === pauseDuration){
            clearInterval(intervalDuringPause)

            let pauseOverDialog = createDialog("dialog", `
            <p>La pause est terminée !</p>
            <button class='ok'>OK</button>
            `)
            
            let okAfterPause = pauseOverDialog.querySelector('.ok')
            okAfterPause.addEventListener('click', ()=>{
                removeDialog({
                    dialog: pauseOverDialog,
                    body: body
                }, "removeDialog")
            }) 
        }
    }, 1000)
}

/**
 * sets an interval of revision duration before pause
 */
function myInterval(){
    let timeToStop = timeStop * 60
    interval = setInterval(()=>{
        time++
        if(time === timeToStop){
            let dialog = createDialog("dialog pause-dialog", `
            <p>C'est le moment de faire une pause ! <span style='font-weight:bold;'>Mettez une alarme de 5 min<span></p>
            <button class='ok'>OK</button><button class='no'>Annuler</button>
            `)
            
            let ok = dialog.querySelector('.ok')
            let no = dialog.querySelector('.no')

            ok.addEventListener('click', ()=>{
                clearInterval(interval)
                let pauseButton = document.querySelector('.revision-pause')
                let playContainer = pauseButton.parentElement
                let playButton = createElement('i', 'fas fa-play revision-button other-revision-play')

                toggleRemoveOrAppendElements(playContainer, pauseButton, playButton)

                time = defaultTimeValue

                pauseMoment(0.25)
                
                removeDialog({
                    dialog: dialog,
                    body: body
                }, "removeDialog")

                clickOnThePlayOnlyAfterPause({
                    playContainer : playContainer,
                    playButton : playButton,
                    pauseButton: pauseButton
                }, myInterval, {
                    timeStop: timeStop,
                    timeForRevisionChrono: timeForRevisionChrono
                })   
            })

            no.addEventListener('click', ()=>{
                removeDialog({
                    dialog: dialog,
                    body: body
                }, "removeDialog")
            })
            
        }
    }, 1000)
}

/**
 * ne permet le click sur le play que lorsque la pause est terminée
 * @param {{playContainer: HTMLElement, playButton: HTMLElement, pauseButton: HTMLElement}} elements elements html nécessaires
 * @param {Callback} callback l'interval à éxecuter
 * @param {{timeStop: number, timeForRevisionChrono: number}} forChronometer le temps pour arrêter le chrono et sa durée
 */
function clickOnThePlayOnlyAfterPause(elements, callback, forChronometer){
    setTimeout(()=>{
        elements.playButton.addEventListener('click', ()=>{
            console.log(" play button clicked")
            toggleRemoveOrAppendElements(elements.playContainer, elements.playButton, elements.pauseButton)
            callback()
            createChronometer(forChronometer.timeStop, forChronometer.timeForRevisionChrono)
        })
    }, 15000) // ON VA CHANGER LA FONCTION POUR QUE CETTE VALEUR SOIT DYNAMIQUE
}

function otherPlayButtonClick(elements, callback, forChronometer){
    toggleRemoveOrAppendElements(playContainer, otherPlayButton, pauseButton)
    myInterval()
    createChronometer(timeStop, timeForRevisionChrono)
}
/**
 * create a chornometer for revision or pause moment
 * @param {int} duration in minutes
 */
function createChronometer(duration, timeForStop){
    let d = duration * 60 //transform duration to seconds
    circular = createElement("div", "circular")
    let inner = createElement("div", "inner")
    let circle = createElement("div", "circle")
    let leftBar = createElement("div", "bar left")
    let right = createElement("div", "bar right")
    let leftProgress = createElement("div", "progress")
    let rightProgress = createElement("div", "progress")
    
    playedSubjectContainer.appendChild(circular)
    circular.appendChild(inner)
    circular.appendChild(circle)
    circle.appendChild(leftBar)
    circle.appendChild(right)
    leftBar.appendChild(leftProgress)
    right.appendChild(rightProgress)
    
    //IL FAUT SUIVRE CETTE LOGIQUE LORS DE LA PRODUCTION EN CHANGEANT ((d - timeForStop) / 2) PAR DURATION
    //IL FAUDRA AUSSI ENLEVER TIMEFORSTOP ET NE FAIRE UN CONDITION POUR ARRETER L'INTERVAL QUE SI D === 0
    leftProgress.style.animationDuration = ((d - timeForStop) / 2) + 's'
    rightProgress.style.animationDelay = ((d - timeForStop) / 2) + 's'
    rightProgress.style.animationDuration = ((d - timeForStop) / 2) + 's'
    
    intervalOfChronometer = setInterval(()=>{
        d--
        let minutesLeft = Math.floor(d / 60) 
        let secondsLeft = d % 60
        
        inner.innerHTML = `<p id='chronometer'>${minutesLeft}:${secondsLeft}</p>`
        
        //MISY ERREUR NY REMOVECHRONOMETRE SATRIA EFA NIFAFA TALOA LE TOKONY HOFAFANA
        if(d === timeForStop){
            removeChronometer(playedSubjectContainer,circular)
            clearInterval(intervalOfChronometer)
        }      
    }, 1000)
}

/**
 * removes the chronometer
 * @param {HTMLElement} parentElement 
 * @param {HTMLElement} toRemove 
 */
function removeChronometer(parentElement, toRemove){
    if(toRemove.parentElement !== null){
        if(toRemove.parentElement.classList.contains('played-subject-container')){
            parentElement.removeChild(toRemove)
        }
    }  
}
