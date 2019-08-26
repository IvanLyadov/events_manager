	jQuery(document).ready(function($) {
		// $(document).on('change', '.person-input', function() {
		// 	$('.person-label').removeClass('person-active');
		// 	$(this).parent('.person-label').addClass('person-active');
		// });
		$(document).on('change', '#recall', function() {
			if ( $(this).is(':checked')	) {
				$(this).siblings('.recall-check').addClass('recall-checkactive');
			}else{
				$(this).siblings('.recall-check').removeClass('recall-checkactive');
			}
		});

		$(document).on('change', '#recall-2', function() {
			if ( $(this).is(':checked')	) {
				$(this).siblings('.recall-check').addClass('recall-checkactive');
			}else{
				$(this).siblings('.recall-check').removeClass('recall-checkactive');
			}
		});

		$(document).on('change', '#recall-3', function() {
			if ( $(this).is(':checked')	) {
				$(this).siblings('.recall-check').addClass('recall-checkactive');
			}else{
				$(this).siblings('.recall-check').removeClass('recall-checkactive');
			}
		});

		document.addEventListener("DOMContentLoaded", function() {
		    var elements = document.getElementsById("recall");
		    for (var i = 0; i < elements.length; i++) {
		        elements[i].oninvalid = function(e) {
		            e.target.setCustomValidity("");
		            if (!e.target.validity.valid) {
		                e.target.setCustomValidity("This field cannot be left blank");
		            }
		        };
		        elements[i].oninput = function(e) {
		            e.target.setCustomValidity("");
		        };
		    }
		})


		$('#trainings-tabs a').click(function (e) {
		  e.preventDefault()
		  $(this).tab('show')
		})

		$(document).on('click', '.delete-link', function(event) {
			var confirmCheck = confirm("Czy na pewno chcesz usunąć?");
			if (confirmCheck == false) {
				event.preventDefault();
				console.log("not confirmed")
			}
			console.log("confirmed")
		});
		$(function () {
		  $('[data-toggle="tooltip"]').tooltip()
		})
	});
	$("#menu-toggle").click(function(e) {
	        e.preventDefault();
	        $("#wrapper").toggleClass("active");
	});
