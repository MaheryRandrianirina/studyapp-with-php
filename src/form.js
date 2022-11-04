function pushElement(elementToPush, elements){
    if(!elements.includes(elementToPush)){
        elements.push(elementToPush)
    }
}

function removeElement(element, elements){
    if(elements.includes(element)){
        let index = elements.indexOf(element)
        elements.splice(index, 1)
    }
}

export default function formObserver(){
    let elements = [
        document.getElementById('pwd'),
        document.getElementById('pwd-confirm')
    ]
    
    let condition_completed = []
    const submitButton = document.querySelector('.submitBtn')
    
    elements.forEach(el => {
        if(el !== null){
            el.addEventListener('keyup', keyUp)
        }
         
    })

    /**
     * vérifie si les conditions sont remplies.
     * si oui, applique les changements.
     * @param {event} e 
     */
    function keyUp(e){
        e.preventDefault()
        
        let array_of_input_valueArray = elements.map(el => {
            
            if(el !== null){
                return el.value.split("")
            }else{
                elements.pop()
            }
            
        })
        
        let letters_number_condition = document.querySelector('.letters_number_condition')
        let one_number_condition = document.querySelector('.one_number_condition')
    
        let active_opacity = 1
        let not_active_opacity = 0.3
        
        array_of_input_valueArray.forEach(arr => {
            let input_value = arr
            
            if(input_value !== undefined && input_value.length >= 8){
                letters_number_condition.style.opacity = active_opacity
                letters_number_condition.previousElementSibling.style.opacity = active_opacity
        
                pushElement("first", condition_completed)
                
                
            }else{
                letters_number_condition.style.opacity = not_active_opacity
                letters_number_condition.previousElementSibling.style.opacity = not_active_opacity
        
                removeElement("first", condition_completed)
                
            }
        })

        array_of_input_valueArray.forEach(arr => {
            let array_of_input_value = arr
            let numbers = []
            /**
             * il n'y a de traitement que pour seulement l'element existant
             */
            if(array_of_input_value !== undefined){
                array_of_input_value.forEach(elem => {
                
                    if(parseInt(elem)){
                        numbers.push(elem)
                        
                    }
                    
                })

                if(numbers.length >= 1){
                    one_number_condition.style.opacity = active_opacity
                    one_number_condition.previousElementSibling.style.opacity = active_opacity
                    
                    pushElement("second", condition_completed)
                    
                }else{
                    one_number_condition.style.opacity = not_active_opacity
                    one_number_condition.previousElementSibling.style.opacity = not_active_opacity
            
                    removeElement("second", condition_completed)
                }
            }
        
            if(condition_completed.length === 2){
                submitButton.removeAttribute('disabled')
                
            }else{
                submitButton.setAttribute('disabled', 'true')
            }
            
        })
    
    }

    /**
     * se charge de l'appui sur le clavier dans le formulaire
     * @param {HTMLElement} form 
     */
    function inputInteraction(form){
        const children = Array.from(form.children)
        let results = []
        children.forEach(child => {
            
            let ch = Array.from(child.children)
            if(ch.length > 0){
                ch.forEach(c => {
                    let nodename = c.nodeName
                    if(nodename === "INPUT" || nodename === "SELECT"){
                        results.push(c)
                    }
                }) 
            }else{
                
                let nodename = child.nodeName
                if(nodename === "INPUT" || nodename === "SELECT"){
                    results.push(child)
                }
                
            }
            
        })
        
        results.forEach(r => {
            r.addEventListener('keyup', (e)=>{
                e.preventDefault()
                let index = results.indexOf(r)

                if(e.key === "Enter"){
                    let indexPlusOne = index + 1
                    if(results[indexPlusOne] === undefined){
                        results[0].focus()
                        
                    }else{
                        results[indexPlusOne].focus()
                    }  
                }
            })
        })
    }
    
    const registerForm = document.querySelector('.register-form-container')
    const loginForm = document.querySelector('.login_form')

    if(registerForm !== null){
        inputInteraction(registerForm)
    }else{
        inputInteraction(loginForm)
    } 
    
}


