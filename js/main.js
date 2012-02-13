$(function () {
	$(":submit").click(function () {
		var submit = $(this);
		if (submit.parents("form").find(":file").length) {
			var newSubmit = submit.clone().val("bitte warten...").attr("disabled", "disabled");
			submit.hide().after(newSubmit);
		}
	});
});