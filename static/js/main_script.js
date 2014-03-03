function load_content(url)
{
    $.get(url, function(data)
    {
        $('#page_content').html(data)}
    );
}

$(function(){
	$('a.content_link').click(function(event)
	{
            event.preventDefault();
            load_content($(this).attr('href'));
	});
});