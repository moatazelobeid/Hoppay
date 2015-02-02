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
	public $uses=array('Product_category','Product','Offer','Menu','Newsletter','Page');
	public $components = array('Session','Paginator','Cookie','RequestHandler','Ctrl');
	

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
            if(in_array($this->params['action'],array('index','categorylist','shopbybrand','offers'))){
            	  $data= $this->Menu->find('first',array('conditions'=>array('Menu.menu_controller'=>$this->params['controller'],'Menu.menu_action'=>$this->params['action'])));
                 
                  $data1=$this->Page->find('first',array('conditions'=>array('Page.id'=>$data['Page']['id'])));
               
                  $this->set('menu_data',$data);
                  $this->set('page_data',$data1);
                  $page_details=$this->Ctrl->languageChanger($data1['Page_lang']);
                  //print_r($data1);
                  $this->metas_all['htitle']=stripslashes(strip_tags($page_details['pg_title']));
                  $this->metas_all['hdescription']=strip_tags(htmlspecialchars_decode($page_details['meta_description']));
                  $this->metas_all['hkeyword']=strip_tags(htmlspecialchars_decode($page_details['meta_keyword']));
                  $this->metas_all['hlang']=$this->Ctrl->getLang();
                  $this->set($this->metas_all);
            }
             // $id=$this->Cookie->read('Search.search_id');
			 //$text=$this->Cookie->read('Search.text');
			 //$this->set(array('search_id'=>$id,'text'=>$text));
		     $footer_menu=$this->Menu->find('threaded',array('conditions'=>array('Menu_position.slug'=>'home-footer','Menu_position.status'=>1,'Menu.status'=>1),'order' => array('Menu.order ASC')));
             //print_r($footer_menu);
             $this->set('footer_menu',$footer_menu);
			
        }
	public function index() 
	{ //echo "<pre>";print_r($_SERVER);exit;  
	//echo Router::reverse($this->params)."<br>";
	//echo $this->webroot; exit;
		/*$this->loadModel('Product_brand');
		$this->loadModel('Product_category');  
		$product_categories = $this->Product_category->Find('all', 
                  array(
                  'conditions'=>array(
                    'Product_category.parent_id'=>0,
                    'Product_category.status'=>1,
                    //'Product_brand_lang.lang_id'=> $langid
                  ),
                  'order' => array('Product_category.cat_order'=>'asc'),
                  'limit'=>12
                )
              );   echo "<pre/>";print_r($product_categories);exit;*/
		
	
	
	
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
									'order' => array('Product_category.cat_order'=>'asc')
									
								)
							); 
		$this->set('product_categories',$product_categories);
		$product_cate = $this->Product_category->Find('all', 
									array(
									'conditions'=>array(
										'Product_category.parent_id'=>0,
										'Product_category.status'=>1,
										//'Product_brand_lang.lang_id'=> $langid
									),
									'order' => array('TRIM(LEADING  "-" from Product_category.slug)'=>'asc')
									
								)
							); 
		$this->set('product_cate',$product_cate);
		
		
		//Get banners
		$this->loadModel('Banner');
		$banners = $this->Banner->Find('all', 
									array(
									'conditions'=>array(
										'Banner.status'=>1,
										//'Banner_lang.lang_id'=>1
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
							
		//echo '<pre>'; print_r($product_brands); echo '</pre>';	 exit;

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
		
		$this->set('slider',$slider);

		
	}
	public function index2() 
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
									'order' => array('Product_category.cat_order'=>'asc')
									
								)
							); 
		$this->set('product_categories',$product_categories);
		$product_cate = $this->Product_category->Find('all', 
									array(
									'conditions'=>array(
										'Product_category.parent_id'=>0,
										'Product_category.status'=>1,
										//'Product_brand_lang.lang_id'=> $langid
									),
									'order' => array('TRIM(LEADING  "-" from Product_category.slug)'=>'asc')
									
								)
							); 
		$this->set('product_cate',$product_cate);
		
		
		//Get banners
		$this->loadModel('Banner');
		$banners = $this->Banner->Find('all', 
									array(
									'conditions'=>array(
										'Banner.status'=>1,
										//'Banner_lang.lang_id'=>1
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
							
		//echo '<pre>'; print_r($product_brands); echo '</pre>';	 exit;

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
		
		$this->set('slider',$slider);

		
	}
	public function getoffers() 
	{
		ini_set('memory_limit','500M');
		ini_set('max_execution_time','1000');
		$this->layout = "ajax";
		$dbval=$this->request->data;	
		$dbval['text']=str_replace(" ","%", trim($dbval['text'])); 
		$dbval['text']=str_replace("-","%", trim($dbval['text'])); 
		//print_r($dbval['text']);
		//print_r($this->request->data);
        //$this->Cookie->delete('Search');
		$lang = $this->Ctrl->getLang();
		if($lang == 'en')
			$lang_id = 1;
		else
			$lang_id = 2;
		
		if($dbval['id']==0)
		{	
		         if($dbval['text'])
				 {
				 	$catas=array();
				 	$catid=$this->Product_category->find('all',array('conditions'=>array('Product_category.slug like'=>'%'.trim($dbval['text']).'%','Product_category.status'=>1),'recursive'=>-1));
				 	 	foreach ($catid as $key => $value) {
				 	 		$cats=$this->Product_category->children($value['Product_category']['id']);
				 	 		$idds=Hash::extract($cats,'{n}.Product_category.id');
				 	 		$catas=array_merge($catas,$idds);
				 	 		array_push($catas,$value['Product_category']['id']);
				 	 		
				 	 	}
				 	 	
				 	 	
				 	 $datas=$this->Product->Product_lang->find('all',
					array('fields'=>array('(select add_to_slider from mc_merchant_logins where id=Product.retailer_id ) add_to_slider','Product.*','Product_lang.*'),'conditions'=>array(
					 	'or'=>array(
					 		'Product_lang.title LIKE'=>'%'.trim($dbval['text']).'%',
					 		'Product.category_id'=>array_unique($catas),
					 		),
					 'Product.category_id !='=>'',
					 'Product.brand !='=>'',
					 'Product.offer_id !='=>'0')
					 ,'recursive' => 1));
					 
				 }
				 else
				 {
				     /*$datas=$this->Product->Product_lang->find('all',
					 array('conditions'=>array('Product.offer_id !='=>'0',
					 'Product.category_id !='=>'',
					 'Product.brand !='=>'',
					 'Product_lang.lang_id'=>$lang_id)
					 ,'recursive' => 3));*/
					 $datas=$this->Product->find('all',
					 array('fields'=>array('(select add_to_slider from mc_merchant_logins where id=Merchant.merchant_id ) add_to_slider','Product.*','Merchant.*'),'conditions'=>array('Product.offer_id !='=>'0',
					 'Product.category_id !='=>'',
					 'Product.brand !='=>'',
					 'Product.status'=>1,
					 ),
					 'recursive' => 1));
				 }
		}
		else 
		{
	      $data=$this->Product_category->children($dbval['id']);
	      if(!empty($data)){	
	      $catids=Hash::extract($data, '{n}.Product_category.id');
		         if($dbval['text'])
				 {
				 	$catas=array();
				 	$catid=$this->Product_category->find('all',array('conditions'=>array('Product_category.slug like'=>'%'.trim($dbval['text']).'%','Product_category.status'=>1),'recursive'=>-1));
				 	 	foreach ($catid as $key => $value) {
				 	 		$cats=$this->Product_category->children($value['Product_category']['id']);
				 	 		$idds=Hash::extract($cats,'{n}.Product_category.id');
				 	 		$catas=array_merge($catas,$idds);
				 	 		array_push($catas,$value['Product_category']['id']);
				 	 		
				 	 	}
				 	 $datas=$this->Product->Product_lang->find('all',
					 array('fields'=>array('(select add_to_slider from mc_merchant_logins where id=Product.retailer_id ) add_to_slider','Product.*','Product_lang.*'),'conditions'=>array('or'=>array(
					 		'Product_lang.title LIKE'=>'%'.trim($dbval['text']).'%',
					 		'Product.category_id'=>array_unique($catas),
					 		),
					 'Product.category_id !='=>'',
					 'Product.brand !='=>'',
					 'category_id'=>$catids,
					 'Product.offer_id !='=>'0'),'recursive' => 1));
				 }
				 else
				 {
				     /*$datas=$this->Product->Product_lang->find('all',
					 array('conditions'=>array('category_id'=>$catids,'Product.offer_id !='=>'0',
					 'Product.category_id !='=>'',
					 'Product.brand !='=>'',
					 'Product_lang.lang_id'=>$lang_id),
					 'recursive' => 3));*/
                     $datas=$this->Product->find('all',
					 array('fields'=>array('(select add_to_slider from mc_merchant_logins where id=Merchant.merchant_id ) add_to_slider','Product.*','Merchant.*'),'conditions'=>array('category_id'=>$catids,'Product.offer_id !='=>'0',
					 'Product.category_id !='=>'',
					 'Product.brand !='=>'',
					 'Product.status'=>1,
					 ),
					 'recursive' => 1));
				 }
			}
			else
			{
				$datas="";

			}
		}	
		 $view1="";
		//print_r($datas); 
		if(!empty($datas)){
			  // $this->Cookie->write('Search.search_id',$dbval['id'], false, '5 Days');
             //  $this->Cookie->write('Search.text', $dbval['text'] , false, '5 Days');
          //  $this->Cookie->write('Search',array('search_id' =>$dbval['id'], 'text' => !empty($dbval['text'])?$dbval['text']:""));
            //print_r($datas);
			foreach ( $datas as $key => $value) {
				if($value[0]['add_to_slider']!=0)
				{
					$todya = date('Y-m-d');		           
					$offer=$this->Offer->find('first',array('conditions'=>array('Offer.id'=>$value['Product']['offer_id'])));
					$start_date=date('Y-m-d', strtotime($offer['Offer']['start_date']));
		            $end_date = date('Y-m-d', strtotime($offer['Offer']['end_date']));
				if(($start_date <= $todya) &&  ($end_date >= $todya))
				{
				//$offer_lang_data = $this->Ctrl->languageChanger($value['Product_lang'])	;
				 $image=json_decode($value['Product']['image_url']);
				 if(isset($value['Product_lang'][0]))
				 {
				 	$details=$this->Ctrl->languageChanger($value['Product_lang']);
				 }
				 else
				 {
				 	$details=$value['Product_lang'];
				 }
				 
				$view1.='<div class="ca-item">
						 <a href="'.$this->webroot.$this->Ctrl->getLang()."/products/".$value['Product']['id'].'-'.$value['Product']['slug'].'">
						<div class="ca-item-main">
							<div class="ca-offers"><del>'.$this->Ctrl->getPriceFormat(number_format($value['Product']['price'],2)).'</del> <br />'.$this->Ctrl->getPriceFormat(number_format(($value['Product']['price']-($value['Product']['price']*$offer['Offer']['discount']/100)),2)).'<br><!--<img src="'.$offer['Offer']['offer_image'].'" style="height:30px;float:left;margin-top:1px;width:auto" alt="">--><span>'.$offer['Offer']['offer_desc'].'</span></div>
						  <div class="bottomtitle"><a  href="'.$this->webroot.$this->Ctrl->getLang() ."/products/".$value['Product']['id'].'-'.$value['Product']['slug'].'">'.((strlen($details['title'])>10)?substr( $details['title'],0,10).'..': $details['title']).'</a></div>
						  <a  href="'.$this->webroot.$this->Ctrl->getLang(). "/products/".$value['Product']['id'].'-'.$value['Product']['slug'].'"><img src="'.$image[0].'" alt="hoppay"></a>
						</div>
						</a>
					  </div>';
					}
				}
	         }
			
		 }

		 echo $view1;
		$this->render('ajax');

	}
	public function productlist() 
	{
		//echo '<pre>'; print_r($slug); echo '</pre>'; exit;
		$this->layout = "productlist";//code for getting site settings
		$this->loadModel('Setting');
		$config_settings=$this->Setting->find('all',array('conditions' => array('Setting.id' =>'1')));
		$this->set("setting",$config_settings[0]);

		//Get params
		if(!empty($this->params['named']['type']))
			$catslug = $this->params['named']['type'];
		else
		{
			$catslug = '';
		}
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
		$cat_path = '';
		$children = '';
		if(!empty($search_cat))
		{
			$search_cat_id = $search_cat['Product_category']['id'];
			$cat_path = $this->Product_category->getPath($search_cat_id);
		
			//Get all related sub categories of the selected category
			$children = $this->Product_category->children($search_cat_id);
		}
		//Get category breadcum path
	    
		$this->set("cat_path",$cat_path);
		
		$all_subid = Hash::extract($children, '{n}.Product_category.id');
		
		array_push($all_subid,$search_cat_id);
		
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
		
		/*$products = $this->Product->Find('all', 
								array(
										'conditions'=>array(
											'Product_category.status'=>1,
											'Product.status'=>1,
											//'Product.deleted'=>0,
											'Product.category_id'=>$all_subid
										),
										//'order' => array('Product_category.cat_order'=>'asc')
									)	
								); */
		
		//echo '<pre>'; print_r($products); echo '</pre>'; exit;
	}
	public function categorylist() 
	{
		 $this->Cookie->name = 'recent_review';
            $this->Cookie->time = '12 hour';  // or '12 hour'
            $this->Cookie->path = '/';
            $this->Cookie->domain = '';
            $this->Cookie->secure = false;  // i.e. only sent if using secure HTTPS
            $this->Cookie->key = 'qSI232qs*&sXOw!adre@34SAv!@*(XSL#$%)asGb$@11~_+!@#HKis~#^';
            $this->Cookie->httpOnly = true;
            $this->Cookie->type('rijndael');
           

            // echo"<pre>";print_r($this->Cookie->read()); echo"</pre>";
             $recent_viewd=$this->Cookie->read();
             $this->set('recent_viewed',$recent_viewd);
		$this->layout = "categorylist";
		 $lang = $this->Ctrl->getLang();
		$lid="";
		if($lang == 'en'){
		$lid=1;
		}
		if($lang == 'ar'){
		$lid=2;
		}
	//echo $lid; exit();
		$this->loadModel('Setting');
		$config_settings=$this->Setting->find('all',array('conditions' => array('Setting.id' =>'1')));
		$this->set("setting",$config_settings[0]);
		
		$hproduct_categories = $this->Product_category->Find('all', 
									array(
									'conditions'=>array(
										'Product_category.parent_id'=>0,
										'Product_category.status'=>1,
										'Product_category.id in (select cat_id from  mc_product_category_langs where lang_id='.$lid.') ',
										//'Product_category_lang.lang_id !='=>$lid,
										//'Product_brand_lang.lang_id'=> $langid
									),
									//'in'=>array(
									//'Product_category.id'=>'select cat_id from  mc_product_category_langs where lang_id='.$lid,
									//),
									'order' => array('Product_category.cat_order'=>'asc'),
									'limit'=>13
								)
							); 
						//	print_r($hproduct_categories);
		$this->set('product_categories',$hproduct_categories);
		
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
		$date = date('Y-m-d');
		$offer=$this->Product->find('all',array('conditions'=>array('Offer.start_date <= ' => $date,
								  /*'Offer.end_date  >= ' => $date*/
								 ),'limit'=>13));
		//print_r($offer);
		$this->set('offer',$offer);

		$product_categories = $this->Product_category->Find('all', 
									
									array(
									'fields' => array(
										'(SELECT COUNT( b.id ) 
											FROM mc_product_categories b
											WHERE b.parent_id = Product_category.id and b.status=1
											)  AS child_count',
										
										'Product_category.*',
										//'Parent.*',
										//'Product_category_lang.*',
										//'Product.*',
									),
									'conditions'=>array(
										'Product_category.parent_id'=>0,
										'Product_category.status'=>1,
										'Product_category.id in (select cat_id from  mc_product_category_langs where lang_id='.$lid.') ',

									//	'Product_category_lang.lang_id'=> $langid
									),
									//'in'=>array(
									//'Product_category.id'=>'select cat_id from  mc_product_category_langs where lang_id='.$lid,
									//),

									'order' => array(
										'Product_category.slug'=>'asc',
										//'child_count'=>'desc'
									)
								)
							); 
				//$product_categories=Hash::sort($product_categories,'{n}.Product_category.0.child_count','desc');
		$this->set("catlist",$product_categories);
		//echo '<pre>'; print_r($product_categories); echo '</pre>'; exit;
	}
	
	function shopbybrand()
	{
		 
		
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
		$date = date('Y-m-d');
		$offer=$this->Product->find('all',array('conditions'=>array('Offer.start_date <= ' => $date,
								  /*'Offer.end_date  >= ' => $date*/
								 ),'limit'=>13));
		//print_r($offer);
		$this->set('offer',$offer);

		 $this->Cookie->name = 'recent_review';
            $this->Cookie->time = '12 hour';  // or '12 hour'
            $this->Cookie->path = '/';
            $this->Cookie->domain = '';
            $this->Cookie->secure = false;  // i.e. only sent if using secure HTTPS
            $this->Cookie->key = 'qSI232qs*&sXOw!adre@34SAv!@*(XSL#$%)asGb$@11~_+!@#HKis~#^';
            $this->Cookie->httpOnly = true;
            $this->Cookie->type('rijndael');
            // echo"<pre>";print_r($this->Cookie->read()); echo"</pre>";
             $recent_viewd=$this->Cookie->read();
             $this->set('recent_viewed',$recent_viewd);
		$this->layout = "brandlist";
		
		//code for getting site settings
		$this->loadModel('Setting');
		$config_settings=$this->Setting->find('all',array('conditions' => array('Setting.id' =>'1')));
		$this->set("setting",$config_settings[0]);
		
		$lang = $this->Ctrl->getLang();
		
		if($lang == 'en')
			$langid = 1;
		else
			$langid = 2;
		
		//get product brands
		$this->loadModel('Product_brand');
		$brandlist = $this->Product_brand->Product_brand_lang->find('all', array(
		
										'conditions' => array(
											'Product_brand.status' => 1,
											'Product_brand_lang.lang_id' => $langid
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


	public function newsletter_signup(){
		$dbval=$this->request->data;
		if($dbval['email_id'])
		{
			$dbval['ip_adress']=$this->RequestHandler->getClientIp();
			$dbval['date']=date('Y-m-d h:i:s');
			
			$check=$this->Newsletter->save($dbval);
			if($check)
			{
				echo "Your subscription has been confirmed. You've been added to our list and will hear from us soon.";
			}
			else
			{
				return false;
			}
		}
		else {
			return false;
		}

		$this->render('ajax');
	}
	public function getAJAXCategorysListView(){
		$this->layout="ajax";
        $this->loadModel('Product_category');
		$product_categories = $this->Product_category->Find('all', 
									array(
									'conditions'=>array(
										'Product_category.parent_id'=>0,
										'Product_category.status'=>1,
										//'Product_brand_lang.lang_id'=> $langid
									),
									'order' => array('Product_category.cat_order'=>'asc'),
									'limit'=>9
								)
							); 
		$this->set('product_categories',$product_categories);
		
		//code for getting site settings
		
		
		//get product categories
		//$this->loadModel('Product_category');
		//$catlist = $this->Product_category->find('threaded');  
		
		$this->set("catlist",$product_categories);
	
        $this->render('get_ajax_category');


	}
	
	public function getAJAXCategorysChildListView($pid){
		$this->layout="ajax";
        $this->loadModel('Product_category');
		$product_categories = $this->Product_category->Find('all', 
									array(
									'conditions'=>array(
										'Product_category.parent_id'=>$pid,
										'Product_category.status'=>1,
										//'Product_brand_lang.lang_id'=> $langid
									),
									'order' => array('Product_category.cat_order'=>'asc'),
									/*'limit'=>9*/
								)
							); 
		$this->set("catlist",$product_categories);
		$this->set("pid",$pid);
        $this->render('get_ajax_child_category');

	}

	public function getSearchHints(){
		$this->layout="ajax";
		$dbval=$this->request->data;
		$cond=array('Product.category_id !='=>'','Product.brand !='=>'','Product.status'=>1);
		$dbval['text']=str_replace(" ","%", trim($dbval['text'])); 
		$dbval['text']=str_replace("-","%", trim($dbval['text'])); 
		$slug_split=explode("%",$dbval['text']);
            $sluges=array();
             
              
             if(!empty($slug_split))
             {
                $cond=array_merge($cond,array('or'=>array()));
                if(count($slug_split)==1)
                {
                  foreach ($slug_split as $key => $value) {
                                   
                   $sluges=array_merge((array)$sluges,(array)$value);
                   $sluges=implode("%", $sluges);
                   array_push($cond['or'],array('Product_lang.title like'=>"%". $sluges."%"));
                
                 }
                }
                else
                {

                 foreach ($slug_split as $key => $value) {
                  if(strlen($value)>2)
                  {                  
                   $sluges=array_merge((array)$sluges,(array)$value);
                   $sluges=implode("%", $sluges);
                   array_push($cond['or'],array('Product_lang.title like'=>"%". $sluges."%"));
                  }
                 }
                 $slug_split=array_reverse($slug_split);
                 $sluges="";
                 foreach ($slug_split as $key => $value) {
                  if(strlen($value)>2)
                  {                  
                   $sluges=array_merge((array)$sluges,(array)$value);
                   $sluges=implode("%", $sluges);
                   array_push($cond['or'],array('Product.slug like'=>"%". $sluges."%"));
                  }
                 }

                }
            }
		//print_r($cond);
		if($dbval['id']==0)
		{
		         if($dbval['text'])
				 {
				 	 $datas=$this->Product->Product_lang->find('all',array('conditions'=>$cond,'recursive' => 2,'limit'=>5));
				 }
				 else
				 {
				     $datas=$this->Product->Product_lang->find('all',array('conditions'=>array('Product_lang.lang_id'=>1,'Product.category_id !='=>'','Product.brand !='=>'','Product.status'=>1),'recursive' => 2,'limit'=>5));
				 }
		}
		else 
		{
			$data=$this->Product_category->children($dbval['id']);
			if(!empty($data)){	
			     $catids=Hash::extract($data, '{n}.Product_category.id');
		         if($dbval['text'])
				 {
				 	$cond=array_merge($cond,array('category_id'=>$catids));
				 	 $datas=$this->Product->Product_lang->find('all',array('conditions'=>$cond,'recursive' => 2,'limit'=>5));
				 }
				 else
				 {
				     $datas=$this->Product->Product_lang->find('all',array('conditions'=>array('category_id'=>$catids,'Product_lang.lang_id'=>1,'Product.category_id !='=>'','Product.brand !='=>'','Product.status'=>1),'recursive' => 2,'limit'=>5));
				 }
			}
			else
			{
				$datas="";

			}
		}	
		
		$search_slug=Hash::extract($datas, '{n}.Product.slug');
		$search_name=Hash::extract($datas, '{n}.Product_lang.title');
		$search_brands=Hash::extract($datas, '{n}.Product.Product_brand.slug');
		$finaldata=array('slugs'=>array_unique($search_slug),'names'=>array_unique($search_name),'barands'=>array_unique($search_brands));
		echo json_encode($finaldata);
		

		$this->render('ajax');
	}
	
	public function offers()
	{
		 $this->Cookie->name = 'recent_review';
            $this->Cookie->time = '12 hour';  // or '12 hour'
            $this->Cookie->path = '/';
            $this->Cookie->domain = '';
            $this->Cookie->secure = false;  // i.e. only sent if using secure HTTPS
            $this->Cookie->key = 'qSI232qs*&sXOw!adre@34SAv!@*(XSL#$%)asGb$@11~_+!@#HKis~#^';
            $this->Cookie->httpOnly = true;
            $this->Cookie->type('rijndael');
            // echo"<pre>";print_r($this->Cookie->read()); echo"</pre>";
             $recent_viewd=$this->Cookie->read();
             $this->set('recent_viewed',$recent_viewd);
		extract($this->request->data);
		
		$params = $this->params;
		
		if(isset($params) and !empty($params['named']))
		  @extract($params['named']);
		
		$this->loadModel('Setting');
		$config_settings = $this->Setting->find('all',array('conditions' => array('Setting.id' =>'1')));
		$this->set("setting",$config_settings[0]);
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
    $date=date('Y-m-d');
    $offer=$this->Product->find('all',array('conditions'=>array('Offer.start_date <= ' => $date,
                              /*'Offer.end_date  >= ' => $date*/
                             ),'limit'=>13));
    //print_r($offer);
    $this->set('offer',$offer);
		$limit = '8';
		$this->layout="offers";
		$limit_start = '0';
		
		$total_products = $this->Product->find('count',
									array(
										'conditions'=>array(
											'Product.offer_id !='=>'0',
											'Offer.end_date >='=>date('Y-m-d')
										)
									));
									
		$sort_by = array('rating_count'=>'desc');
			
		if(!empty($sort))
		{
			switch ($sort) 
			{
				case 'popular':
					$sort_by = array('rating_count'=>'desc');
					break;
					
				case 'plow':
					
					$sort_by = array('offer_price'=>'asc');
					break;
					
				case 'phigh':
					$sort_by = array('offer_price'=>'desc');
					break;
				
			}
		}
		//echo print_r($sort_by);
									
		$products = $this->Product->find('all',
									array(
									
										'fields' => array(
												'Product.*',
												 
												 'Product.price-((Product.price * Offer.discount)/100)   AS offer_price',
												'(

													SELECT COUNT( b.id ) 
													FROM mc_product_reviews b
													WHERE b.product_id = Product.id and b.status=1
													) AS review_count',
													
												'(
													SELECT sum( b.rating )/review_count
													FROM mc_product_reviews b
													WHERE b.product_id = Product.id
													) AS rating_count',
												
												'Offer.*',
												
												'Product_brand.*'
													
												),
										
										'conditions'=>array(
											'Product.offer_id !='=>'0',
											'Offer.status'=>1,
											'Offer.end_date >='=>date('Y-m-d')
										),
										'offset' => $limit_start,
										'limit' => $limit,
										'order' => $sort_by
									));
	
		$this->set("limit",$limit);
		$this->set("total_products",$total_products);
		$this->set("products",$products);
			
		//echo '<pre>'; print_r($products); echo '</pre>';  exit;
	}
	
	public function ajaxOffers($limit_start)
	{
		$limit = '8';
		$this->layout="ajax";
		
		$params = $this->params;
		
		if(isset($params) and !empty($params['named']))
		  @extract($params['named']);
		
		if(!empty($sort))
		{
			switch ($sort) 
			{
				case 'popular':
					$sort_by = array('rating_count'=>'desc');
					break;
					
				case 'plow':
					
					$sort_by = array('offer_price'=>'asc');
					break;
					
				case 'phigh':
					$sort_by = array('offer_price'=>'desc');
					break;
			}
		}
		else
		{
			$sort_by = array('rating_count'=>'desc');	
		}
		
		
		$products = $this->Product->find('all',
									array(
									
										'fields' => array(
												'Product.*',
												 
												 'Product.price-((Product.price * Offer.discount)/100)   AS offer_price',
												'(

													SELECT COUNT( b.id ) 
													FROM mc_product_reviews b
													WHERE b.product_id = Product.id and b.status=1
													) AS review_count',
													
												'(
													SELECT sum( b.rating )/review_count
													FROM mc_product_reviews b
													WHERE b.product_id = Product.id
													) AS rating_count',
												
												'Offer.*',
												
												'Product_brand.*'
													
												),
										
										'conditions'=>array(
											'Product.offer_id !='=>'0',
											'Offer.status'=>1,
											'Offer.end_date >='=>date('Y-m-d')
										),
										'offset' => $limit_start,
										'limit' => $limit,
										'order' => $sort_by
									));
		
		$this->set("products",$products);
			
		$this->render('get_ajax_offers');
	}
	
}
