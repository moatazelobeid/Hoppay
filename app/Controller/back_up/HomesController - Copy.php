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
									'limit'=>10
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
									'limit'=>10
								)
							); 
		$this->set('product_brands',$product_brands);
	}
	public function productlist() 
	{
		$this->layout = "productlist";
		
		//code for getting site settings
		$this->loadModel('Setting');
		$config_settings=$this->Setting->find('all',array('conditions' => array('Setting.id' =>'1')));
		$this->set("setting",$config_settings[0]);
		
		$catslug = '';
		$product_subcategories = '';
		//Get params
		if(!empty($this->params['named']['type']))
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
		
		//fetch product list of the selected category
		if(!empty($this->params['named']['type']))
		{
			$conditions = array('Product_category.status'=>1,
					'Product.status'=>1,
					//'Product.deleted'=>0,
					'Product.category_id'=>$all_subid,
				);
		}
		//fetch product list of the selected brand
		if(!empty($this->params['named']['brand']))
		{
			
			$this->loadModel('Product_brand');
			$brand_slug = $this->params['named']['brand'];
			//Get category id of the current searched category
			$search_brand = $this->Product_brand->find('first',
										array(
											'conditions'=>array(
												'Product_brand.slug'=>$brand_slug,
											)
										));
										
			$search_brand_id = $search_brand['Product_brand']['id'];
			
			$conditions = array('Product_brand.status'=>1,
					'Product.status'=>1,
					//'Product.deleted'=>0,
					'Product.brand'=>$search_brand_id,
				);
		}
		
		//Get all products
		$products = $this->Product->Find('all', 
							array(
									'conditions'=>$conditions
									//'order' => array('Product_category.cat_order'=>'asc')
								)	
							); 

		$this->set("products",$products);
		
		//echo '<pre>'; print_r($products); echo '</pre>'; exit;
	}
	public function categorylist() 
	{
		$this->layout = "categorylist";
		
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
		//echo '<pre>'; print_r($brandlist); echo '</pre>'; exit;
	}
}