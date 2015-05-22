//Search

$(document).ready(function()
{
	
/*---------------------------------------------------------------------------*/
/*								   A r r a y s			  					 */
/*---------------------------------------------------------------------------*/
	
	var tagsList = [];
	var searchList = [];

/*---------------------------------------------------------------------------*/
/*								V a r i a b l e s		  					 */
/*---------------------------------------------------------------------------*/

	var searchField 	= $('.searchField');
	var searchButton 	= $('.searchButton');
	var searchResults 	= $('.searchResults');

	// hide:
	searchResults.hide();

/*---------------------------------------------------------------------------*/
/*							   I n i t i a l i z e		  					 */
/*---------------------------------------------------------------------------*/

	url = window.location.origin;
	$.ajax
	({
		url: url + '/api/posts',
		success: function(posts)
		{
			$.each(posts, function (i, post)
			{
				var patt = /(#\w+)/;
	   		 	var res = patt.exec(post.text);
	   		 	res = res.slice(0);	// Remove hashtag.

				var tags = res.toString().split(",");
				$.each(tags, function(i, eleme){
					if($.inArray(elem, tagsList)==-1){
						tagsList.push(elem)
					}
				})
				//tagsList.push(tags[0]);		// temporarily code. 
				console.log(tagsList);
			});
		}
	});

	

	/*for (i = 0; i< tags.length; i++)
	{
		for(j = 0; j < tags.length; j++)
		{
			if(tags[j] == tags[i])
				
		}
	} */

/*---------------------------------------------------------------------------*/
/*								F u n c t i o n s		  					 */
/*---------------------------------------------------------------------------*/

	function search( searchInput ) 		// doesn't work very well. Just testing.
	{
		if( searchInput != "" )
		{
   			url = window.location.origin+"/tag/" + searchInput;
			window.location.href = url;

		}
	}

/*---------------------------------------------------------------------------*/
/*								K e y   E v e n t s		  					 */
/*---------------------------------------------------------------------------*/

	searchField.bind('keyup change', function(e)
	{
		var input = searchField.val();

		searchList = [];
		searchResults.html('');

		if( input == "" )
		{
			searchResults.slideUp();
			searchField.css({'border-radius':'10px 0px 0px 10px'});
			searchResults.html('');
			searchList = [];
		}

		if (e.which == 13 || e.keyCode == 13) 	// Pressed Enter.
			search(input);

		var result = false;

		for(var i = 0; i < tagsList.length; i++)
		{	
			if( tagsList[i].indexOf(input) > 0 ) 	// found a match with the stored tags.
			{
				result = true;						// found a tag, checking.

				if (searchList.length != 0)			// the search list is not empty.
				{
					if( searchResults.text().indexOf(tagsList[i]) == -1 )
					{
				    	searchList.push('<li name = '+ tagsList[i] +'>' + tagsList[i] + '</li>');
				    }
				}
				else
				    searchList.push('<li name = '+ tagsList[i] +'>' + tagsList[i] + '</li>');
			}

			if ( i == tagsList.length-1 && input != '') 	// looped through all tags AND input is not empty.
			{
				searchResults.slideDown();
				searchField.css({'border-radius':'10px 0px 0px 0px'});
				
				if (result)
					searchResults.append(searchList);
				else
					searchResults.append('<li>Sorry no results for <br><i>"'+ input +'"</i></li>');
			}
		}	

	});

/*---------------------------------------------------------------------------*/
/*							  C l i c k   E v e n t s		  				 */
/*---------------------------------------------------------------------------*/

	searchButton.click( function()
	{
		search( searchField.val() );
	});

	$('.searchResults').delegate('li', 'click',function()
	{
		var searchValue = $(this).attr('name');
		searchValue = searchValue.substring(1);
		search( searchValue);
	});

	
/*---------------------------------------------------------------------------*/
});		// End document ready.

