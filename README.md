# Paginator
Pagination class that creates links according configuration
Usage

$options = array('total_pages' 	    => 10, 		  //total number of pagination links
                 'total_rows'	      => 100, 		//optional, in case 'total_pages' is missing, used with 'rows_per_page'
                 'rows_per_page'	  => 10, 		  //optional, in case 'total_pages' is missing, used with 'total_rows'
                 'visible_pages'	  => 5, 		  //number of pagination links shown
                 'param'			      => 'page', 	//default 'p'
                 'url' 			        => '', 		  //default $_SERVER['PHP_SELF']
                 'class_active'     => '', 		  //default 'paginator-active'
                 'class_element'    => '', 		  //default 'paginator-element'
                 'class_container'  => '', 		  //default 'paginator-container'
                 'first_last'       => FALSE);  //default TRUE, shows link to first and last pages

$paginator = new Paginator($options);
echo $paginator->generate();
