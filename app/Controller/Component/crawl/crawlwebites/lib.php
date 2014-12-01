<?php
include(__dir__."\simple_html_dom.php");

Class Crawllib{
    protected $categories=array();
	protected $products=array();
	protected $offers=array();
	protected $final=array('msg'=>'success');
	protected $htmls;

	public function __construct(){
		//print_r((array)$this);
	}
	protected function process(){
		$this->processCat()->processProd()->marge();
		
	}
	protected function processCat(){
		$html_en=str_get_html(htmlspecialchars_decode(stripslashes($this->htmls['en'])));
		$html_ar=str_get_html(htmlspecialchars_decode(stripslashes($this->htmls['ar'])));
		$this->categories['en']=$this->getCategories($html_en);
		$this->categories['ar']=$this->getCategories($html_ar);
		$this->marge('cat');
		return $this;
		
	}
	protected function processProd(){
		$html_en=str_get_html(htmlspecialchars_decode(stripslashes($this->htmls['en'])));
		$html_ar=str_get_html(htmlspecialchars_decode(stripslashes($this->htmls['ar'])));
		$this->categories=$this->getProducts($html_en)->getProducts($html_ar)->marge();
		return $this;
		
	}
	protected function marge(){

	}
	public function toAscii($str, $replace=array(), $delimiter='-') {
       setlocale(LC_ALL, 'en_US.UTF8');
      if( !empty($replace) ) {
          $str = str_replace((array)$replace, ' ', $str);
      }

      $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
      $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
      $clean = strtolower(trim($clean, '-'));
      $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

      return $clean;
     }

}