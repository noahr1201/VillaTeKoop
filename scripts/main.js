/** @format */

$(document).ready(function () {
	'use strict';

	// Form

	const contactForm = () => {
		const form = $('#contactForm');

		if (form.length > 0) {
			$.validator.setDefaults({
				errorClass: 'help-block',
				errorElement: 'div',
				errorPlacement: function (error, element) {
					error.insertAfter(element);
				},
				highlight: function (element) {
					$(element).closest('.form-group').addClass('has-error');
				},
				unhighlight: function (element) {
					$(element).closest('.form-group').removeClass('has-error');
				},
			});

			form.validate({
				rules: {
					name: {
						required: true,
					},
					email: {
						required: true,
						email: true,
					},
					message: {
						required: true,
						minlength: 5,
					},
				},
				messages: {
					name: {
						required: 'Vul uw naam in',
					},
					email: 'Voer een geldig e-mailadres in',
					message: 'Voer een bericht in',
				},
				submitHandler: function (form) {
					const submitButton = $('.submitting');
					const waitText = 'Bezig met verzenden...';

					$.ajax({
						type: 'POST',
						url: 'php/submit-form.php',
						data: $(form).serialize(),
						beforeSend: function () {
							submitButton.css('display', 'block').text(waitText);
							form.find(':submit').prop('disabled', true); // Disable submit button
						},
						success: function (msg) {
							if (msg === 'OK') {
								$('#form-message-warning').hide();
								setTimeout(function () {
									form.fadeOut();
								}, 1000);
								setTimeout(function () {
									$('#form-message-success').fadeIn();
								}, 1400);
							} else {
								$('#form-message-warning').html(msg).fadeIn();
								submitButton.css('display', 'none');
							}
						},
						error: function () {
							$('#form-message-warning')
								.html('Er is iets misgegaan. Probeer het opnieuw.')
								.fadeIn();
							submitButton.css('display', 'none');
							form.find(':submit').prop('disabled', false); // Enable submit button
						},
					});
				},
			});

			// Real-time validation on keyup
			form.find('input, textarea').on('keyup', function () {
				$(this).valid();
			});
		}
	};

	contactForm();
});
