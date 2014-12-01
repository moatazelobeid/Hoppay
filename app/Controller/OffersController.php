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
App::uses('CakeTime', 'Utility','Error');


/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class OffersController extends AppController {
public $helpers = array('Html', 'Form','Session','Paginator','Fck','Template');
 public $components = array('Session','Paginator','Cookie');
/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array('Merchant','Merchant_login','Menu','Product_category','Product_category','Product_brand','Product_brand_lang','Product','Product_lang','Offer');

	public $merchantid="";
    public $common="";
    public $merchant_data="";
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
             $merchant_menu=$this->Menu->find('threaded',array('conditions'=>array('Menu_position.slug'=>'merchant-top','Menu_position.status'=>1,'Menu.status'=>1),'order' => array('Menu.order ASC')));
            //print_r($merchant_menu);
            $this->set('merchant_menu',$merchant_menu);
            if(in_array($this->params['action'],array('comming_soon','PrivacyPolicy','TermsAndConditions','HelpCenter','faq','ContactUs','HintsTips','partners','HowItWorks','DataFeedSpecification','SuccessStories')))
            {
                 if( $this->Session->check('Merchant'))
               {
                 $this->merchantid = $this->Session->read('Merchant.id');
                 //$this->set('merchantid',$this->merchantid);
                 $this->set('merchantid',$this->merchantid);
                 $useremail = $this->Session->read('Merchant.email');
                 $data=$this->Merchant->find('first',array('conditions'=>array('Merchant.merchant_id'=>$this->merchantid)));
                 //debug($data);
                 $this->merchant_data=$data;
                 $this->set('merchant',$data);
                 $data_prod=$this->Product->find('count',array('conditions'=>array('Product.retailer_id'=>$this->merchantid)));
                 
                 // print_r(count($data_prod));
                 $this->set('products_count',$data_prod);
                 $data_off=$this->Offer->find('count',array('conditions'=>array('Offer.merchant_id'=>$this->merchantid,'status'=>1)));
                 //print_r($data_off);
                 $this->set('offer_count',$data_off);


               }
            }
            else
            {               

            if(!in_array($this->params['action'],array('login','signup','forgot_password','index','activate','send_activation')))
		   	{
		   	  if( $this->Session->check('Merchant'))
               {
                 $this->merchantid = $this->Session->read('Merchant.id');
                 $this->set('merchantid',$this->merchantid);
                 $useremail = $this->Session->read('Merchant.email');
                 $data=$this->Merchant->find('first',array('conditions'=>array('Merchant.merchant_id'=>$this->merchantid)));
                 //debug($data);
                 $this->merchant_data=$data;

                 $this->set('merchant',$data);
                 $data_prod=$this->Product->find('count',array('conditions'=>array('Product.retailer_id'=>$this->merchantid)));
                 
                 // print_r(count($data_prod));
                 $this->set('products_count',$data_prod);
                 $data_off=$this->Offer->find('count',array('conditions'=>array('Offer.merchant_id'=>$this->merchantid,'status'=>1)));
                 //print_r($data_off);
                 $this->set('offer_count',$data_off);


               }
                if(!$this->merchantid)
				{
					$this->redirect( array('controller' => 'merchant', 'action' => 'login','lang'=>isset($this->params['lang'])?$this->params['lang']:'en'));
				   //$this->redirect('/merchant/login');
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
           }
         //$func=$this->params['action'];
        // echo method_exists($this,$func);
         //if(!method_exists($this,$func))
         //{
        //  $this->cakeError('error404');
         //}
           $this->loadModel('Setting');
		$config_settings=$this->Setting->find('all',array('conditions' => array('Setting.id' =>'1')));
		$this->set("setting",$config_settings[0]);
        $this->common=new CommonFunction($this->merchantid);
    }

	public function merchant_index() 
	{
		$this->set('text_data',array('title'=>'Offers & Deals'));
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
		
		$this->merchantid = $this->Session->read('Merchant.id');
		
		if(isset($offer_type) && $offer_type == 'discount')
			$offer_type=1;
		if(isset($offer_type) && $offer_type == 'coupon_code')
			$offer_type=2;
		
		$text_search=isset($text_search)?$text_search:"";      
		
		$this->Paginator->settings = array(
		'conditions' => array('merchant_id'=>$this->merchantid,'Offer.offer_title LIKE' => '%'.$text_search.'%',(isset($offer_type) and $offer_type!="")?'Offer.offer_type':'Offer.offer_type !='=>isset($offer_type)?$offer_type:"",
		(isset($status) and $status!="")?'Offer.status':'Offer.status !='=>isset($status)?$status:""),
		'limit' => 10
		);
		
		
		$data=$this->paginate('Offer');
		
		//echo '<pre>'; print_r($data); echo '</pre>'; //exit;
		
		$this->set('offerlist',$data);
		$this->set('condition',$condition);
	}
	
	public function merchant_add_offer() 
	{
		$this->set('text_data',array('title'=>'Add Offer'));
		//Get login merchant id
		$this->merchantid = $this->Session->read('Merchant.id');
		
		if($this->request->is('post'))
		{
			$condition=$this->request['url'];
			extract($condition);
			$lang_id=isset($lang_id)?$lang_id:1;
               
			$val=$this->request->data;
			
			$val['offer_title'] = strip_tags(trim($val['offer_title']));
			$val['offer_desc'] = strip_tags(trim($val['offer_desc']));
			$val['other_offer_type'] = strip_tags(trim($val['other_offer_type']));
			$val['created_date'] = date('Y-m-d H:i:s');
			$val['merchant_id'] = $this->merchantid;
			$val['start_date'] = date('Y-m-d',strtotime($val['start_date']));
			$val['end_date'] = date('Y-m-d',strtotime($val['end_date']));
			
			
			if (isset($_FILES['offer_image']) and $_FILES['offer_image']['tmp_name']!="") 
			{
				$val['offer_image'] = @$this->uploadImage('offer_image','uploads/offers');
			}
	
			
			$check=$this->Offer->save($val);
			
			if($check)
			{
				$this->Session->setFlash('Offer Added Successfully!', 'default', array(), 'msg');
			}
			else
			{
				$this->Session->setFlash('Updated Not Added', 'default', array(), 'msg');
			}
		}
		
	}
	
	//update offers
	function merchant_update($id)
	{
		$this->set('text_data',array('title'=>'Update Offer'));
		
		if($this->request->is('post'))
		{
			$val=$this->request->data;
			
			$val['offer_title'] = strip_tags(trim($val['offer_title']));
			$val['id'] = $id;
			$val['start_date'] = date('Y-m-d',strtotime($val['start_date']));
			$val['end_date'] = date('Y-m-d',strtotime($val['end_date']));
			
			$val['offer_desc'] = strip_tags(trim($val['offer_desc']));
			$val['other_offer_type'] = strip_tags(trim($val['other_offer_type']));
			
			if (isset($_FILES['offer_image']) and $_FILES['offer_image']['tmp_name']!="") 
			{
				$val['offer_image'] = @$this->uploadImage('offer_image','uploads/offers');
			}
	
			$check=$this->Offer->save($val);
			
			if($check)
			{
				$this->Session->setFlash('Offer Updated Successfully!', 'default', array(), 'msg');
			}
			else
			{
				$this->Session->setFlash('Offer Not Updated', 'default', array(), 'msg');
			}
		}
		
		$data=$this->Offer->find('first',array('conditions'=>array('Offer.id'=>$id)));
		
		//echo '<pre>'; print_r($data); echo '</pre>';
		
		$this->set('offer',$data);
	}
	
	
	public function uploadImage($name,$uploadFolder="",$types=null){
			if(is_array($name)){
				 $image = $name;
			}else
			{
				 $image = $_FILES[$name];
			}
		 if (isset($image) and $image['name']!="") {

		   
			//allowed image types
			if(is_null($types)){
				$imageTypes = array("image/gif", "image/jpeg","image/jpeg", "image/png");
			}
			else
			{
				$imageTypes=$types;
			}

			//upload folder - make sure to create one in webroot
		   // $uploadFolder = "uploads/page";
			//full path to upload folder
			$uploadPath = WWW_ROOT . $uploadFolder;
		   

			//check if image type fits one of allowed types
			
				if (in_array($image['type'] , $imageTypes)) {
				  //check if there wasn't errors uploading file on serwer
					if ($image['error'] == 0) {
						 //image file name
						$imageName = $image['name'];
						//check if file exists in upload folder
						if(!in_array($name,array('logo','favicon'))){
							if (file_exists($uploadPath . '/' . $imageName)) {
							//create full filename with timestamp
							$imageName = date('His') . $imageName;
						  }
						}
						
						//create full path with image name

						$full_image_path = $uploadPath . '/' . $imageName;
						$genralPath=$uploadFolder.'/'.$imageName;
						//upload image to upload folder
						if (move_uploaded_file($image['tmp_name'], $full_image_path)) {
						   
							return $genralPath;                               

						} else {
							$this->Session->setFlash('There was a problem uploading file. Please try again.', 'default', array(), 'bad');
							return 0;
						}
					} else {
						$this->Session->setFlash('Error uploading file.', 'default', array(), 'bad');
						return 0;
					}
				   
				} else {
					$this->Session->setFlash('Unacceptable file type', 'default', array(), 'bad');
					return 0;
				}
			
		}
	}
		
		
		
	public function merchant_set_product($id)
	{
		$this->set('text_data',array('title'=>'Set Product Offer'));
		
		$lang_id=isset($lang_id)?$lang_id:1;
		
		$catlist=$this->Product_category->Product_category_lang->find('all', array(
										'conditions'=>array(
											'Product_category.status'=>1,
											'Product_category.parent_id'=>0,
											'Product_category_lang.lang_id' =>$lang_id
										)));
		
		//echo '<pre>'; print_r($pids); echo '</pre>'; exit;
		
		$this->set('catlist',$catlist);
		
		if($this->request->is('post'))
		{
			$val=$this->request->data;
			
			//echo '<pre>'; print_r($pids); echo '</pre>'; exit;
			
			if(!empty($val['product']))
			{
				$cnt = 0;
				foreach($val['product'] as $pid)
				{
					$product['id'] = 	$pid;
					$product['offer_id'] = 	$id;
					$check=$this->Product->save($product);
					if($check)
						$cnt++;
				}	
			}
			
			if(!empty($val['category_id']))
			{
				foreach($val['category_id'] as $cid)
				{
					$product['category_id'] = 	$cid;
					$product['offer_id'] = 	$id;
					$check=$this->Product->save($product);
					if($check)
						$cnt++;
				}	
			}
			
			if(!empty($cnt))
			{
				$this->Session->setFlash('Product Assigned Successfully!', 'default', array(), 'msg');
			}
			else
			{
				$this->Session->setFlash('Product Not Assigned', 'default', array(), 'msg');
			}
		}
		$data=$this->Offer->find('first',array('conditions'=>array('Offer.id'=>$id)));
		
		//echo '<pre>'; print_r($data); echo '</pre>';
		
		$this->set('offer',$data);
		
		//Fetch all products
		$this->merchantid = $this->Session->read('Merchant.id');
		
		$this->Paginator->settings = array(
		'conditions' => array('retailer_id'=>$this->merchantid,'Product.status'=>1,'Product_lang.lang_id'=>$lang_id),
		'order' => array('Product_lang.title'=>'asc'),  
		'limit' => 100
		);

		$products = $this->paginate('Product_lang');
		$this->set('products',$products);
	}
	
	public function get_subcat($offer_id,$id,$slno=0)
	{
		
		$slno = $slno+1;
		$lang_id=isset($lang_id)?$lang_id:1;
		$subcats = $this->Product_category->Product_category_lang->Find('all', 
							array(
							'conditions'=>array(
								'Product_category.parent_id'=>$id,
								'Product_category.status'=>1,
								'Product_category_lang.lang_id'=> $lang_id
							),
							'order' => array('Product_category_lang.category_name'=>'asc')
						)
					); 
		
		
		$result = '';
		if(!empty($subcats))
		{
			$result .= '<fieldset id="cat_lvl_'.$slno.'">
						
						<select name="category_id[]" id="cat_'.$slno.'" class="valid catlist_box" onchange="getSubcat(this.value,'.$slno.');">
						<option value="">Select Category</option>';
			
			foreach($subcats as $subcat)
			{
				
				$scatid = $subcat['Product_category']['id'];
				$scatname = $subcat['Product_category_lang']['category_name'];
				$result .= '<option value="'.$scatid.'">'.$scatname.'</option>';
				
			}
			
			$result.= '</select>
			<a href="javaScript:void(0);" onclick="removeCat('.$slno.')">Remove</a>
			</fieldset>';
		}
		
		//Get all related sub categories of the selected category
		$children = $this->Product_category->children($id);
		
		$all_subid = Hash::extract($children, '{n}.Product_category.id');
		
		array_unshift($all_subid, $id);
		
		$this->merchantid = $this->Session->read('Merchant.id');
		
		$this->Paginator->settings = array(
		'conditions' => array('retailer_id'=>$this->merchantid,'Product.status'=>1,'Product.category_id'=>$all_subid),
		'order' => array('Product_lang.title'=>'asc'),  
		'limit' => 100
		);

		$products = $this->paginate('Product_lang');
		
		//Get all products
		/*$products = $this->Product->Product_lang->Find('all', 
							array(
									'conditions'=>array(
										'Product.status'=>1,
										'Product.retailer_id'=>$this->merchantid,
										'Product.category_id'=>$id,
										//'Product_lang.lang_id'=>$lang_id
									),
									'order' => array('Product_lang.title'=>'asc')
								)	
							); */
							
							
							
		//echo '<pre>'; print_r($children); echo '</pre>'; exit;	 		
		
		$product_result = '';
		
		if(!empty($products))
		{
			$product_result.= '<div id="product_list">
								<h3><input type="checkbox" onclick="checkAllProducts();" id="chkall" /> Select Product</h3><div id="perr_msg"></div>';
			foreach($products as $product)
			{
				$pid = $product['Product']['id'];	
				$pname = stripslashes($product['Product_lang']['title']);	
				
				$checked='';
				
				if($offer_id == $product['Product']['offer_id'])
					$checked='checked="checked"';
					
				if(!empty($product['Product']['offer_id']))
				{
					$pofferid = $product['Product']['offer_id'];
					$offer_data = $this->Offer->find('first',array('conditions'=>array('Offer.id'=>$pofferid)));	
					$offer_name = stripslashes($offer_data['Offer']['offer_title']);
					
					if($offer_data['Offer']['offer_type']==3)
						$offer_name = stripslashes($offer_data['Offer']['other_offer_type']);
					
					if(!empty($offer_name))
					{
						$pname = '<b>'.$pname.'</b> ('.$offer_name.')';
					}	 
				}
				else
				{
					$offer_name = '';	
				}
				
				$product_result.= '<input type="checkbox" class="pid_chk" name="product[]" value="'.$pid.'" '.$checked.' />'.$pname.'<br>';
			}	
			
			
			$product_result.= '</div>';
		}	
		else
		{
			$product_result.= '<div class="no_msg">No Product Found</div>';	
		}	
		
		$total_result = $result.'~*~'.$product_result;					
		
		echo $total_result; exit;
	}
	
	
	public function get_allproducts($offer_id)
	{
		$lang_id=isset($lang_id)?$lang_id:1;
		
		//Fetch all products
		$this->merchantid = $this->Session->read('Merchant.id');
		
		$this->Paginator->settings = array(
		'conditions' => array('retailer_id'=>$this->merchantid,'Product.status'=>1,'Product_lang.lang_id'=>$lang_id),
		'order' => array('Product_lang.title'=>'asc'),  
		'limit' => 100
		);
		$products = $this->paginate('Product_lang');
		$product_result = '';
		if(!empty($products))
		{
			$product_result.= '<div id="product_list">
								<h3><input type="checkbox" onclick="checkAllProducts();" id="chkall" /> Select Product</h3><div id="perr_msg"></div>';
			foreach($products as $product)
			{
				$pid = $product['Product']['id'];	
				$pname = stripslashes($product['Product_lang']['title']);	
				
				$checked='';
				
				if($offer_id == $product['Product']['offer_id'])
					$checked='checked="checked"';
					
				if(!empty($product['Product']['offer_id']))
				{
					$pofferid = $product['Product']['offer_id'];
					$offer_data = $this->Offer->find('first',array('conditions'=>array('Offer.id'=>$pofferid)));	
					$offer_name = stripslashes($offer_data['Offer']['offer_title']);
					
					if($offer_data['Offer']['offer_type']==3)
						$offer_name = stripslashes($offer_data['Offer']['other_offer_type']);
					
					if(!empty($offer_name))
					{
						$pname = '<b>'.$pname.'</b> ('.$offer_name.')';
					}	 
				}
				else
				{
					$offer_name = '';	
				}
				
				$product_result.= '<input type="checkbox" class="pid_chk" name="product[]" value="'.$pid.'" '.$checked.' />'.$pname.'<br>';
			}	
			
			
			$product_result.= '</div>';
		}	
		else
		{
			$product_result.= '<div class="no_msg">No Product Found</div>';	
		}	
		echo $product_result; exit;
		
	}
	
	public function merchant_delete($id)
	{
		//$this->Offer->id=$id;
		$check=$this->Offer->delete(array('Offer.id'=>$id));
		
		//Update offer id of products
		$this->Product->delete(array('Product.offer_id'=>$id));
		
		if($check)
		{
			$this->Session->setFlash('Offer Deleted Successfully!', 'default', array(), 'msg');
			$this->redirect('/en/merchant/offers');
		}
	
	}
	
       public function bulk_active(){
        $this->layout = 'ajax';
       if($this->request->is('post')){
           $val_arr=$this->request->data('ids');
           $model= $this->request->data('model');        
           $val_arr=json_decode($val_arr);           
           $this->loadmodel($model);
           foreach($val_arr as $val){
               $this->{$model}->id=$val;
               $this->{$model}->save(array('status'=>'1'));
           }
          echo 1;
       }
       $this->render('ajax');
    }
    public function bulk_inactive(){
        $this->layout = 'ajax';
       if($this->request->is('post')){
           $val_arr=$this->request->data('ids');
           $model= $this->request->data('model');        
           $val_arr=json_decode($val_arr);           
           $this->loadmodel($model);
           foreach($val_arr as $val){
               $this->{$model}->id=$val;
               $this->{$model}->save(array('status'=>'0'));
           }
          echo 1;
       }
       $this->render('ajax');
    }
    public function bulk_delete(){
        $this->layout = 'ajax';
       if($this->request->is('post')){
           $val_arr=$this->request->data('ids');
           $model= $this->request->data('model');        
           $val_arr=json_decode($val_arr);           
           $this->loadmodel($model);
           foreach($val_arr as $val){
               $this->{$model}->id=$val;
               $this->{$model}->delete();
		
				//Update offer id of products
				$this->Product->delete(array('Product.offer_id'=>$val));
		
           }
          echo 1;
       }
       $this->render('ajax');
    }	
	
}

