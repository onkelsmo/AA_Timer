/**
 * bandoneon - akkordeo
 */
function bandoneon(content,bar)
{
	if(!content.length || !bar.length)return;
	content.hide();
	bar.click(function(){
		bar.removeClass("current");
		content.not(":hidden").slideUp('slow');
		var current = $(this);
		$(this).next()
			.not(":visible")
			.slideDown('slow',function(){
				current.addClass("current");
			});
	});
}

/**
 * Change color when time is running out
 */
function colorChanger(obj)
{
    if(obj.length == 0)return;
    obj.find("span.ready")
        .parent()
        .parent()
        .prev("h3")
        .addClass("ready");
}

