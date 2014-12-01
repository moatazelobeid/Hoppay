<?php
include(__dir__."\lib.php");
class extrastores extends Crawllib{
	public $catinfos=array();
	public $perpage=12;
	public $prodUrl=array();

	public function __construct($html,$id){
       //return $this->final;
		parent::__construct();
		$this->htmls=$html;
		return parent::process();
	}
	/*Important function mandatory*/
	protected function getCategories($html)
	{
		$cats=array();
		foreach ($html->find('#eXtraContentPlaceHolder_divMainSiteMap')  as $key => $value) {
			foreach ($value->find('div.sitemapcont') as $k => $val) {
				foreach ($val->find('div.sitemapbox') as $ke => $valu) {
					$cats[]=array('title'=>$valu->find('h2',0)->innertext);
					foreach ($valu->find('ul.ulspacer') as $kk => $vall) {
						$cats[(count($cats)-1)]['children'][$kk]=array('title'=>$vall->find('li.smtitle',0)->find('a',0)->innertext,'url'=>$vall->find('li.smtitle',0)->find('a',0)->href);
						foreach ($vall->find('li') as $k1 => $val1) {
							if($k1!=0)
							{
								$cats[(count($cats)-1)]['children'][$kk]['children'][$k1]=array('title'=>$val1->find('a',0)->innertext,'url'=>$val1->find('a',0)->href );
							}
						}
					}
				}
			}
		}
		//echo "<pre>"; print_r($cats); echo "</pre>";
		return $cats;
	}

	protected function getUrlsofProdList($html){
		 $urls=array();
	    $data=array();
		foreach ($html as $key => $value) {
			//print_r($value);
			$htm=str_get_html(htmlspecialchars_decode(stripslashes($value)));
			$catlsit=$htm->find('ul.filterul',0)->find('li');
			$count=count($catlsit);
			//echo $count;
				foreach ($catlsit as $k => $val) {
					
						if($k>0)
						{
						   if($k<=($count-3))
					       {
							if(!isset($this->catinfos[$key])){
								$this->catinfos[$key]=array();
							}
							preg_match('/\d+/',$val->find('div',0)->innertext,$matches);
							//print_r($matches);
							$this->catinfos[$key][]=array(
								'url'=>$val->find('a',0)->href,
								'count'=>$matches['0'],
								'total_page'=>$this->getThePageCount($matches['0'],$this->perpage)
								);
						    }
						}				   
					
				}
				break;
		}
		//print_r($this->catinfos); exit;
		foreach ($this->catinfos['en'] as $key => $value) {
				if($value['total_page']>0)
				{
					for($i=1;$value['total_page']>=$i;$i++)
					{
						$this->prodUrl['en']=$this->getProdUrls($this->doCalls($this->__getMerchantUrl().$value['url']."&page=".$i));
						$this->prodUrl['ar']=$this->getProdUrls($this->doCalls($this->__getMerchantUrl().$this->catinfos['ar'][$key]['url']."&page=".$i));
						$this->__setProdUrls($this->prodUrl);
						break;
					}
				}
				break;
		}
		unset($this->catinfos);
		return $this;
	}
    protected function getProdUrls($html){
    	$productUrls=array();
       $htm=str_get_html(htmlspecialchars_decode(stripslashes($html)));
       print_r($htm);
       foreach ($htm->find('div.mainproductlist',0)->find('div') as $key => $value) {
          foreach ($value->find('.productbox') as $k => $val) {
          		$productUrls[]= $val->find('.prodlisttitle',0)->find('a',0)->href;
          }
       }
       return $productUrls;
    }
	/*Important function mandatory*/
	protected function getProductsUrl($html)
	{
		$this->getUrlsofProdList($html);

		print_r($this->__getProdUrls());
		return $this;
	}
	
}

?>