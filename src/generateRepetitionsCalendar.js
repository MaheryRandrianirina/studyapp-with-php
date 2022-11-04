import addLine from "./addLine"
import createElement from "./createElement"

export default function generateRepetitionsCalendar(nb, element){
    let number = nb
    let elementInputs = element.querySelectorAll('input')
    let emptyInputExists = false
    elementInputs.forEach(i => {
        if(i.value === ''){
            emptyInputExists = true
        }
    })
    if(!emptyInputExists){
        number++
        addLine(number)
        generateLines(element)
    }else{
        if(document.querySelector('.warning') === null){
            createWarning("Impossible de générer les répétitions si les champs sont vides.")
        }
        
    }
}


/**
 * génère des lignes d'inputs d'une matière à reviser
 * @param {HTMLElement} element
 */
 function generateLines(element){
    let tbody = document.querySelector('tbody')
    //lastElementChild représente le dernier element qui vient d'être ajouté
    let subjectInput = tbody.lastElementChild.querySelector('#subject-input')
    let chapterInput = tbody.lastElementChild.querySelector('#chapter-input')
    let dateInput = tbody.lastElementChild.querySelector('#date-input')
    let hourInput = tbody.lastElementChild.querySelector('#hour-input')

    subjectInput.value = element.querySelector('#subject-input').value
    chapterInput.value = element.querySelector('#chapter-input').value
    
    let splittedHour = element.querySelector('#hour-input').value.split(':')
    let splittedDate = element.querySelector('#date-input').value.split('-')
    
    let year = splittedDate[0]
    let month = splittedDate[1]
    let day =  splittedDate[2]
    let newHourValue = parseInt(splittedHour[0]) + 8
    
    if(newHourValue < 20){
        dateInput.value = element.querySelector('#date-input').value
        hourInput.value = newHourValue + ':' + splittedHour[1]
    }else{
        let newDayValue = parseInt(day) + 1
        newHourValue = 8
        dateInput.value = year + '-' + month + '-' + newDayValue

        if(dateInput.value === ''){
            if(parseInt(month) < 12){
                dateInput.value = year + '-' + (parseInt(month) + 1) + '-' + '01'
            }else{
                dateInput.value = (parseInt(year) + 1) + '-' + '01' + '-' + '01'
            }
        }

        hourInput.value = '0' + newHourValue + ':' + splittedHour[1]
    }   
}
/**
 * crée un message warnig
 * @param {string} message 
 */
export function createWarning(message){
    
    let p = createElement('p', 'warning')
    let i = createElement('i', 'fas fa-exclamation-triangle')
    let span = createElement('span', 'warnig-message')

    document.querySelector('.content').appendChild(p)
    p.appendChild(i)
    p.appendChild(span)
    span.innerHTML = message
}
