<?php 
/*
	File Name:init.php (1st file used for crawl function)
	Description: By using this we crawl the merchant sites 
	             and by calling difrent diffrent site modules.

*/
Class CrawlInit
{

	/*
	    Variables
	*/
	private $en_url="http://www.extrastores.com/en-sa/sitemap";
	private $ar_url="http://www.extrastores.com/ar-sa/sitemap";
	private $collected_data;
	private $html_content;
	private $error="200";
	private $modulName="extrastores";
	private $merchant_id;


	/*
	    Mathords
	*/
	public function __construct($data=array()){
		//echo $data['merchant_paths'];
		//$url=json_decode(htmlspecialchars_decode(stripslashes($data['merchant_paths'])));
		//print_r($url);
		//$this->en_url=$url->en;
		//$this->ar_url=$url->ar;
		//echo $data['merchant_id'];
		$this->merchant_id=$data['merchant_id'];
		//echo $this->merchant_id;
	}
	public function start(){

		$this->collected_data= $this->getDOM()->callModules();
		return $this;
	} 
	public function save(){
		

		return (array)$this;
	} 
	public function callModules(){
		include("crawlwebites/".$this->modulName.".php");
		$data= new $this->modulName($this->html_content,$this->merchant_id);
		return $data;
	}
	public function getDOM()
	{
		//echo $this->doCalls($this->en_url);
		$this->html_content['en']=$this->doCalls($this->en_url);
		$this->html_content['ar']=$this->doCalls($this->ar_url);
	    return $this;
  
    } 
     private function doCalls($url){
     	//echo $url;
     	$ch = curl_init($url);
	   curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	   curl_setopt($ch, CURLOPT_RANGE, '0-100');
	   $content = curl_exec($ch);
	   $info = curl_getinfo($ch);
	   curl_close($ch);
	  // echo $url."<br>";

	  //echo $content;


	   /*$dom = new simple_html_dom();
	   $dom->load($content);*/
	//print_r($info);
	   if($info['http_code']=="200"){
        //$this->htmlContent=$content;
	      return htmlspecialchars($content);
	      //return $Content;
	   }
	   else
	   {
	   	$this->error="404";
	     return $this;
	   }
     }
}
$this->Crawl_merchant_website=ClassRegistry::init('Crawl_merchant_website');
$crawl_data=  $this->Crawl_merchant_website->find('first',array('id'=>$id));
//print_r($crawl_data);
$crawl=new CrawlInit($crawl_data['Crawl_merchant_website']);
$retdata= $crawl->start()->save();
?>
