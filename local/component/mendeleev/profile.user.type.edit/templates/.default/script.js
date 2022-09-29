$(function () {
	$(".edit-email").on("click", function (e) {
		e.preventDefault();
		e.stopPropagation();
		$(".profile__edit-email").slideToggle(300);
	});
	$(".edit-email-cancel-js").on("click", function (event) {
		event.preventDefault()
		$(".profile__edit-email").slideToggle(300);
	})

	$(".edit-password").on("click", function (e) {
		e.preventDefault();
		e.stopPropagation();
		$(".profile__edit-password").slideToggle(300);
	});

	$(".edit-password-cancel-js").on("click", function (e) {
		e.preventDefault();
		e.stopPropagation();
		$(".profile__edit-password").slideToggle(300);
	});
});