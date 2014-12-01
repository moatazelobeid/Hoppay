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
//App::import('Vendor', 'inflector');
App::uses('CakeTime', 'Utility');
/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class ProductsController extends AppController {
 public $helpers = array('Html', 'Form','Session','Paginator','Fck','Template');
 public $components = array('Session','Paginator','Cookie','RequestHandler','Ctrl');
 //public $scaffold = 'merchant'; 
/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array('Merchant','Unique_visitor','Merchant_rating','Product_review','Reviewed_user','Setting','Merchant_login','Product_store','Product_category','Menu','Product_category_lang','Product_brand','Product_brand_lang','Product','Product_lang','Click_track');

	public $merchantid="";
    public $common="";
    public $merchant_detail="";
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
             $this->Cookie->name = 'recent_review';
            $this->Cookie->time = '12 hour';  // or '12 hour'
            $this->Cookie->path = '/';
            $this->Cookie->domain = '';
            $this->Cookie->secure = false;  // i.e. only sent if using secure HTTPS
            $this->Cookie->key = 'qSI232qs*&sXOw!adre@34SAv!@*(XSL#$%)asGb$@11~_+!@#HKis~#^';
            $this->Cookie->httpOnly = true;
            $this->Cookie->type('rijndael');
            // echo"<pre>";print_r($this->Cookie->read()); echo"</pre>";
            
            $condition=$this->request['url'];
            
     if(isset($this->request->params['prefix']) and $this->request->params['prefix']=="admin")
     {
       $this->set('site_title',$this->sitetitle);
        if($this->params['action']!='login')
        {
              if( $this->Cookie->check('Admin'))
                 {
                  // print_r($this->Cookie->read('Admin'));
                   $this->userid = $this->Cookie->read('Admin.id');
                   $useremail = $this->Cookie->read('Admin.email');
                 }
                 else if( $this->Session->check('Admin'))
                 {
                   $this->userid = $this->Session->read('Admin.id');
                   $useremail = $this->Session->read('Admin.email');
                 }
       if(!$this->userid)
        {
           $this->redirect('/admin/login');
                 exit();
        }
        else{    
                 $this->loadmodel('User');
               $data=$this->User->find('first',array ('conditions' => array('email' => $useremail,'id'=>$this->userid,'user_type'=>'A','status'=>'1')));
               if($data){    
              $this->set('site_title',$this->sitetitle);
              $this->set('admin_name',$data['User']['name']);
            $this->Session->write(array('Admin'=>array('id'=>$data['User']['id'],'email'=>$data['User']['email'])));
                }
             else
             {
               $this->logout();
               $this->redirect('/admin/login');             
                       exit();
             }
        }
      }
      else
      {

      }
        $this->layout = 'admin';
       // echo $this->request->params['prefix'];
     }
      else if(isset($this->request->params['prefix']) and $this->request->params['prefix']=="merchant")
      {
       if(!isset($condition['ajax']))
       {
           

            $this->layout = 'merchant';
          
            $merchant_menu=$this->Menu->find('threaded',array('conditions'=>array('Menu_position.slug'=>'merchant-top','Menu_position.status'=>1,'Menu.status'=>1),'order' => array('Menu.order ASC')));
            //print_r($merchant_menu);
            $this->set('merchant_menu',$merchant_menu);
            if(!in_array($this->params['action'],array()))
		   	{
		   	  if( $this->Session->check('Merchant'))
               {
                 $this->merchantid = $this->Session->read('Merchant.id');
                 $this->set('merchantid',$this->merchantid );
                 $useremail = $this->Session->read('Merchant.email');
                 $this->merchant_detail=$data=$this->Merchant->find('first',array('conditions'=>array('Merchant.merchant_id'=>$this->merchantid)));
               //debug($data);
                 $this->set('merchant',$data);
                   $data_prod=$this->Product->find('count',array('conditions'=>array('retailer_id'=>$this->merchantid)));
                 //print_r($data_prod);
                 $this->set('products_count',$data_prod);

               }
                if(!$this->merchantid)
				{
					$this->redirect( array('controller' => 'merchant', 'action' => 'index','lang'=>isset($this->params['lang'])?$this->params['lang']:'en'));
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
				    // $this->redirect('/merchant/dashbord');
	                exit();
				}
		   	}
       }
     }else
     {
         $config_settings=$this->Setting->find('all',array('conditions' => array('Setting.id' =>'1')));
         $this->set("setting",$config_settings[0]);
         $footer_menu=$this->Menu->find('threaded',array('conditions'=>array('Menu_position.slug'=>'home-footer','Menu_position.status'=>1,'Menu.status'=>1),'order' => array('Menu.order ASC')));
         $this->set('footer_menu',$footer_menu);
     }
        // $func=$this->params['action'];
        // echo method_exists($this,$func);
        // if(!method_exists($this,$func))
        // {
        //    $this->render('404');
       //  }
$this->loadModel('Setting');
    $config_settings=$this->Setting->find('all',array('conditions' => array('Setting.id' =>'1')));
    $this->set("setting",$config_settings[0]);
             $recent_viewd=$this->Cookie->read();
           //  print_r($recent_viewd);
             $this->set('recent_viewed',$recent_viewd);
        $this->common=new CommonFunction($this->merchantid);
    }
        /*public function index()
        {
             $this->set('text_data',array('title'=>'My Products'));
              $condition=$this->request['url'];
                extract($condition);
                 $lang_id=isset($lang_id)?$lang_id:1;
                //$cat_id=isset($cat_id)?$cat_id:"";
             $data_prod=$this->Product->find('all',array('conditions'=>array('retailer_id'=>$this->merchantid)));
             $category=array();
             foreach($data_prod as $key=>$val)
             {
                array_push($category,array('id'=>$val['Product']['category_id'],'name'=>$this->getCategoryById( $val['Product']['category_id'])));
             }
             $this->set('category',$category);
              $text_search=isset($text_search)?$text_search:"";      
              $this->Paginator->settings = array(
               'conditions' => array('retailer_id'=>$this->merchantid,'Product_lang.title LIKE' => '%'.$text_search.'%','Product_lang.lang_id'=>$lang_id,(isset($cat_id) and $cat_id!="")?'Product.category_id':'Product.category_id !='=>isset($cat_id)?$cat_id:"",(isset($status) and $status!="")?'Product.status':'Product.status !='=>isset($status)?$status:""),
                'limit' => 10
             );

            
              $data=$this->paginate('Product.Product_lang');
             
              foreach ($data as $key => $value) {
                   $data[$key]['Product']['category_id']=$this->getCategoryById( $value['Product']['category_id'],$lang_id);
                   $data[$key]['Product']['brand']=$this->getBrandById( $value['Product']['brand'],$lang_id);
              }
             
            $this->set('product_info',$data);
            $this->loadmodel('Language');
            $lang=$this->Language->find('all');           
            $this->set('lang', $lang);
           
        }*/

       public function merchant_index()
       {
           $this->set('text_data',array('title'=>'My Products'));
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
                             ),'limit'=>6));
    //print_r($offer);
    $this->set('offer',$offer);
              $condition=$this->request['url'];
                extract($condition);
                 $lang_id=isset($lang_id)?$lang_id:1;
                //$cat_id=isset($cat_id)?$cat_id:"";
             $data_prod=$this->Product->find('all',array('conditions'=>array('retailer_id'=>$this->merchantid)));
             $category=array();
             foreach($data_prod as $key=>$val)
             {

                array_push($category,$val['Product']['category_id']);
                //array_push($category,array('id'=>$val['Product']['category_id'],'name'=>$this->getCategoryById( $val['Product']['category_id'])));
             }
             $data_prod=array_unique(array_filter($category));
             unset($category);
             $category=array();
             foreach($data_prod as $key=>$val)
             {

                //array_push($category,$val['Product']['category_id']);
                array_push($category,array('id'=>$val,'name'=>$this->getCategoryById( $val)));
             }
             //print_r($category);
             $this->set('category',$category);
              $text_search=isset($text_search)?$text_search:"";      
              $this->Paginator->settings = array(
               'conditions' => array('retailer_id'=>$this->merchantid,'Product_lang.title LIKE' => '%'.$text_search.'%','Product_lang.lang_id'=>$lang_id,(isset($cat_id) and $cat_id!="")?'Product.category_id':'1'=>isset($cat_id)?$cat_id:"1",(isset($status) and $status!="")?'Product.status':'Product.status !='=>isset($status)?$status:""),
                'limit' => 20,
                'order'=>array('Product.id'=>'desc')
             );

            
              $data=$this->paginate('Product.Product_lang');
             
              foreach ($data as $key => $value) {
               // echo $value['Product']['brand']."sdghfshd";
                   $data[$key]['Product']['category_id']=$this->getCategoryById( $value['Product']['category_id'],$lang_id);
                   $data[$key]['Product']['brand']=$this->getBrandById( $value['Product']['brand'],$lang_id);
              }
             
            $this->set('product_info',$data);
            $this->loadmodel('Language');
            $lang=$this->Language->find('all');           
            $this->set('lang', $lang);
       }

       //model classes 
      public function getCategoryLangById($id="",$lang_id=1){
          $data=$this->Product_category_lang->find('first',array('conditions'=>array('cat_id'=>$id,'lang_id'=>$lang_id)));
          return $data['Product_category_lang']['category_name'];
      }
       public function getCategoryById($id="",$lang_id=1,$cond="normal"){
          if($cond=="normal")
          {
             $data= $this->Product_category->Product_category_lang->find('first',array('conditions'=>array('Product_category.id'=>$id,"Product_category_lang.lang_id"=>$lang_id)));

             return @htmlspecialchars_decode($data['Product_category_lang']['category_name']);
          }
          elseif($cond=="high")
          {
              $parents = $this->Product_category->getPath($id);
              $array_merg=array();
              foreach ($parents as $key => $value) {
                array_push($array_merg,$this->getCategoryLangById($value['Product_category']['id'],$lang_id));
              }
              $result=implode(' > ', $array_merg);
             return $result;
          }
       }
        public function getCategoryByName($name="",$lang_id=1){
           $this->layout = 'ajax';
           // echo $this->request->data['ajax'];
        
            $getId=$this->Product_category->Product_category_lang->find('all',array('conditions'=>array('Product_category_lang.category_name like'=>"%".trim($name)."%"),'limit'=>5));
           // echo "<pre>";
           // print_r( $getId);

            $final_res=array();
             foreach($getId as $k=>$v)
             {
                $parents = $this->Product_category->getPath($v['Product_category']['id']);
              //  print_r($parents);
                $array_merg=array();
                foreach ($parents as $key => $value) {
                  array_push($array_merg,$this->getCategoryLangById($value['Product_category']['id'],$lang_id));
                }
                $result=implode(' > ', $array_merg);
                 //print_r($result);
                array_push($final_res,array('value'=>$v['Product_category']['id'],'label'=>$result));
             }
           //  print_r($final_res);
             echo json_encode($final_res);
      
                 $this->render('ajax');
         
        }
        public function getBrandById($id="",$lang_id=1){
           $data= $this->Product_brand->Product_brand_lang->find('first',array('conditions'=>array('Product_brand.id'=>$id,"Product_brand_lang.lang_id"=>$lang_id)));
        //  print_r($data);
           return @htmlspecialchars_decode($data['Product_brand_lang']['brand_title']);
       }
       public function merchant_delete($id,$page=1){
            $this->Product->id=$id;
            $check=$this->Product->delete();
            if($check)
            {
                $this->Session->setFlash('Product Deleted Successfully!', 'default', array(), 'msg');
                $this->redirect('/en/merchant/products/page:'.$page);
                exit;
            }else
            {
                $this->Session->setFlash('Product Not Deleted!', 'default', array(), 'bad');
                $this->redirect('/en/merchant/products/page:'.$page);
                exit;
            }
            $this->render('ajax');
       }
        public function merchant_update($id="",$page=1){
           // $this->Product->id=$id;
          $this->set('text_data',array('title'=>'Update product'));
          if($id!="")
          {          
          
              $condition=$this->request['url'];
              extract($condition);
              $lang_id=isset($lang_id)?$lang_id:1;
              ini_set('post_max_size','50M');
              ini_set('upload_max_filesize','20M');
              ini_set('memory_limit','1000M');
               
             /* echo "<pre>";
                print_r($_POST);
                 echo "</pre>";*/
               if($this->request->is('post'))
                {
                  /*echo "post";*/
                 // echo "<pre>";
                 // print_r($this->request->data['product_details']);
                 // echo "</pre>";
                  $val=$this->request->data;
                 /* echo "<pre>";
                print_r($_REQUEST);
                 echo "</pre>";*/
                  $val1['title']=strip_tags(trim($val['title']));
                  $val1['description']=htmlspecialchars(trim($val['description']));
                  $val1['id']=trim($val['product_lang_id']);
                  $val1['product_details']=Hash::combine($val['product_details'], 'key.{n}','value.{n}');
                   //print_r($val1['product_details']);
                  $val1['product_details']=Hash::filter($val1['product_details']);
                  unset($val1['product_details']['']);
                  $val1['product_details']=htmlspecialchars(json_encode($val1['product_details']));
                  $val1['seo_details']=htmlspecialchars(json_encode($val['seo_details']));
                  unset($val['title']);
                  unset($val['description']);
                  unset($val['product_lang_id']);
                  unset($val['seo_details']);

                   $val['image_url']=json_encode(explode(',',$val['tags']));
                   $val['is_error']=0;
                   $val['last_modified']=date('Y-m-d');
                    $this->Product->id=$id;
                    $check=$this->Product->save($val);
                    if($check)
                    {
                      $check1=$this->Product_lang->save($val1);
                      if($check1){
                         $this->Session->setFlash('Product Updated Successfully!', 'default', array(), 'msg');
                         $this->redirect('/merchant/products/page:'.$page);
                         exit;
                      }
                      else {
                        $this->Session->setFlash('Product Not Updated', 'default', array(), 'msg');
                      }
                    }
                    else {
                        $this->Session->setFlash('Product Not Updated', 'default', array(), 'msg');
                      }

                }
              $prod_data=$this->Product->Product_lang->find('first',array('conditions'=>array('Product.id'=>$id,'Product_lang.lang_id'=>$lang_id)));
             if(!empty($prod_data))
             {
              $prod_data['Product']['category']=$this->getCategoryById($prod_data['Product']['category_id'],1,'high');
              $this->loadmodel('Product_brand');
              $lang=$this->Product_brand->find('all');
              $this->set('brand', $lang);

             $this->loadmodel('Language');
             $lang=$this->Language->find('all');
             $this->set('lang', $lang);
            
             $this->set('prod_data', $prod_data);
             }else
             {
            //  $this->set('title_404','Update Products')
              $this->render('merchant_404');
             }

        }
        else
        {
            $this->render('merchant_404');
        }
           

       }
        /* public function update($id=""){
           // $this->Product->id=$id;
          $this->set('text_data',array('title'=>'Update product'));
          if($id!="")
          {          
          
              $condition=$this->request['url'];
              extract($condition);
              $lang_id=isset($lang_id)?$lang_id:1;
               if($this->request->is('post'))
                {
                 // echo "<pre>";
                //  print_r($this->request->data);
                  //echo "</pre>";
                  $val=$this->request->data;

                  $val1['title']=strip_tags(trim($val['title']));
                  $val1['description']=htmlspecialchars(trim($val['description']));
                  $val1['id']=trim($val['product_lang_id']);
                   
                   unset($val['title']);
                   unset($val['description']);
                   unset($val['product_lang_id']);

                   $val['image_url']=json_encode(explode(',',$val['tags']));
                   $val['is_error']=0;
                   $val['last_modified']=date('Y-m-d');
                    $this->Product->id=$id;
                    $check=$this->Product->save($val);
                    if($check)
                    {
                      $check1=$this->Product_lang->save($val1);
                      if($check1){
                         $this->Session->setFlash('Product Updated Successfully!', 'default', array(), 'msg');
                      }
                      else {
                        $this->Session->setFlash('Product Not Updated', 'default', array(), 'msg');
                      }
                    }
                    else {
                        $this->Session->setFlash('Product Not Updated', 'default', array(), 'msg');
                      }

                }
              $prod_data=$this->Product->Product_lang->find('first',array('conditions'=>array('Product.id'=>$id,'Product_lang.lang_id'=>$lang_id)));
             if(!empty($prod_data))
             {
              $prod_data['Product']['category']=$this->getCategoryById($prod_data['Product']['category_id'],1,'high');
            

             $this->loadmodel('Product_brand');
             $lang=$this->Product_brand->find('all');
             $this->set('brand', $lang);

             $this->loadmodel('Language');
             $lang=$this->Language->find('all');
             $this->set('lang', $lang);
            
             $this->set('prod_data', $prod_data);
             }else
             {
            //  $this->set('title_404','Update Products')
              $this->render('merchant_404');
             }

        }else
        {
            $this->render('merchant_404');
        }
           

       } */

       //---//model classes ----//
         # @ Ajax bulk order
      public function bulk_order(){
         $this->layout = 'ajax';
         if($this->request->is('post')){
       
             $val_arr=$this->request->data('ids');
             $arr_data=$this->request->data('datas');
             $model= $this->request->data('model');   
             $field=$this->request->data('field');   
             $val_arr=json_decode($val_arr);   
             $arr_data= json_decode($arr_data);        

             $this->loadmodel($model);
             foreach($val_arr as $k=>$val){
                 $this->{$model}->id=$val;
                 $this->{$model}->save(array($field=>$arr_data[$k]));
             }
            echo 1;
         }
         $this->render('ajax');
      }

