//Search

$(document).ready(function()
{
		
	$('.searchResults').undelegate('click');	

/*---------------------------------------------------------------------------*/
/*								   A r r a y s			  					 */
/*---------------------------------------------------------------------------*/
	 
	var tagsList = []; 									// Store all tags.
	var searchList = [];								// Store all tags that match the search value.

/*---------------------------------------------------------------------------*/
/*								V a r i a b l e s		  					 */
/*---------------------------------------------------------------------------*/

	var searchField 	= $('.searchField');			// The search field.
	var searchButton 	= $('.searchButton');			// The search button.
	var searchResults 	= $('.searchResults'); 			// The unordered list.

/*---------------------------------------------------------------------------*/
/*							   I n i t i a l i z e		  					 */
/*---------------------------------------------------------------------------*/
	
	// hide:
	searchResults.hide(); 								// Hide the search results on defualt.

	url = window.location.origin; 						// Get root path.
	
	$.ajax												// Get all tags and store them in tagsList.
	({
		url: url + '/api/posts/all',						// Get all posts from json.
		success: function(posts) 						// Success callback:
		{
			$.each(posts, function (i, post)			// Find all hashtags and store unambiguously:
			{
				var patt = /(#\w+)/; 					// Regular expression to find all tags (!) not working properly..
	   		 	var res = patt.exec(post.text);			// Get result of regular expression.
				var tags = res.toString().split(","); 	// Split string to array on ','.	

				$.each(tags, function(i, elem) 			// Filter ambigious tags:
				{
					if($.inArray(elem, tagsList)==-1){
						tagsList.push(elem);
					}
				})
			});
		}
	});

/*---------------------------------------------------------------------------*/
/*								F u n c t i o n s		  					 */
/*---------------------------------------------------------------------------*/

	function search( searchInput ) 						// Search after this input. 
	{
		if( searchInput != "" ) 						// The input must have a value.	
		{
   			url = window.location.origin+"/tag/" + searchInput;
			window.location.href = url;
		}
	}

/*---------------------------------------------------------------------------*/
/*								K e y   E v e n t s		  					 */
/*---------------------------------------------------------------------------*/

	searchField.bind('keyup change', function(e) 			// When the user presses a key.
	{
		var input = searchField.val(); 						// Get input value.

		searchList = []; 									// Reset search array.
		searchResults.html(''); 							// Reset the search output.

		if( input == "" ) 									// The user backspaced the input value:
		{
			searchResults.slideUp();
			searchField.css({'border-radius':'10px 0px 0px 10px'});
			searchResults.html('');
			searchList = [];
		}

		if (e.which == 13 || e.keyCode == 13) 				// Pressed Enter:
			search(input);									// Perform a search.

		var result = false; 								// Boolean to check if there was any results.

		for(var i = 0; i < tagsList.length; i++) 			// Loop through all tags:
		{	
			if( tagsList[i].indexOf(input) > 0 ) 			// Found a match with the stored tags.
			{
				result = true;								// Found a tag, boolean is true.

				if (searchList.length != 0)					// The search list array is NOT empty.
				{
					if( searchResults.text() 				// The tag isn't a duplicate of the current search results:
						.indexOf(tagsList[i]) == -1 )
					{ 										// Add this tag to into search results.
				    	searchList.push('<li name = '
				    	+ tagsList[i] +'>' + tagsList[i] + '</li>');
				    }
				}
				else										// The search list array is empty:
																// Add the tag into search results.
				    searchList.push('<li name = '
				    	+ tagsList[i] +'>' + tagsList[i] + '</li>');
			}

			if ( i == tagsList.length-1 && input != '') 	// looped through all tags AND input is NOT empty.
			{
				searchResults.slideDown();					// Display the search results container.
				searchField.css({'border-radius':'10px 0px 0px 0px'});
				
				if (result)									// The search input resulted positive:
					searchResults.append(searchList); 		// Display all search results.
				else
					searchResults.append('<li>Sorry no results for <br><i>"'+ input +'"</i></li>');
			}
		}	

	});

/*---------------------------------------------------------------------------*/
/*							  C l i c k   E v e n t s		  				 */
/*---------------------------------------------------------------------------*/

	searchButton.click( function() 							// Clicked on the search button:	
	{	
		search( searchField.val() );						// Search with the current input.
	});

	$('.searchResults').delegate('li', 'click',function() 	// Clicked on a search reuslt from the list:
	{
		var searchValue = $(this).attr('name');				// Get this search value by attr name.
		searchValue = searchValue.substring(1);				// Remove hashtag from search value.

		console.log('clicked');

		search( searchValue);								// Search with this input.
	});

	
/*---------------------------------------------------------------------------*/
});		// End document ready.

