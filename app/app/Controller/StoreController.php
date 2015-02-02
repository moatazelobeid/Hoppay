<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('AppController', 'Controller');
App::uses('TemplateHelper', 'View/Helper');
App::uses('CakeEmail', 'Network/Email');
App::import('Vendor', 'common_class');
App::uses('CakeTime', 'Utility');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class StoreController extends AppController {
public $helpers = array('Html', 'Form','Session','Paginator','Fck','Template');
 public $components = array('Session','Paginator','Cookie');
/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array('Merchant','Menu','Merchant_login','Product_category','Product_category','Product_brand','Product_brand_lang','Product','Product_lang','Product_store','Offer','Product_store_lang');

	public $merchantid="";
    public $common="";
    /**
     * Displays a view
     *
     * @param mixed What page to display
     * @return void
     * @throws NotFoundException When the view file could not be found
     *	or MissingViewException in debug mode.
     */
    public function beforeFilter(){     
        parent::beforeFilter();
       
            $this->Cookie->name = 'Menacompare_merchent';
            $this->Cookie->time = '1 hour';  // or '12 hour'
            $this->Cookie->path = '/';
            $this->Cookie->domain = '';
            $this->Cookie->secure = false;  // i.e. only sent if using secure HTTPS
            $this->Cookie->key = 'qSI232qs*&sXOw!adre@34SAv!@*(XSL#$%)asGb$@11~_+!@#HKis~#^';
            $this->Cookie->httpOnly = true;
            $this->Cookie->type('rijndael');

            $this->layout = 'merchant';
            //echo $this->Session->read('Merchant.id');
            $merchant_menu=$this->Menu->find('threaded',array('conditions'=>array('Menu_position.slug'=>'merchant-top','Menu_position.status'=>1,'Menu.status'=>1),'order' => array('Menu.order ASC')));
            //print_r($merchant_menu);
            $this->set('merchant_menu',$merchant_menu);
            if(!in_array($this->params['action'],array()))
		   	{
		   	  if( $this->Session->check('Merchant'))
               {
                 $this->merchantid = $this->Session->read('Merchant.id');
                 $useremail = $this->Session->read('Merchant.email');
                 $data=$this->Merchant->find('first',array('conditions'=>array('Merchant.merchant_id'=>$this->merchantid)));
               //debug($data);
                 $this->set('merchant',$data);
                 $data_prod=$this->Product->find('count',array('conditions'=>array('retailer_id'=>$this->merchantid)));
                 //print_r($data_prod);
                 $this->set('products_count',$data_prod);
                 
                  $data_off=$this->Offer->find('count',array('conditions'=>array('Offer.merchant_id'=>$this->merchantid,'status'=>1)));
                  	$this->set('offer_count',$data_off);

               }
                if(!$this->merchantid)
				{
			        $this->redirect( array('controller' => 'merchant', 'action' => 'login','lang'=>isset($this->params['lang'])?$this->params['lang']:'en'));
				   $this->redirect('/merchant/login');
	               exit();
				}
		   	}
		   	else 
		   	{
		   		if( $this->Session->check('Merchant'))
		   		{
		   		 $this->merchantid = $this->Session->read('Merchant.id');
                 $useremail = $this->Session->read('Merchant.email');
                }
                if($this->merchantid)
				{
					$this->redirect( array('controller' => 'merchant', 'action' => 'dashbord','lang'=>isset($this->params['lang'])?$this->params['lang']:'en'));
				    $this->redirect('/merchant/dashbord');
	                exit();
				}
		   	}

         $func=$this->params['action'];
        // echo method_exists($this,$func);
         if(!method_exists($this,$func))
         {
            $this->render('404');
         }
       $this->loadModel('Setting');
		$config_settings=$this->Setting->find('all',array('conditions' => array('Setting.id' =>'1')));
		$this->set("setting",$config_settings[0]);
        $this->common=new CommonFunction($this->merchantid);
    }
    public function index(){
         $this->set('text_data',array('title'=>'Store Setup'));
           $this->loadModel('Product_category');
        $product_categories = $this->Product_category->Find('all', 
                                    array(
                                    'conditions'=>array(
                                        'Product_category.parent_id'=>0,
                                        'Product_category.status'=>1,
                                        //'Product_brand_lang.lang_id'=> $langid
                                    ),
                                    'order' => array('Product_category.slug'=>'asc')
                                    
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
                              'Offer.end_date    >= ' => $date
                             ),'limit'=>6));
        //print_r($offer);
        $this->set('offer',$offer);
		  $condition=$this->request['url'];
                extract($condition);
                 $lang_id=isset($lang_id)?$lang_id:1;
		 if( $this->Session->check('Merchant'))
		{
			 $this->merchantid = $this->Session->read('Merchant.id');
		 	 $useremail = $this->Session->read('Merchant.email');
		 
		 	//get all languages
			 $this->loadmodel('Language');
			 $lang=$this->Language->find('all');
			 $this->set('lang', $lang);
			   
			 //get all social settings
			 $this->loadmodel('Social_setting');
			 $social=$this->Social_setting->find('all',array('conditions'=>array('status'=>'1')));
			 $this->set('social_icons', $social); 
			  
			  //getall merchant basic datas
			 $this->loadmodel('Merchant');
			 $merchant_info=$this->Merchant->find('first',array('conditions'=>array('Merchant.merchant_id'=>$this->merchantid)));
			   
			 $storeinfo = $this->Product_store->find('first',array('conditions'=>array('merchant_id'=>$this->merchantid)));
				
			 if($this->request->is('post')){	
		
				  $fields = $this->request->data;
				 // print_r($fields);
				  if(!empty($fields['social_link']))
				  {
				   $social_linkurl =json_encode($fields['social_link']);				  
				  }
				  $storevals['merchant_id'] =$this->merchantid;
				  $storevals['social_links'] = $social_linkurl;
				  $storevals['shipping_details'] = trim(strip_tags($fields['shipping_details']));
				  $storevals['shipping_price'] = $fields['shipping_price'];
				  $storevals['shipping_time'] = trim(strip_tags($fields['shipping_time']));
				  $storevals['payment_details'] = json_encode(isset($fields['payment_details'])?$fields['payment_details']:"");
				  $storevals['contact_name'] = $merchant_info['Merchant']['first_name'].' '.$merchant_info['Merchant']['last_name'];
				  $storevals['contact_email'] = $useremail;
				  $storevals['contact_phone'] = $merchant_info['Merchant']['phone'];
				  $storevals['last_modified'] = date('Y-m-d H:i:s');
				  $storevals['status']=$fields['status'];
				  if(!empty($fields['id']))
				  {
				  	$storevals['id']=$fields['id'];
				  }
				  $this->Product_store->save($storevals); 
				
				  $storevals_langs['title'] = $fields['title'];
				  $storevals_langs['store_id'] = empty($fields['id'])?$this->Product_store->getLastInsertId():$fields['id'];
				  $storevals_langs['lang_id'] = $fields['lang_id'];
				  $storevals_langs['description'] =  $fields['description'];
				  $storevals_langs['status'] = $fields['status'];
				   if(!empty($fields['lange_id']))
				  {
				  	 $storevals_langs['id'] = $fields['lange_id'];
				  }
				 
				  
			   $save = $this->Product_store_lang->save($storevals_langs);
			   if($save)
			   { 
			   	$this->Session->setFlash('The Store Information Updated Successfully', 'default', array(), 'msg');}
			   }
		$storeinfo = $this->Product_store->Product_store_lang->find('first',array('conditions'=>array('merchant_id'=>$this->merchantid,'Product_store_lang.lang_id'=>$lang_id)));
	  	if(empty($storeinfo))
	  	{
	  		$storeinfo = $this->Product_store->find('first',array('conditions'=>array('merchant_id'=>$this->merchantid)));
	  	}

	  	  $this->set('store_info', $storeinfo); 
		 // print_r($storeinfo); exit;
		}
		  
		 
    }
}