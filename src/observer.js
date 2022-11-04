let presentation_title = document.querySelector('.presentation-title')
let presentation_paragraphe = document.querySelector('.presentation-paragraphe')

function callback(entries){
    entries.forEach(entry => {
        if(entry.intersectionRatio > 0.5){
            
            entry.target.classList.add('visible')
        }
    })
}

let Observer = new IntersectionObserver(callback, {
   threshold: [0.5] 
})

export default function Observe(){
    Observer.observe(presentation_title)
    Observer.observe(presentation_paragraphe)
}