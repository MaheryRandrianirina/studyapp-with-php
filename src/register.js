import css from "./app.scss"
import Carousel from "./carousel"
import formObserver from "./form"

document.body.removeAttribute('class')

function formInteraction(){
    let formContainers = document.querySelectorAll('.input-container')

    formContainers.forEach(container => {
        let containerChildren = Array.from(container.children)
        container.addEventListener('click', containerClick)
        containerChildren.forEach(cc => {
            cc.addEventListener('focus', containerClick)
        })

        function containerClick(e){
            
            let container = e.currentTarget
            if(container.classList.contains('input-container')){
                toggleContainerFocus()
            }else{
                container = container.parentElement
                toggleContainerFocus()
            }
        
            function toggleContainerFocus(){
                formContainers.forEach(c => {
                    c.classList.remove('active-container')
                })
                container.classList.add('active-container')
            }  
        }   
    })
}


window.addEventListener('DOMContentLoaded', ()=>{
    formInteraction()
    new Carousel(document.querySelector('.register-form-container'))
})
formObserver()