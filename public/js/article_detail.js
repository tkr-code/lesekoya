$(document).ready(function () {
    //charge les commentaires
    function loadComment() {
        $.ajax({
            url: "{{ path('comment_load',{id:article.id}) }}",
            method: "POST",
            type: 'json',
            beforeSend: function () {
                $('.js-loader-text').text('Actualisation en cour ...')
                $('.js-loader').css('display', 'flex')
            },
            success: function (data) {
                $('.js-loader').css('display', 'none')
                $('#load_comment').html(data.content)
            }
        })
    }

    //Charge le modal de modifications des commentaires
    $(document).on('click', '#btn-modal-comment', function (e) {
        e.preventDefault()
        $('.star').css('color', '#ccc')
        $('#modal-default').modal('show')
        $('#modal-default .modal-title').text('Modifier votre commentaire')
        let path = $(this).data('path')
        $.ajax({
            url: path,
            method: "POST",
            type: 'json',
            beforeSend: function () {
                $('.modal-js-loader-text').text('chargement du commentaire en cour ...')
                $('.modal-js-loader').css('display', 'flex')
                $('#modal-default .modal-body').css('dispay', 'none')
            },
            success: function (data) {
                $('.modal-js-loader').css('display', 'none')
                $('#modal-default .modal-body').html(data.content)
            }
        })
        $('#modal-default .modal-footer').hide()
    })

    $(document).on('click', '#btn-edit-comment', function (e) {
        e.preventDefault()
        if ($('#rating-edit').val() == '') {
            Swal.fire({
                icon: 'warning',
                title: 'Donnez une note.',
                showConfirmButton: false,
                timer: 2000
            })
            return
        }
        if (($('#comment_content_edit').val().length) <= 10) {
            Swal.fire({
                icon: 'warning',
                title: 'Le commentaire doit etre supérieur à 10 caractères.',
                showConfirmButton: false,
                timer: 2000
            })
            return
        }
        let rating = $('#rating-edit').val()
        let content = $('#comment_content_edit').val()
        let path = $(this).data('path')
        $.ajax({
            url: path,
            method: 'POST',
            type: 'json',
            beforeSend: function () {
                $('.modal-js-loader-text').text('Modification en cour ...')
                $('.modal-js-loader').css('display', 'flex')
                $('#modal-default .modal-body').css('display', 'none')
            },
            data: {
                ajax: true,
                rating: rating,
                content: content
            },
            success: function (data) {
                $('.js-loader').css('display', 'none')
                Swal.fire({
                    icon: 'success',
                    title: 'Le commentaire a été modifié.',
                    showConfirmButton: false,
                    timer: 2000
                })
                loadComment()
                $('#modal-default').modal('hide')
                $('#modal-default .modal-body').css('display', 'initial')
                $('#modal-default .modal-body').html(data.content)
            },
            error: function () {
                $('.js-loader').css('display', 'none')
                Swal.fire({
                    icon: 'warning',
                    title: 'Une erreur est survenue',
                    showConfirmButton: false,
                    timer: 2000
                })
            }
        })
    })

    $(document).on('click', '#btn-add-comment', function (e) {
        e.preventDefault()
        if ($('#rating').val() == '') {
            Swal.fire({
                icon: 'warning',
                title: 'Donnez une note.',
                showConfirmButton: false,
                timer: 2000
            })
            return
        }

        if (($('#comment_content').val().length) <= 10) {
            Swal.fire({
                icon: 'warning',
                title: 'Le commentaire doit etre supérieur à 10 caractères.',
                showConfirmButton: false,
                timer: 2000
            })
            return
        }
        $('#form_comment').submit()
    })

    $('.star').css('color', '#ccc')
    //Active l'etoile 1
    $(document).on('click', '.star-1', function (e) {
        e.preventDefault()
        $('.star').css('color', '#2d2e80')
        $('.star-1').css('color', '#bf8040')
        $('#rating').val(20)
        $('#rating-edit').val(20)
    })
    //Active l'etoile 2
    $(document).on('click', '.star-2', function (e) {
        e.preventDefault()
        $('.star').css('color', '#2d2e80')
        $('.star-1, .star-2').css('color', '#bf8040')
        $('#rating').val(40)
        $('#rating-edit').val(40)
    })
    //Active l'etoile 3
    $(document).on('click', '.star-3', function (e) {
        e.preventDefault()
        $('.star').css('color', '#2d2e80')
        $('.star-1, .star-2, .star-3').css('color', '#bf8040')
        $('#rating').val(60)
        $('#rating-edit').val(60)
    })
    //Active l'etoile 4
    $(document).on('click', '.star-4', function (e) {
        e.preventDefault()
        $('.star').css('color', '#2d2e80')
        $('.star-1, .star-2, .star-3, .star-4').css('color', '#bf8040')

        $('#rating').val(80)
        $('#rating-edit').val(80)
    })
    //Active l'etoile 5
    $(document).on('click', '.star-5', function (e) {
        e.preventDefault()
        $('.star').css('color', '#2d2e80')
        $('.star-1, .star-2, .star-3, .star-4, .star-5').css('color', '#bf8040')
        $('#rating').val(100)
        $('#rating-edit').val(100)
    })
})