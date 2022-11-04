/**
 * crée une barre de progression
 * @param {object} XHRandData 
 * @return response
 */
export default function createProgressBar(XHRandData)
{
    let progressBar = document.createElement('div')
    let body = document.querySelector('body')
    let responseToReturn
    progressBar.className = "progress-bar"
    body.appendChild(progressBar)

    XHRandData.ajax.onreadystatechange = ()=>{
        let addWidthToProgressbar = window.innerWidth / 4
        let width = 0
        
        
        for(let i = 0; i < XHRandData.ajax.readyState; i++){
            width += addWidthToProgressbar
            progressBar.style.width = width + "px"
        }

        if(XHRandData.ajax.readyState === 4){
            let response = JSON.parse(XHRandData.ajax.responseText) 
            responseToReturn = response
            if(response.success !== undefined){
                alert(response.success)
            }else if(response.fail !== undefined){
                alert(response.fail)
            }
            
            setTimeout(()=>{
                body.removeChild(progressBar)
            }, 1000)
        }
    }

    return responseToReturn
}