<script>
	$(function () {
		$("#method input").click(function () {
			var hidden = $(".hidden");
			var val = $(this).val();
			hidden.eq(val).slideDown();
			hidden.eq(val == 1 ? 0 : 1).slideUp();
		});
	});
</script>