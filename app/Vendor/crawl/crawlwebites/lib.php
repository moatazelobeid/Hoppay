<?php
//define('APP','/')
ini_set('memory_limit','5000000M');
ini_set('max_execution_time','10000');
include(__dir__."\simple_html_dom.php");

Class Crawllib extends CrawlInit{
  protected $categories=array();
	protected $products=array();
	protected $offers=array();
	protected $final=array('msg'=>'success');
	protected $htmls;
  protected $caturls;
  protected $produrls;
  public $merchant_url;

	public function __construct(){
		//print_r((array)$this);
	}
	protected function process(){
		$this->processCat()->processProdUrl()->processProd()->marge();
		
	}
	protected function processCat(){
		$html_en=str_get_html(htmlspecialchars_decode(stripslashes($this->htmls['en'])));
		$html_ar=str_get_html(htmlspecialchars_decode(stripslashes($this->htmls['ar'])));
		$this->categories['en']=$this->getCategories($html_en);
		$this->categories['ar']=$this->getCategories($html_ar);
		$this->marge('cat');
	echo "<pre>"; print_r($this->categories['en']);echo "</pre>"; exit; 
		return $this;
		
	}
  
	/*protected function processCategotyForProd(){
    foreach ($this->categories['en'] as $key => $value) {
       if(isset($value['url'])){
           $this->categories['en'][$key]['products']=$this->__processUrl($value['url'],$value['url_ar']);
       }
       if(isset($value['children']))
       {
          $this->categories['en'][$key]['children']=$this->processCategotyForProd_child($value['children']);
       }
    }
		
		return $this;
	}
  protected function processCategotyForProd_child($data){
    foreach ($data as $key => $value) {
       if(isset($value['url'])){
          $data[$key]['products']=$this->__processUrl($value['url'],$value['url_ar']);
       }
       if(isset($value['children']))
       {
          $data[$key]['children']=$this->processCategotyForProd_child($value['children']);
       }
    }
    return $data;
    
  }*/
  protected function __getCatUrl(){
    return $this->caturls;
  }
  protected function __getProdUrls()
  {
    return $this->produrls;
  }
  protected function __setProdUrls($url)
  {
    if(!isset($this->produrls['en']))
    {
      $this->produrls['en']=array();
    }
    if(!isset($this->produrls['ar']))
    {
      $this->produrls['ar']=array();
    }
   array_push($this->produrls['en'],$url['en']);
   array_push($this->produrls['ar'],$url['ar']);
  }
  public function __getMerchantUrl(){
    global $argv;
   return $argv[2];

  }
  protected function __processUrl($url){
            $merchant_url= $this->__getMerchantUrl();
            // print_r($merchant_url);
             $prodhtml['en']=$this->doCalls($merchant_url.$url['en']);
            if(isset($url['ar']))
            {
              $prodhtml['ar']=$this->doCalls($merchant_url.$url['ar']);
            }
          // print_r($this->doCalls($this->merchant_url.$url['en']));
           return $this->getProductsUrl($prodhtml);
  }
  protected function processProdUrl(){
    //print_r($html);
   // print_r($this->__getCatUrl());
   foreach ($this->__getCatUrl() as $key => $value) {
     $this->__processUrl($value);
     break;
    }
    /*$html_en=str_get_html(htmlspecialchars_decode(stripslashes($html['en'])));
    $html_ar=str_get_html(htmlspecialchars_decode(stripslashes($html['ar'])));
    $this->products['en']=$this->getProductsUrl($html_en);
    $this->products['ar']=$this->getProductsUrl($html_ar);
    $this->marge('prod');*/
    return $this;
  }
  protected function processProd()
  {
    return $this;
  }
	protected function marge($type="",$dataen=array(),$dataar=array()){
      switch ($type) {
      	case 'cat':
      		$cat=array();
  			foreach ($this->categories['en'] as $key => $value) {
  				$this->categories['en'][$key]['slug']=$this->toAscii(trim($value['title']));

  				$this->categories['en'][$key]['title_ar']=@$this->categories['ar'][$key]['title'];
          if(isset($value['url']))
          {
               $this->caturls[]=array('en'=>$value['url'],'ar'=>$value['url_ar']);
          }
       
          //$this->categories['en'][$key]['url_ar']=$this->categories['ar'][$key]['url'];
  				if(isset($value['children']))
  				{
  				   	$this->categories['en'][$key]['children']=$this->marge('child',$value['children'],$this->categories['ar'][$key]['children']);
  				   	//echo "<pre>"; print_r($this->categories['en'][$key]['children']);echo "</pre>";
  				}
  				
  			}	

        break;
        case 'child':
        	foreach ($dataen as $key => $value) {
                $dataen[$key]['slug']=$this->toAscii(trim($value['title']));
  				      $dataen[$key]['title_ar']=$dataar[$key]['title'];
                $dataen[$key]['url_ar']=$dataar[$key]['url'];
                $this->caturls[]=array('en'=>$dataen[$key]['url'],'ar'=>$dataen[$key]['url_ar']);
  				if(isset($value['children']))
  				{
  					 $dataen[$key]['children']=$this->marge('child',$dataen[$key]['children'],$dataar[$key]['children']);
  					//echo "<pre>"; print_r($this->categories['en'][$key]['children']);echo "</pre>";
  				}
  			}	
  			return $dataen;
        break;
        case 'prod':
        break;
        default:
        return $this;
        break;
       }
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
     public function getThePageCount($tot,$perpage){
          return ceil($tot/$perpage);
     }

}