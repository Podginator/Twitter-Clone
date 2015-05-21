//Search

$(document).ready(function()
{

/*---------------------------------------------------------------------------*/
/*								V a r i a b l e s		  					 */
/*---------------------------------------------------------------------------*/

	var searchField = $('.searchField');
	var searchButton = $('.searchButton');

/*---------------------------------------------------------------------------*/
/*								F u n c t i o n s		  					 */
/*---------------------------------------------------------------------------*/

	function search() 		// doesn't work very well. Just testing.
	{
		var input = searchField.val();
		if( input != "" )
		{
   			url = window.location.origin+"/tag/" + input;

			window.location.href = url;
		}
	}

/*---------------------------------------------------------------------------*/
/*								K e y   E v e n t s		  					 */
/*---------------------------------------------------------------------------*/

	searchField.bind('keyup change', function(e)
	{
		if (e.which == 13 || e.keyCode == 13) 	// Pressed Enter.
			search();

		// do something, mabye an ajax call to display matching input inside a dropdown list (?)
	});

/*---------------------------------------------------------------------------*/
/*							  C l i c k   E v e n t s		  				 */
/*---------------------------------------------------------------------------*/

	searchButton.click( search );

	
/*---------------------------------------------------------------------------*/
});		// End document ready.

