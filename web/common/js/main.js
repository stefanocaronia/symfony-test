$(function(){
	
	checkTags($("#filter-tags"));
	
	$("#filter-tags").on("keyup",function(e){
		checkTags($(this));
	});
	
	function checkTags(input){
		var tagstring=input.val();
		var found=false;
		if (tagstring) {		
			var tags=tagstring.split(" ");			
			$("tr.line").each(function(){
				var tr=$(this);
				var ptags=$(this).data("tags");
				found=false;
				$.each(ptags, function(i,pt){
					$.each(tags, function(ti, ta){
						if (pt.indexOf(ta) > -1) {
							found=true;
							return;
						}
					});
					if (found) return;
				});
				if (!found) $(this).addClass("hidden");
				else $(this).removeClass("hidden");				
			});	
			if (!found) $(".filter-empty").show();
			else $(".filter-empty").hide();
		} else {
			$("tr.line").removeClass("hidden");
			$(".filter-empty").hide();
		}
	}
	
	$("tr.line").on("click",function(){
		location.href=$(this).data("route");
	});
});