function load(page,div)
{
	$.ajax({
        url: site+page,
       beforeSend: function(){
        },
        success: function(response){
            $(div).html(response);
			
        },
        dataType:"html"  		
    });
    return false;
}