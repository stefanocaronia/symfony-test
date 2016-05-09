$(function () {

	checkTags($("#filter-tags"));

	$("#filter-tags").on("keyup", function (e) {
		checkTags($(this));
	});

	function checkTags(input) {
		var tagstring = (typeof input != "undefined" ? input.val() : "");
		var gfound = false;
		if (tagstring != "") {
			var tags = tagstring.split(" ");
			$("tr.line").each(function () {
				var tr = $(this);
				var ptags = $(this).data("tags");
				var found = false;
				$.each(ptags, function (i, pt) {
					$.each(tags, function (ti, ta) {
						if (pt.indexOf(ta) > -1) {
							found = gfound = true;
							return !found;
						}
					});
					return !found;
				});
				if (!found) {
					$(this).addClass("hidden");
				} else {
					$(this).removeClass("hidden");
				}
			});
			if (!gfound) {
				$(".filter-empty").show();
			} else {
				$(".filter-empty").hide();
			}
		} else {
			$("tr.line").removeClass("hidden");
			$(".filter-empty").hide();
		}
	}

	$("tr.line").on("click", function () {
		location.href = $(this).data("route");
	});
});