export default function addLine (number){
    let tr = document.createElement('tr')
    let removeLine = document.querySelector('.remove-line')
    let addLineButton = document.querySelector('.add-line')
    let addButtonContainer = addLineButton.parentElement
    let subjectLine = addLineButton.parentElement.parentElement
    let generateCalendarButton = subjectLine.querySelector('.generate-calendar')
    let generateCalendarButtonContainer = generateCalendarButton.parentElement
    let calendarCreationTbody = document.querySelector('.calendar-creation-tbody')
    tr.className = 'subject-line'

    //on supprime le bouton
    subjectLine.removeChild(addButtonContainer)
    subjectLine.removeChild(generateCalendarButtonContainer)
    
    if(removeLine !== null){
    removeLine.parentElement.parentElement.removeChild(removeLine.parentElement) 
    }
    
    calendarCreationTbody.appendChild(tr)
    
    tr.innerHTML = `
    <td><input type='text' name='subject-${number}' id='subject-input'></td>
    <td><input type='text' name='chapter-${number}' id='chapter-input'></td>
    <td><input type='date' name='date-${number}' id='date-input'></td>
    <td><input type='time' name='hour-${number}' id='hour-input'></td>
    <td><i class='fas fa-plus add-line'></i></td>
    <td><i class='fas fa-check generate-calendar'></i></td>
    <td><i class='fas fa-window-close remove-line'></i></td>
    `
    
    //on reassigne une valeur à removeLine car une ligne vient d'être ajouté et elle pouvait être vide au début
    removeLine = document.querySelector('.remove-line')
    if(removeLine !== null){
        removeLine.addEventListener('click', ()=>{
            const removeButton = removeLine.parentElement
            removeButton.parentElement.classList.add('invisible-subject-line')
            
            removeButton.parentElement.addEventListener('animationend', ()=>{
                calendarCreationTbody.removeChild(removeButton.parentElement)
                calendarCreationTbody.lastElementChild.appendChild(addButtonContainer)
                calendarCreationTbody.lastElementChild.appendChild(generateCalendarButtonContainer)
                if(calendarCreationTbody.firstElementChild !== calendarCreationTbody.lastElementChild){
                    calendarCreationTbody.lastElementChild.appendChild(removeButton)
                }
            })    
        })
    }
    
}