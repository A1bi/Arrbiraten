$(function () {
	$("form").submit(function () {
		if ($(":file", this).length) {
			var submit = $(":submit", this);
			var newSubmit = submit.clone().val("bitte warten...").attr("disabled", "disabled");
			submit.hide().after(newSubmit);
		}
	});
});