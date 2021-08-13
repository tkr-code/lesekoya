window.onload = () =>{
    //Gestion des button supprimmer
    let links = document.querySelectorAll("[data-delete]")
    //on boucle sur links
    for(link of links){
        //on ecoute le click
        link.addEventListener('click',function(e){
            e.preventDefault()
            // on demande confirmation
            if(confirm("Voulez vous supprimr cettre image")){
                // on envoi une requette ajax
                fetch(this.getAttribute("href"),{
                    method: 'DELETE',
                    headers: {
                        'X-Requested-with': 'XMLHttpRequest',
                        'Content-Type': 'application/json'
                    },
                    body:JSON.stringify({'_token':this.dataset.token})
                }).then(
                    //on recuppere la reponse
                    response => response.json()
                ).then(data => {
                    if(data.success)
                        this.parentElement.remove()
                    else
                        alert(data.error)
                }).catch( error => alert(error))
            }
        })
    }
}