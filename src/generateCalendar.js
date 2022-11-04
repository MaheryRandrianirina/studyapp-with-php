import generateRepetitionsCalendar, { createWarning } from "./generateRepetitionsCalendar"

let tbody

export default function generateCalendarFunc(e){
    
    tbody = document.querySelector('.calendar-creation-tbody')
    //contient les tous les tr
    let subjectsLines = Array.from(document.querySelectorAll('.subject-line'))
    // nécessaire pour différencier le "name" d'un input. Il sera incrémenté à chaque fois qu'il y a une nouvelle ligne
    let number = subjectsLines.length
    //contient les inputs dont la la revision est de type exercice
    let isExercise = []
    //contient les td qui contiennent les inputs
    let inputsContainer = []
    //contient les inputs eux-mêmes
    let inputs = []
    //contient tous les input de type date
    let dateInputs = []
    //contient tous les input qui ont la même date
    let inputsWithSameDate = {}
    //contient toutes les lignes(tr) qui ont la même date et heure où l'on trouvera ceux dont la date devrait être rajoutée +2
    let newLineWithSameDate = {}
    let sameDate = {}
    //0 si l'utilsateur a fait une erreur de remplissage d'emploi du temps (quotas 3 leçons / j)
    let isWarning = 0

    
    /**
     * contient les elements à repeter
     * @var toRepeat {}
     */
    let toRepeat = {}

    subjectsLines.forEach(line => {
        inputsContainer.push(line.querySelectorAll('input'))        
    })

    inputsContainer.forEach(lineInputs => {
        lineInputs.forEach(lineinput => {
            inputs.push(lineinput)
        })
             
    })
    
    for(let x = 0; x < inputs.length; x++){
        if(inputs[x].id === "date-input"){
            dateInputs.push(inputs[x])
        }
    }

    for(let n = 0; n < dateInputs.length; n++){
        // si l'element n + 1 du tableau existe (cad on est toujours dans le tableau)
        if(dateInputs[n + 1] !== undefined){
            //si les 2 elements qui se suivent ont les mêmes valeurs
            if(dateInputs[n].value === dateInputs[n + 1].value){
                /*s'il n'existe pas encore aucun tableau contenant les elements avec les mêmes valeurs(date),
                on le crée puis on push les elements qui se suivent. Sinon on push seulement la prochaine element
                */
                if(inputsWithSameDate[dateInputs[n].value] === undefined){
                    inputsWithSameDate[dateInputs[n].value] = []
                    inputsWithSameDate[dateInputs[n].value].push(dateInputs[n])
                    inputsWithSameDate[dateInputs[n].value].push(dateInputs[n + 1])
                }else{
                    inputsWithSameDate[dateInputs[n].value].push(dateInputs[n + 1])
                }
            }else{
                
                if(inputsWithSameDate[dateInputs[n].value] === undefined){
                    
                    inputsWithSameDate[dateInputs[n].value] = []
                    inputsWithSameDate[dateInputs[n].value].push(dateInputs[n])
                }else{
                    if(inputsWithSameDate[dateInputs[n + 1].value] === undefined){
                        inputsWithSameDate[dateInputs[n + 1].value] = []
                        inputsWithSameDate[dateInputs[n + 1].value].push(dateInputs[n + 1])
                    }
                }
                
            }
        }else{
            if(inputsWithSameDate[dateInputs[n].value] === undefined){
                inputsWithSameDate[dateInputs[n].value] = []
                inputsWithSameDate[dateInputs[n].value].push(dateInputs[n])
            }  
        } 
    }

    let n = 0
    for(let date in inputsWithSameDate){
        inputsWithSameDate[date].forEach(input => {
            
            let parent = input.parentElement.parentElement
            let chapterInput = parent.querySelector('#chapter-input')
            
            if(chapterInput.value.includes("exercice")){
                n++
                isExercise[date] = n
            }else{
                // si le tableau n'exsite pas encore, on le crée
                if(toRepeat[date] === undefined){
                    toRepeat[date] = []
                }
                //dans tous les cas on push
                toRepeat[date].push(chapterInput.parentElement.parentElement)
            }
        })
    }
    
    for(let d in inputsWithSameDate){
        if(inputsWithSameDate[d].length < 4){
            toRepeat[d].forEach(element => {
                generateRepetitionsCalendar(number, element)
                
            })
        }
        
        switch(inputsWithSameDate[d].length){

            case 4: 
                if(isExercise[d] >= 1){
                    if(isWarning === 0){
                        toRepeat[d].forEach(element => {
                            generateRepetitionsCalendar(number, element)
                        })
                    }
                }else{
                    isWarning = 1
                    focusOnElementsAfterWarning(toRepeat[d])
                    createWarning("Erreur du quota 3 matières/j. Il faut au moins que l'une d'entre elles soient un exercice.")
                }
                break
            case 5:
                if(isExercise[d] >= 2){
                    if(isWarning === 0){
                        toRepeat[d].forEach(element => {
                            generateRepetitionsCalendar(number, element)
                        })
                    }
                }else{
                    isWarning++
                    focusOnElementsAfterWarning(toRepeat[d])
                    createWarning("Erreur du quota 3 matières/j. Il faut au moins que deux d'entre elles soient un exercice.")
                }
                break      
        }
    }
    //mise à jour de subjectLines car de nouveaux elements ont été rajoutés 
    subjectsLines = tbody.querySelectorAll('tr')
    
    subjectsLines.forEach(line => {
        let date = line.querySelector('#date-input').value
        let hour = line.querySelector('#hour-input').value
        
        if(sameDate[date] === undefined){
            sameDate[date] = []
        }
        
        if(newLineWithSameDate[date + hour] === undefined){
            newLineWithSameDate[date + hour] = []
        }
        newLineWithSameDate[date + hour].push(line)  
        sameDate[date].push(line)
    })
    
    // cas où plusieurs revisions sont dans la même heure
    SpaceEveryRevisionIfTimesAreSemblables(newLineWithSameDate)

    // cas où l'espace entre plusieurs revisions de la même journée est  < 2h
    
    SpaceEveryRevisionIfTimesAreSemblables(sameDate, true)
    
}

