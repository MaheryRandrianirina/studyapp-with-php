
const canvas = document.getElementById('canvas')
const ctx = canvas.getContext("2d")
const canvasRect = canvas.getBoundingClientRect()

var bulles = []
/**
 * représente une bulle
 */
class Bulle {
    constructor(x, y, r, c){ 
        this.x = x
        this.y = y
        this.r = r
        this.c = c
        this.dx = (Math.random() * 1.5) + 0.5
        this.dy = (Math.random() * 1.5) + 0.5
        
    }

    draw(){
        ctx.beginPath()
        ctx.fillStyle = this.c
        ctx.arc(this.x, this.y, this.r, 0, 2*Math.PI)
        ctx.fill()
    }

    aplicateGradient(){
        let linearGradient = ctx.createLinearGradient(this.x, this.y, (this.x + this.r * 2), (this.y + this.r * 2))
        linearGradient.addColorStop(0, "#025e73bd")
        linearGradient.addColorStop(0.5, "#025e738a")
        linearGradient.addColorStop(1, "#025e7313")
        this.c = linearGradient
    }

    animate(){
        this.x += this.dx
        this.y -= this.dy
        
        if((this.x - this.r) > canvas.width || (this.y + this.r) < 0) {
            this.x = Math.random() * (canvas.width - this.r * 2) + this.r
            this.y = Math.random() * (canvas.height - this.r * 2) + this.r
            
        }
        this.draw()
    }
}

for(let i = 0; i < 10; i++){
    let x = Math.random() * (canvas.width - r * 2) + r
    let y = Math.random() * (canvas.height - r * 2) + r
    let r = Math.floor(Math.random() * 10) + 5
    let c = "#888C80"

    bulles.push(new Bulle(x, y, r, c))
}

export default function UpdateBulleAnimation(){
    ctx.clearRect(0, 0, canvas.width, canvas.height)

    for(let i = 0; i < bulles.length; i++){
        bulles[i].animate()
    }
    
    requestAnimationFrame(UpdateBulleAnimation)
}