//.....--------------------------------------------------
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
           }
          echo 1;
       }
       $this->render('ajax');
    }
    public function merchant_download() {
    $this->viewClass = 'Media';
    App::import('Vendor', 'PHPExcel/Classes/PHPExcel');
    App::import('Vendor', 'PHPExcel/Classes/PHPExcel/Cell/AdvancedValueBinder.php');
    App::import('Vendor', 'PHPExcel/Classes/PHPExcel/IOFactory');
    PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator($this->merchant_detail['Merchant']['first_name']);
    $objPHPExcel->getProperties()->setLastModifiedBy($this->merchant_detail['Merchant']['first_name']);
    $objPHPExcel->getProperties()->setTitle($this->merchant_detail['Merchant']['website_name']." ".date('Y-m-d'));
    $objPHPExcel->getProperties()->setSubject($this->merchant_detail['Merchant']['website_name']." Product feed of  ".date('Y-m-d'));
    $objPHPExcel->getProperties()->setDescription($this->merchant_detail['Merchant']['website_name']." Product feed of  ".date('Y-m-d'));
    $objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
    $objPHPExcel->getProperties()->setCategory("DATAFEED");
    $objPHPExcel->setActiveSheetIndex(0);

    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
  //  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(50);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(50);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);

    $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Product ID');
    $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Product Title');
    $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Product Title (Arabic)');
    $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Product Description');
    $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Product Description (Arabic)');
    $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Product URL');
    $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Price');
    $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Brand');
    $objPHPExcel->getActiveSheet()->setCellValue('I1', 'Condition');
    $objPHPExcel->getActiveSheet()->setCellValue('J1', 'Image URLs');
    $objPHPExcel->getActiveSheet()->setCellValue('K1', 'ISBN');
    $objPHPExcel->getActiveSheet()->setCellValue('L1', 'MPN');
    $objPHPExcel->getActiveSheet()->setCellValue('M1', 'UPC');
    $objPHPExcel->getActiveSheet()->setCellValue('N1', 'Weight');
    $objPHPExcel->getActiveSheet()->setCellValue('O1', 'Height');
    $objPHPExcel->getActiveSheet()->setCellValue('P1', 'Width');
    $objPHPExcel->getActiveSheet()->setCellValue('Q1', 'Category');
    $objPHPExcel->getActiveSheet()->setCellValue('R1', 'Quantity');
    $objPHPExcel->getActiveSheet()->setCellValue('S1', 'Shipping');
    $objPHPExcel->getActiveSheet()->setCellValue('T1', 'Tax');
    $objPHPExcel->getActiveSheet()->setCellValue('U1', 'Product Details');
    $objPHPExcel->getActiveSheet()->setCellValue('V1', 'Product Details (Arabic)');
    $objPHPExcel->getActiveSheet()->setCellValue('W1', 'SEO KEYWORD/DESCRIPTIONS');
    $objPHPExcel->getActiveSheet()->setCellValue('X1', 'SEO KEYWORD/DESCRIPTIONS (Arabic)');

    $objPHPExcel->getActiveSheet()->setCellValue('A2', 'id');
    $objPHPExcel->getActiveSheet()->setCellValue('B2', 'title');
    $objPHPExcel->getActiveSheet()->setCellValue('C2', 'title_ar');
    $objPHPExcel->getActiveSheet()->setCellValue('D2', 'description');
    $objPHPExcel->getActiveSheet()->setCellValue('E2', 'description_ar');
    $objPHPExcel->getActiveSheet()->setCellValue('F2', 'link');
    $objPHPExcel->getActiveSheet()->setCellValue('G2', 'price');
    $objPHPExcel->getActiveSheet()->setCellValue('H2', 'brand');
    $objPHPExcel->getActiveSheet()->setCellValue('I2', 'condition');
    $objPHPExcel->getActiveSheet()->setCellValue('J2', 'image_link');
    $objPHPExcel->getActiveSheet()->setCellValue('K2', 'isbn');
    $objPHPExcel->getActiveSheet()->setCellValue('L2', 'mpn');
    $objPHPExcel->getActiveSheet()->setCellValue('M2', 'upc');
    $objPHPExcel->getActiveSheet()->setCellValue('N2', 'weight');
    $objPHPExcel->getActiveSheet()->setCellValue('O2', 'height');
    $objPHPExcel->getActiveSheet()->setCellValue('P2', 'width');
    $objPHPExcel->getActiveSheet()->setCellValue('Q2', 'category');
    $objPHPExcel->getActiveSheet()->setCellValue('R2', 'quantity');
    $objPHPExcel->getActiveSheet()->setCellValue('S2', 'shipping');
    $objPHPExcel->getActiveSheet()->setCellValue('T2', 'tax');
    $objPHPExcel->getActiveSheet()->setCellValue('U2', 'product_details');
    $objPHPExcel->getActiveSheet()->setCellValue('V2', 'product_details_ar');
    $objPHPExcel->getActiveSheet()->setCellValue('W2', 'seo_details');
    $objPHPExcel->getActiveSheet()->setCellValue('X2', 'seo_details_ar');

    $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Required');
    $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
    $objPHPExcel->getActiveSheet()->setCellValue('B3', 'Required');
    $objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
    $objPHPExcel->getActiveSheet()->setCellValue('C3', 'Recommended');
    $objPHPExcel->getActiveSheet()->setCellValue('D3', 'Required');
    $objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
    $objPHPExcel->getActiveSheet()->setCellValue('E3', 'Recommended');
    $objPHPExcel->getActiveSheet()->setCellValue('F3', 'Required');
    $objPHPExcel->getActiveSheet()->getStyle('F3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
    $objPHPExcel->getActiveSheet()->setCellValue('G3', 'Required');
    $objPHPExcel->getActiveSheet()->getStyle('G3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
    $objPHPExcel->getActiveSheet()->setCellValue('H3', 'Recommended');
    $objPHPExcel->getActiveSheet()->setCellValue('I3', 'Required');
    $objPHPExcel->getActiveSheet()->getStyle('I3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
    $objPHPExcel->getActiveSheet()->setCellValue('J3', 'Required');
    $objPHPExcel->getActiveSheet()->getStyle('J3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
    $objPHPExcel->getActiveSheet()->setCellValue('K3', 'Recommended');
    $objPHPExcel->getActiveSheet()->setCellValue('L3', 'Recommended');
    $objPHPExcel->getActiveSheet()->setCellValue('M3', 'Recommended');
    $objPHPExcel->getActiveSheet()->setCellValue('N3', 'Recommended');
    $objPHPExcel->getActiveSheet()->setCellValue('O3', 'Recommended');
    $objPHPExcel->getActiveSheet()->setCellValue('P3', 'Recommended');
    $objPHPExcel->getActiveSheet()->setCellValue('Q3', 'Required');
    $objPHPExcel->getActiveSheet()->getStyle('Q3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
    $objPHPExcel->getActiveSheet()->setCellValue('R3', 'Required');
    $objPHPExcel->getActiveSheet()->getStyle('R3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
    $objPHPExcel->getActiveSheet()->setCellValue('S3', 'Recommended');
    $objPHPExcel->getActiveSheet()->setCellValue('T3', 'Recommended');
    $objPHPExcel->getActiveSheet()->setCellValue('U3', 'Required');
    $objPHPExcel->getActiveSheet()->setCellValue('V3', 'Recommended');
    $objPHPExcel->getActiveSheet()->setCellValue('W3', 'Recommended');
    $objPHPExcel->getActiveSheet()->setCellValue('X3', 'Recommended');

    $objPHPExcel->getActiveSheet()->getRowDimension('2')->setVisible(false);
    $data=$this->Product->find('all',array('conditions',array('merchant_id'=>$this->merchantid)));
    foreach($data as $key=>$var)
    {
      $keys=$key+4;
      $objPHPExcel->getActiveSheet()->setCellValue('A'.$keys, $var['Product']['merchant_product_id']);
      foreach($var['Product_lang'] as $k=>$val)
      {
        if($val['lang_id']==1)
        {
         $objPHPExcel->getActiveSheet()->setCellValue('B'.$keys, isset($val['title'])?htmlspecialchars_decode(trim($val['title'])):"");
         $objPHPExcel->getActiveSheet()->getStyle('B'.$keys)->getAlignment()->setWrapText(true);


          $objPHPExcel->getActiveSheet()->setCellValue('D'.$keys, isset($val['description'])?htmlspecialchars_decode(trim($val['description'])):"");
          $objPHPExcel->getActiveSheet()->getStyle('D'.$keys)->getAlignment()->setWrapText(true);

          $objPHPExcel->getActiveSheet()->setCellValue('U'.$keys, isset($val['product_details'])?htmlspecialchars_decode(trim($val['product_details'])):"");
          $objPHPExcel->getActiveSheet()->getStyle('U'.$keys)->getAlignment()->setWrapText(true);

          $objPHPExcel->getActiveSheet()->setCellValue('W'.$keys, isset($val['seo_details'])?htmlspecialchars_decode(trim($val['seo_details'])):"");
          $objPHPExcel->getActiveSheet()->getStyle('W'.$keys)->getAlignment()->setWrapText(true);
       }elseif($val['lang_id']==2)
       {
         $objPHPExcel->getActiveSheet()->setCellValue('c'.$keys, isset($val['title'])?htmlspecialchars_decode(trim($val['title'])):"");
         $objPHPExcel->getActiveSheet()->getStyle('C'.$keys)->getAlignment()->setWrapText(true);

          $objPHPExcel->getActiveSheet()->setCellValue('E'.$keys, isset($val['description'])?htmlspecialchars_decode(trim($val['description'])):"");
          $objPHPExcel->getActiveSheet()->getStyle('E'.$keys)->getAlignment()->setWrapText(true);

          $objPHPExcel->getActiveSheet()->setCellValue('V'.$keys, isset($val['product_details'])?htmlspecialchars_decode(trim($val['product_details'])):"");
          $objPHPExcel->getActiveSheet()->getStyle('V'.$keys)->getAlignment()->setWrapText(true);

           $objPHPExcel->getActiveSheet()->setCellValue('X'.$keys, isset($val['seo_details'])?htmlspecialchars_decode(trim($val['seo_details'])):"");
          $objPHPExcel->getActiveSheet()->getStyle('X'.$keys)->getAlignment()->setWrapText(true);
       }
         
      }     

      $objPHPExcel->getActiveSheet()->setCellValue('F'.$keys, $var['Product']['product_url']);
      $objPHPExcel->getActiveSheet()->getStyle('F'.$keys)->getAlignment()->setWrapText(true);

      $objPHPExcel->getActiveSheet()->setCellValue('G'.$keys, $var['Product']['price']." ".strtoupper($var['Product']['price_type']));
      $objPHPExcel->getActiveSheet()->setCellValue('H'.$keys, $this->getBrandById($var['Product']['brand']));
      $objPHPExcel->getActiveSheet()->setCellValue('I'.$keys, $var['Product']['condition']);

      $objPHPExcel->getActiveSheet()->setCellValue('J'.$keys, stripslashes($var['Product']['image_url']));
      $objPHPExcel->getActiveSheet()->getStyle('J'.$keys)->getAlignment()->setWrapText(true);

      $objPHPExcel->getActiveSheet()->setCellValue('K'.$keys, $var['Product']['isbn']);
      $objPHPExcel->getActiveSheet()->setCellValue('L'.$keys, $var['Product']['mpn']);
      $objPHPExcel->getActiveSheet()->setCellValue('M'.$keys, $var['Product']['upc']);
      $objPHPExcel->getActiveSheet()->setCellValue('N'.$keys, $var['Product']['weight']);
      $objPHPExcel->getActiveSheet()->setCellValue('O'.$keys, $var['Product']['height']);
      $objPHPExcel->getActiveSheet()->setCellValue('P'.$keys, $var['Product']['width']);
      $objPHPExcel->getActiveSheet()->setCellValue('Q'.$keys, empty($var['Product']['category_id'])?"":$this->getCategoryById($var['Product']['category_id'],1,'high'));
      $objPHPExcel->getActiveSheet()->setCellValue('R'.$keys, $var['Product']['quantity']);
      $objPHPExcel->getActiveSheet()->setCellValue('S'.$keys, $var['Product']['shipping_cost']);
      $objPHPExcel->getActiveSheet()->setCellValue('T'.$keys, $var['Product']['tax']);
    }


   // header('Content-Type: application/vnd.ms-excel');
    //header('Content-Disposition: attachment;filename="myfile.xls"');
   // header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
   // $objWriter->save('php://output'); 
    $file_name=$this->merchantid."_".date('Y-m-d').".xls";
    $objWriter->save('uploads/products/datafeed' . DS.$file_name);

    // Render app/webroot/files/example.docx
    $params = array(
        'id'        => $file_name,
        'name'      => '"'.$this->merchantid."_".date('Y-m-d').'"',
        'extension' => 'xls',
        'mimeType'  => array('xls'=>'application/vnd.ms-excel'),    
        'path'      => 'uploads/products/datafeed' . DS
    );
    $this->set($params); 
}
/*function securimage($random_number){ 
        $this->autoLayout = false; //a blank layout 

        //override variables set in the component - look in component for full list 
        $this->captcha->image_height = 75; 
        $this->captcha->image_width = 350; 
        $this->captcha->image_bg_color = '#ffffff'; 
        $this->captcha->line_color = '#cccccc'; 
        $this->captcha->arc_line_colors = '#999999,#cccccc'; 
        $this->captcha->code_length = 5; 
        $this->captcha->font_size = 45; 
        $this->captcha->text_color = '#000000'; 

        $this->set('captcha_data', $this->captcha->show()); //dynamically creates an image 
    } */
/*-----Compare Page------*/
  public function compare($id="",$slug=""){
    $this->layout="page";

    $lang=$this->Ctrl->getLang();
    if($lang=="en")
    {
      $lang_id=1;
    }
    else
    {
      $lang_id=2;
    }
    
 
    //$this->Session->write('unique_id', md5(rand()));
    $unique_id=$this->Session->read('unique_id');
   /*  $this->set('captcha_image_url', $this->webroot.'products/securimage/0'); //url for the captcha image 

        $captcha_success_msg = 'The code you entered matched the captcha'; 
        $captcha_error_msg = 'The code you entered does not match'; 

        if( empty($this->data) ){ //form has not been submitted yet 
            $this->set('error_captcha', ''); //error message displayed to user 
            $this->set('success_captcha', ''); //success message displayed to user 
            //$this->render(); //reload page 
        } else { //form was submitted      
            if( $this->captcha->check($this->data['Contact']['captcha_code']) == false ) { 
                //the code was incorrect - display an error message to user 
                $this->set('error_captcha', $captcha_error_msg); //set error msg 
                $this->set('success_captcha', ''); //set success msg 
                $this->render(); //reload page 
            } else { 
                //the code was correct - display a success message to user 
                $this->set('error_captcha', ''); //set error msg 
                $this->set('success_captcha', $captcha_success_msg); //set success msg 
                $this->render(); //reload page 

                //after testing is complete, you would process the other form data here and save it 
            } 
        } */
    if($unique_id=="")
    {
      $this->Session->write('unique_id', md5(rand()));
      $unique_id=$this->Session->read('unique_id');
    }
    else
    {
       $unique_id=$this->Session->read('unique_id');
      
    }
     $check= $this->Unique_visitor->save(array('ip'=>$this->RequestHandler->getClientIp(),'unique_id'=>$unique_id,'product_id'=>$id,'date'=>date('Y-m-d h:i:s')));
    
    
     
    if($id and $slug)
    {
        if($this->request->is('post'))
        {
          $dbval=$this->request->data;
          // echo"<pre>"; print_r($dbval);  echo"</pre>";
          if(!isset($dbval['user_id']))
          {
             $dat=$this->Reviewed_user->findByEmailId($dbval['email_id']);
          }
          else if($dbval['user_id'])
          {
            $dat=$this->Reviewed_user->findById($dbval['user_id']);
          }
           //print_r($dat);
        // echo $dbval['email_id'];
          if(empty($dat))
          {
           $data['name']=$dbval['name'];
           $data['email_id']=$dbval['email_id'];
           $data['date']=date('Y-m-d h:i:s');

           unset($dbval['name']);
           unset($dbval['email_id']);

           $dbval['title']=trim(strip_tags($dbval['title']));
           $dbval['comment']=htmlspecialchars(trim($dbval['comment']));
           $dbval['rating']=  $dbval['tot_ratings'];
           $dbval['ip']=  $this->RequestHandler->getClientIp();
           $dbval['review_date']= date('Y-m-d h:i:s');
           if(!isset($dbval['merchant_id']))
           {
              $dbval['product_id']=$id;
           }
           

           $check=$this->Reviewed_user->save($data);
           if($check)
           {
              
              $dbval['user_id']=$this->Reviewed_user->getInsertID();
              $this->Cookie->write('user_id',$dbval['user_id'], false, '1 hour');
              $this->Cookie->write('name',$data['name'], false, '1 hour');
              if(!isset($dbval['merchant_id']))
              {
               $check=$this->Reviewed_user->Product_review->save($dbval);
             }else
             {
                $check=$this->Reviewed_user->Merchant_rating->save($dbval);
             }
               if($check)
               {
                  $this->Session->setFlash('A review added Successfully', 'default', array(), 'msg');
               }
               else
               {
                  $this->Session->setFlash('Error in reviews.', 'default', array(), 'msg');
               }
           }
         }else
         {
          if(!isset($dbval['merchant_id']))
           {
             $dat1=$this->Reviewed_user->Product_review->findByProductIdAndUserId($id,$dat['Reviewed_user']['id']);
          }else
          {
             $dat1=$this->Reviewed_user->Merchant_rating->findByMerchantIdAndUserId($dbval['merchant_id'],$dat['Reviewed_user']['id']);
          }
             if(empty($dat1))
             {
           unset($dbval['name']);
           unset($dbval['email_id']);
           $this->Cookie->write('user_id',$dat['Reviewed_user']['id'], false, '1 hour');
           $this->Cookie->write('name',$dat['Reviewed_user']['name'], false, '1 hour');
           $dbval['title']=trim(strip_tags($dbval['title']));
           $dbval['comment']=htmlspecialchars(trim($dbval['comment']));
           $dbval['user_id']=$dat['Reviewed_user']['id'];
           $dbval['rating']=  $dbval['tot_ratings'];
           $dbval['ip']=  $this->RequestHandler->getClientIp();
           $dbval['review_date']= date('Y-m-d h:i:s');
           if(!isset($dbval['merchant_id']))
           {
             $dbval['product_id']=$id;
             $check=$this->Reviewed_user->Product_review->save($dbval);
           }else
           {
            //print_r($dbval);
            //print_r($this->Merchant_rating->find('all'));
            $check=$this->Reviewed_user->Merchant_rating->save($dbval);
           }
               if($check)
               {
                  $this->Session->setFlash('A review added Successfully', 'default', array(), 'msg');
               }
               else
               {
                  $this->Session->setFlash('Error in reviews', 'default', array(), 'msg');
               }
              }
              else
              {
                 if(!isset($dbval['merchant_id']))
                {
                $this->Session->setFlash('You already reviewed this product.', 'default', array(), 'bad');
                }
                else
                {
                  $this->Session->setFlash('You already reviewed this Seller.', 'default', array(), 'bad');
                }
              }

         }


        }
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
       $product=$this->Product->find('first',array('conditions'=>array('Product.id'=>$id,'Product.slug'=>$slug)));
      // echo "<pre>";print_r( $product);echo "</pre>";
       $cdate=date('Y-m-d');
      
              if((@$product['Offer']['status'] == 1) && ($product['Offer']['end_date']!='0000-00-00 00:00:00') && ($product['Product']['Offer']['end_date'] >= $cdate)) 
              {
               $product['Product']['offer_price']=($product['Product']['price']-($product['Product']['price']*$product['Product']['Offer']['discount']/100));
                $product['Product']['offer_percent']=isset($product['Product']['Offer']['discount'])?$product['Product']['Offer']['discount']:0;
              }
              else{
                $product['Product']['offer_price']=$product['Product']['price'];
                $product['Product']['offer_percent']=0;
              } 
              
               if(!empty($product['Product']['Product_review']))
               {
                $res=Hash::extract($product['Product']['Product_review'], '{n}.rating'); 
               // print_r($res);            
                $product['Product']['reate_count']= (array_sum($res)/count($res));
               }else
               {
                $product['Product']['reate_count']=0;
               }
      $product['Product_lang']=$this->Ctrl->languageChanger($product['Product_lang']);
       $this->set('product',$product);
        // $product_details=$this->Ctrl->languageChanger($product['Product_lang']);
    //print_r($data1);
    $this->metas_all['htitle']=stripslashes(strip_tags($product['Product_lang']['title']));
    $seo=json_decode(htmlspecialchars_decode($product['Product_lang']['seo_details']),true);
      $this->metas_all['hdescription']=strip_tags($seo['description']);
      $this->metas_all['hkeyword']=strip_tags($seo['keyword']);
      $this->metas_all['hlang']=$this->Ctrl->getLang();

     
     // print_r($this->metas_all);
      $this->set($this->metas_all);
    //  print_r($product);
         
       // $product['Product_lang'][0]=$this->Ctrl->languageChanger($product['Product_lang']);
        
           $img=json_decode(stripslashes($product['Product']['image_url']));
        
         $this->Cookie->write('prod'.$product['Product']['id'],
          array('id'=>$product['Product']['id'],
            'price'=>$this->Ctrl->getPriceFormat(number_format($product['Product']['offer_price'],2)),
            'img'=>$img[0],
            'name'=>htmlspecialchars_decode($product['Product_lang']['title']),
            'slug'=> $product['Product']['slug']
              ));


       /*---- Find merchant using the product slug name categoty brand-----*/
       // $cond=array('Product.slug like'=>"%". str_replace('-','%',$slug)."%",'Product.category_id'=>$product['Product']['category_id'],'Product.brand'=>$product['Product']['brand']);
   /*$slug_split=explode("-",$slug);
            $sluges=array();
              if(!empty($slug_split))
              {
                $cond=array_merge($cond,array('or'=>array()));
                 foreach ($slug_split as $key => $value) {
                   $sluges=array_merge((array)$sluges,(array)$value);
                   $sluges=implode("%", $sluges);
                   array_push($cond['or'],array('Product.slug like'=>"%". $sluges."%"));
                 }
            }*/
        $merchant=$this->Ctrl->getMerchantDetailsByProduct($product['Product']['id'],$slug,'all',$lang_id);
     
       $results = Hash::extract($merchant, '{n}.Product.offer_price');

      //echo "<pre>";print_r($merchant);echo "</pre>";
        $this->set('merchantids',$merchant);
        $this->set('price',$results);

        $related=$this->Product->find('all',array('conditions'=>array('or'=>array('Product.slug like'=>"%".$slug."%",'Product.category_id'=>$product['Product']['category_id'],'Product.brand'=>$product['Product']['brand']),'Product.id !='=>$id,'Product.category_id !='=>'','Product.brand !='=>'')));
        //echo "<pre>";print_r($related);echo "</pre>";
        $products=$related;
         if(!empty($products))
           {
              foreach($products as $key=>$val)
               {   
                  $img=json_decode(stripslashes($val['Product']['image_url']));
                 $products[$key]['Product']['image_path']=$img[0];

                //echo $this->Ctrl->getMerchantDetailsByProduct($val['Product']['id'],$val['Product']['slug']);
                 $products[$key]['Product']['merchant_count']=$this->Ctrl->getMerchantDetailsByProduct($val['Product']['id'],$val['Product']['slug']);
                   $products[$key]['Product']['merchant_count_new']=" ".($products[$key]['Product']['merchant_count']." ".(($products[$key]['Product']['merchant_count']>1)?$this->Ctrl->getWord('sellers'):$this->Ctrl->getWord('seller')));
                  if((@$val['Offer']['status'] == 1) && ($val['Offer']['end_date']!='0000-00-00 00:00:00') && ($val['Offer']['end_date'] >= $cdate)) 
                  {
          $products[$key]['Product']['offer_price']=$this->Ctrl->getPriceFormat(number_format($val['Product']['price']-($val['Product']['price']*$val['Offer']['discount']/100),2));
                   //($val['Product']['price']-($val['Product']['price']*$val['Offer']['discount']/100));
                    $products[$key]['Product']['offer_percent']=isset($val['Offer']['discount'])?$val['Offer']['discount']:0;
                  }
                  else{
                    $products[$key]['Product']['offer_price']=$this->Ctrl->getPriceFormat(number_format($val['Product']['price'],2));
                    $products[$key]['Product']['offer_percent']=0;
                  } 
                  
                   if(!empty($val['Product_review']))
                   {
                    $res=Hash::extract($val['Product_review'], '{n}.rating'); 
                  //  print_r($res);            
                    $products[$key]['Product']['review_count']=count($res);
                    $products[$key]['Product']['reate_count']= (array_sum($res)/count($res));
                   }else
                   {
                    $products[$key]['Product']['review_count']=0;
                    $products[$key]['Product']['reate_count']=0;
                   }

               }
         }
          //echo '<pre>'; print_r($products); echo '</pre>'; 
        $this->set('products',$products);
        $allratings=$this->Reviewed_user->Product_review->findAllByProductIdAndStatus($id,1);
        $this->set('allratings',$allratings);
        $this->set('ratingcount',count($allratings));
        $rresults = Hash::extract($allratings, '{n}.Product_review.rating');
        if(count($rresults)>0)
        {
          $this->set('avgreating',(array_sum($rresults)/count($rresults)));
        }
        else
        {
          $this->set('avgreating',0);
        }
        
      //  print_r($results);
        $this->set('user',$this->Cookie->read('user_id'));
        $this->set('name',$this->Cookie->read('name'));

    } 
   
  }

  public function productlist($type="",$slug="",$cat_id="",$dtype="block",$short="popular") 
  {
  ini_set('max_execution_time','1000');
	$cdate = date('Y-m-d');
    $limit='12';
		
	$limit_start = '0';
	
	$sort_by = array('rating_count'=>'desc','Product.slug'=>'asc');
	
	$sort = $this->params['short'];
	
	$filter_cond = '';
	
	if(!empty($sort))
	{
		switch ($sort) 
		{
			case 'popular':
				$sort_by = array('rating_count'=>'desc','Product.slug');
				break;
				
			case 'plow':
				
				$sort_by = array('offer_price'=>'asc','Product.slug');
				break;
				
			case 'phigh':
				$sort_by = array('offer_price'=>'desc','Product.slug');
				break;
			
			case 'hdiscount':
				$sort_by = array('offer_price'=>'desc','Product.slug');
				$filter_cond = 1;
				break;
			
			case 'ldiscount':
				$sort_by = array('offer_price'=>'asc','Product.slug');
				$filter_cond = 1;
				break;
			
		}
	}
  //echo $this->params['dtype'];
  $this->set('dtype',$this->params['dtype']);
    //echo '<pre>'; print_r($slug); echo '</pre>'; exit;
    //print_r($this->request->params['pass']);
    //$type=$this->params['named']['type'];
    //$slugq =$this->params['named']['slug'];
    //$cat_id=$this->params['named']['cat_id'];
    //$dtype=$this->params['named']['dtype'];
    /*------------ GETing Site Settings ------------*/
   
    $this->layout = "productlist";//code for getting site settings
    $this->loadModel('Setting');
    $config_settings=$this->Setting->find('all',array('conditions' => array('Setting.id' =>'1')));
    $this->set("setting",$config_settings[0]);

    /*-----------  Header Departmenrt section------*/
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
     $product_subcategories = $this->Product_category->Find('all', 
                  array(
                  'conditions'=>array(
                    'Parent.slug'=>$slug,
                    'Product_category.status'=>1,
                    //'Product_category_lang.lang_id'=> $langid
                  ),
                  'order' => array('Product_category.lft'=>'asc')
                )
              ); 
    $this->set('product_subcategories',$product_subcategories);

    /*-----------  Get the category wise or brand wise product listing ---------*/
    switch ($this->params['type']) {
      case 'category':
            $this->loadModel('Product');
    
            /*---Get category id of the current searched category ----*/
            $search_cat = $this->Product_category->find('first',
                                  array(
                                    'conditions'=>array(
                                      'Product_category.slug'=>$slug,
                                    )
                                  ));


              $category_details=$this->Ctrl->languageChanger($search_cat['Product_category_lang']);
//print_r($brand);
      $this->metas_all['htitle']=stripslashes(strip_tags($category_details['category_name']));
      $this->metas_all['hdescription']=strip_tags(htmlspecialchars_decode($category_details['meta_description']));
      $this->metas_all['hkeyword']=strip_tags(htmlspecialchars_decode($category_details['meta_keyword']));
      $this->metas_all['hlang']=$this->Ctrl->getLang();
     //print_r($this->metas_all);
     
            //print_r($this->metas_all);
            $this->set($this->metas_all);
            $cat_path = '';
            $children = '';
            if(!empty($search_cat))
            {
              $search_cat_id = $search_cat['Product_category']['id'];
              $cat_path = $this->Product_category->getPath($search_cat_id);
            
              //Get all related sub categories of the selected category
              $children = $this->Product_category->children($search_cat_id);
			  
               //get product categories
			   
			        $getCategories=array();
               
              array_push($getCategories,$cat_path);
                       
              $pcategorys=Hash::combine($getCategories, '{n}.0.Product_category.id', '{n}.0.Product_category');
              
              $pcategorys=array_values($pcategorys);

              $pccatidd=Hash::extract($pcategorys,'{n}.id');    
              // print_r( $pccatidd); exit;          
              
			   //get product categories
			  
            }
            //Get category breadcum path
              
            $this->set("cat_path",$cat_path);
            $this->set('category_searched',$search_cat);
            $all_subid = Hash::extract($children, '{n}.Product_category.id');
            
            array_push($all_subid,$search_cat_id);
            $this->set('category_ids',$all_subid);
            //Get all products
            /*$products = $this->Product->Find('all', 
                        array(
                            'conditions'=>array(
                              'Product_category.status'=>1,
                              'Product.status'=>1,
                              'Product.category_id'=>$all_subid,
                              'Product.category_id !='=>'',
                              'Product.brand !='=>'',
                              
                            ),
                            
                            
                            //'order' => array('Product_category.cat_order'=>'asc')
                          ) 
                        ); 
            $productsCount = $this->Product->Find('count', 
                        array(
                            'conditions'=>array(
                              'Product_category.status'=>1,
                              'Product.status'=>1,                              
                              'Product.category_id'=>$all_subid,
                              'Product.category_id !='=>'',
                              'Product.brand !='=>'',
                                     
                            ),
                            'limit'=>$limit,
                            
                            //'order' => array('Product_category.cat_order'=>'asc')
                          ) 
                        ); */
						
				$cond['Product_category.status']= 1;
				$cond['Product.status']	= 1;
				$cond['Product.category_id']= $all_subid;
				$cond['Product.category_id !=']	= '';
				$cond['Product.brand !=']	= '';
					
				if(!empty($filter_cond))
				{
          $cond['Product.offer_id !=']=0;
					$cond['Offer.discount !='] = 0;
          //$cond['Offer.discount !=']  = "";
					$cond['Offer.status']	= '1';
					$cond['Offer.end_date >= ']	= date('Y-m-d');
				}

				  $products = $this->Product->find('all',
					  array(
						
						'fields' => array(
						
							'Product.*',
							
							'Offer.*',
							
							'(case when (Product.offer_id != 0 and Offer.end_date >= "'.$cdate.'" and Offer.status=1) then Product.price-((Product.price * Offer.discount)/100) else Product.price end) as offer_price',
					
							'(
								SELECT COUNT( b.id ) 
								FROM mc_product_reviews b
								WHERE b.product_id = Product.id and b.status=1
								) AS review_count',
								
							'(
								SELECT sum( b.rating )/review_count
								FROM mc_product_reviews b
								WHERE b.product_id = Product.id and b.status=1
								) AS rating_count',
								
							'Product_category.*',
							
							'Product_brand.*',
							
							'Merchant.*'

						),
						
						'conditions'=>$cond,
						
						'offset' => $limit_start,
						'limit' => $limit,
						'order' => $sort_by
						
					  ));
								  
			$productsCount = $this->Product->Find('count', 
                        array(
                            'conditions'=>$cond
                          ) 
                        );	
                       // print_r($products);		exit;
//echo $productsCount;
           // $this->set("products",$products);
//echo $dtype;
           // if($dtype=="list")
          //    $this->render('product_list');
        break;
        case 'brand':
      //echo   str_replace("-", "%",$slug);
          $brand=$this->Product_brand->findBySlug($slug);
          $barand_details=$this->Ctrl->languageChanger($brand['Product_brand_lang']);
//print_r($brand);
      $this->metas_all['htitle']=stripslashes(strip_tags($barand_details['brand_title']));
      $this->metas_all['hdescription']=strip_tags(htmlspecialchars_decode($barand_details['meta_description']));
      $this->metas_all['hkeyword']=strip_tags(htmlspecialchars_decode($barand_details['meta_keyword']));
      $this->metas_all['hlang']=$this->Ctrl->getLang();
     //print_r($this->metas_all);
      $this->set($this->metas_all);
          $brand_filter_id=$brand['Product_brand']['id'];
          /*$products= $this->Product->Product_brand->find('all',
                                  array(
                                    'conditions'=>array(                                    
                                    'Product_brand.slug like'=>str_replace("-", "%",$slug)."%",
                                    'Product.category_id !='=>'',
                                    ),
                                     'recursive' => 2
                                   ));*/
		
		$cond['Product.brand']	= $brand_filter_id;
		$cond['Product.status']	= 1;
		$cond['Product.category_id !=']	= '';
		$cond['Product.brand !=']	= '';
		
		if(!empty($filter_cond))
		{
		$cond['Offer.discount !=']  = 0;
              $cond['Offer.discount !=']  = "";
			$cond['Offer.status']	= '1';
			$cond['Offer.end_date >= ']	= date('Y-m-d');
		}
		
		/*$products= $this->Product->find('all',
                                  array(
                                    'conditions'=>array(                                    
                                    'Product.brand'=>$brand_filter_id,
                                    'Product.category_id !='=>'',
                                    )                                    
                                   ));*/
								   
				  
		$products = $this->Product->find('all',
				  array(
					
					'fields' => array(
					
						'Product.*',
						
						'Offer.*',
						
						'(case when (Product.offer_id != 0 and Offer.end_date >= "'.$cdate.'" and Offer.status=1) then Product.price-((Product.price * Offer.discount)/100) else Product.price end) as offer_price',
						
						'(
							SELECT COUNT( b.id ) 
							FROM mc_product_reviews b
							WHERE b.product_id = Product.id and b.status=1
							) AS review_count',
							
						'(
							SELECT sum( b.rating )/review_count
							FROM mc_product_reviews b
							WHERE b.product_id = Product.id and b.status=1
							) AS rating_count',
							
						'Product_category.*',
						
						'Product_brand.*',
						
						'Merchant.*'

					),
					
					'conditions'=>$cond,
					
					'offset' => $limit_start,
					'limit' => $limit,
					
					'order' => $sort_by
					
				  ));
				  
		$productsCount = $this->Product->find('count',
				  array(
				  	'conditions'=>$cond
					
				  ));
								   
        // debug($products);
        //  $res=Hash::extract($products, '{n}.Product.{n}');
          //
          //$productsCount=count($products);
        /* $products=array();
          foreach ($res as $key => $value) {
           //$value['Product_lang']=$value['Product_lang']
           
             $products[$key]=array(
              'Product'=>$value,
              'Product_lang'=>$value['Product_lang'],
              'Product_category'=>$value['Product_category'],
              'Offer'=>$value['Offer'],
              'Product_brand'=>$value['Product_brand'],
              'Product_review'=>$value['Product_review'],
              'Merchant'=>$value['Merchant']
              );
          }*/
          //print_r($res1);
           //$res= Hash::combine($products, 'Product', '{n}');
         // $this->set("products",$res1);
            //echo $cat_id;
           $search_string=ucfirst(str_replace('-',' ',$slug));
           //array('Product_category_lang'=>array(array('category_name'=> $search_string)));
           $this->set('category_searched', array('Product_category_lang'=>array(array('category_name'=> $search_string))));
           $this->set('pcattitle',$search_string);
          // print_r($Products);
           
        break;
        case 'search-for':
        $slugs=str_replace('-','%',$slug);
        $slug3=str_replace('-','* ',$slug);
        $list_data=$this->Product->Product_lang->find('list',array('fields'=>array('Product_lang.product_id'),'conditions'=>array('or'=>array('Product_lang.title like '=>'%'.$slugs.'%' ,/*'MATCH (Product_lang.description ) AGAINST ("'.$slug3.'*" IN BOOLEAN MODE)' */)),'order'=>'Product_lang.title'));
     //  print_r(array_values($list_data));
        if($cat_id!=0)
        {
            $categorys = $this->Product_category->children($cat_id);
            $all_subid = Hash::extract($categorys, '{n}.Product_category.id');
            array_push($all_subid,$cat_id);
            //print_r($all_subid);
            //echo str_replace("-", "%",$slug);
                // $slug=str_replace("-", " ",$slug);
            $cond=$this->Ctrl->createConditions($slug,$list_data,$all_subid);
            /* $cond=array( 'Product.category_id'=>$all_subid,
                                      'Product.category_id !='=>'',
                                      'Product.brand !='=>'',
                                      'Product.status'=>1
                                    );
             $slug2=str_replace('-',' ',$slug);
             $slug3=str_replace('-','* ',$slug);
            // $slug3=preg_replace('//', '', $slug3, 1);
            $data_cat=$this->getCatIdsBYSlug($slug2);
            $data_brand=$this->getBrandIdsBYSlug1($slug2);
         
             if(empty($data_brand) and empty($data_cat))
            {
                $cond['or'][0]=array('Product.brand'=>$data_brand);
                $cond['or'][1]=array('Product.category_id'=>$data_cat);            
                //$cond['or'][2]=array('MATCH (Product.slug) AGAINST ("+'.$slug3.'*" IN BOOLEAN MODE)');
                $cond['or'][2]=array('Product.id'=>$list_data);
            }
            else
            {
              if(!empty($data_brand))
                {
                  $cond['and'][0]=array('Product.brand'=>array_keys($data_brand));
                }
                if(!empty($data_cat))
                {
                   $cond['and'][1]=array('Product.category_id'=>$data_cat);    
                }
                   $countdata=explode(' ', $slug);
                   $slug1=str_replace(' ','-', strtolower(trim($slug)));
                   //echo count($countdata);
                  function trims($n)
                  {
                      return ltrim(rtrim($n,'-'),'-');
                  }


                $brandas= array_map("trims", array_values($data_brand));
                if(!empty($data_brand) and !in_array($slug1,$brandas))
                {
                 //$cond['and'][2]=array('MATCH (Product.slug) AGAINST ("+'.$slug3.'*" IN BOOLEAN MODE)');
                  $cond['and'][2]=array('Product.id'=>$list_data);
                }
            }*/
            
            /*$slug_split=explode("-",$slug);
            $sluges=array();
             
              
             if(!empty($slug_split))
             {
                $cond=array_merge($cond,array('or'=>array(array('or'=>array()),array('or'=>array()),array('or'=>array()))));
                if(count($slug_split)==1)
                {
                  foreach ($slug_split as $key => $value) {
                                   
                   $sluges=array_merge((array)$sluges,(array)$value);
                   $sluges=implode("%", $sluges);
                 //  array_push($cond['or'][0]['or'],array('Product.slug like'=>"%". $sluges."%"));
                	
     array_push($cond['or'][0]['or'],array('MATCH (slug) AGAINST '=>"('".$sluges."' IN BOOLEAN MODE) "));
					$data_cat=$this->getCatIdsBYSlug($sluges);
                	if(!empty($data_cat))
						array_push($cond['or'][1]['or'],array('Product.category_id'=>$data_cat));
                	
					$data_brand=$this->getBrandIdsBYSlug($sluges);
                	if(!empty($data_brand))
						array_push($cond['or'][2]['or'],array('Product.brand'=>$data_brand));
                
                 }
                }
                else
                {

                 foreach ($slug_split as $key => $value) {
                  if(strlen($value)>2)
                  {                  
                   $sluges=array_merge((array)$sluges,(array)$value);
                   $sluges=implode("%", $sluges);
                   array_push($cond['or'][0]['or'],array('Product.slug like'=>"%". $sluges."%"));
                    //array_push($cond['or'][1]['or'],array('Product_category.slug like'=>"%". $sluges."%"));
                	
					$data_cat=$this->getCatIdsBYSlug($sluges);
                	if(!empty($data_cat))
						array_push($cond['or'][1]['or'],array('Product.category_id'=>$data_cat));
                	
					$data_brand=$this->getBrandIdsBYSlug($sluges);
                	if(!empty($data_brand))
						array_push($cond['or'][2]['or'],array('Product.brand'=>$data_brand));
                
				  }
                 }
                 $slug_split=array_reverse($slug_split);
                 $sluges="";
                 foreach ($slug_split as $key => $value) {
                  if(strlen($value)>2)
                  {                  
                   $sluges=array_merge((array)$sluges,(array)$value);
                   $sluges=implode("%", $sluges);
                  array_push($cond['or'][0]['or'],array('Product.slug like'=>"%". $sluges."%"));
                  //array_push($cond['or'][1]['or'],array('Product_category.slug like'=>"%". $sluges."%"));
                	
					$data_cat=$this->getCatIdsBYSlug($sluges);
                	if(!empty($data_cat))
						array_push($cond['or'][1]['or'],array('Product.category_id'=>$data_cat));
                	
					$data_brand=$this->getBrandIdsBYSlug($sluges);
                	if(!empty($data_brand))
						array_push($cond['or'][2]['or'],array('Product.brand'=>$data_brand));
                
				  }
                 }

                }
            }*/
         
        //echo "<pre>";print_r($cond); echo "</pre>";
           /* $products= $this->Product->find('all',array('conditions'=>$cond));*/
			
			 
			if(!empty($filter_cond))
			{
				$cond['Offer.discount !=']  = 0;
        $cond['Offer.discount !=']  = "";
				$cond['Offer.status']	= '1';
				$cond['Offer.end_date >= ']	= date('Y-m-d');
			}
							  
			$products = $this->Product->find('all',
					  array(
						
						'fields' => array(
						
							'Product.*',
							
							'Offer.*',
							
							'(case when (Product.offer_id != 0 and Offer.end_date >= "'.$cdate.'" and Offer.status=1) then Product.price-((Product.price * Offer.discount)/100) else Product.price end) as offer_price',
							
							'(
								SELECT COUNT( b.id ) 
								FROM mc_product_reviews b
								WHERE b.product_id = Product.id and b.status=1
								) AS review_count',
								
							'(
								SELECT sum( b.rating )/review_count
								FROM mc_product_reviews b
								WHERE b.product_id = Product.id and b.status=1
								) AS rating_count',
								
							'Product_category.*',
							
							'Product_brand.*',
							
							'Merchant.*'

						),
						
						'conditions'=>$cond,
						
						'offset' => $limit_start,
						'limit' => $limit,
						'order' => $sort_by
						
					  ));
								  
			
            $productsCount= $this->Product->find('count',
                                  array(
                                    'conditions'=>$cond
                                  ));

        }
        else
        {
          //echo str_replace("-", "%",$slug);

          $cond=$this->Ctrl->createConditions($slug,$list_data);

          /* $slug2=str_replace('-',' ',$slug);
            $slug3=str_replace('-','* ',$slug);*/
           // $slug3=preg_replace('/*/', '', $slug3, 1);
            /*$data_cat=$this->getCatIdsBYSlug($slug2);
            $data_brand=$this->getBrandIdsBYSlug1($slug2);
            //print_r($data_brand);
            if(empty($data_brand) and empty($data_cat))
            {
                $cond['or'][0]=array('Product.brand'=>$data_brand);
                $cond['or'][1]=array('Product.category_id'=>$data_cat);            
                //$cond['or'][2]=array('MATCH (Product.slug) AGAINST ("+'.$slug3.'*" IN BOOLEAN MODE)');
                $cond['or'][2]=array('Product.id'=>$list_data);
            }
           else if(!empty($data_brand))
                {
                  $cond['and'][0]=array('Product.brand'=>array_keys($data_brand));
                  $cond['or'][1]=array('Product.id'=>$list_data);  
                }
           else if(!empty($data_cat))
              {
                 $cond['or'][0]=array('Product.category_id'=>$data_cat); 
                 $cond['or'][1]=array('Product.id'=>$list_data);   
              }
            else
            {

                   $countdata=explode(' ', $slug);
                  $slug1=str_replace(' ','-', strtolower(trim($slug)));
                   //echo count($countdata);
                  function trims($n)
                  {
                      return ltrim(rtrim($n,'-'),'-');
                  }


                 $brandas= array_map("trims", array_values($data_brand));
                 //print_r($brandas);
                if(!empty($data_brand) and !in_array($slug1,$brandas))
                {
                 //$cond['and'][2]=array('MATCH (Product.slug) AGAINST ("+'.$slug3.'*" IN BOOLEAN MODE)');
                  $cond['and'][2]=array('Product.id'=>$list_data);
                }
                 if(count($countdata)>1 and !empty($data_cat))
                {
                   //$cond['and'][2]=array('MATCH (Product.slug) AGAINST ("+'.$slug3.'*" IN BOOLEAN MODE)');
                  $cond['and'][2]=array('Product.id'=>$list_data);
                }
            }*/
           
            
            /*$cond['or'][2]=array('Product.brand'=>$data_brand);*/
          /* $cond['MATCH (Product.slug) AGAINST']='("+'.$slug.'" IN BOOLEAN MODE)';
            $cond['Product.category_id']=$data_cat;
            //$cond['Product.brand']=$data_brand;*/
            // $slug_split=explode("-",$slug);
          //  $sluges=array();
           /*   if(!empty($slug_split))
              {
                 $cond=array_merge($cond,array('or'=>array(array('or'=>array()),array('or'=>array()),array('or'=>array()))));
                if(count($slug_split)==1)
                {
                  foreach ($slug_split as $key => $value) {
                                   
                   $sluges=array_merge((array)$sluges,(array)$value);
                   //$sluges=implode("%", $sluges);
                   array_push($cond['or'][0]['or'],array('MATCH (slug) AGAINST '=>"('".$sluges."' IN BOOLEAN MODE) "));
                  // array_push($cond['or'][0]['or'],array('Product.slug like'=>"%". $sluges."%"));
                  // array_push($cond['or'][1]['or'],array('Product_category.slug like'=>"%". $sluges."%"));
                	
					$data_cat=$this->getCatIdsBYSlug($sluges);
         // print_r($data_cat);
                	if(!empty($data_cat))
						array_push($cond['or'][1]['or'],array('Product.category_id'=>$data_cat));
                	
					$data_brand=$this->getBrandIdsBYSlug($sluges);
                	if(!empty($data_brand))
						array_push($cond['or'][2]['or'],array('Product.brand'=>$data_brand));
                
                 }
                }
                else
                {

                 foreach ($slug_split as $key => $value) {
                  if(strlen($value)>2)
                  {                  
                   $sluges=array_merge((array)$sluges,(array)$value);
                   $sluges=implode(" ", $sluges);
                   $cond['or'][0]['or']=array('MATCH (Product.slug) AGAINST ("+'.$sluges.'" IN BOOLEAN MODE)');
                  // array_push($cond['or'][0]['or'],array('Product.slug like'=>"%". $sluges."%"));
                 // array_push($cond['or'][1]['or'],array('Product_category.slug like'=>"%". $sluges."%"));
                	
					$data_cat=$this->getCatIdsBYSlug($sluges);
                	if(!empty($data_cat))
						array_push($cond['or'][1]['or'],array('Product.category_id'=>$data_cat));
                	
					$data_brand=$this->getBrandIdsBYSlug($sluges);
                	if(!empty($data_brand))
						array_push($cond['or'][2]['or'],array('Product.brand'=>$data_brand));
                
				         }
                 }
                /* $slug_split=array_reverse($slug_split);
                 $sluges="";
                 foreach ($slug_split as $key => $value) {
                  if(strlen($value)>2)
                  {                  
                   $sluges=array_merge((array)$sluges,(array)$value);
                   $sluges=implode("%", $sluges);
                   array_push($cond['or'][0]['or'],array('Product.slug like'=>"%". $sluges."%"));
                  //array_push($cond['or'][1]['or'],array('Product_category.slug like'=>"%". $sluges."%"));
                	
					$data_cat=$this->getCatIdsBYSlug($sluges);
                	if(!empty($data_cat))
						array_push($cond['or'][1]['or'],array('Product.category_id'=>$data_cat));
                	
					$data_brand=$this->getBrandIdsBYSlug($sluges);
                	if(!empty($data_brand))
						array_push($cond['or'][2]['or'],array('Product.brand'=>$data_brand));
                
				  }
                 }*/

             //   }
           // }
//echo "<pre>";print_r($cond); echo "</pre>";
                        /*$products = $this->Product->find('all',
                                  array(
                                    'conditions'=>$cond
                                  ));*/
								  
							 
						if(!empty($filter_cond))
						{
							$cond['Offer.discount !=']	= 0;
              $cond['Offer.discount !=']  = "";
							$cond['Offer.status']	= '1';
							$cond['Offer.end_date >= ']	= date('Y-m-d');
						}
          //  echo "<pre>"; print_r($cond);   echo "</pre>";
                        $products = $this->Product->find('all',
                                  array(
                                    
									'fields' => array(
									
										'Product.*',
										
										'Offer.*',
										
										'(case when (Product.offer_id != 0 and Offer.end_date >= "'.$cdate.'" and Offer.status=1) then Product.price-((Product.price * Offer.discount)/100) else Product.price end) as offer_price',
										
										'(
											SELECT COUNT( b.id ) 
											FROM mc_product_reviews b
											WHERE b.product_id = Product.id and b.status=1
											) AS review_count',
											
										'(
											SELECT sum( b.rating )/review_count
											FROM mc_product_reviews b
											WHERE b.product_id = Product.id and b.status=1
											) AS rating_count',
											
										'Product_category.*',
										
										'Product_brand.*',
										
										'Merchant.*'

									),
									
									'conditions'=>$cond,
									
									'offset' => $limit_start,
									'limit' => $limit,
									'order' => $sort_by
									
                                  ));
								  
								// $log = $this->Product->getDataSource()->getLog(false, false);
                 //debug($log);
								  
                        $productsCount= $this->Product->find('count',
                                  array(
                                    'conditions'=>$cond
                                  ));

                        
        }
           //print_r($Products);
          
          
            //echo $cat_id;
           $search_string=ucfirst(str_replace('-',' ',$slug));
           //array('Product_category_lang'=>array(array('category_name'=> $search_string)));
           $this->set('category_searched', array('Product_category_lang'=>array(array('category_name'=> $search_string))));
           $this->set('pcattitle',$search_string);
           
        break;
     
    }
   $cdate=date('Y-m-d');
  // print_r($products);
   if(!empty($products))
   {
          foreach($products as $key=>$val)
           {   
              $img=json_decode(stripslashes($val['Product']['image_url']));
             $products[$key]['Product']['image_path']=$img[0];
             $products[$key]['Product_lang'][0]=$this->Ctrl->languageChanger($products[$key]['Product_lang']);
             $products[$key]['Product_lang'][0]['description']=$this->Ctrl->summary($products[$key]['Product_lang'][0]['description'],200);
            //echo $this->Ctrl->getMerchantDetailsByProduct($val['Product']['id'],$val['Product']['slug']);
               $products[$key]['Product']['merchant_count']=$this->Ctrl->getMerchantDetailsByProduct($val['Product']['id'],$val['Product']['slug']);
              // echo $products[$key]['Product']['merchant_count'];
               $products[$key]['Product']['merchant_count_new']=" ".($products[$key]['Product']['merchant_count']." ".(($products[$key]['Product']['merchant_count']>1)?$this->Ctrl->getWord('sellers'):$this->Ctrl->getWord('seller')));
              if((@$val['Offer']['status'] == 1) && ($val['Offer']['end_date']!='0000-00-00 00:00:00') && ($val['Offer']['end_date'] >= $cdate)) 
              {
               $products[$key]['Product']['offer_price']=$this->Ctrl->getPriceFormat(number_format($val['Product']['price']-($val['Product']['price']*$val['Offer']['discount']/100),2));
               $products[$key]['Product']['offer_price_new']=$val['Product']['price']-($val['Product']['price']*$val['Offer']['discount']/100);
               $products[$key]['Product']['offer_percent']=isset($val['Offer']['discount'])?$val['Offer']['discount']:0;
              }
              else{
                $products[$key]['Product']['offer_price']=$this->Ctrl->getPriceFormat(number_format($val['Product']['price'],2));
                $products[$key]['Product']['offer_price_new']=$val['Product']['price'];
                $products[$key]['Product']['offer_percent']=0;
              } 
              
               /*if(!empty($val['Product_review']))
               {
                $res=Hash::extract($val['Product_review'], '{n}.rating'); 
              //  print_r($res);            
                $products[$key]['Product']['review_count']=count($res);
                $products[$key]['Product']['reate_count']= (array_sum($res)/count($res));
               }else
               {
                $products[$key]['Product']['review_count']=0;
                $products[$key]['Product']['reate_count']=0;
               }*/
			   
                $products[$key]['Product']['review_count'] = $products[$key][0]['review_count'];
                $products[$key]['Product']['reate_count'] = $products[$key][0]['rating_count'];

           }
         }
         else
         {
          $products=array();
         }
           //print_r($this->params);
           switch ($this->params['short']) {
             case 'popular':
              $products=Hash::sort($products, '{n}.Product.reate_count', 'desc');
              break;
              case 'plow':
              $products=Hash::sort($products, '{n}.Product.offer_price_new', 'asc');
              break;
              case 'phigh':
              $products=Hash::sort($products, '{n}.Product.offer_price_new', 'desc');
              break;
              case 'hdiscount':
              $products= Hash::map($products, "{n}", array($this, 'filterDiscantProd'));
              $products=array_filter($products);
              //$products=Hash::sort($products, '{n}.Product.offer_percent', 'desc');
              $products=Hash::sort($products, '{n}.Product.offer_price_new', 'desc');
              //$productsCount=count($products);

              break;
              case 'ldiscount':
              $products= Hash::map($products, "{n}", array($this, 'filterDiscantProd'));
              $products=array_filter($products);
              //$products=Hash::sort($products, '{n}.Product.offer_percent', 'desc');
              $products=Hash::sort($products, '{n}.Product.offer_price_new', 'asc');
              //$productsCount=count($products);

              break;
             default:
              //$products=Hash::sort($products, '{n}.Product.reate_count', 'desc');
               break;
           }
           $proddata=array();
           $restproddata=array();
          
           foreach ($products as $key => $value) {
             if($key<$limit)
             {
               array_push($proddata,$value);
             }else
             {
              //array_push($restproddata,$value);
              break;
             }
           }
           
           $this->set("products",$proddata);          
           $this->set('productsCount', $productsCount);
              switch ($this->params['type']) {
                case 'category':
                 $serch_slug = $search_cat_id;
                break; 
                case 'brand':
                 $serch_slug = $brand_filter_id;
                break;
                case 'search-for':
                 $serch_slug = $this->params['slug'];
                break;               
                
              }
         /*-- Category Filter---*/
              //$pcategorys = $this->categoryFilter($products,$this->params['slug'],$this->params['type']);
				if($this->params['type']=='category')
				{
					$pcategorys = $this->getfilterCategory(array('parents'=>$pccatidd,'type'=>$this->params['type'],'slug'=>$this->params['slug'],'sort'=>$this->params['short']));
				}
				else
				{
          //unset($cond['Offer.discount !=']);
          //unset($cond['Offer.end_date >= ']);
          //unset($cond['Offer.status']);
         // print_r($cond);
				$cids = $this->Product->find('all', array(
	  
						'fields' => array(
						
							'Product.category_id',
							//'Product_category.*',
							//'count(Product.id) as product_count'
							
						),
									   
						'conditions' => $cond ,
						'group' =>'Product.category_id',
						//'order' =>array('product_count'=>'desc')
						
					));	
      // echo"<pre>"; print_r($cids); echo"</pre>";
        $cids=Hash::extract($cids,'{n}.Product.category_id');
         // print_r($cids);
     //  echo $this->params['short'];
					$pcategorys = $this->categoryFilter(array_values($cids),$this->params['slug'],$this->params['type'],array(),$this->params['short']);		
				}
              //print_r($pcategorys);
              $this->set('filter_category',array('category'=>$pcategorys));
          /*-- End Of Category Filter ---*/

          /*----- Brand Filter -----*/
              //$brand_filter=$this->brandFilter($products,$serch_slug,'',$this->params['type']);
			  $brand_filter = $this->Ctrl->getProductBrands($cond,'');	
               // echo "<pre>";  print_r($brand_filter);  echo "</pre>";
              $this->set('brand_filter',array('brand'=>$brand_filter));
          /*----- End Brand Filter -----*/

          /*----- Merchant Filter -----*/
             // $merchant_filter=$this->merchantFilter($products,$this->params['slug'],$this->params['type']);
			  $merchant_filter = $this->Ctrl->getProductSellers($cond,'');		
               // echo "<pre>";  print_r($brand_filter);  echo "</pre>";
              $this->set('merchant_filter',array('merchant'=>$merchant_filter));
          /*----- End Merchant Filter -----*/
          /*----- Price min max Filter -----*/
              //$priceMinMax=$this->priceMinMax($products);
			  $priceMinMax = $this->Ctrl->getProductMinMaxPrice($cond);	
              $this->set('price_filter',array('price'=>$priceMinMax));
            
          /*----- End min max Filter -----*/
          /*--- Filter all Attribute ----*/
                //$countdiscount=$this->getDiscountAndNondiscountCounts($products);
				$countdiscount=$this->Ctrl->getDiscountAndNondiscountCounts($cond);
        $this->set('count_discount', $countdiscount);
          /*--- End Filter all Attribute ----*/
          /*--- Filter all Attribute ----*/
                //$attributes=$this->getAttributes($products);
				$attributes = $this->Ctrl->getAttributes($cond);
        //print_r($attributes);
        $this->set('attribute_filter',$attributes);
          /*--- End Filter all Attribute ----*/
            $this->set('search_id',$serch_slug);
            if($this->params['dtype']=="list")
              $this->render('product_list');
   
         }
		 
         private function getBrandIdsBYSlug($slug)
		 {
          		$data_brand_id = '';
			  
			  $data_brand_id=$this->Product_brand->find('list',
													  array(
														  'conditions'=>array(
															  'TRIM(BOTH "-" FROM Product_brand.slug) like'=>"%".str_replace(' ','%',$slug)."%",
                               // array('MATCH (Product_brand.slug) AGAINST ("+'.$slug.'" IN BOOLEAN MODE)'),
															  'Product_brand.status'=>1
														  ),
													  	'fields'=>array(
													  		'Product_brand.id',
                               

													  
													  	)
													  ));
				return $data_brand_id;									  
		 }
          private function getBrandIdsBYSlug1($slug)
     {
              $data_brand_id = '';
        //echo $slug;
              if(strlen(trim($slug))>4)
              {
                $cond=array('MATCH (Product_brand.slug) AGAINST ("+'.$slug.'*" IN BOOLEAN MODE)');
              }
              else
              {
                $cond[' TRIM(BOTH "-" FROM Product_brand.slug) like']="".str_replace(' ','%',$slug)."%";
              }
              
        $data_brand_id=$this->Product_brand->find('list',
                            array(
                              'conditions'=>array(

                               //' TRIM(BOTH "-" FROM Product_brand.slug) like'=>"".str_replace(' ','%',$slug)."%",

                              $cond,
                                'Product_brand.status'=>1
                              ),
                              'fields'=>array(
                                'Product_brand.id',
                                'Product_brand.slug'

                            
                              )
                            ));
      // print_r($data_brand_id);
        return $data_brand_id;                    
     }
         private function getCatIdsBYSlug($slug)
		 {
          
			  $data_cat_id=$this->Product_category->find('all',
													  array(
														  'conditions'=>array(
															  'TRIM(BOTH "-" FROM Product_category.slug) like'=>"". str_replace(' ','%',$slug)."%",
                                /*'MATCH (Product_category.slug) AGAINST ("'.$slug.'" IN BOOLEAN MODE)',*/
															  'Product_category.status'=>1
														  ),
													  	'fields'=>array(
													  		'Product_category.id'
													  
													  	)
													  ));
        //print_r($data_cat_id);
                 $data_cat_ids=Hash::extract($data_cat_id,'{n}.Product_category.id');
                
                 $data_cat=array();
                 foreach ($data_cat_ids as $key => $value) {
                    $data_id = $this->Product_category->children($value);
                    //print_r($data_id);
                   $cat_ids= Hash::extract($data_id,'{n}.Product_category.id');
                   //print_r($cat_ids);
                   array_push($cat_ids,$value);
                    $data_cat= array_merge($data_cat,$cat_ids);
                 }
               
                 $data_cat=array_values(array_unique($data_cat));
				 return $data_cat;
         }
		 
         private function getDiscountAndNondiscountCounts($products){
              $countnon=0;
              $count=0;
            $percent=Hash::extract($products, '{n}.Product.offer_percent');
            foreach ($percent as $key => $value) {
             if($value!=0)
             {
                $count++;
             }
             else
             {
              $countnon++;
             }
            }
            return array('noncount'=> $countnon,'count'=>$count);
         }
        private function getAttributes($products,$lang=0){
          //print_r($products[0]['Product_lang']);
        //$attributes= Hash::extract($products, json_decode('{n}.Product_lang.'.$lang.'.product_details')); 
        //  $attrs= array_values(array_filter($attributes));
         //print_r($products);
           $lang=$this->Ctrl->getLang();
          $attr_prod_details=array();
         foreach ($products as $key => $value) {
         // $product_details_first=trim('"',);
        //  $prod_details=$this->Ctrl->languageChanger($value['Product_lang']);
          $attr_prod=$value['Product_lang'][0]['product_details'];
         // $attr_prod=$value['Product_lang'][$lang]['product_details'];

            if($attr_prod)
            {
              if($lang!="en")
              {
                $attr_prod_ar=isset($value['Product_lang'][1])?$value['Product_lang'][1]['product_details']:"";
              }
              if($attr_prod_ar!="")
              {
                 $product_details_ar=htmlspecialchars_decode($attr_prod_ar); 
                 $product_details_ar=json_decode($product_details_ar);
              }
              $product_details=htmlspecialchars_decode($attr_prod);             
              $product_details=json_decode($product_details);
              //print_r($product_details);
             //print_r($product_details);
             foreach ($product_details as $k => $val) {

                 $attr=strtolower(trim($k));
                 //$attr=str_replace(' ', replace, subject)
                 // $attr=$this->Ctrl->pluralize($attr);
                // $attr=str_replace(" ", "%20",$attr);  
                  $path=array('color'=>'اللون','size'=>'حجم','memorie'=>'الذاكرة','screen'=>"الشاشة",'ram'=>"رام",'resolution'=>'قرار','cpu'=>'وحدة المعالجة المركزية','megapixel'=>"ميجابيكسل",'screen size'=>'حجم الشاشة','hard disk'=>'القرص الثابت','digital camera'=>"كاميرا رقمية",'optical zoom'=>'زوم بصري','type'=>'نوع');
                   if($attr!="brand")
                   {
                      if(in_array($attr,array('color','size','memorie','screen','ram','resolution','cpu','megapixel','screen size','hard disk capacitie','digital camera type','optical zoom','type')))
                    {
                        if(!isset($attr_prod_details[$attr]))
                       {
                         $attr_prod_details[$attr]=array();
                       }   
                        $sort_val=strtolower(trim(is_numeric($val)?"'".$val."'":$val));
                       if(!isset($attr_prod_details[$attr][$sort_val]))
                       {
                        $attr_prod_details[$attr]=array_merge($attr_prod_details[$attr],array($sort_val=>array('ar'=>isset($product_details_ar->$k)?$product_details_ar->$k:"",'count'=>0,'product_id'=>array())));
                       }
                       array_walk($attr_prod_details[$attr],array($this,"sortUniceAndGetCount"),array($sort_val,$value['Product_lang'][0]['product_id']));
                       $attr_prod_details[$attr]=array_filter($attr_prod_details[$attr]);
                     }  
                  }  
               
             }
           }
          
        }
        //print_r($attr_prod_details);
        
        $new_sort_data=array();
        $i=0;
        foreach ($attr_prod_details as $key => $value) {
          if(!empty($value))
          {
            $j=0;
         $new_sort_data[$i]=array('tslug'=>$this->Ctrl->camelize(ucfirst(str_replace("'",'',trim($key)))),'title'=>($lang=="en")?ucfirst(str_replace("'",'',trim($key))):$path[str_replace("'",'',trim($key))],'children'=>array());
          //print_r($value);
          foreach ($value as $k => $val) {
              if($val['count']!=0)
              {             
                 array_push($new_sort_data[$i]['children'],array('id'=>($i.$j),'item'=>($lang=="en")?str_replace("'",'',trim($k)):$val['ar'],'slug'=>$this->Ctrl->camelize(str_replace(' ','_',$k)),'checked'=>false,'count'=>$val['count'],'product_id'=>$val['product_id']));
                //print_r($new_sort_data[$i]['children']);
                 
              }
              if(empty($new_sort_data[$i]['children']))
                 {
                    unset($new_sort_data[$i]);
                 }
               $j++;
          }
          $i++;

          }
        }
       // print_r($new_sort_data);
        return $new_sort_data;
      
      }
      
      private function array_unique_multidimensional($array)
      {
        
      }
      private function sortUniceAndGetCount(&$v,$k,$cond){
         // print_r($v);
          if($k==$cond[0])
          {
            ++$v['count'];
              $v['product_id']=array_merge($v['product_id'],(array)$cond[1]);
          }
          //echo $cond;
      }
        private function priceMinMax($products){
            $pricea=Hash::extract($products, '{n}.Product.offer_price_new'); 
            if(!empty($pricea))
			{
				$pricemin=min($pricea);
				$peicemax=max($pricea);
				return array('min'=>floor($pricemin),'max'=>floor($peicemax));
			}
        }
        private function merchantFilter($products,$search_slug,$params=array())
         {
           
            //print_r($products);
            $merchants=Hash::extract($products, '{n}.Merchant.id'); 
            $merchants=array_unique($merchants);
            $merchants=array_values($merchants);
            //print_r($merchants);
            $merch=array();
            foreach ($merchants as $key => $value) {
              $data=$this->Merchant->findById($value);
              array_push($merch,$data['Merchant']);
            if($params['merchant']!="")
            {
              $merchants=explode("_", $params['merchant']);
            }
            else
            {
              $merchants=array();
            }
              //$prods=Hash::insert($data['Product'], '{n}.search_slug', $search_slug);
             // $brand_filter[$key]['product_count']=count(array_filter(Hash::map($prods, "{n}", array($this, 'getProductCount'))));
             // $brand_filter[$key]['brand_name']=$data['Product_brand_lang'][0]['brand_title'];
            if(!empty($merchants))
            {
              if(in_array($merch[$key]['id'],$merchants))
              {
                $merch[$key]['checked']=true;
              }
              else
              {
                $merch[$key]['checked']=false;
              }
            }
            else
            {
              $merch[$key]['checked']=false;
            }

            }
            
            return $merch;
         }
        private function categoryFilter($products,$search_slug,$type,$params=array(),$sort=""){
         //print_r($products);
          if(!empty($params))
             {
              foreach ($params as $key => $value) {
                switch ($key) {
                  case 'brand':
                  //echo $array_values;
                  if($value)
                  {
                    foreach($products as $k=>$val)
                   {
                     // echo $val['Product_brand']['id'];
                      if($val['Product_brand']['id']!=$value)
                      {
                        //unset($products[$k]);
                      }
                   }
                 }                   
                   break;
                  
                  
                }
              }
             }
             //print_r($products);
             /*$fcategorys=Hash::extract($products, '{n}.Product_category.id'); 
           
             $unique_cat=array_unique($fcategorys,SORT_NUMERIC);*/
			 
			        $unique_cat = $products;

               $getCategories=array();
               foreach ($unique_cat as $key => $value) {
                  array_push($getCategories,$this->Product_category->getPath($value));
               }             
              // print_r($getCategories);
              $pcategorys=Hash::combine($getCategories, '{n}.0.Product_category.id', '{n}.0.Product_category');
              $pcategorys=array_values($pcategorys);
              $pccatidd=Hash::extract($pcategorys,'{n}.id'); 
              //$pccatidd=array_merge($unique_cat,$pccatidd);
              //print_r($pccatidd);  

              $pcategorys=$this->getfilterCategory(array('parents'=>$pccatidd,'type'=>$type,'slug'=>$search_slug,'params'=>$params,'sort'=>$sort));
              /* foreach ($pcategorys as $key => $value) {
              $pcategorys[$key]['title']=ucfirst(str_replace('-',' ',$value['slug']));
              $pcategorys[$key]['checked']=false;
              $pcategorys[$key]['children']=array();
              $cat=$this->Product_category->children($value['id'],true,null,null,null,1,1);  
              if(!in_array($type,array("category",'brand')))
              {            
                 $pcategorys[$key]['children']=$this->getCategoryDetails($cat,$search_slug);
              }
              else
              {
                 $pcategorys[$key]['children']=$this->getCategoryDetails($cat,isset($brand['Product_brand']['id'])?$brand['Product_brand']['id']:"",$this->params['type']);
              }
               foreach ( $pcategorys[$key]['children'] as $k => $va) {
                  $pcategorys[$key]['children'][$k]['checked']=false;
                  $pcategorys[$key]['children'][$k]['children']=false;
               }
             } */

             //print_r($pcategorys);
             return $pcategorys;
         }
        function brandFilter($products,$search_slug,$brandid="",$type="",$params="",$sort=""){
            //$products= array_values($this->filterbyall($products,$params,$search_slug));
            $fbranss=Hash::extract($products, '{n}.Product_brand.id');
           
             if($brandid!="")
              { 
                $brandid=explode("_", $brandid);
              }
            $fbranss_unique=array_values(array_filter(array_unique($fbranss)));
            //print_r($search_slug);
            $brand_filter=array();
            $cond=array();
           //print_r($params);
         
            if(!empty($fbranss_unique))
            {
            foreach ($fbranss_unique as $key => $value) {
              if(!empty($value))
              {
                $cond['Product_brand.id']=$value;
              }
              //print_r($cond);
              $data=$this->Product_brand->find('first',array('conditions'=>$cond));
             // print_r($data);
              if(!empty($data))
              {
                array_push($brand_filter,$data['Product_brand']);
                //$prods=Hash::insert($data['Product'], '{n}.search_slug', $search_slug);
                //$prods=Hash::insert($prods,'{n}.type', $type);
               /* if(!empty($params))
                {
                  $prods=Hash::insert($prods,'{n}.params', $params);
                }*/
                $count=$this->getBrandCount($data['Product'],$search_slug,$type,$params,$sort);
               
                 if($count==0)
                 {
                   unset($brand_filter[$key]);
                   continue;
                 }                  
                 else
                   $brand_filter[$key]['product_count']=$count;
                //count(array_values(array_filter(Hash::map($prods, "{n}", array($this, 'getProductCount')))));
               $brand_lang=$this->Ctrl->languageChanger($data['Product_brand_lang']);
                $brand_filter[$key]['brand_name']=$brand_lang['brand_title'];
                //print_r($brandid);
                if(!empty($brandid))
                {
                  // 
                   if(in_array($data['Product_brand']['id'], $brandid))
                    {
                      $brand_filter[$key]['checked']=true;
                    }
                    else
                    {
                      $brand_filter[$key]['checked']=false;
                    }
                }else
                {
                  $brand_filter[$key]['checked']=false;
                }
               
                
              }
             }
           }else
           {

           }
           //echo "<pre>";print_r($brand_filter);echo "</pre>";
            return array_values($brand_filter);
}
function getBrandCount($prods,$slug="",$type="",$params,$sort=""){
   $prid_id=Hash::extract($prods, '{n}.id');
//echo count($prid_id);
      $cond=array('Product.category_id !='=>'','Product.brand !='=>'','Product.status'=>1);
  if(in_array($sort,array('hdiscount','ldiscount')))
   {
     $cond['Offer.discount !=']="";
     $cond['Offer.status']=1;
     $cond['Product.offer_id !=']="";
     $cond['Offer.end_date >=']=date('Y-m-d');

   }

  switch ($type) {
    case 'category':
      if(!empty($params))
      {
          $slug=$params['cat'];
      }
      $searchreg = $this->Product_category->children($slug);
    
      $searchreg =Hash::extract($searchreg, '{n}.Product_category.id'); 
      array_push($searchreg,$slug);
      $cond= array_merge($cond,array('Product.id'=>$prid_id,'Product.category_id'=>$searchreg));
      break;
      case 'brand':
       $cond= array_merge($cond,array('Product.brand'=>$slug));
      break;
      case 'search-for':      
           if(isset($params['cat']))
          {
            $searchreg = $this->Product_category->children($params['cat']);
            $searchreg =Hash::extract($searchreg, '{n}.Product_category.id'); 
             array_push($searchreg,$params['cat']);
            // print_r($searchreg);
            $cond= array_merge($cond,array('Product.id'=>$prid_id,'Product.category_id'=>$searchreg));
          }
          //print_r($prid_id);
                  $cond = array_merge($cond,array('Product.id'=>$prid_id));
                      $slug=preg_replace('/-+/', '-', $slug);
                      $slug_split=explode("-",$slug);
                      $sluges=array();
                        if(!empty($slug_split))
                        {
                           $cond=array_merge($cond,array('or'=>array(array('or'=>array()),array('or'=>array()),array('or'=>array()))));
                           if(count($slug_split)==1)
                {
                  foreach ($slug_split as $key => $value) {
                   
                   $sluges= '';                
                   $sluges=array_merge((array)$sluges,(array)$value);
                   $sluges=implode("%", $sluges);
                   array_push($cond['or'][0]['or'],array('Product.slug like'=>"%". $sluges."%"));   
          //array_push($cond['or'][1]['or'],array('Product_brand.slug like'=>"%". $sluges."%"));  
          //array_push($cond['or'][0]['or'],array('Product_category.slug like'=>"%". $sluges."%"));                   
                  
                  
          $data_cat=$this->getCatIdsBYSlug($sluges);
                  if(!empty($data_cat))
            array_push($cond['or'][1]['or'],array('Product.category_id'=>$data_cat));
                  
          $data_brand=$this->getBrandIdsBYSlug($sluges);
                  if(!empty($data_brand))
            array_push($cond['or'][1]['or'],array('Product.brand'=>$data_brand));
                
                 }
                }
                else
                {

                 foreach ($slug_split as $key => $value) {
                  if(strlen($value)>2)
                  {                  
                   $sluges=array_merge((array)$sluges,(array)$value);
                   $sluges=implode("%", $sluges);
                   array_push($cond['or'][0]['or'],array('Product.slug like'=>"%". $sluges."%"));
                  // $data_cat=$this->getCatIdsBYSlug($slug);
                //  array_push($cond['or'][1]['or'],array('Product.category_id'=>$data_cat));
        
                  
          $data_cat=$this->getCatIdsBYSlug($sluges);
                  if(!empty($data_cat))
            array_push($cond['or'][1]['or'],array('Product.category_id'=>$data_cat));
                  
          $data_brand=$this->getBrandIdsBYSlug($sluges);
                  if(!empty($data_brand))
            array_push($cond['or'][1]['or'],array('Product.brand'=>$data_brand));
                
        
                  }
                 }
                 $slug_split=array_reverse($slug_split);
                 $sluges="";
                 foreach ($slug_split as $key => $value) {
                  if(strlen($value)>2)
                  {                  
                   $sluges=array_merge((array)$sluges,(array)$value);
                   $sluges=implode("%", $sluges);
                   array_push($cond['or'][0]['or'],array('Product.slug like'=>"%". $sluges."%"));
                   //$data_cat=$this->getCatIdsBYSlug($slug);
                  // array_push($cond['or'][1]['or'],array('Product.category_id'=>$data_cat));
          
                  
          $data_cat=$this->getCatIdsBYSlug($sluges);
                  if(!empty($data_cat))
            array_push($cond['or'][1]['or'],array('Product.category_id'=>$data_cat));
                  
          $data_brand=$this->getBrandIdsBYSlug($sluges);
                  if(!empty($data_brand))
            array_push($cond['or'][1]['or'],array('Product.brand'=>$data_brand));
                
          
                  }
                 }

                }
                   }
                 //print_r($cond);
              break;
          }
//print_r($cond);
          $cdate=date('Y-m-d');
        
         $products = $this->Product->find('all',
                                  array(
                                    
                  'fields' => array(
                  
                    'Product.*',
                    
                    'Offer.*',
                    
                    '(case when (Product.offer_id != 0 and Offer.end_date >= "'.$cdate.'" and Offer.status=1) then Product.price-((Product.price * Offer.discount)/100) else Product.price end) as offer_price',
                    
                    '(
                      SELECT COUNT( b.id ) 
                      FROM mc_product_reviews b
                      WHERE b.product_id = Product.id and b.status=1
                      ) AS review_count',
                      
                    '(
                      SELECT sum( b.rating )/review_count
                      FROM mc_product_reviews b
                      WHERE b.product_id = Product.id and b.status=1
                      ) AS rating_count',
                      
                    'Product_category.*',
                    
                    'Product_brand.*',
                    
                    'Merchant.*'

                  ),
                  
                  'conditions'=>$cond
                 
                  
                                  ));
