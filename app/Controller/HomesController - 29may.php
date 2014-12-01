<?php

App::uses('AppController', 'Controller');
App::uses('TemplateHelper', 'View/Helper');
App::uses('CakeEmail', 'Network/Email');
App::import('Vendor', 'common_class');
App::uses('CakeTime', 'Utility','Error');

// Home Controller
// Loads Home Page of Au Pair Site
/* Methods
	- index
	- beforeFilter
*/
class HomesController extends AppController {

	public $helpers = array('Html', 'Form','Session','Paginator','Fck','Template');
	//public $cacheAction = "0.1 hour";
	public $uses=array('Product_category','Product','Offer','Menu');
	 public $components = array('Session','Paginator','Cookie');

	 public function beforeFilter(){
                // $this->set('_constants', array('this', 'that', 'the other'));
           
            parent::beforeFilter();
            $this->Cookie->name = 'Menacompare_Search';
            $this->Cookie->time = '5 Days';  // or '12 hour'
            $this->Cookie->path = '/';
            $this->Cookie->domain = '';
            $this->Cookie->secure = false;  // i.e. only sent if using secure HTTPS
            $this->Cookie->key = 'qSI232qs*&sXOw!adre@34SAv!@*(XSL#$%)asGb$@11~_+!@#HKis~#^';
            $this->Cookie->httpOnly = true;
            $this->Cookie->type('rijndael');

           // $id=$this->Cookie->read('Search.search_id');
			//$text=$this->Cookie->read('Search.text');
			//$this->set(array('search_id'=>$id,'text'=>$text));
			$footer_menu=$this->Menu->find('threaded',array('conditions'=>array('Menu_position.slug'=>'home-footer','Menu_position.status'=>1,'Menu.status'=>1),'order' => array('Menu.order ASC')));
         //print_r($footer_menu);
        $this->set('footer_menu',$footer_menu);
			
        }
	public function index() 
	{
		$this->layout = "home";
		$langid = 1;
		//Get product categories and sub categories
		$this->loadModel('Product_category');
		$product_categories = $this->Product_category->Find('all', 
									array(
									'conditions'=>array(
										'Product_category.parent_id'=>0,
										'Product_category.status'=>1,
										//'Product_brand_lang.lang_id'=> $langid
									),
									'order' => array('Product_category.cat_order'=>'asc'),
									'limit'=>13
								)
							); 
		$this->set('product_categories',$product_categories);
		
		
		//Get banners
		$this->loadModel('Banner');
		$banners = $this->Banner->Banner_lang->Find('all', 
									array(
									'conditions'=>array(
										'Banner.status'=>1,
										'Banner_lang.lang_id'=>1
									),
									'order' => array('Banner.banner_order'=>'asc')
								)
							); 
		$this->set('banners',$banners);
		
		//code for getting site settings
		$this->loadModel('Setting');
		$config_settings=$this->Setting->find('all',array('conditions' => array('Setting.id' =>'1')));
		$this->set("setting",$config_settings[0]);
		
		//Get product brands
		$this->loadModel('Product_brand');
		$product_brands = $this->Product_brand->Find('all', 
									array(
									'conditions'=>array(
										
										'Product_brand.status'=>1
									),
									'order' => array('Product_brand.order'=>'asc'),
									'limit'=>13
								)
							); 
		$this->set('product_brands',$product_brands);
		$this->loadModel('Merchant_login');
		$slider = $this->Merchant_login->Find('all', 
									array(
									'conditions'=>array(
										
										'Merchant_login.status'=>1,'Merchant_login.add_to_slider'=>1
									),
									'order' => array('Merchant_login.id'=>'asc'),
									'limit'=>13
								)	
							); 
		$date=date('Y-m-d');
		$offer=$this->Product->find('all',array('conditions'=>array('Offer.start_date <= ' => $date,
                              'Offer.end_date	 >= ' => $date
                             ),'limit'=>6));
		//print_r($offer);
		$this->set('offer',$offer);
		$this->set('slider',$slider);

		
	}
	public function getoffers() 
	{
		$this->layout = "ajax";
		$dbval=$this->request->data;	
		//print_r($this->request->data);
        //$this->Cookie->delete('Search');

		if($dbval['id']==0)
		{
		         if($dbval['text'])
				 {
				 	 $datas=$this->Product->Product_lang->find('all',array('conditions'=>array('Product_lang.title LIKE'=>'%'.trim($dbval['text']).'%','Product.offer_id !='=>'0')));
				 }
				 else
				 {
				     $datas=$this->Product->Product_lang->find('all',array('conditions'=>array('Product.offer_id !='=>'0','Product_lang.lang_id'=>1)));
				 }
		}
		else 
		{
	      $data=$this->Product_category->children($dbval['id']);
	      if(!empty($data)){	
	      $catids=Hash::extract($data, '{n}.Product_category.id');
		         if($dbval['text'])
				 {
				 	 $datas=$this->Product->Product_lang->find('all',array('conditions'=>array('Product_lang.title LIKE'=>'%'.trim($dbval['text']).'%','category_id'=>$catids,'Product.offer_id !='=>'0')));
				 }
				 else
				 {
				     $datas=$this->Product->Product_lang->find('all',array('conditions'=>array('category_id'=>$catids,'Product.offer_id !='=>'0','Product_lang.lang_id'=>1)));
				 }
			}
			else
			{
				$datas="";

			}
		}	
		 $view1="";
		
		if(!empty($datas)){
			  // $this->Cookie->write('Search.search_id',$dbval['id'], false, '5 Days');
             //  $this->Cookie->write('Search.text', $dbval['text'] , false, '5 Days');
          //  $this->Cookie->write('Search',array('search_id' =>$dbval['id'], 'text' => !empty($dbval['text'])?$dbval['text']:""));
             
			foreach ( $datas as $key => $value) {
					$image=json_decode($value['Product']['image_url']);
					$offer=$this->Offer->find('first',array('conditions'=>array('Offer.id'=>$value['Product']['offer_id'])));
					//print_r($offer);
				
				$view1.='<div class="ca-item">
						<div class="ca-item-main">
							<div class="ca-offers">'.$offer['Offer']['offer_title'].'<br><img src="'.$offer['Offer']['offer_image'].'" style="height:30px;float:left;margin-top:1px;width:auto" alt=""><span>'.$offer['Offer']['offer_desc'].'</span></div>
						  <div class="bottomtitle"><a target="_blank" href="'.$value['Product']['product_url'].'">'.((strlen($value['Product_lang']['title'])>10)?substr($value['Product_lang']['title'],0,10).'..':$value['Product_lang']['title']).'</a></div>
						  <a target="_blank" href="'.$value['Product']['product_url'].'"><img src="'.$image[0].'" alt=""></a>
						</div>
					  </div>';
	         }
			
		 }

		 echo $view1;
		$this->render('ajax');

	}
	public function productlist() 
	{
		$this->layout = "productlist";
		
		//code for getting site settings
		$this->loadModel('Setting');
		$config_settings=$this->Setting->find('all',array('conditions' => array('Setting.id' =>'1')));
		$this->set("setting",$config_settings[0]);

		//Get params
		$catslug = $this->params['named']['type'];
		$langid = 1;
		
		//Get product categories and sub categories
		$this->loadModel('Product_category');
		$product_categories = $this->Product_category->Find('all', 
									array(
									'conditions'=>array(
										'Product_category.parent_id'=>0,
										'Product_category.status'=>1,
										//'Product_brand_lang.lang_id'=> $langid
									),
									'order' => array('Product_category.cat_order'=>'asc')
								)
							); 
		$this->set('product_categories',$product_categories);
		
		//Get Product subcategories
		$product_subcategories = $this->Product_category->Find('all', 
									array(
									'conditions'=>array(
										'Parent.slug'=>$catslug,
										'Product_category.status'=>1,
										//'Product_category_lang.lang_id'=> $langid
									),
									'order' => array('Product_category.lft'=>'asc')
								)
							); 
		$this->set('product_subcategories',$product_subcategories);
		
		//Code to get product list
		$this->loadModel('Product');
		
		//Get category id of the current searched category
		$search_cat = $this->Product_category->find('first',
													array(
														'conditions'=>array(
															'Product_category.slug'=>$catslug,
														)
													));
		$search_cat_id = $search_cat['Product_category']['id'];
		
		//Get category breadcum path
	    $cat_path = $this->Product_category->getPath($search_cat_id);
		$this->set("cat_path",$cat_path);
		
		//Get all related sub categories of the selected category
		$children = $this->Product_category->children($search_cat_id);
		
		$all_subid = Hash::extract($children, '{n}.Product_category.id');
		
		//Get all products
		$products = $this->Product->Find('all', 
								array(
										'conditions'=>array(
											'Product_category.status'=>1,
											'Product.status'=>1,
											//'Product.deleted'=>0,
											'Product.category_id'=>$all_subid
										),
										//'order' => array('Product_category.cat_order'=>'asc')
									)	
								); 

		$this->set("products",$products);
		
		//echo '<pre>'; print_r($products); echo '</pre>'; exit;
	}
	public function categorylist() 
	{
		$this->layout = "categorylist";
		
		$this->loadModel('Product_category');
		$product_categories = $this->Product_category->Find('all', 
									array(
									'conditions'=>array(
										'Product_category.parent_id'=>0,
										'Product_category.status'=>1,
										//'Product_brand_lang.lang_id'=> $langid
									),
									'order' => array('Product_category.cat_order'=>'asc'),
									'limit'=>13
								)
							); 
		$this->set('product_categories',$product_categories);
		
		
		//code for getting site settings
		$this->loadModel('Setting');
		$config_settings=$this->Setting->find('all',array('conditions' => array('Setting.id' =>'1')));
		$this->set("setting",$config_settings[0]);
		
		//get product categories
		$this->loadModel('Product_category');
		$catlist = $this->Product_category->find('threaded');  
		
		$this->set("catlist",$catlist);
		//echo '<pre>'; print_r($catlist); echo '</pre>'; exit;
	}
	
	function shopbybrand()
	{
		$this->layout = "brandlist";
		
		//code for getting site settings
		$this->loadModel('Setting');
		$config_settings=$this->Setting->find('all',array('conditions' => array('Setting.id' =>'1')));
		$this->set("setting",$config_settings[0]);
		
		//get product brands
		$this->loadModel('Product_brand');
		$brandlist = $this->Product_brand->Product_brand_lang->find('all', array(
		
										'conditions' => array(
											'Product_brand.status' => 1,
											'Product_brand_lang.lang_id' => 1
											),
										'order'=>array('Product_brand_lang.brand_title'=>'asc')
										));  
		
		$this->set("brandlist",$brandlist);
		$product_categories = $this->Product_category->Find('all', 
									array(
									'conditions'=>array(
										'Product_category.parent_id'=>0,
										'Product_category.status'=>1,
										//'Product_brand_lang.lang_id'=> $langid
									),
									'order' => array('Product_category.cat_order'=>'asc'),
									'limit'=>13
								)
							); 
		$this->set('product_categories',$product_categories);
		//echo '<pre>'; print_r($brandlist); echo '</pre>'; exit;
	}
}