/**
 * focus sur les elements dont l'un ou plusieurs d'entre eux doivent être un exercice
 * @param {Array} toRepeatElements element tr où trouver l'element à focus
 */
 function focusOnElementsAfterWarning(toRepeatElements){
    toRepeatElements.forEach(el => {
        el.querySelector('#chapter-input').classList.add('focus-for-warning')
    })
}

/**
 * Ajuste l'heure en ajoutant 2 ou 1h de plus selon le cas s'il existe plusieurs revision à la même heure 
 * ou l'espace entre 2 revisions fait moins de 2h
 * @param {{key: []}} ObjectToLoop 
 * @param {{lastHour: number, lastHourInput: HTMLInputElement | undefined}} OptionsForUnderTwoHourSpacement 
 */
function SpaceEveryRevisionIfTimesAreSemblables(ObjectToLoop, OptionsForUnderTwoHourSpacement = false){
    let lastHour = 0
    let lastHourInput
    for(let date in ObjectToLoop){
        const length = ObjectToLoop[date].length

        if(length > 1){
            for(let i = 0; i < length; i++){
                let hour = ObjectToLoop[date][i].querySelector('#hour-input')
                let arrayFromHour = hour.value.split(':')
                let hourValue = parseInt(arrayFromHour[0])
                if(!OptionsForUnderTwoHourSpacement){
                    if(i >= Math.floor(length / 2)){
                        AddNewHourValue({
                            hourValue: hourValue,
                            valueToAdd: 2
                        }, hour, arrayFromHour[1])
                    }
                }else{
                    console.log(ObjectToLoop)

                    if(lastHour > 0){
                        console.log(hourValue + '---' + lastHour)
                        if(hourValue > lastHour){
                            
                            if((hourValue - lastHour) < 2 && (hourValue - lastHour) > 0){
                                
                                AddNewHourValue({
                                    hourValue: hourValue,
                                    valueToAdd: 1
                                }, hour, arrayFromHour[1])
                            }
                        }else if(lastHour > hourValue){
                            
                            if((lastHour - hourValue) < 2 && (lastHour - hourValue) > 0){
                                console.log('under 2h 2')
                                AddNewHourValue({
                                    hourValue: lastHour,
                                    valueToAdd: 1
                                }, lastHourInput, arrayFromHour[1])
                            }
                        }
                        
                    }
    
                    lastHour = hourValue
                    lastHourInput = hour
                }
                
            } 
        }
          
    }
}

/**
 * Rajoute la nouvelle valeur de l'heure de revision pour chaqun suivant la fonction SpaceEveryRevisionIfTimesAreSemblables
 * @param {{hourValue: number, valueToAdd: number}} hourProperties 
 * @param {HTMLInputElement} hourInput 
 * @param {number} minutes 
 */
function AddNewHourValue(hourProperties, hourInput, minutes){
    let newHour = hourProperties.hourValue + hourProperties.valueToAdd
    console.log(hourInput)
    hourInput.value = newHour + ':' + minutes
}
