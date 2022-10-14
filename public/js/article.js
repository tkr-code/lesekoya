$(document).ready(function () {
    // Ajoute un article au panier
    $(document).on('click', '.js-btn-add', function (e) {
        e.preventDefault();
        let id = $(this).data('id')
        $.ajax({
            url: "/cart/add-ajax",
            method: 'POST',
            type: 'json',
            beforeSend: function () {
                $('.js-loader-text').text('Ajout au panier en cour ...')
                $('.js-loader').css('display', 'flex')
            },
            data: {
                id: id
            },
            success: function (data) {
                loadCart()
                $('.js-loader').css('display', 'none')
                if (data) { // Alert success
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Le produit a été ajouté au panier.',
                        showConfirmButton: false,
                        timer: 2000
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Une erreur est survenu.'
                    })
                }
            },
            error: function () {
                alert('Une erreur est survenu.')
            }
        })
    })

    // SUPPRIMER UN ARTICLE DU PANIERr
    $(document).on('click', '.js-delete-cart', function (e) {
        e.preventDefault();
        let id = $(this).data('id')
        $.ajax({
            url: "/cart/delete-ajax",
            method: 'POST',
            type: 'json',
            beforeSend: function () {
                $('.js-loader-text').text('Suppression du panier en cour ...')
                $('.js-loader').css('display', 'flex')
            },
            data: {
                id: id
            },
            success: function (data) {
                loadCart()
                $('.js-loader').css('display', 'none')
                if (data) { // Alert success
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Le produit a été retiré du panier.',
                        showConfirmButton: false,
                        timer: 2000
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Une erreur est survenu.'
                    })
                }
            },
            error: function () {
                $('.js-loader').css('display', 'none')
                alert('Une erreur est survenu.')
            }
        })
    })

    // AJOUTER L'ARTICLE EN FAVORIS
    $(document).on('click', '.js-add-favoris', function (e) {
        e.preventDefault()
        let id = $(this).data('id')

        $.ajax({
            url: "/favoris/add-ajax",
            method: 'POST',
            type: 'json',
            beforeSend: function () {
                $('.js-loader-text').text('Ajout dans la liste des favoris en en cour ...')
                $('.js-loader').css('display', 'flex')
            },
            data: {
                id: id
            },
            success: function (data) { // $().html(remove)
                loadFavoris()
                $('.js-loader').css('display', 'none')
                if (data) { // changer l'icon
                    $('.article-' + id + ' .js-favoris').attr('href', "/favoris/remove/" + id)
                        .removeClass('js-add-favoris')
                        .addClass('js-remove-favoris bg-danger')
                    $('.article-' + id + ' .js-favoris span').addClass('bg-danger text-white').text('Retirer des favoris')
                    // Alert success
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Le produit a été ajouté à la liste des  favoris.',
                        showConfirmButton: false,
                        timer: 2000
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Une erreur est survenu.'
                    })
                }
            },
            error: function () {
                $('.js-loader').css('display', 'none')
                alert('Une erreur est survenu.')
            }
        })
    })

    // SUPPRIMER L'ARTICLE EN FAVORIS
    $(document).on('click', '.js-remove-favoris', function (e) {
        e.preventDefault()
        let id = $(this).data('id')

        $.ajax({
            url: "/favoris/remove-ajax",
            method: 'POST',
            type: 'json',
            beforeSend: function () {
                $('.js-loader-text').text('Suppression dans la liste des favoris en en cour ...')
                $('.js-loader').css('display', 'flex')
            },
            data: {
                id: id
            },
            success: function (data) { // $().html(remove)
                loadFavoris()
                $('.js-loader').css('display', 'none')
                if (data) { // changer l'icon
                    $('.article-' + id + ' .js-favoris').attr('href', "/favoris/add/" + id)
                    $('.article-' + id + ' .js-favoris').removeClass('js-remove-favoris bg-danger')
                    $('.article-' + id + ' .js-favoris').addClass('js-add-favoris')
                    $('.article-' + id + ' .js-favoris span').removeClass('bg-danger text-white').text('Ajouter aux favoris')
                    // Alert success
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Le produit a été retiré de la liste des  favoris.',
                        showConfirmButton: false,
                        timer: 2000
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Une erreur est survenu.'
                    })
                }
            },
            error: function () {
                alert('Une erreur est survenu.')
            }
        })
    })

    // CHARGER LE PANIER
    function loadCart() {
        $.ajax({
            url: "/cart/load",
            method: "POST",
            type: 'json',
            success: function (data) {
                $('.js-cart-load').html(data.cart)
            }
        })
    }
    // CHARGER LE PANIER
    function loadFavoris() {
        $.ajax({
            url: "favoris/load-ajax",
            method: "POST",
            type: 'json',
            success: function (data) {
                $('.wishlist').html(data)
            }
        })
    }
    //SE CONNECTER POUR METTRE EN FAVORIS
    $(document).on('click', '.js-favoris-login', function (e) {
        e.preventDefault()
        Swal.fire(
            'Oups !',
            'Merci de vous conneter pour ajouter un produit à la liste des favoris.',
            'info'
        ).then(() => {
            $('#signin-modal').modal('show')
        })
    })
})