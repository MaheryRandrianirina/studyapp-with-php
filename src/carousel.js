export default class Carousel {
    constructor (element) {
        this.element = element
        this.elementChildren = Array.from(element.children)
        this.firstInputContainer
        this.ScreenWidthForCarousel = 630
        this.firstWindowWidth = window.innerWidth
        this.translateX = 0
        this.item = 0
        this.boundWidth = 20
        document.body.style.height = window.innerHeight + "px"
        document.querySelector('.register-form-container').style.height = (window.innerHeight - document.querySelector('.navbar').clientHeight) + "px"
        this.elementChildren.forEach(child => {
            if(this.firstInputContainer === undefined){
                this.firstInputContainer = child
            }
        })

        if(window.innerWidth <= this.ScreenWidthForCarousel){
            console.log('devient carousel')
            document.body.classList.add('become-carousel')
            this.make()
        }

        window.addEventListener('resize', this.resize.bind(this))
    }

    /**
     * s'occupe de l'évènement resize.
     */
    resize(){
        if(window.innerWidth <= this.ScreenWidthForCarousel){
            if(!document.body.classList.contains('become-carousel')){
                console.log('devient carousel')
                document.body.classList.add('become-carousel')
                this.make()
            }   
        }
    }

    /**
     * crée le carousel en fonction de la taille de l'écran
     */
    make(){
        this.element.classList.add('register-form-to-carousel')
        this.root = this.createElement('div', 'carousel-root')
        this.container = this.createElement('div', 'carousel-container')
        this.firstWindowWidth = window.innerWidth
        this.container.style.width = (this.firstWindowWidth * this.elementChildren.length) + "px"

        this.elementChildren.forEach(child => {
            let carouselItem = this.createElement('div', 'carousel-item')
            carouselItem.style.width = (this.firstWindowWidth) + "px"
            carouselItem.appendChild(child)
            this.container.appendChild(carouselItem)
            
        })

        this.root.appendChild(this.container)
        this.element.appendChild(this.root)
        this.createButtons()
        window.addEventListener('touchmove', this.touch.bind(this))
    }

    createButtons(){
        let left = this.createElement('i', "fas fa-arrow-left left-button")
        let right = this.createElement('i', "fas fa-arrow-right right-button")
        
        this.root.appendChild(left)
        this.root.appendChild(right)

        left.addEventListener('click', this.left.bind(this))
        right.addEventListener('click', this.right.bind(this))
        
    }

    left(){
        if(this.item > 0){
            this.item--
            this.moveTo(this.firstWindowWidth)
        }
    }
    right(){
        if(this.item < 2){
            this.item++
            this.moveTo(-this.firstWindowWidth)
        }
    }

    moveTo(direction){
        this.translateX += direction
        this.container.style.transform = `translateX(${this.translateX}px)` 
    }

    touch(e){
        let touches = e.changedTouches
        let firstTouch = touches[0]
        console.log(touches)
        let lastTouch
        for(let i = 0; i < touches.length; i++){
            if(touches[i+1] === undefined){
                lastTouch = touches[i]
            }
        }
        console.log(firstTouch,lastTouch)
    }
    createElement(type, className){
        let element = document.createElement(type)
        element.className = className
        return element

    }
}

