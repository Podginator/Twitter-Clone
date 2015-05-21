<?php namespace App\Model;
//A terrible name for a model, but I couldn't think of a better one '
use Illuminate\Database\Eloquent\Model;

//Cannot initialize a TimeModel, it exists as an abstact class.
abstract class TimeModel extends Model {
	//Here we want to implement a Method that tells you the relative time 
	//since Object Creation.
	public function getRelativeTime() 				// Show dynamic post time: 
	{	
		if(!$this->created_at)
		{
			return null;
		}

		$createdDate = date_create(date('Y-m-d', 		// Create date var. from the post. 
		strtotime($this->created_at)) );
		$currentDate = date_create(date('Y-m-d'));		// Create date var. of the current date.
		
		$diff=date_diff($createdDate,$currentDate); 	// Get the time difference.

		$d = $diff->format('%a');						// Number of days.
		$m = $diff->format('%m');						// Number of months.

		if ($d <= 31) 									// Posted the past 31 days:					
		{
			switch($d)
			{
				case 0:		     			return 'Today'; 		break;
				case 1:		     			return 'Yesterday'; 	break;
				case ($d < 7):   		    return $d ." days ago"; break;
				case ($d >= 7 && $d < 14):  return '1 week ago'; 	break;
				case ($d >= 14 && $d < 21): return '2 weeks ago'; 	break;
				case ($d >= 21 && $d < 28): return '3 weeks ago'; 	break;
				case ($d >= 28):  			return '4 weeks ago'; 	break;
			}
		}
		else if( $m > 0 ) 								// Posted over a month ago:
			return "$m month(s), $d day(s) ago";
	}

}
