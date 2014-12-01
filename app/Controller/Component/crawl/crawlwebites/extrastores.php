<?php
include(__dir__."\lib.php");
class extrastores extends Crawllib{
	
	public function __construct($html,$id){
       //return $this->final;
		parent::__construct();
		$this->htmls=$html;
		return parent::process();
	}
	
	protected function getCategories($html)
	{
		$cats=array();
		foreach ($html->find('#eXtraContentPlaceHolder_divMainSiteMap')  as $key => $value) {
			foreach ($value->find('div.sitemapcont') as $k => $val) {
				foreach ($val->find('div.sitemapbox') as $ke => $valu) {
					$cats[$ke]=array('title'=>$valu->find('h2',0)->innertext);
					foreach ($valu->find('ul.ulspacer') as $kk => $vall) {
						$cats[$ke]['children'][$kk]=array('title'=>$vall->find('li.smtitle',0)->innertext);
						foreach ($vall->find('li') as $k1 => $val1) {
							if($k1!=0)
							{
								$cats[$ke]['children'][$kk]['children'][$k1]=array('title'=>$val1->innertext );
							}
						}
					}
				}
			}
		}
		echo "<pre>"; print_r($cats); echo "</pre>";
		return $this;
	}
	protected function getProducts($html)
	{
        return $this;
	}
	
}

?>