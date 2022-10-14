$(document).ready(function(){
		//VISUSALISE UNE COMMANDE
		$(document).on('click', '.js-order-view', function (e) {
			e.preventDefault()
			let href = $(this).attr('href')
			$.ajax({
				url: href,
				method: 'POST',
				type: 'json',
				data: {
					ajax:true
				},
				beforeSend: function () {
					$('.js-loader-text').text('Chargement de la commande en cour ...')
					$('.js-loader').css('display', 'flex')
				},
				success: function (data) {
					$('.js-loader').css('display', 'none')
					if (data.reponse == true) {
						$('#modal-order-view').html(data.content)
						$('#order-view-modal').modal('show')
					} else {
						alert('Une erreur est servenue')
					}
				},
				error: function () {
					$('.js-loader').css('display', 'none')
					alert('Une erreur est servenue')
				}
			})
		})

		// ANNULE UNE COMMANDE
		$(document).on('click', '.js-order-canceled', function (e) {
			e.preventDefault()
			let id = $(this).data('id')
			let page = $(this).data('page')
			let href= $(this).attr('href')
			let token = 'token'
			Swal.fire({
				title: 'Etes vous sur ?',
				text: "Vous allez annuler cette commande !",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Oui, Annuler',
				cancelButtonText: 'Fermer'
			}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						url: href,
						method: 'POST',
						type: 'json',
						data: {
							token : token,
							ajax:true
						},
						beforeSend: function () {
							$('.js-loader-text').text('Annulation de la commande en en cour ...')
							$('.js-loader').css('display', 'flex')
						},
						success: function (data) {
							$('.js-loader').css('display', 'none')
							if (data.reponse) {
								Swal.fire({
									title: 'Modification enregistrée',
									icon: 'success',
								}).then((result) => {
									if(page == 'order_index'){
										window.location.href = "/admin/order/"
									}else{
										window.location.href = "/customer?tab=orders"
									}
								})
							} else {
                                $('.js-loader').css('display', 'none')
								alert('Une erreur est survenue. code : 002')
							}
						},
						error: function () {
							$('.js-loader').css('display', 'none')
							alert('Une erreur est survenue. code : 001')
						}
					})
				}
			})
		})

		

})