//$cdate=date('Y-m-d');
  // print_r($products);
   if(!empty($products))
   {
          foreach($products as $key=>$val)
           {   
              $img=json_decode(stripslashes($val['Product']['image_url']));
             $products[$key]['Product']['image_path']=$img[0];
             $products[$key]['Product_lang'][0]=$this->Ctrl->languageChanger($products[$key]['Product_lang']);
             $products[$key]['Product_lang'][0]['description']=$this->Ctrl->summary($products[$key]['Product_lang'][0]['description'],200);
            //echo $this->Ctrl->getMerchantDetailsByProduct($val['Product']['id'],$val['Product']['slug']);
               $products[$key]['Product']['merchant_count']=$this->Ctrl->getMerchantDetailsByProduct($val['Product']['id'],$val['Product']['slug']);
              // echo $products[$key]['Product']['merchant_count'];
               $products[$key]['Product']['merchant_count_new']=" ".($products[$key]['Product']['merchant_count']." ".(($products[$key]['Product']['merchant_count']>1)?$this->Ctrl->getWord('sellers'):$this->Ctrl->getWord('seller')));
              if((@$val['Offer']['status'] == 1) && ($val['Offer']['end_date']!='0000-00-00 00:00:00') && ($val['Offer']['end_date'] >= $cdate)) 
              {
               $products[$key]['Product']['offer_price']=$this->Ctrl->getPriceFormat(number_format($val['Product']['price']-($val['Product']['price']*$val['Offer']['discount']/100),2));
               $products[$key]['Product']['offer_price_new']=$val['Product']['price']-($val['Product']['price']*$val['Offer']['discount']/100);
               $products[$key]['Product']['offer_percent']=isset($val['Offer']['discount'])?$val['Offer']['discount']:0;
              }
              else{
                $products[$key]['Product']['offer_price']=$this->Ctrl->getPriceFormat(number_format($val['Product']['price'],2));
                $products[$key]['Product']['offer_price_new']=$val['Product']['price'];
                $products[$key]['Product']['offer_percent']=0;
              } 
              
               /*if(!empty($val['Product_review']))
               {
                $res=Hash::extract($val['Product_review'], '{n}.rating'); 
              //  print_r($res);            
                $products[$key]['Product']['review_count']=count($res);
                $products[$key]['Product']['reate_count']= (array_sum($res)/count($res));
               }else
               {
                $products[$key]['Product']['review_count']=0;
                $products[$key]['Product']['reate_count']=0;
               }*/
         
                $products[$key]['Product']['review_count'] = $products[$key][0]['review_count'];
                $products[$key]['Product']['reate_count'] = $products[$key][0]['rating_count'];

           }
         }
         else
         {
          $products=array();
         }
   foreach ($products as $k => $value) {
    
     foreach ($params as $key => $val) {
       switch ($key) {
         case 'price':
            $price=explode('_',$val);
             // print_r($products[$key]);
              if(($value['Product']['offer_price_new']>=$price[0]) and ($value['Product']['offer_price_new']<=$price[1]))
              {

              }else
              {
                 unset($products[$k]); 
              }
      
           break;
        
       }
     }

   }
