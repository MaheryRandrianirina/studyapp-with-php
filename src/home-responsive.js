
export default class HomeResponsive {
    constructor(){
        console.log('home responsive')
        this.resize()
        window.addEventListener('resize', this.resize.bind(this))
    }

    resize(e){
        if(window.innerWidth <= 600){
            this.sidebarLeft = document.querySelector('.sidebar-left')
            this.userProfileRight = document.querySelector('.user-profile-right')
            if(!this.sidebarLeft.classList.contains('set-display-none') && !this.userProfileRight.classList.contains('set-display-none')){
                this.sidebarLeft.classList.add('set-display-none')
                this.userProfileRight.classList.add('set-display-none')
                if(this.userProfileRight.previousElementSibling !== null){
                    this.userProfileRight.previousElementSibling.style.width = "100%"
                }
                
            }
            
            this.makeMenu()
            
        }
    }

    makeMenu(){
        if(document.querySelector('.menu-button-container') === null){
            this.menuButtonContainer = this.createElement('div', 'menu-button-container')
            this.bars = this.createElement('i', 'fas fa-bars bar-menu')
            
            document.body.appendChild(this.menuButtonContainer)
            this.menuButtonContainer.appendChild(this.bars)

            this.menuButtonContainer.addEventListener('click', this.showHamburgerMenu.bind(this))
        }
         
    }

    showHamburgerMenu(e){
        if(document.querySelector('.hamburger-menu') !== null){
            console.log("fermer le menu")
            this.hamburgerMenu.classList.remove('active-hamburger')
            this.changeIcon(document.querySelector('.quit-hamburger-menu'), this.bars)
            this.hamburgerMenu.addEventListener('transitionend', ()=>{
                if(this.hamburgerMenu.parentElement !== null){
                    this.hamburgerMenu.parentElement.removeChild(this.hamburgerMenu)
                }
                
            })
           
            return
        }

        this.hamburgerMenu = this.createElement('div', 'hamburger-menu')
        this.bars.classList.add('change-icon')
        
        document.body.appendChild(this.hamburgerMenu)
        this.hamburgerMenu.offsetWidth
        this.hamburgerMenu.classList.add('active-hamburger')
        this.hamburgerMenu.appendChild(this.userProfileRight)
        let icons = this.sidebarLeft.querySelectorAll('i')
        let countSpan = 0
        icons.forEach(i => {
            countSpan++
            if(i.querySelector(`.count-${countSpan}`) === null){
                let span = this.createElement('span', `menu-name count-${countSpan}`)
                span.innerHTML = i.getAttribute('data-name')
                i.appendChild(span) 
            }
        })
        
        this.hamburgerMenu.appendChild(this.sidebarLeft)
    
        if(this.userProfileRight.classList.contains('set-display-none') && this.sidebarLeft.classList.contains('set-display-none')){
            this.userProfileRight.classList.remove('set-display-none')
            this.sidebarLeft.classList.remove('set-display-none')
            this.userProfileRight.classList.add('inside-hamburger-user-profile')
            this.sidebarLeft.classList.add('inside-hamburger-precedent-sidebar')
            //this.sidebarLeft.querySelector()
        }
        
        setTimeout(()=>{
            this.changeIcon(this.bars, this.createElement('i', 'fa-solid fa-xmark quit-hamburger-menu'))
        },300)
            
        
        
    }

    /**
     * change l'icone du menu hamburger
     * @param {HTMLElement} icon
     * @param {HTMLElement} newIcon
     */
    changeIcon(icon, newIcon){
        if(icon.classList.contains('active')){
            icon.classList.remove('active')
        }
        
        icon.parentElement.removeChild(icon) 
        
        this.hamburgerMenu.appendChild(this.menuButtonContainer)
        if(newIcon.classList.contains('bar-menu')){
            document.body.appendChild(this.menuButtonContainer)  
            this.menuButtonContainer.classList.remove('inside-hamburger') 
        }else{
            this.menuButtonContainer.classList.add('inside-hamburger')
        }
        this.menuButtonContainer.appendChild(newIcon)
        
        newIcon.offsetWidth
        if(newIcon.classList.contains('bar-menu')){
            icon.classList.remove('active')
            newIcon.classList.remove('change-icon')
        }else{
            newIcon.classList.add('active')
        }
        

    }

    createElement(type, className = null){
        let element = document.createElement(type)

        if(className !== null){
            element.className = className
        }
        
        return element
    }
}