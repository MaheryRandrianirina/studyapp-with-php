import { loadContent } from "./home"
import { createDialog, removeDialog } from "./stopRevision"

/**
 * allows to use ajax object and
 * waits for json response
 * @param {Array} data 
 * @param {Object} options
 */
export default function xhr(data = undefined, options = {})
{
    let xhr = new XMLHttpRequest()
    
    xhr.onload = ()=>{
        //on doit pouvoir vérifier que la response est un objet json ou non
        //mais là, on s'en tient à ce qu'elle soit toujours du json
        let response = JSON.parse(xhr.responseText)

        if(response.success){
            console.log("success")
            //IL RESTE CE CAS D'OUVERTURE D'UNE BOITE DE DIALOGUE
            if(options.openDialog){
                console.log("send message")
                createThenRemoveDialog(response.success)
            }
        }else if(response.fail){
            console.log("success")
            if(options.openDialog){
                createThenRemoveDialog(response.fail)
            }
        }
        
    }

    xhr.open(options.method, options.url)

    if(data !== undefined){
        let formdata = new FormData()
        
        for(const d of data){
            formdata.append(d.name, d.value)
        }
        
        xhr.send(formdata)
    }else{
        xhr.send()
    }
    
}

function createThenRemoveDialog(message){
    let dialog = createDialog("dialog", `
    <p>${message}</p>
    `)

    setTimeout(()=>{
        removeDialog({
            dialog: dialog,
            body: document.body
        }, "removeDialog")
    }, 3000)
}