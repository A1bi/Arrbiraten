$(function () {
	var actions = ["pics", "reupload"];
	
	$.each(actions, function (key, action) {
		$(".story .actions .s_"+action).click(function () {
			var _this = this;
			$.each(actions, function (key2, action2) {
				var obj = $(_this).parent().parent().find("."+action2);
				if (action2 == action) {
					obj.slideDown();
				} else if (obj.is(":visible")) {
					obj.slideUp();
				}
			});
		});
	});
});