//$count=$this->filterbyall($products,$params,$slug);
 /* $count=$this->Product->find('all',array(
    
     'conditions'=>$cond,    
    ));*/
 //print_r($count);echo "---";
return count(array_values($products));
}
function filterDiscantProd($array){
 
    if($array['Product']['offer_percent']!=0 or $array['Product']['offer_percent']!="" )
    {
      return $array;
    }
 
}
function getProductCount($array) {
 //do stuff to array and return the result
 // print_r($array);
 //echo "Cat_id: ".$array['category_id'];
 //echo "<br>Status:".$array['status'];
  if($array['status']!=1)
  {
     return false;
     exit;
  }
  if($array['category_id']=="")
  {
    return false;
    exit;
  }
  //echo $array['type'];

switch (@$array['type']) {
  case 'category':
  // echo $array['category_id'];
   $searchreg = $this->Product_category->children($array['search_slug']);
   $searchreg =Hash::extract($searchreg, '{n}.Product_category.id'); 
   array_push($searchreg,$array['search_slug']);
  // print_r($searchreg);
   if(!in_array($array['category_id'],$searchreg))
    {
      return false;
      exit;
    }
    else
    {
      return $array;
    }
  break;
  case 'brand':
   if($array['brand']!=$array['search_slug'])
    {
      return false;
      exit;
    }
    else
    {
      return $array;
    }
    break;
  case 'search-for':
  //echo $array['params']['cat'];
      if(isset($array['params']['cat']))
      {
        $searchreg = $this->Product_category->children($array['params']['cat']);
        $searchreg =Hash::extract($searchreg, '{n}.Product_category.id'); 
         array_push($searchreg,$array['params']['cat']);
        // print_r($searchreg);
        if(!in_array($array['category_id'],$searchreg))
        {
          return false;
          exit;
        }
      }
      if($array['search_slug']!="")
      {
        $slug= explode('-',strtolower($array['search_slug']));
       $slug_mech="";
         foreach ($slug as $key => $value) {
          if($key==0)
          {
             $slug_mech=$value;
           }else
           {
            $slug_mech.="(".$value.")";
           }
         }
        //echo $array['slug']."--";
          preg_match_all("/".$slug_mech."*/i",$array['slug'],$match);    

          $match=array_filter($match[0]);
         // print_r($match);
      }
      else
      {
        $match=array(1,2);

      }
      if(count($match))
      {
        return $array;
      }else
      {
        return false;
      }
    break;
  
  }

 
  
 
}
 function getCategoryDetails($cat,$search="",$type="",$sort=""){
            $va=array();
            $va1=array();
            //print_r($cat);exit;
            foreach ($cat as $key => $value) {    
            $count=$this->Ctrl->GetProductCountBycategory($value['Product_category']['id'],$search,$type,$sort);
          // echo $count; exit;
            if($count!=0)
             {          
               $va[$key]=$value['Product_category'];
              
             $change_langs= $this->Ctrl->languageChanger($value['Product_category_lang']);
             unset($change_langs['id']);
               $va[$key]= array_merge($va[$key],$change_langs);

              $va[$key]['prod_count']=$count;
              $va1[]=$va[$key];
             }
             
            }
            return $va1;
}
    public function get($pid="",$lang)
    {
      $lang=$this->Ctrl->getLang();
      $this->layout="ajax";
      $products=$this->Product->find('first',array('conditions'=>array('Product.id'=>$pid)));
      $val=$products;
 
      $cdate=date('Y-m-d');
      //print_r($products['Product']['image_url']);
      $img=json_decode(stripslashes($val['Product']['image_url']));
      //print_r($img);
      if(empty($img))
      {
        $img=str_replace(array('["','"]'),array('',''),stripslashes($val['Product']['image_url']));
      }
      $products['Product']['image_path']=$img[0];
      $products['Product']['merchant_count']=$this->Ctrl->getMerchantDetailsByProduct($val['Product']['id'],$val['Product']['slug']);
      if((@$val['Offer']['status'] == 1) && ($val['Offer']['end_date']!='0000-00-00 00:00:00') && ($val['Offer']['end_date'] >= $cdate)) 
      {
       $products['Product']['offer_price']=($val['Product']['price']-($val['Product']['price']*$val['Offer']['discount']/100));
        $products['Product']['offer_percent']=isset($val['Offer']['discount'])?$val['Offer']['discount']:0;
      }
      else{
        $products['Product']['offer_price']=$val['Product']['price'];
        $products['Product']['offer_percent']=0;
      } 
      
       if(!empty($val['Product_review']))
       {
        $res=Hash::extract($val['Product_review'], '{n}.rating'); 
       // print_r($res);            
        $products['Product']['review_count']=count($res);
        $products['Product']['reate_count']= (array_sum($res)/count($res));
       }else
       {
        $products['Product']['review_count']=0;
        $products['Product']['reate_count']=0;
       }
       $pro_details=$this->Ctrl->languageChanger($products['Product_lang']);
      $merchant_store= $this->Product_store->findByMerchant_id($products['Merchant']['id']);
   //print_r($merchant_store);
    $img=json_decode($products['Product']['image_url']);
    $merchants= $this->Ctrl->getMerchantDetailsByProduct($products['Product']['id'],$products['Product']['slug'],'all')
    
      ?>       
                            <div class="icon_close" onclick="hide1()">&nbsp;</div>
                            <div class="listclickpane">
                            <div class="thumbnail-div">
                            <a href="<?=$this->webroot.$lang?>/products/<?=$products['Product']['id']?>-<?=$products['Product']['slug']?>">
                            <img src="<?=$img[0]?>" alt="" /></a>
                            </a>
                            </div>
                            
                            <div class="thumbdata-div">
                            <h1>
                            <a href="<?=$this->webroot.$lang?>/products/<?=$products['Product']['id']?>-<?=$products['Product']['slug']?>">
                          <b> <?= $pro_details['title']?> </b><font style="font-size:13px;"></font>
                            </a>
                            </h1>
                            <!-- style="height: auto;border: none;margin: 10px 0px;border-bottom: 1px solid rgb(221, 221, 221); -->
                            <div class="del_prod_content" style="margin: 10px 0px;border-bottom: 2px solid rgb(221, 221, 221);padding-bottom:5px">
                                <div class="specification" >
                                <?=htmlspecialchars_decode($pro_details['description'])?>
                                </div>
                             </div>
                            <div class="compare_sec_leftdiv">
                            <?php /*?><h2><a href="<?=$this->webroot.$lang?>/products/<?=$products['Product']['id']?>-<?=$products['Product']['slug']?>">More Info &raquo;</a></h2> <?php */?>
                           
                            <div class="clear" style="height:5px;"></div>
                            <?php //print_r($merchants); ?>
                             <?php foreach ($merchants as $key => $value) { ?>
                             <table>
                              <tr>
                                <td style="min-width:50px"><?=ucfirst($value['Merchant']['website_name'])?> :</td>
                                <?php /* ?>    onClick="clickTrack('<?=$value['Product']['product_url']?>','<?=$value['Product']['id']?>','<?=$value['Merchant']['id']?>','<?=$value['Product']['offer_price']?>','<?=$value['Merchant']['image_url']?>','<?=$value['Merchant']['url']?>','<?=$img[0]?>','<?=addslashes($value['Product_lang'][0]['title'])?>');" <?php */ ?>
                                <td><a href="javaScript:void(0);" style="text-decoration:none;float: initial;margin-left: 5px;font-size: 15px;"
               
                  class="shop_by_btn" >
                   <?=$this->Ctrl->getPriceFormat(number_format($value['Product']['offer_price'],2))?>
                   </a></td>
                              </tr>
                             </table>

                           <?php /* ?> <div class="detailslist_data1">
                          <span style="display:inline-block">  <a href="javascript:voif(0)" target="_blank" style="color: #000 !important;
font-size: 15px;"><?=$value['Merchant']['website_name']?></a> :</span> 
                            <span style="display:inline-block;padding-left:5px"><a href="javaScript:void(0);" style="text-decoration:none;float: initial;margin-left: 5px;font-size: 15px;"
                  onClick="clickTrack('<?=$value['Product']['product_url']?>','<?=$value['Product']['id']?>','<?=$value['Merchant']['id']?>','<?=$value['Product']['offer_price']?>','<?=$value['Merchant']['image_url']?>','<?=$value['Merchant']['url']?>','<?=$img[0]?>','<?=$value['Product_lang'][0]['title']?>');"
                  class="shop_by_btn" >
                   <?=$this->Ctrl->getPriceFormat(number_format($value['Product']['offer_price'],2))?>
                   </a></span>
                            </div><?php */ ?>
                            <?php } ?>
                           
                                <div class="small03_get_details"><a href="<?=$this->webroot.$lang?>/products/<?=$products['Product']['id']?>-<?=$products['Product']['slug']?><?php if(count($merchants)>1){ ?>#one <?php } ?>"><?php if(count($merchants)>1){ ?><?=$this->Ctrl->getWord('compare_prices_from')?> <?=count($merchants)?> <?=$this->Ctrl->getWord('stores')?> <?php }else{ ?> <?=$this->Ctrl->getWord('more_info')?> <?php } ?></a></div>
                                 </div>
                                <div class="compare_sec_rgtdiv"> 

<?php /* ?> onClick="clickTrack('<?=$products['Product']['product_url']?>','<?=$products['Product']['id']?>','<?=$products['Merchant']['id']?>','<?=$products['Product']['offer_price']?>','<?=$products['Merchant']['image_url']?>','<?=$products['Merchant']['url']?>','<?=$img[0]?>','<?=addslashes($products['Product_lang'][0]['title'])?>');"<?php */?>
                                    <div class="showlistprice" style="position:inherit;">
                               <a href="javaScript:void(0);" style="text-decoration:none;"
                 
                  class="shop_by_btn pspo-offer-link kpbb" >  
                           <!-- <a class="pspo-offer-link kpbb" href="#">-->
                            <div class="pspo-ol-price">
                    
                              <?=$this->Ctrl->getPriceFormat(number_format($products['Product']['offer_price'],2))?>

                            </div>

                                <div class="pspo-ol-details">
                                    <div class="pspo-ol-seller" style="padding: 5px;"><?=$products['Merchant']['website_name']?></div>
                                  <?php /* ?><div><?=isset($merchant_store['Product_store']['shipping_details'])?$merchant_store['Product_store']['shipping_details']:''?></div><?php */ ?>
                            </div>
                             <div class="psclear"></div>
                            </a>
                            
                            <div class="pspo-offer-flare">
                            
                           <!-- <span><span class="shoppingstarsjs__stars" style=" width:auto; float:left; display:inherit; background-image:url(images/shopping_sprites186_hr.png);background-position:-8px -30px;height:10px;width:65px;background-size:128px">
                            <span class="shoppingstarsjs__stars" aria-label="4" role="img" style="display: block;margin: inherit;float: left;background-image:url(/images/shopping/shopping_sprites186_hr.png);height:13px;width:52px;background-size:128px;background-position:-17px -14px"></span>-->
                            
                            </span>
                            <a class="pspo-sr-link">
                              <div id="ratingss_load" class="showratings">
                                  <div class="star_1 ratings_stars <?=(floor($products['Product']['reate_count']>=1)?"ratings_over":'')?>"></div>
                                  <div class="star_2 ratings_stars <?=(floor($products['Product']['reate_count']>=2)?"ratings_over":'')?>"></div>
                                  <div class="star_3 ratings_stars <?=(floor($products['Product']['reate_count']>=3)?"ratings_over":'')?>"></div>
                                  <div class="star_4 ratings_stars <?=(floor($products['Product']['reate_count']>=4)?"ratings_over":'')?>"></div>
                                  <div class="star_5 ratings_stars <?=(floor($products['Product']['reate_count']>=5)?"ratings_over":'')?>"></div>
                              </div>
                            
                            &nbsp;&nbsp;<small style="font-size:1em;">(<?=$this->Ctrl->getReviewText($products['Product']['review_count'])?>)</small>
                            </a>
                            </span>
                           <a href="javaScript:void(0);" style=""
                  onClick="clickTrack('<?=$products['Product']['product_url']?>','<?=$products['Product']['id']?>','<?=$products['Merchant']['id']?>','<?=$products['Product']['offer_price']?>','<?=$products['Merchant']['image_url']?>','<?=$products['Merchant']['url']?>','<?=$img[0]?>','<?=addslashes($pro_details['title'])?>');"
                  class="shop_by_btn pspo-offer-link kpbb shop_by_btn123 supby_inner_popup"><?=$this->Ctrl->getWord('buy_on_seller');?></a>
                            </div>
                            </div></div>
                           
                            
                            
                            </div>
                            </div>
      <?php
      $this->render('ajax');
    }

   public function GetAutoLoadProduct($type="",$limit="",$page="")
   {
	
	//$limit_1='12';
	 $limit_start = $limit*($page-1); 
   //echo $limit;
	//$limit_start = $limit_1 + ($limit*($page-2)); 
	//echo $limit_start.'==limit start'.$limit.'=='.$page.'=='.$type; //exit;
	$sort_by = array('rating_count'=>'desc','Product.slug'=>'asc');
	
    extract($this->request->data);
    //print_r($this->request->data);
    //print_r($params);
    if(isset($params) and !empty($params))
      extract($params);
	
	if(@$ftype)
	{
		$limit_start = 0;
		$limit = '';
	}
		
	
	$filter_cond = '';
	
	if(!empty($short))
	{
		switch ($short) 
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
			
			case 'hdiscount':
				$sort_by = array('offer_price'=>'desc');
				$filter_cond = 1;
				break;
			
			case 'ldiscount':
				$sort_by = array('offer_price'=>'asc');
				$filter_cond = 1;
				break;
			
		}
	}
	  
    $this->layout="ajax";
    $products=array();
    switch ($type) {
      case 'category':
       $cdate = date('Y-m-d');
       $cond="";
      //echo $ftype;
       if(@$ftype)
       {
          if(isset($cat))
          {
            $all_subid=$this->Product_category->children($cat);
           $all_subid=Hash::extract($all_subid, '{n}.Product_category.id');
            array_push($all_subid,$cat);
           $all_subid=json_encode($all_subid);
          }
         
       }
    
            
        $cond['Product_category.status']= 1;
        $cond['Product.status'] = 1;
        $cond['Product.category_id']= json_decode($all_subid);
        $cond['Product.category_id !='] = '';
        $cond['Product.brand !='] = '';
          
        if(!empty($filter_cond))
        {
          $cond['Offer.discount !=']  = '';
          $cond['Offer.status'] = '1';
          $cond['Offer.end_date >= '] = date('Y-m-d');
        }
              $cdate=date('Y-m-d');
              $products = $this->Product->find('all',
              array(
              
              'fields' => array(
              
                'Product.*',
                
                'Offer.*',
                
                '(case when (Product.offer_id != 0 and Offer.end_date >= "'.$cdate.'" and Offer.status=1) then Product.price-((Product.price * Offer.discount)/100) else Product.price end) as offer_price',
            
                '(
                  SELECT COUNT( b.id ) 
                  FROM mc_product_reviews b
                  WHERE b.product_id = Product.id and b.status=1
                  ) AS review_count',
                  
                '(
                  SELECT sum( b.rating )/review_count
                  FROM mc_product_reviews b
                  WHERE b.product_id = Product.id and b.status=1
                  ) AS rating_count',
                  
                'Product_category.*',
                
                'Product_brand.*',
                
                'Merchant.*'

              ),
              
              'conditions'=>$cond,
              
              'offset' => $limit_start,
              'limit' => $limit,
              'order' => $sort_by
              
              ));
                  
           // echo '<pre>'; print_r($limit); echo '</pre>'; exit;  
            
            /*$productsCount = $this->Product->Find('count', 
                        array(
                            'conditions'=>array(
                              'Product_category.status'=>1,
                              'Product.status'=>1,                              
                              'Product.category_id'=>$all_subid,
                              'Product.category_id !='=>'',
                              'Product.brand !='=>'',
                                     
                            ),
                            'limit'=>$limit,
                            
                            //'order' => array('Product_category.cat_order'=>'asc')
                          ) 
                        );*/ 
            
    $productsCount = $this->Product->Find('count', 
                        array(
                            'conditions'=>$cond
                          ) 
                        );    

           /* $products = $this->Product->Find('all', 
              array(
                  'conditions'=>array(
                    'Product_category.status'=>1,
                    'Product.status'=>1,                    
                    'Product.category_id'=>json_decode($all_subid),                    
                    'Product.brand !='=>'',
                  ),
                
                            //'order' => array('Product_category.cat_order'=>'asc')
              ) 
            ); */
        break;
      case 'brand':
      $cdate = date('Y-m-d');
      $cond="";
  
      $cond['Product.brand']  = $slug;
      $cond['Product.status'] = 1;
      $cond['Product.category_id !='] = '';
      $cond['Product.brand !='] = '';
    
      if(!empty($filter_cond))
      {
        $cond['Offer.discount !=']  = '';
        $cond['Offer.status'] = '1';
        $cond['Offer.end_date >= '] = date('Y-m-d');
      }
          
    
      
           $res= Hash::combine($products, 'Product', '{n}');
        
        
          if(@$ftype)
          {
            if(isset($cat))
            {
            $categorys = $this->Product_category->children($cat);
            //print_r($categorys);
            $all_subid = Hash::extract($categorys, '{n}.Product_category.id');
            array_push($all_subid,$cat);
            $cond['Product.category_id']=$all_subid;
          /*  $products= $this->Product->find('all',
                array(
                  'conditions'=>array(                                    
                  'Product.brand'=>$slug,  
                  'Product.category_id'=>$all_subid,
                  'Product.brand !='=>'',  

                  )
                 ));*/

             }else
             {
              /*$products= $this->Product->find('all',
                array(
                  'conditions'=>array(                                    
                  'Product.brand'=>$slug,  
                  'Product.category_id !='=>'',
                  'Product.brand !='=>'',  

                  )
                  
                 ));*/
             }
          }
          else
          {

          /* $products= $this->Product->find('all',
                array(
                  'conditions'=>array(                                    
                  'Product.brand'=>$slug,  
                  'Product.category_id !='=>'',
                  'Product.brand !='=>'',  

                  )
                  
                 ));*/
          }
           
        // debug($products);
         // $res=Hash::extract($products, '{n}.Product.{n}');
          //
          $products = $this->Product->find('all',
          array(
          
          'fields' => array(
          
            'Product.*',
            
            'Offer.*',
            
            '(case when (Product.offer_id != 0 and Offer.end_date >= "'.$cdate.'" and Offer.status=1) then Product.price-((Product.price * Offer.discount)/100) else Product.price end) as offer_price',
            
            '(
              SELECT COUNT( b.id ) 
              FROM mc_product_reviews b
              WHERE b.product_id = Product.id and b.status=1
              ) AS review_count',
              
            '(
              SELECT sum( b.rating )/review_count
              FROM mc_product_reviews b
              WHERE b.product_id = Product.id and b.status=1
              ) AS rating_count',
              
            'Product_category.*',
            
            'Product_brand.*',
            
            'Merchant.*'

          ),
          
          'conditions'=>$cond,
          
          'offset' => $limit_start,
          'limit' => $limit,
          
          'order' => $sort_by
          
          ));
    //echo '<pre>'; print_r($products); echo '</pre>'; exit;          
    $productsCount = $this->Product->find('count',
          array(
            'conditions'=>$cond
          
          ));

          //$productsCount=count( $products);
         // $products=array();
          /*foreach ($res as $key => $value) {
           //$value['Product_lang']=$value['Product_lang']
           
             $products[$key]=array(
              'Product'=>$value,
              'Product_lang'=>$value['Product_lang'],
              'Product_category'=>$value['Product_category'],
              'Offer'=>$value['Offer'],
              'Product_brand'=>$value['Product_brand'],
              'Product_review'=>$value['Product_review'],
              'Merchant'=>$value['Merchant']
              );
          }*/
        break;
      case 'search-for':
        //extract($this->request->data);
        //echo $cat_id;
        $slugs=str_replace('-','%',$slug);
        $list_data=$this->Product->Product_lang->find('list',array('fields'=>array('Product_lang.product_id'),'conditions'=>array('or'=>array('Product_lang.title like '=>'%'.$slugs.'%' ,/*'MATCH (Product_lang.description ) AGAINST ("'.$slug3.'*" IN BOOLEAN MODE)' */)),'order'=>'Product_lang.title'));
        if(@$cat!=0)
        {
            $categorys = $this->Product_category->children($cat);

            //print_r($categorys);
            $all_subid = Hash::extract($categorys, '{n}.Product_category.id');
            array_push($all_subid,$cat);
          //  print_r($all_subid);
            if(count($all_subid)==1)
            {
              $all_subid=$cat;
           
            }
            $cond=$this->Ctrl->createConditions($slug,$list_data, $all_subid);
            /* $cond=array('Product.category_id'=>$all_subid,                                        
                          'Product.category_id !='=>'',
                          'Product.brand !='=>'',
                          );
          $slug2=str_replace('-',' ',$slug);
          $slug3=str_replace('-','* ',$slug);
          //$slug3=preg_replace('/*', '', $slug3, 1);
            $data_cat=$this->getCatIdsBYSlug($slug2);
            $data_brand=$this->getBrandIdsBYSlug1($slug2);
         //print_r($data_brand);
             if(empty($data_brand) and empty($data_cat))
            {
                $cond['or'][0]=array('Product.brand'=>$data_brand);
                $cond['or'][1]=array('Product.category_id'=>$data_cat);            
                $cond['or'][2]=array('MATCH (Product.slug) AGAINST ("+'.$slug3.'*" IN BOOLEAN MODE)');
            }
            else
            {
              if(!empty($data_brand))
                {
                  $cond['and'][0]=array('Product.brand'=>array_keys($data_brand));
                }
                if(!empty($data_cat))
                {
                   $cond['and'][1]=array('Product.category_id'=>$data_cat);    
                }
                   $countdata=explode(' ', $slug);
                   $slug1=str_replace(' ','-', strtolower(trim($slug)));
                   //echo count($countdata);
                  function trims($n)
                  {
                      return ltrim(rtrim($n,'-'),'-');
                  }


$brandas= array_map("trims", array_values($data_brand));
                if(count($countdata)>1 and !empty($data_brand) and !in_array($slug1,$brandas))
                {
                 $cond['and'][2]=array('MATCH (Product.slug) AGAINST ("+'.$slug3.'*" IN BOOLEAN MODE)');
                }
            }*/
         /*$slug_split=explode("-",$slug);
            $sluges=array();
             
              
             if(!empty($slug_split))
             {
                 $cond=array_merge($cond,array('or'=>array(array('or'=>array()),array('or'=>array()),array('or'=>array()))));
                if(count($slug_split)==1)
                {
                  foreach ($slug_split as $key => $value) {
                                   
                   $sluges=array_merge((array)$sluges,(array)$value);
                   $sluges=implode("%", $sluges);
                   array_push($cond['or'][0]['or'],array('Product.slug like'=>"%". $sluges."%"));
                  //  $data_cat=$this->getCatIdsBYSlug($slug);
                  //array_push($cond['or'][1]['or'],array('Product.category_id'=>$data_cat));
                	
					$data_cat=$this->getCatIdsBYSlug($sluges);
                	if(!empty($data_cat))
						array_push($cond['or'][1]['or'],array('Product.category_id'=>$data_cat));
                	
					$data_brand=$this->getBrandIdsBYSlug($sluges);
          //print_r($cond['or'][2]['or']);
                	if(!empty($data_brand))
						array_push($cond['or'][2]['or'],array('Product.brand'=>$data_brand));
                
                 }
                }
                else
                {

                 foreach ($slug_split as $key => $value) {
                  if(strlen($value)>2)
                  {                  
                   $sluges=array_merge((array)$sluges,(array)$value);
                   $sluges=implode("%", $sluges);
                   array_push($cond['or'][0]['or'],array('Product.slug like'=>"%". $sluges."%"));
                    //$data_cat=$this->getCatIdsBYSlug($slug);
                 // array_push($cond['or'][1]['or'],array('Product.category_id'=>$data_cat));
                	
					$data_cat=$this->getCatIdsBYSlug($sluges);
                	if(!empty($data_cat))
						array_push($cond['or'][1]['or'],array('Product.category_id'=>$data_cat));
                	
					$data_brand=$this->getBrandIdsBYSlug($sluges);
                	if(!empty($data_brand))
						array_push($cond['or'][2]['or'],array('Product.brand'=>$data_brand));
                
                  }
                 }
                 $slug_split=array_reverse($slug_split);
                 $sluges="";
                 foreach ($slug_split as $key => $value) {
                  if(strlen($value)>2)
                  {                  
                   $sluges=array_merge((array)$sluges,(array)$value);
                   $sluges=implode("%", $sluges);
                  array_push($cond['or'][0]['or'],array('Product.slug like'=>"%". $sluges."%"));
                	
					$data_cat=$this->getCatIdsBYSlug($sluges);
                	if(!empty($data_cat))
						array_push($cond['or'][1]['or'],array('Product.category_id'=>$data_cat));
                	
					$data_brand=$this->getBrandIdsBYSlug($sluges);
                	if(!empty($data_brand))
						array_push($cond['or'][2]['or'],array('Product.brand'=>$data_brand));
                
                  // $data_cat=$this->getCatIdsBYSlug($slug);
                  //array_push($cond['or'][1]['or'],array('Product.category_id'=>$data_cat));
                  }
                 }

                }
            }*/
                   
                     
             /*$products= $this->Product->find('all',array('conditions'=>$cond));*/
			 
		if(!empty($filter_cond))
		{
			$cond['Offer.discount !=']	= '';
			$cond['Offer.status']	= '1';
			$cond['Offer.end_date >= ']	= date('Y-m-d');
		}
				  $cdate=date('Y-m-d');
		$products = $this->Product->find('all',
				  array(
					
					'fields' => array(
					
						'Product.*',
						
						'Offer.*',
						
						'(case when (Product.offer_id != 0 and Offer.end_date >= "'.$cdate.'" and Offer.status=1) then Product.price-((Product.price * Offer.discount)/100) else Product.price end) as offer_price',
						
						'(
							SELECT COUNT( b.id ) 
							FROM mc_product_reviews b
							WHERE b.product_id = Product.id and b.status=1
							) AS review_count',
							
						'(
							SELECT sum( b.rating )/review_count
							FROM mc_product_reviews b
							WHERE b.product_id = Product.id and b.status=1
							) AS rating_count',
							
						'Product_category.*',
						
						'Product_brand.*',
						
						'Merchant.*'

					),
					
					'conditions'=>$cond,
					
					'offset' => $limit_start,
					'limit' => $limit,
					'order' => $sort_by
					
				  ));
						  
						
			 
             $productsCount= $this->Product->find('count',array('conditions'=>$cond));

        }
        else
        {

          $cond=$this->Ctrl->createConditions($slug,$list_data);


          //echo str_replace("-", "%",$slug);
         /* $cond=array('Product.category_id !='=>'',
                      'Product.brand !='=>'',
                      'Product.status'=>1
                    );*/
        //  $slug = 'Mobile'; 
		 //echo $slug;
		  /* $slug2=str_replace('-',' ',$slug);
          $slug3=str_replace('-','* ',$slug);
         // $slug3=preg_replace('/*', '', $slug3, 1);
            $data_cat=$this->getCatIdsBYSlug($slug2);
            $data_brand=$this->getBrandIdsBYSlug1($slug2);
         
             if(empty($data_brand) and empty($data_cat))
            {
                $cond['or'][0]=array('Product.brand'=>$data_brand);
                $cond['or'][1]=array('Product.category_id'=>$data_cat);            
                $cond['or'][2]=array('MATCH (Product.slug) AGAINST ("+'.$slug3.'*" IN BOOLEAN MODE)');
            }
            else
            {
             if(!empty($data_brand))
                {
                  $cond['and'][0]=array('Product.brand'=>array_keys($data_brand));
                }
                if(!empty($data_cat))
                {
                   $cond['and'][1]=array('Product.category_id'=>$data_cat);    
                }
                   $countdata=explode(' ', $slug);
                   $slug1=str_replace(' ','-', strtolower(trim($slug)));
                   //echo count($countdata);
                  function trims($n)
                  {
                      return ltrim(rtrim($n,'-'),'-');
                  }


$brandas= array_map("trims", array_values($data_brand));
                if(!empty($data_brand) and !in_array($slug1,$brandas))
                {
                 $cond['and'][2]=array('MATCH (Product.slug) AGAINST ("+'.$slug3.'*" IN BOOLEAN MODE)');
                }
            }
            */
		  /*$slug_split=explode("-",$slug);
            $sluges=array();
             
              
             if(!empty($slug_split))
             {
                 $cond=array_merge($cond,array('or'=>array(array('or'=>array()),array('or'=>array()),array('or'=>array()))));
                if(count($slug_split)==1)
                {
                  foreach ($slug_split as $key => $value) {
                                   
                   $sluges=array_merge((array)$sluges,(array)$value);
                   $sluges=implode("%", $sluges);
                   array_push($cond['or'][0]['or'],array('Product.slug like'=>"%". $sluges."%"));
                 // $data_cat=$this->getCatIdsBYSlug($slug);
                 //  array_push($cond['or'][1]['or'],array('Product.category_id'=>$data_cat));
				  
                	
					$data_cat=$this->getCatIdsBYSlug($sluges);
                	if(!empty($data_cat))
						array_push($cond['or'][1]['or'],array('Product.category_id'=>$data_cat));
                	
					$data_brand=$this->getBrandIdsBYSlug($sluges);
                	if(!empty($data_brand))
						array_push($cond['or'][2]['or'],array('Product.brand'=>$data_brand));
                
                 }
                }
                else
                {

                 foreach ($slug_split as $key => $value) {
                  if(strlen($value)>2)
                  {                  
                   $sluges=array_merge((array)$sluges,(array)$value);
                   $sluges=implode("%", $sluges);
                   array_push($cond['or'][0]['or'],array('Product.slug like'=>"%". $sluges."%"));
                   // $data_cat=$this->getCatIdsBYSlug($slug);
                  // array_push($cond['or'][1]['or'],array('Product.category_id'=>$data_cat));
				  
                	
					$data_cat=$this->getCatIdsBYSlug($sluges);
                	if(!empty($data_cat))
						array_push($cond['or'][1]['or'],array('Product.category_id'=>$data_cat));
                	
					$data_brand=$this->getBrandIdsBYSlug($sluges);
                	if(!empty($data_brand))
						array_push($cond['or'][2]['or'],array('Product.brand'=>$data_brand));
                
				  }
                 }
                 $slug_split=array_reverse($slug_split);
                 $sluges="";
                 foreach ($slug_split as $key => $value) {
                  if(strlen($value)>2)
                  {                  
                   $sluges=array_merge((array)$sluges,(array)$value);
                   $sluges=implode("%", $sluges);
                  array_push($cond['or'][0]['or'],array('Product.slug like'=>"%". $sluges."%"));
                 //  $data_cat=$this->getCatIdsBYSlug($slug);
                 //  array_push($cond['or'][1]['or'],array('Product.category_id'=>$data_cat));
				  
                	
					$data_cat=$this->getCatIdsBYSlug($sluges);
                	if(!empty($data_cat))
						array_push($cond['or'][1]['or'],array('Product.category_id'=>$data_cat));
                	
					$data_brand=$this->getBrandIdsBYSlug($sluges);
                	if(!empty($data_brand))
						array_push($cond['or'][2]['or'],array('Product.brand'=>$data_brand));
                
				  }
                 }

                }
            }*/
                        /*$products= $this->Product->find('all',
                                  array(
                                    'conditions'=>$cond
                                  ));*/
								  
		if(!empty($filter_cond))
		{
			$cond['Offer.discount !=']	= '';
			$cond['Offer.status']	= '1';
			$cond['Offer.end_date >= ']	= date('Y-m-d');
		}
				  $cdate=date('Y-m-d');
		      $products = $this->Product->find('all',
				  array(
					
					'fields' => array(
					
						'Product.*',
						
						'Offer.*',
						
						'(case when (Product.offer_id != 0 and Offer.end_date >= "'.$cdate.'" and Offer.status=1) then Product.price-((Product.price * Offer.discount)/100) else Product.price end) as offer_price',
						
						'(
							SELECT COUNT( b.id ) 
							FROM mc_product_reviews b
							WHERE b.product_id = Product.id and b.status=1
							) AS review_count',
							
						'(
							SELECT sum( b.rating )/review_count
							FROM mc_product_reviews b
							WHERE b.product_id = Product.id and b.status=1
							) AS rating_count',
							
						'Product_category.*',
						
						'Product_brand.*',
						
						'Merchant.*'

					),
					
					'conditions'=>$cond,
					
					'offset' => $limit_start,
					'limit' => $limit,
					'order' => $sort_by
					
				  ));
						// echo $this->element('sql_dump'); 
				//echo '<pre>'; print_r($cond);	echo '=='.$limit_start	.'=='.$limit; print_r($sort_by);echo '<pre>'; print_r($products);
					//	$log = $this->Product->getDataSource()->getLog(false, false);
          //  print_r($log);
                         $productsCount= $this->Product->find('count',
                                  array(
                                    'conditions'=>$cond
                                  ));
        }
        break;
     
    }

          $cdate=date('Y-m-d');
          foreach($products as $key=>$val)
           {
              $img=json_decode(stripslashes($val['Product']['image_url']));
               $products[$key]['Product_lang'][0]=$this->Ctrl->languageChanger($products[$key]['Product_lang']);
               $products[$key]['Product_lang'][0]['title_list']=addslashes($products[$key]['Product_lang'][0]['title']);
               $products[$key]['Product_lang'][0]['title_list_new']=$products[$key]['Product_lang'][0]['title'];
               $products[$key]['Product_lang'][0]['title']=$this->Ctrl->summary($products[$key]['Product_lang'][0]['title'],20);
              $products[$key]['Product_lang'][0]['description']=$this->Ctrl->summary($products[$key]['Product_lang'][0]['description'],200);
              $products[$key]['Product']['image_path']=$img[0];
              $products[$key]['Product']['merchant_count']=$this->Ctrl->getMerchantDetailsByProduct($val['Product']['id'],$val['Product']['slug']);
                $products[$key]['Product']['merchant_count_new']=" ".($products[$key]['Product']['merchant_count']." ".(($products[$key]['Product']['merchant_count']>1)?$this->Ctrl->getWord('sellers'):$this->Ctrl->getWord('seller')));
              if((@$val['Offer']['status'] == 1) && ($val['Offer']['end_date']!='0000-00-00 00:00:00') && ($val['Offer']['end_date'] >= $cdate)) 
              {
               $products[$key]['Product']['offer_price']=$this->Ctrl->getPriceFormat(number_format($val['Product']['price']-($val['Product']['price']*$val['Offer']['discount']/100),2));
               $products[$key]['Product']['offer_price_new']=$val['Product']['price']-($val['Product']['price']*$val['Offer']['discount']/100);
               //($val['Product']['price']-($val['Product']['price']*$val['Offer']['discount']/100));
                $products[$key]['Product']['offer_percent']=isset($val['Offer']['discount'])?$val['Offer']['discount']:0;
                 //$products[$key]['Product']['discount']=true;
                 $products[$key]['Product']['price']=$this->Ctrl->getPriceFormat(number_format($val['Product']['price'],2));
              }
              else{
                $products[$key]['Product']['offer_price']=$this->Ctrl->getPriceFormat(number_format($val['Product']['price'],2));
                $products[$key]['Product']['offer_percent']=0;
                 $products[$key]['Product']['offer_price_new']=$val['Product']['price'];
                  //$products[$key]['Product']['discount']=false;
                  $products[$key]['Product']['price']=$this->Ctrl->getPriceFormat(number_format($val['Product']['price'],2));
              } 
              
               /*if(!empty($val['Product_review']))
               {
                $res=Hash::extract($val['Product_review'], '{n}.rating'); 
               // print_r($res);            
                $products[$key]['Product']['review_count']=count($res);
                $products[$key]['Product']['reate_count']= (array_sum($res)/count($res));
               }else
               {
                $products[$key]['Product']['review_count']=0;
                $products[$key]['Product']['reate_count']=0;
               }*/
			   
                $products[$key]['Product']['review_count']=$products[$key][0]['review_count'];
                $products[$key]['Product']['reate_count']=$products[$key][0]['rating_count'];
                $products[$key]['Product']['review_count_new']=$this->Ctrl->getReviewText($products[$key][0]['review_count']);

           }
          
           //print_r($this->params);
          
           /*switch ($short) {
             case 'popular':
              $products=Hash::sort($products, '{n}.Product.reate_count', 'desc');
              break;
              case 'plow':
              $products=Hash::sort($products, '{n}.Product.offer_price_new', 'asc');
              break;
              case 'phigh':
              $products=Hash::sort($products, '{n}.Product.offer_price_new', 'desc');
              break;
               case 'hdiscount':
              $products= Hash::map($products, "{n}", array($this, 'filterDiscantProd'));
              $products=array_filter($products);
              //$products=Hash::sort($products, '{n}.Product.offer_percent', 'desc');
              $products=Hash::sort($products, '{n}.Product.offer_price_new', 'desc');
              $productsCount=count($products);

              break;
              case 'ldiscount':
              $products= Hash::map($products, "{n}", array($this, 'filterDiscantProd'));
              $products=array_filter($products);
              //$products=Hash::sort($products, '{n}.Product.offer_percent', 'desc');
              $products=Hash::sort($products, '{n}.Product.offer_price_new', 'asc');
              $productsCount=count($products);

              break;
             default:
              $products=Hash::sort($products, '{n}.Product.reate_count', 'desc');
               break;
           }*/

        
         $proddata=array();
            //$rproduct=array();
            //$restproducts=$restdata;
            //print_r($restproducts);
           $i=0;
           //$pageleft ($limit*$page);
        // print_r($products);
         if(!@$ftype)
          {
             $proddata = $products;
			   
			 /*foreach ($products as $key => $value) {
             // echo $key;
             //echo  ($limit*$page);
               if(($key>=($limit*$page)) )
               {
                  if(($i<$limit))
                  {
                    $i++;
                   array_push($proddata,$value);
                  }else
                  {
                    break;
                  }
               }
             }*/
           }else
           {
             //print_r($products);
            $prod=$this->filterbyall($products,$params,$slug);

            $proddata=$prod['products'];
            $withoutDiscount=$prod['withoutdiscount'];
            $proddataWithoutPrice=$prod['withoutprice'];
           //print_r($type);
             // $pcategorys = $this->categoryFilter($products,$slug,$type,$params); 
             //$pcategorys=array();  
           //print_r($params);
             $brands=array();
             $merchant=array();
             $countdiscount=array();
             $attributes=array();
             $priceMinMax=array();
             $i=0;
             foreach ($params as $key => $value) {
                      switch ($key) {
                        case 'cat':
                           $brands=$this->brandFilter($products,$slug,@$brand,$type,$params,$short);  
                           $merchant=$this->merchantFilter($products,$slug,$params);                           $attributes=$this->getAttributes($proddata);       
                           if(!isset($params['brand']))  
                           $countdiscount=$this->getDiscountAndNondiscountCounts($products);  
                            else
                              $countdiscount=$this->getDiscountAndNondiscountCounts($withoutDiscount);

                           $attributes=$this->getAttributes($proddata);
                            if(!isset($params['price']))     
                           $priceMinMax=$this->priceMinMax($proddata); 
                           else                
                             $priceMinMax=$this->priceMinMax($proddataWithoutPrice); 
                        break;
                        case 'brand':                       
                          $brands=$this->brandFilter($products,$slug,@$brand,$type,$params,$short);
                          $merchant=$this->merchantFilter($proddata,$slug,$params); 

                          if(!isset($params['discount']))  
                          $countdiscount=$this->getDiscountAndNondiscountCounts($proddata);
                          else
                          $countdiscount=$this->getDiscountAndNondiscountCounts($withoutDiscount);
                         //print_r($proddata);
                          $attributes=$this->getAttributes($proddata);  
                           if(!isset($params['price']))     
                           $priceMinMax=$this->priceMinMax($proddata); 
                           else                
                             $priceMinMax=$this->priceMinMax($proddataWithoutPrice); 

                         break;
                         case 'price':                       
                          $brands=$this->brandFilter($products,$slug,@$brand,$type,$params,$short);

                          $merchant=$this->merchantFilter($proddata,$slug,$params); 

                         if(!isset($params['discount']))  
                          $countdiscount=$this->getDiscountAndNondiscountCounts($proddata);
                         else
                          $countdiscount=$this->getDiscountAndNondiscountCounts($withoutDiscount);

                          $attributes=$this->getAttributes($proddata); 
                          if(!isset($params['price']))     
                           $priceMinMax=$this->priceMinMax($proddata); 
                           else                
                             $priceMinMax=$this->priceMinMax($proddataWithoutPrice); 

                         break;
                         case 'merchant':
                         $attributes=$this->getAttributes($proddata);
                          if($i==0)
                          {
                            //$merchant=$this->merchantFilter($products,$slug,$params);
                          }
                          else
                          {
                            //$merchant=$this->merchantFilter($proddata,$slug,$params);
                          }                        
                          if(!isset($params['price']))     
                           $priceMinMax=$this->priceMinMax($proddata); 
                           else                
                             $priceMinMax=$this->priceMinMax($proddataWithoutPrice); 
                            //$brands=$this->brandFilter($products,$slug,@$brand);
                         break;
                         case 'discount':
                          $brands=$this->brandFilter($products,$slug,@$brand,$type,$params,$short);

                          $merchant=$this->merchantFilter($proddata,$slug,$params); 

                         if(!isset($params['discount']))  
                          $countdiscount=$this->getDiscountAndNondiscountCounts($proddata);
                         else
                          $countdiscount=$this->getDiscountAndNondiscountCounts($withoutDiscount);

                          $attributes=$this->getAttributes($proddata); 
                           if(!isset($params['price']))     
                           $priceMinMax=$this->priceMinMax($proddata); 
                           else                
                             $priceMinMax=$this->priceMinMax($proddataWithoutPrice); 
                         break;
                         case 'attr':
                         //print_r($proddata);
                            if(empty($attributes))
                            {
                               $attributes=$this->getAttributes($proddata);                                              
                            }
                          
                            $prodData=array();
                            $parts=explode("@", $value);
                           
                            foreach ($parts as $k => $value) {
                               $parts1=explode("_", $value);
                               // print_r($parts1);
                             foreach ($attributes as $key => $val) {
                            //  print_r($val);
                                if($val['tslug']==$parts1[0])
                                {
                                //  print_r($attributes);
                                  foreach ($val['children'] as $ke => $valu) {
                                    //print_r($valu);
                                      if($valu['slug']==$parts1[1])
                                      {
                                       // print_r($valu);
                                       // echo $valu['product_id'];
                                        $prodData=array_merge($prodData,$valu['product_id']);
                                        $attributes[$key]['children'][$ke]['checked']=true;
                                      }
                                         
                                  }
                                
                                }
                              }
                             
                            }
                             //print_r($attributes);
                            $prodData=array_values(array_unique($prodData));
                            $products=$this->Product->find('all',array('conditions'=>array('Product.id'=>$prodData)));
                           // $attributes=array();
                          // print_r($products);
                 foreach($products as $key=>$val)
                 {
                    $img=json_decode(stripslashes($val['Product']['image_url']));
                    $products[$key]['Product_lang'][0]['title']=$this->Ctrl->summary($products[$key]['Product_lang'][0]['title'],20);
                     $products[$key]['Product_lang'][0]['title_list']=addslashes($products[$key]['Product_lang'][0]['title']);
                     $products[$key]['Product_lang'][0]['title_list_new']=$products[$key]['Product_lang'][0]['title'];
                    $products[$key]['Product_lang'][0]['description']=$this->Ctrl->summary($products[$key]['Product_lang'][0]['description'],200);
                    $products[$key]['Product']['image_path']=$img[0];
                    $products[$key]['Product']['merchant_count']=$this->Ctrl->getMerchantDetailsByProduct($val['Product']['id'],$val['Product']['slug']);
                     $products[$key]['Product']['merchant_count_new']=" ".($products[$key]['Product']['merchant_count']." ".(($products[$key]['Product']['merchant_count']>1)?$this->Ctrl->getWord('sellers'):$this->Ctrl->getWord('seller')));
                    if((@$val['Offer']['status'] == 1) && ($val['Offer']['end_date']!='0000-00-00 00:00:00') && ($val['Offer']['end_date'] >= $cdate)) 
                    {
                     $products[$key]['Product']['offer_price']=$this->Ctrl->getPriceFormat(number_format($val['Product']['price']-($val['Product']['price']*$val['Offer']['discount']/100),2));
                     $products[$key]['Product']['offer_price_new']=$val['Product']['price']-($val['Product']['price']*$val['Offer']['discount']/100);
                     //($val['Product']['price']-($val['Product']['price']*$val['Offer']['discount']/100));
                      $products[$key]['Product']['offer_percent']=isset($val['Offer']['discount'])?$val['Offer']['discount']:0;
                       //$products[$key]['Product']['discount']=false;
                       $products[$key]['Product']['price']=$this->Ctrl->getPriceFormat(number_format($val['Product']['price'],2));
                    }
                    else{
                      $products[$key]['Product']['offer_price']=$this->Ctrl->getPriceFormat(number_format($val['Product']['price'],2));
                      $products[$key]['Product']['offer_percent']=0;
                       $products[$key]['Product']['offer_price_new']=$val['Product']['price'];
                       // $products[$key]['Product']['discount']=true;
                        $products[$key]['Product']['price']=$this->Ctrl->getPriceFormat(number_format($val['Product']['price'],2));
                    } 
                    
                     if(!empty($val['Product_review']))
                     {
                      $res=Hash::extract($val['Product_review'], '{n}.rating'); 
                     // print_r($res);            
                      $products[$key]['Product']['review_count']=count($res);
                      $products[$key]['Product']['reate_count']= (array_sum($res)/count($res));
                     }else
                     {
                      $products[$key]['Product']['review_count']=0;
                      $products[$key]['Product']['reate_count']=0;
                     }
                       $products[$key]['Product']['review_count_new']=$this->Ctrl->getReviewText($products[$key]['Product']['review_count']);

                 }
        //print_r($products);
       // print_r($attributes);
           //print_r($this->params);
          
           switch ($short) {
             case 'popular':
              $products=Hash::sort($products, '{n}.Product.reate_count', 'desc');
              break;
              case 'plow':
              $products=Hash::sort($products, '{n}.Product.offer_price_new', 'asc');
              break;
              case 'phigh':
              $products=Hash::sort($products, '{n}.Product.offer_price_new', 'desc');
              break;
               case 'hdiscount':
              $products= Hash::map($products, "{n}", array($this, 'filterDiscantProd'));
              $products=array_filter($products);
              //$products=Hash::sort($products, '{n}.Product.offer_percent', 'desc');
              $products=Hash::sort($products, '{n}.Product.offer_price_new', 'desc');
              $productsCount=count($products);

              break;
              case 'ldiscount':
              $products= Hash::map($products, "{n}", array($this, 'filterDiscantProd'));
              $products=array_filter($products);
              //$products=Hash::sort($products, '{n}.Product.offer_percent', 'desc');
              $products=Hash::sort($products, '{n}.Product.offer_price_new', 'asc');
              $productsCount=count($products);

              break;
             default:
              //$products=Hash::sort($products, '{n}.Product.reate_count', 'desc');
               break;
           }
           $proddata=$products;
            if(!isset($params['price']))     
                           $priceMinMax=$this->priceMinMax($proddata); 
                           else                
                             $priceMinMax=$this->priceMinMax($proddataWithoutPrice); 
                            //$proddata=$products;
                             break;
                             default:
                             // $attributes=$this->getAttributes($proddata);                         
                             break;
                          }
                           
                        
                          $i++;
                        }
          }
		  
		 $total_count = $this->Product->find('count', array( 
		 
		 								'conditions'=>$cond 
		 							)); 
		  
		  
		 // echo '<pre>'; print_r($attributes);
		  //echo '<pre>'; print_r($proddata);
         //print_r($countdiscount);
           //print_r($proddata);
           //print_r($brands);
          //print_r(array('allproduct'=>$proddata,'params'=>array('brand'=>@$brands,'category'=>@$pcategorys)));
           echo json_encode(array('allproduct'=>$proddata,'params'=>array('brand'=>@$brands,'merchant'=>@$merchant,'discount'=>@$countdiscount,'attr'=>@$attributes,'price'=>@$priceMinMax),'total_count'=>$productsCount));
           //$this->set("products",$products);
           //$this->set('productsCount', $productsCount);
           $this->render('ajax');
      }
   private function filterbyall($products=array(),$params=array(),$slug=""){
      $prod=array();
      $i=0;
    // print_r($products);
    $privproducts=$products;
    $totalProdWithoutDiscount=$products;
    $withoutprice=$products;
      foreach ($products as $key => $value) {
        foreach ($params as $k => $val) {
          switch ($k) {
            case 'cat':
             //array_push($prod,$value);
              break;
              case 'brand':
              $val=explode('_', $val);
              if(is_array($val))
              {              
               if(!in_array($value['Product_brand']['id'], $val))
               {
                unset($products[$key]); 
                unset($totalProdWithoutDiscount[$key]);  
                unset($withoutprice[$key]);           
               }
              }
              else if(!is_array($val))
              {
                if( $val!=$value['Product_brand']['id'])
               {
                unset($products[$key]);  
                 unset($totalProdWithoutDiscount[$key]);  
                 unset($withoutprice[$key]);                    
               }
              }
              break;
              case 'merchant':
              $val=explode('_', $val);
              if(is_array($val))
              {              
               if(!in_array($value['Merchant']['id'], $val))
               {
                unset($products[$key]); 
                unset($totalProdWithoutDiscount[$key]);  
                unset($withoutprice[$key]);           
               }
              }
              else if(!is_array($val))
              {
                if($val!=$value['Merchant']['id'])
               {
                unset($products[$key]);  
                 unset($totalProdWithoutDiscount[$key]);  
                 unset($withoutprice[$key]);                    
               }
              }
               
              break;
              case 'discount':
              if($val==1)
              {
                if($value['Product']['offer_percent']>0)
               {
                unset($products[$key]);  
                unset($withoutprice[$key]);              
               }
              }
              elseif($val==2)
              {

                  if($value['Product']['offer_percent']==0)
                   {
                    //echo $value['Product']['offer_percent'];
                    unset($products[$key]); 
                    unset($withoutprice[$key]);               
                   }
              }
               
              break;
              case 'price':
              $price=explode('_',$val);
             // print_r($products[$key]);
              if(($value['Product']['offer_price_new']>=$price[0]) and ($value['Product']['offer_price_new']<=$price[1]))
              {

              }else
              {
                 unset($products[$key]); 
                  unset($totalProdWithoutDiscount[$key]);        
              }
              break;
           
          }
        }
      }
      return array('products'=>array_values($products),'privprod'=>array_values($privproducts),'withoutdiscount'=> $totalProdWithoutDiscount,'withoutprice'=>$withoutprice);
   }
   public $i=0;
   public function getfilterChild($chcat="",$check=array(),$slug="",$type="",$next=true,$select_id="",$sort=""){
           if(!empty($check))
           {
            if(isset($check['cat']))
            {
              $cat=$this->Product_category->getPath($check['cat']);
              $res=Hash::extract($cat, '{n}.Product_category.id'); 
            }
            if(isset($check['brand']))
            {
              $brand=$check['brand'];
            }
             
           }
          //print_r($check);
		  if(!empty($check))
           $check=array_merge($check,array('slug'=>$slug));
         // print_r($res);
            if($next)
            {
               $this->i++;
            if(((count(@$res)-1)>=$this->i)  )
            {
                foreach ($chcat as $k => $val) {
                  /* echo $this->i;
                    echo "---";
                    echo @$res[$this->i];
                    echo "---";
                    echo $val['id'];
                     echo "---#";*/
                     //echo $select_id;
                      if($val['id']==$select_id)
                      {
                         $chcat[$k]['is_parent']=true;
                      }
                      else
                      {
                          $chcat[$k]['is_parent']=false;
                      }
                    if($val['id']==@$res[($this->i)])
                     {
                      //$chcat[$k]['children']=$this->getfilterChild($chcat[$k]['children'],$check,$slug);
                        $cat=$this->Product_category->children($val['id'],true,null,null,null,1,1);
                        if((count($res)-1)==($this->i))
                        {
                         $chcat[$k]['checked']=true;
                        }
                        else
                        {
                          $chcat[$k]['checked']=false;
                        }
                        $chcat[$k]['children']=array();
                        $chcat[$k]['children']=$this->getCategoryDetails($cat,$check,$type,$sort);
                        $chcat[$k]['children']=$this->getfilterChild($chcat[$k]['children'],$check,$slug,$type,true,$select_id,$sort);
                        //print_r($chcat[$k]['children']);
                       // print_r($this->getfilterChild($chcat[$k]['children'],$check,$slug));
                     }else
                     {
                        $chcat[$k]['checked']=false;
                        $chcat[$k]['children']=false;
                     }
                   }
           }else
           {
             foreach ($chcat as $k => $val) {
                    if($val['id']==$select_id)
                      {
                         $chcat[$k]['is_parent']=true;
                      }
                      else
                      {
                          $chcat[$k]['is_parent']=false;
                      }
                        $chcat[$k]['checked']=false;
                        $chcat[$k]['children']=false;
             }
           }
         }
         else
           {
             foreach ($chcat as $k => $val) {
                      if($val['id']==$select_id)
                      {
                         $chcat[$k]['is_parent']=true;
                      }
                      else
                      {
                          $chcat[$k]['is_parent']=false;
                      }
                        $chcat[$k]['checked']=false;
                        $chcat[$k]['children']=false;
             }
           }
          
           //print_r($chcat);
           return $chcat;
   }
   public function getfilterCategory(){
    
  //
    $dbval=func_get_args();  
    $check=1;
    if(empty($dbval))
    {
      $this->layout="ajax";
      $dbval=$this->request->data;
      $dbval['params']=array('cat'=>$dbval['catid']);
      $check=0;
    }
    else
    {
       $dbval= $dbval[0];
    }
   // print_r($dbval);
    if(in_array($dbval['type'],array('category','brand')))
    {
      if($dbval['type']=='brand')
      {
         $brand=$this->Product_brand->findBySlug($dbval['slug']);
         $dbval['slug']=$brand['Product_brand']['id'];
       } 
       else{
         $dbval['slug']="";
       }    
      
    }
    $dat=array();
    foreach ($dbval['parents'] as $key => $value) {
       $pcat=$this->Product_category->findById($value);
       array_push($dat,$pcat['Product_category'] );
       $change_language = $this->Ctrl->languageChanger($pcat['Product_category_lang']);
       unset($change_language['id']);
       $dat[$key]=array_merge($dat[$key],$change_language);
       $cat=$this->Product_category->children($value,true,null,null,null,1,1);
       //print_r($cat);
       //echo $dbval['slug'];
       $prm=array('slug'=>$dbval['slug']);
       if(isset($dbval['params']))
       {
          $prm=array_merge($prm,$dbval['params']);
       }
      // echo $dbval['sort'];
      // print_r($cat);
       $dat[$key]['children']=$this->getCategoryDetails($cat,$prm,$dbval['type'],$dbval['sort']);
       //print_r($cat); exit;
    }
    //print_r($dat);
    foreach ($dat as $key => $value) {
      if(@$dbval['params']['cat']!="")
      {
         $cat=$this->Product_category->getPath($dbval['params']['cat']);
         $res=Hash::extract($cat, '{n}.Product_category.id'); 
      }
      
       //print_r($res);
       //echo $value['id'];
     // echo $select_id;
      if($value['id']==@$dbval['select_id'])
      {
         $dat[$key]['is_parent']=true;
      }
      else
      {
         $dat[$key]['is_parent']=false;
      }
       if($value['id']==@$res[0])
       {
           //echo $res[0];
          if(count(@$res)==1)
          {
            $dat[$key]['checked']=true;
          }
          else{
            $dat[$key]['checked']=false;
          }      
         $dat[$key]['title']=ucfirst(str_replace('-',' ',$value['slug']));  
         $dat[$key]['children']=$this->getfilterChild($dat[$key]['children'],@$dbval['params'],$dbval['slug'],$dbval['type'],true,($dbval['type']=="category")?$dbval['select_id']:"",$dbval['sort']);
         
       }
       else
       {
         if($value['id']==@$dbval['select_id'])
          {
             $dat[$key]['is_parent']=true;
          }
          else
          {
             $dat[$key]['is_parent']=false;
          }
          $dat[$key]['title']=ucfirst(str_replace('-',' ',$value['slug']));  
          $dat[$key]['children']=$this->getfilterChild($dat[$key]['children'],@$dbval['params'],$dbval['slug'],$dbval['type'],false,($dbval['type']=="category")?@$dbval['select_id']:"",$dbval['sort']);
          $dat[$key]['checked']=false;
          
       }
     
    }
    //print_r($check);
    if($check==0)
    {
      echo json_encode(array('category'=>$dat));
       $this->render('ajax');
    }
    elseif($check==1)
    {
     return $dat;

    }
   }
   function getfilterBrand(){
      $this->layout="ajax";
      $dbval=$this->request->data;
  //print_r($this->request->data);
           $brand_filter=array();
            foreach ($dbval['parents'] as $key => $value) {
              $data=$this->Product_brand->find('first',array('conditions'=>array('Product_brand.id'=>$value)));
              array_push($brand_filter,$data['Product_brand']);
              //$prods=Hash::insert($data['Product'], '{n}.search_slug', $dbval['slug']);
              //$prods=Hash::insert($prods, '{n}.type', $dbval['type']);
              //$prods=Hash::insert($prods, '{n}.params', $dbval['params']);
              $count=$this->getBrandCount($data['Product'],$dbval['slug'],$dbval['type'],$dbval['params'],$dbval['short']);
               if($count==0)
               {
                unset($brand_filter[$key]);
                continue;
               }              
              else
              {
                $brand_filter[$key]['product_count']=$count;
              }
             // $brand_filter[$key]['product_count']=count(array_filter(Hash::map($prods, "{n}", array($this, 'getProductCount'))));
              $brand_lang=$this->Ctrl->languageChanger($data['Product_brand_lang']);
              $brand_filter[$key]['brand_name']=$brand_lang['brand_title'];
              if(in_array($value, $dbval['brandid']))
              {
                 $brand_filter[$key]['checked']=true;
              }else
              {
                 $brand_filter[$key]['checked']=false;
              }
             // print_r($data);
            }
           echo  json_encode(array('brand'=>array_values($brand_filter)));     
            $this->render('ajax');
   }
   function getfilterMerchant(){
      $this->layout="ajax";
      $dbval=$this->request->data;
     // print_r($this->request->data);
           $merchant_filter=array();
            foreach ($dbval['parents'] as $key => $value) {
              $data=$this->Merchant->find('first',array('conditions'=>array('Merchant.id'=>$value)));
              array_push($merchant_filter,$data['Merchant']);
              if(in_array($value,$dbval['merchant_id']))
              {
                 $merchant_filter[$key]['checked']=true;
              }else
              {
                 $merchant_filter[$key]['checked']=false;
              }
             // print_r($data);
            }
           echo  json_encode(array('merchant'=>$merchant_filter));     
            $this->render('ajax');
   }
   
   function ajaxClickTrack($pid, $mid, $price)
   {
		$this->layout="ajax";
		$click_data = '';
		$click_data['product_id'] = $pid;   
		$click_data['merchant_id'] = $mid;   
		$click_data['product_price'] = $price;  
		
		$check = $this->Click_track->save($click_data);
		if($check)
		{
			$click_track = 1;
		}
		else
		{
			$click_track = 0;	
		}
		$this->set("click_track",$click_track);
		$this->render('ajax_click_track');	
   }
   function clear_recent()
   {
    
	$cookie_data=$this->Cookie->read();
	$this->layout="ajax";
     $dbval=$this->request->data;
     extract($dbval);
     if(isset($id))
     {
        ob_start();
        $this->Cookie->delete($id);
        echo 1;
     }  
     if(isset($clear))
      {
        ob_start();
         $this->Cookie->destroy();
        echo 1;
      }  
     // print_r( $this->Cookie->read());
     $this->render('ajax');
   }

   public function getCategoriesBySlug($slug){
    $this->layout="ajax";   
    $subcats=$this->Product_category->children($slug,true);    

      if(!empty($subcats))
      {
        //$subcats['clildren']=array();
        
        foreach ($subcats as $key => $value) {
          $susubcats=$this->Product_category->children($value['Product_category']['id'],true);
          $subcats[$key]['Product_category']['count']=$this->Ctrl->GetProductCountBycategory($value['Product_category']['id']);
         // $subcats[$key]['Product_category']['clildren']=$susubcat;
          $title=$this->Ctrl->languageChanger($this->Product_category_lang->findAllByCatId($value['Product_category']['id']));
          $subcats[$key]['Product_category']['title']=$title['Product_category_lang']['category_name'];
            foreach ($susubcats as $k => $val) {
                  //$susubcat=$this->Product_category->children($val['Product_category']['id']);
                  $susubcats[$k]['Product_category']['count']=$this->Ctrl->GetProductCountBycategory($val['Product_category']['id']);
                  $title=$this->Ctrl->languageChanger($this->Product_category_lang->findAllByCatId($val['Product_category']['id']));
                  $lang=$this->Ctrl->getLang();
                  if($lang=='en')
                  {
                    $susubcats[$k]['Product_category']['title']=$this->Ctrl->summary($title['Product_category_lang']['category_name'],30);
                  }else
                  {
                    $susubcats[$k]['Product_category']['title']=$this->Ctrl->summary($title['Product_category_lang']['category_name'],50);
                  }
                  
                 // $susubcats[$k]['Product_category']['clildren']=$susubcat;
            }
            $susubcats= Hash::sort($susubcats, '{n}.Product_category.count', 'desc');
          $subcats[$key]['Product_category']['clildren']=$susubcats;
        }
      }
      $subcats= Hash::sort($subcats, '{n}.Product_category.count', 'desc');
     // print_r($subcats);
     echo json_encode($subcats);
      $this->render('ajax');
   }
   public function getBreadcroms($id)
   {
    $req=$this->request->data;
    //print_r($req);
    $this->layout="ajax";
    $data=$this->Product_category->getPath($id);
    if($req['type']=='category')
    {

    }
    else if($req['type']=='brand')
    {

    }
    else
    {
       array_push($data,array('Product_category'=>array('title'=>str_replace('-',' ',$req['slug']))));
    }
   
    $dcount=count($data);

    foreach ($data as $key => $value) {
       // print_r($value['Product_category']['id']);
     
      if(!isset($value['Product_category']['title']))
      {
          $cat_data=$this->Product_category->find('first',array('conditions'=>array('Product_category.id'=>$value['Product_category']['id'])));
          $lang_data=$this->Ctrl->languageChanger($cat_data['Product_category_lang']);
          $data[$key]['Product_category']['title']=$lang_data['category_name'];

      }
       if(($dcount-1)==$key)
          {
            $data[$key]['Product_category']['last']=true;
          }
          else
          {
            $data[$key]['Product_category']['last']=false;
          }
    
      
    }
    echo json_encode($data);
    $this->render('ajax');
    //
   }
   public function ajaxGetRatings()
   {
     $this->layout="ajax";
      $dbval = $this->request->data;
          $data=array();
          if($dbval['type']=="merchant")
          {
            $productrate=$this->Reviewed_user->Merchant_rating->findAllByMerchantIdAndStatus($dbval['id'],1);
             $rresults = Hash::extract($productrate, '{n}.Merchant_rating.rating');
          }else if($dbval['type']=="product")
          {
             $productrate=$this->Reviewed_user->Product_review->findAllByProductIdAndStatus($dbval['id'],1);
             $rresults = Hash::extract($productrate, '{n}.Product_review.rating');
          }
          
         
            $rcount=count($rresults);      
            if($rcount>0)
            $avgrate=(array_sum($rresults)/count($rresults));
            else
            $avgrate=0;
          $data['avg']=floor($avgrate);
          $data['counts']=array();
          $stars=$this->Ctrl->getWord('stars');
          $star=$this->Ctrl->getWord('star');
          $data['counts'][0]=array('tot'=>0,'name'=>"5 ".$stars,'rat'=>5);
          $data['counts'][1]=array('tot'=>0,'name'=>"4 ".$stars,'rat'=>4);
          $data['counts'][2]=array('tot'=>0,'name'=>"3 ".$stars,'rat'=>3);
          $data['counts'][3]=array('tot'=>0,'name'=>"2 ".$stars,'rat'=>2);
          $data['counts'][4]=array('tot'=>0,'name'=>"1 ".$stars,'rat'=>1);  
          foreach ($rresults as $key => $value) {
            switch ($value) {
                case 1:
                  $data['counts'][4]['tot']=($data['counts'][4]['tot']+1);
                 
                break;
                case 2:
                  $data['counts'][3]['tot']=($data['counts'][3]['tot']+1);
                 
                break;
                case 3:
                  $data['counts'][2]['tot']=($data['counts'][2]['tot']+1);
                 
                break;
                case 4:
                  $data['counts'][1]['tot']=($data['counts'][1]['tot']+1);
                 
                break;
                case 5:
                  $data['counts'][0]['tot']=($data['counts'][0]['tot']+1);
                  
                break;

            }
          }
          foreach ($data['counts'] as $key => $value) {
                  if($rcount>0)
                  {
                    //echo "tot -".$data['counts'][$key]['tot'];
                   // echo  "rat -".$data['counts'][$key]['rat'];
                    //echo "totcount -".$rcount;
                    //echo "sum -".array_sum($rresults);
                  // $data['counts'][$key]['percent']=floor(((($data['counts'][$key]['tot']*$data['counts'][$key]['rat'])/($rcount*array_sum($rresults)))*100));
                    $data['counts'][$key]['percent']=floor((($data['counts'][$key]['tot']/$rcount)*100));
                  }
                  else
                  {
                    $data['error']=1;
                  }
                   //$data['counts'][$key]['name']= ucwords(str_replace("_", " ", $key));
           }
            //print_r( $data);   
          echo json_encode($data);
     $this->render('ajax');
   } 

   public function admin_report($slug="all",$id=""){
    
     $this->set('menu_title','Product Report');    
      $data['totalProd']=$this->Product->find('count');
        $data['activeProd']=$this->Product->find('count',array('conditions'=>array('Product.status'=>1,'Product.category_id !='=>"",'Product.brand !='=>"")));       
        $data['inactiveProd']=($data['totalProd']-$data['activeProd']);
        $data['popularityProd']=$this->Product_review->find('all',
            array(
              'conditions'=>array('Product.status'=>1),
              'group' => array('Product_review.product_id'),
              'fields' => array('floor(Sum(Product_review.rating)/count(Product_review.user_id)) ratings', 'Product_review.product_id'),
              
              ));
        $data['totpopularityProd']=count($data['popularityProd']);
        foreach ($data['popularityProd'] as $key => $value) {
          if(!isset($data['star'.$value[0]['ratings'].'Prod']))
          {
            $data['star'.$value[0]['ratings'].'Prod']=0;
          }
          $data['star'.$value[0]['ratings'].'Prod']++;
        }
       $data['top5']=$this->Product->find('all',array(
        'conditions'=>array(
          'Product.status'=>1,'Product.category_id !='=>'','Product.brand !='=>""),
        'fields'=>array(
          '(Select sum(rating)/count(mc_product_reviews.id) from mc_product_reviews where mc_product_reviews.status=1 and mc_product_reviews.product_id=Product.id) ratings',
          'Product.*',
          'Merchant.*',
          '(Select mc_merchant_logins.status from mc_merchant_logins where mc_merchant_logins.id=Product.retailer_id) merchnat_status'),
        'order'=>array('ratings'=>'DESC'),
        'limit'=>5));

       // echo "<pre>"; print_r($top5);  echo "</pre>"; 
       switch ($slug) {
         case 'all':
            $condition=$this->request['url'];
                extract($condition);
                $cond=array();
               if(!empty($fdate))
            {
              $cond['DATE_FORMAT(Product.created_date,"%Y-%m-%d") >='] = date('Y-m-d',strtotime($fdate));
            }
            if(!empty($endate)) 
            {
              $cond['DATE_FORMAT(Product.created_date,"%Y-%m-%d") <='] = date('Y-m-d',strtotime($endate));
            } 
            if(!empty($merchants))
            {
              $cond['Product.retailer_id']=$merchants;
            }
            if(!empty($rating))
            {
              $cond['(Select sum(rating)/count(mc_product_reviews.id) from mc_product_reviews where mc_product_reviews.status=1 and mc_product_reviews.product_id=Product.id)']=$rating;
            }
            $data['countProducts']=$this->Product->find('count');
            if(empty($limit))
            {
              $limit=20;
            }
            elseif($limit=="all")
            {
              $limit=$data['countProducts'];
            }
            if(!empty($categories)){

              $cats=$this->Product_category->children($categories);
              $catids=Hash::extract($cats,'{n}.Product_category.id');
             // print_r($catids);
              $cond['Product.category_id']=$catids;
            }
           $this->Paginator->settings = array(
               'conditions' => $cond,
            'fields'=>array(
          '(Select sum(rating)/count(mc_product_reviews.id) from mc_product_reviews where mc_product_reviews.status=1 and mc_product_reviews.product_id=Product.id) ratings',
          '(Select count(id) from mc_product_reviews where mc_product_reviews.status=1 and mc_product_reviews.product_id = Product.id) as totRev',
          'Product.*',
          'Merchant.*',
          '(Select category_name from mc_product_category_langs where mc_product_category_langs.cat_id=Product.category_id and mc_product_category_langs.lang_id=1  ) as catName',
          '(Select mc_merchant_logins.status from mc_merchant_logins where mc_merchant_logins.id=Product.retailer_id) merchnat_status',
          '(Select count(DISTINCT unique_id) from mc_unique_visitors where mc_unique_visitors.product_id=Product.id) as uniqueVisitoCount'),
                'limit' => $limit,
                'order'=>array('Product.id'=>'desc')
             );

            
              $data['products']=$this->paginate('Product');
              
              $data['merchants']=$this->Merchant_login->Profile->find('all',array('conditions'=>array('User.id !='=>"")));
              $data['categories']=$this->Product_category->Product_category_lang->find('all',array('conditions'=>array('parent_id'=>0,'Product_category.id !='=>"",'lang_id'=>1)));
             //echo "<pre>"; print_r($data['categories']);  echo "</pre>"; 
           break;
         case 'view':
           if($id!="")
           {
            $data['indiVProdDetails']=$this->Product->find('first',
              array('conditions'=>array('Product.id'=>$id),
                'fields'=>array(
                  '(Select sum(rating)/count(mc_product_reviews.id) from mc_product_reviews where mc_product_reviews.status=1 and mc_product_reviews.product_id=Product.id) ratings',
                  '(Select count(id) from mc_product_reviews where mc_product_reviews.status=1 and mc_product_reviews.product_id = Product.id) as totRev',
                  'Product.*',
                  'Merchant.*',
                  'Offer.*',
                  '(Select mc_merchant_logins.status from mc_merchant_logins where mc_merchant_logins.id=Product.retailer_id) merchnat_status',
                  '(Select category_name from mc_product_category_langs where mc_product_category_langs.cat_id=Product.category_id and mc_product_category_langs.lang_id=1  ) as catName',
                  '(Select brand_title from mc_product_brand_langs where mc_product_brand_langs.brand_id=Product.brand and mc_product_brand_langs.lang_id=1  ) as barndName'
                  )
                ));
            $data['merchant']=$this->Ctrl->getMerchantDetailsByProduct($data['indiVProdDetails']['Product']['id'],$data['indiVProdDetails']['Product']['slug'],'all',1,$data['indiVProdDetails']['Product']['retailer_id']);
             //echo "<pre>"; print_r($data['merchant']);  echo "</pre>"; 
           }
           break;
         default:
           # code...
           break;
       }
       
        $this->set($data);
   
   }
  public function getAttrsValus(){
    $this->layout="ajax";
    ini_set('max_execution_time','1000');
    $dbval=$this->request->data;
    extract($dbval);
   $atsplit= explode("@", $filter);
            foreach ($filter_data as $k=>$x)
                  {
                    foreach($x['children'] as $kk=>$xx)
                      {
                        $filter_data[$k]['children'][$kk]['checked']=false; 
                      }
                  }
             foreach($atsplit as $i)
            {
              $cdata=str_replace('\"','',$i);
              
              $atdata=explode("_", $cdata);
             //console.log(atdata);
                foreach($filter_data as $k=>$x)
                  {
                   
                    
                   if($filter_data[$k]['title']===$atdata[0])
                   {
                    //console.log(atdata[0]);
                      foreach($filter_data[$k]['children'] as $kk=>$xx)
                      {
                         
                         //console.log(atdata[1]);
                        // 
                        if($filter_data[$k]['children'][$kk]['slug']===$atdata[1])
                        {
                         // console.log(atdata[1]);
                            $filter_data[$k]['children'][$kk]['checked']=true;
                        }
                     
                      }
                   }
              
                  }

            }
            if(!empty($filter_data))
            {
              echo json_encode($filter_data);
            }
            else
            {
              echo "{}";
            }
    $this->rander('ajax');
  }
}


