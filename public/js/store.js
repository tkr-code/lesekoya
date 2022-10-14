$(document).ready(function(){
    //Copier un lien
    $(document).on('click', '.copie', function (e) {
        e.preventDefault()
        navigator.clipboard.writeText($(this).data('text'));
        Swal.fire({
            icon: 'success',
            title: "Le lien de l'article a été copié",
            showConfirmButton: false,
            timer: 2000
        })
    })
})