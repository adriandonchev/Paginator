<?php

class Paginator {
	
	private $total_pages 	 = NULL;
	private $visible_pages	 = 1;
	private $param 			 = 'p';
	private $curr_page		 = 1;
	private $class_active	 = 'paginator-active';
	private $class_element   = 'paginator-element';
	private $class_container = 'paginator-container';
	private $first_last 	 = TRUE;
	private $url 			 = NULL;
	private $pages 			 = array();
	
	function __construct($opts = array())
	{
		if (isset($opts['visible_pages'])) {
			$this->visible_pages = intval($opts['visible_pages']);
		}
		
		if(isset($opts['total_pages'])){
			$this->total_pages = intval($opts['total_pages']);
		}
		elseif (isset($opts['total_rows']) AND isset($opts['rows_per_page'])) {
			$this->total_pages = round(intval($opts['total_rows'])/intval($opts['rows_per_page']));
		}
		
		if (isset($opts['param'])) {
			$this->param = $opts['param'];
		}
		
		
		if (isset($_GET[$this->param])) {
			$this->curr_page = intval($_GET[$this->param]); 
		}
		
		if ($this->curr_page <= 0) {
			$this->curr_page = 1;
		}
		
		if (isset($opts['url'])) {
			$this->url = $opts['url'];
		}
		else {
			$this->url = $_SERVER['PHP_SELF'];
		}
		
		if (isset($opts['class_active'])) {
			$this->class_active = $opts['class_active'];
		}
		
		if (isset($opts['class_element'])) {
			$this->class_element = $opts['class_element'];
		}
		
		if (isset($opts['class_container'])) {
			$this->class_container = $opts['class_container'];
		}
	}
	
	function generate()
	{
		if (!$this->get_pages() OR count($this->pages) < 2) {
			return FALSE;
		}
		
		$return = "";
		
		if ($this->pages[0] > 1 AND $this->first_last) {
			$return .= $this->get_link(NULL, '<<');
		}
			
		if ($this->curr_page > 1) {
			$return .= $this->get_link($this->curr_page-1, '<');
		}	
		
		if ($this->pages[0] > 1) {
			$return .= "<span>...</span>";
		}
		
		foreach ($this->pages as $p) {
			$return .= $this->get_link($p, $p);
		}
		
		if ($p < $this->total_pages) {
			$return .= "<span>...</span>";
		}
		
		if ($this->curr_page < $this->total_pages) {
			$return .= $this->get_link($this->curr_page+1, '>');
		}
		
		if ($p < $this->total_pages AND $this->first_last) {
			$return .= $this->get_link($this->total_pages, '>>');
		}
		
		return "<div class=\"".$this->class_container."\">".$return."</div>";
	}
	
	private function get_pages()
	{
		if (!$this->total_pages) {
			return FALSE;
		}
		
		$ofset 	= ceil(($this->visible_pages-1)/2);
		$start	= $this->curr_page - $ofset;
		$end 	= $this->curr_page + $ofset;
		
		if ($end > $this->total_pages) { //if last page out of bounds
		
			$start = $start - $end + $this->total_pages; 	
			$end   = $this->total_pages;
		}
		
		if ($start <= 0) { //if first page out of bounds
			$end = $end + 1 - $start;	
			
			if($end > $this->total_pages){
				$end = $this->total_pages;
			}
			$start = 1;
		}
		
		for ($i = $start; $i <= $end; $i++) {
			$this->pages[] = $i;
		}	
		
		return TRUE;
	}
	
	private function get_link($page_num, $link_title)
	{
		$sign = '&';
		
		if (strpos($this->url, '?') === FALSE) {
			$sign = '?';
		}
		
		$url = $this->url.$sign.$this->param."=".$page_num;
		
		$class_active = $this->curr_page == $page_num ? $this->class_active : '';
		
		return "<a href=\"".$url."\" class=\"".$this->class_element." ".$class_active."\">".$link_title."</a>&nbsp;&nbsp;";
	}
}

/*$options = array('total_pages' 	  => 10, 		//total number of pagination links
				'total_rows'	  => 100, 		//optional, in case 'total_pages' is missing, used with 'rows_per_page'
				'rows_per_page'	  => 10, 		//optional, in case 'total_pages' is missing, used with 'total_rows'
				'visible_pages'	  => 5, 		//number of pagination links shown
				'param'			  => 'page', 	//default 'p'
				'url' 			  => '', 		//default $_SERVER['PHP_SELF']
				'class_active'    => '', 		//default 'paginator-active'
				'class_element'   => '', 		//default 'paginator-element'
				'class_container' => '', 		//default 'paginator-container'
				'first_last'      => FALSE);    //default TRUE, shows link to first and last pages

$paginator = new Paginator($options);

echo $paginator->generate();
*/
?>