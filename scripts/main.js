/** @format */

$(document).ready(function () {
	'use strict';

	// Form

	const contactForm = () => {
		const form = $('#contactForm');

		if (form.length > 0) {
			form.validate({
				rules: {
					name: 'required',
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
					name: 'Please enter your name',
					email: 'Please enter a valid email address',
					message: 'Please enter a message',
				},
				errorPlacement: function (error, element) {
					error.appendTo(element.closest('.form-group'));
				},
				highlight: function (element) {
					$(element).closest('.form-group').addClass('has-error');
				},
				unhighlight: function (element) {
					$(element).closest('.form-group').removeClass('has-error');
				},
				success: function (label) {
					label.closest('.form-group').removeClass('has-error');
				},
				submitHandler: function (form) {
					const submitButton = $('.submitting');
					const waitText = 'Submitting...';

					$.ajax({
						type: 'POST',
						url: 'php/send-email.php',
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
								.html('Something went wrong. Please try again.')
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
