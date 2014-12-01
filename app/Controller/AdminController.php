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
  App::uses('Folder', 'Utility');
  App::uses('File', 'Utility');
  App::uses('TemplateHelper', 'View/Helper');

  /**
   * Static content controller
   *
   * Override this controller by placing a copy in controllers directory of an application
   *
   * @package       app.Controller
   * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
   */
  class AdminController extends AppController {
   public $helpers = array('Html', 'Form','Session','Paginator','Fck','Template');
   public $components = array('Session','Paginator','Cookie','Ctrl');
     public $paginate = array(
          'fields' => array('User.id', 'User.created'),
          'limit' => 25,
          'order' => array(
              'User.id' => 'desc'
          )
      );
   public $sitetitle="Admin | Hoppay";
   //public $pagina_show=10;
   public $userid;

   
  /**
   * This controller does not use a model
   *
   * @var array
   */
    public $uses = array('Faq_category','Unique_visitor','Product_category_lang','Backup_restor','Product_review','Tag_lang','Tag','Tagline','faq_lang','Banner','Faq_category_lang','faq','Merchant_login','Merchant','Language','Product_category','Click_track','Product');
      public $urlgen="";
  /**
   * Displays a view
   *
   * @param mixed What page to display
   * @return void
   * @throws NotFoundException When the view file could not be found
   *  or MissingViewException in debug mode.
   */
     public function beforeFilter(){
                  // $this->set('_constants', array('this', 'that', 'the other'));
             
              parent::beforeFilter();
              $this->Cookie->name = 'Menacompare_Admin_id';
              $this->Cookie->time = '5 Days';  // or '12 hour'
              $this->Cookie->path = '/';
              $this->Cookie->domain = '';
              $this->Cookie->secure = false;  // i.e. only sent if using secure HTTPS
              $this->Cookie->key = 'qSI232qs*&sXOw!adre@34SAv!@*(XSL#$%)asGb$@11~_+!@#HKis~#^';
              $this->Cookie->httpOnly = true;
              $this->Cookie->type('rijndael');


           
           $this->layout = 'admin';
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
        $this->loadModel('Setting');
      $config_settings=$this->Setting->find('all',array('conditions' => array('Setting.id' =>'1')));
      $this->set("setting",$config_settings[0]);
     }
     /*-----------------------------COMMON CODES-----------------------------------------------*/
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
     /*-----------------------------COMMON CODES-----------------------------------------------*/
    public function index() {       
        $this->set('menu_title','Dashboard');
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
        
        $data['totalMerchant']=$this->Merchant_login->find('count');
        $data['activeMerchant']=$this->Merchant_login->find('count',array('conditions'=>array('Merchant_login.status'=>1)));  

        $data['inactiveMerchant']=($data['totalMerchant']-$data['activeMerchant']);
       $data['actMerchant']=$this->Product->Product_review->find('all',array(
          'conditions'=>array('Product.status'=>1),
          'group'=>array('Product.retailer_id'),
          'fields' => array('floor(Sum(Product_review.rating)/count(Product_review.user_id)) ratings', 
                            'Product.retailer_id',
                            '(Select mc_merchant_logins.status from mc_merchant_logins where mc_merchant_logins.id=Product.retailer_id) merchnat_status',
          ))); 

        foreach ($data['actMerchant'] as $key => $value) {
          if($value[0]['merchnat_status']==1)
          {
            
            if(!isset($data['star'.$value[0]['ratings'].'Merchnat']))
            {
              $data['star'.$value[0]['ratings'].'Merchnat']=0;
            }
            $data['star'.$value[0]['ratings'].'Merchnat']++;
          }
        }
        $data['uniqueCount']=$this->Unique_visitor->find('count',array('group'=>array('unique_id')));
        $data['prodCountUser']=$this->Unique_visitor->find('count',array('group'=>array('product_id')));
       // echo $uniqueCount;
        //echo "<pre>";print_r($data['returningUser']); echo "</pre>";
        $this->set($data);

    }

    public function login() {
      
      $this->layout = 'login';
        $username = $this->Session->read('Admin.id'); 
        if($username){
          $this->redirect('/admin');
                exit();
        }
      
             if($this->request->is('post')){
            $value = $this->request->data('login');
          $userid  =  $this->request->data('username');
          $password= $this->request->data('password');
          $utype = $this->request->data('user_type');
                  $remem_me=$this->request->data('remem_me'); 
                  
            $this->loadmodel('User');
            $data=$this->User->find('first',array ('conditions' => array('username' => $userid,'user_type'=>'A','status'=>'1')));
            if($data){
            
              if($data['User']['password']==base64_encode($password)){

                $username = $this->Session->write(array('Admin'=>array('id'=>$data['User']['id'],'email'=>$data['User']['email'])));
                if($remem_me=="1")
                      {
                        $this->Cookie->write('Admin',array('id' => $data['User']['id'], 'email' => $data['User']['email']));
                      }
                      $this->redirect('/admin');
                    exit();
              }
              else
              {
                
                 $this->Session->setFlash('Login failed! <br> Please check your username and password!', 'default', array(), 'bad');
                 $this->redirect('/admin/login');             
                   exit();
              }
            }
            else
            {
                 $this->Session->setFlash('Login faild! Please check your username and password!', 'default', array(), 'bad');
                 $this->redirect('/admin/login');             
                   exit();
            }
         
        }

      }


      public function logout(){     
        $this->Session->delete('Admin');
        $this->Session->destroy();
          $this->Cookie->delete('Admin');
          $this->Cookie->destroy();
        $this->Session->setFlash('Logout Successfully!', 'default', array(), 'msg');
        $this->redirect('/admin/login');
          exit();
      }
    

      public function adminUser(){
        $this->set('menu_title','Admin Users');
        
          $condition=$this->request['url'];
          extract($condition);
          
          $text_search=isset($text_search)?$text_search:"";
          
           $this->Paginator->settings = array(
              'conditions' => array('or'=>array('name LIKE' => '%'.$text_search.'%',
                                                'email LIKE' =>'%'.$text_search.'%',
                                                'username LIKE' =>'%'.$text_search.'%',
                                                
                                              ),(isset($status) and $status!="")?'status':'status !='=>isset($status)?$status:""),
              'limit' => 5
           );
          $this->set('all_user', $this->paginate('User'));
         
      }
      public function delete_admin_user($id,$page){
        $this->set('menu_title','Delete Admin Users');    
        if($id!=$this->userid)
        { 
        $this->loadmodel('User');
        $check=$this->User->delete(array('id'=>$id));
          if($check)
          {
            $this->Session->setFlash('Account is deleted Successfully!', 'default', array(), 'msg');
            $this->redirect('/admin/adminUser/page:'.$page);
                exit();
          }
        }
        else
        {
              $this->Session->setFlash('You can\'t delete this account.' , 'default', array(), 'bad');
            $this->redirect('/admin/adminUser/page:'.$page);
                exit();
        }
        
        $this->render('admin_user');

      }
      public function update_admin_user($id,$page=1){
        $this->set('menu_title','Update Admin Users');
        $this->set('admin_button','Update');
        $this->loadmodel('User');
        if($this->request->is('post'))
        {
          //print_r($_REQUEST);
          $dbval['name'] =  $this->request->data('uname');
          $dbval['email'] =  $this->request->data('email');
          $dbval['username'] =  $this->request->data('username');
          $dbval['phone'] =  $this->request->data('phone');
          $dbval['password']= base64_encode($this->request->data('password'));
          $dbval['status']= $this->request->data('user_status');
          $dbval['user_type']="A";
        //$dbval['activation_code']=md5(microtime().rand());      
          $dbval['last_modified']=date('Y-m-d');
           $data=$this->User->find('first',array('conditions'=>array('OR'=>array('email'=>$this->request->data('email'),'username'=>$this->request->data('username')),'id !='=>$id)));
           if(!$data){
          $this->User->id = $id;
              $check=$this->User->save($dbval);
              if($check)
              {
                $this->Session->setFlash('Account of  "'.$this->request->data('email').'" was Updated Successfully!', 'default', array(), 'msg');
                $this->redirect('/admin/adminUser/page:'.$page);
                exit();
              }
             }
             else
             {
                  if($data['User']['email']==$this->request->data('email')){
              $this->Session->setFlash('The Email id Already Exist!', 'default', array(), 'bad');
            }
            else if($data['User']['username']==$this->request->data('username'))
            {
              $this->Session->setFlash('The Username Already Exist!', 'default', array(), 'bad');
            }
            $data=$this->User->find('first',array('conditions'=>array('id'=>$id)));
             }
        }
        else
        {

        $data=$this->User->find('first',array('conditions'=>array('id'=>$id)));
        
        
        }
        $this->set('user_data',$data);
        $this->render('add_admin_user');
        
      }
      public function inactive_admin_user($id){
        $this->set('menu_title','Admin Users');
        $this->loadmodel('User');
        $this->User->id = $id;
          $check=$this->User->save(array('status'=>'0'));
          if($check)
          {
            $this->Session->setFlash('The User Inactive Successfully!', 'default', array(), 'msg');
            $this->redirect('/admin/admin_user');
              exit();
          }
          $this->render('admin_user');
      }
       public function active_admin_user($id){
        $this->set('menu_title','Admin Users');
        $this->loadmodel('User');
        $this->User->id = $id;
          $check=$this->User->save(array('status'=>'1'));
          if($check)
          {
            $this->Session->setFlash('The User Active Successfully!', 'default', array(), 'msg');
            $this->redirect('/admin/admin_user');
              exit();
          }
          $this->render('admin_user');
      }
     
      public function add_admin_user(){
          $this->set('menu_title','Add Admin Users');
          $this->set('admin_button','Create');
         if($this->request->is('post')){
          $dbval['name'] =  $this->request->data('uname');
          $dbval['email'] =  $this->request->data('email');
          $dbval['username'] =  $this->request->data('username');
          $dbval['phone'] =  $this->request->data('phone');
          $dbval['password']= base64_encode($this->request->data('password'));
          $dbval['status']= $this->request->data('user_status');
          $dbval['user_type']="A";
          $dbval['activation_code']=md5(microtime().rand());      
          $dbval['join_date']=date('Y-m-d');
          $this->loadmodel('User');
          $data=$this->User->find('first',array('conditions'=>array('OR'=>array('email'=>$this->request->data('email'),'username'=>$this->request->data('username')))));
          if(!$data){
            $check=$this->User->save($dbval);
            if($check){
              //debug($this->validationErrors); die();
              $this->Session->setFlash('Account added Successfully!', 'default', array(), 'msg');
              
            }
            else
            {
              $this->Session->setFlash('Error on Create Account!', 'default', array(), 'bad');

            }
          }
          else
          {
            if($data['User']['email']==$this->request->data('email')){
              $this->Session->setFlash('The Email id Already Exist!', 'default', array(), 'bad');
            }
            else if($data['User']['username']==$this->request->data('username'))
            {
              $this->Session->setFlash('The Username Already Exist!', 'default', array(), 'bad');
            }
            
          }
         }

      }

      /*----- Merchant area----*/
      public function delete_reviewRatings($id,$page=1){
         $this->layout="ajax";
        $this->loadModel('Product_review');
            $this->Product_review->id=$id;
            $check=$this->Product_review->delete();
            //echo $id;
            if($check)
            {
                 $this->Session->setFlash('You are successfully deleted', 'default', array(), 'msg');
                 $this->redirect('ratingReviews/page:'.$page);
                 exit;
            }
            else
            {
                $this->Session->setFlash('You are successfully deleted', 'default', array(), 'msg');
                $this->redirect('ratingReviews/page:'.$page);
                 exit;
            }
            $this->render('ajax');
      }
      public function ratingReviews(){
      $this->set('menu_title','Ratings & Reviews'); 
      $this->set('inner_section_name','All Ratings and Reviews');
      $merchant=$this->Merchant_login->find('all');
     //echo "<pre>"; print_r($merchant); echo "</pre>";
     $this->set('merchantdetails',$merchant);
    if(!empty($this->params['named']['product']))
      $product = $this->params['named']['product'];
    else
    {
      $product = '';
    }
    
    $langid = 1;
    
    $this->set('text_data',array('title'=>'Reviews and Ratings'));
        //$data = $this->Product_review->find('all',array('conditions'=>array('Product.retailer_id'=>$this->merchantid),'order'=>'Product_review.review_date DESC','fields'=>array('Product_review.product_id'), 'group' => array('Product_review.product_id')));  
        $product_list = $this->Product->Product_review->find('all',array(
            'conditions'=>array(
           // 'Product.retailer_id'=>$this->merchantid
              ),
            'order'=>'Product.slug asc',
            'fields'=>array('Product_review.product_id','Product.slug'),
            'group' => array(
            'Product_review.product_id')
            ));  
        $this->set('product_list',$product_list);

    $conditions=array();
    //
    
    if(!empty($this->params->query))
    {
      //echo "<pre>";print_r($this->params->query);echo "</pre>"; exit; 
      $srch_data = $this->params->query;
      if(!empty($srch_data['from_date']))
        $from_date = date('Y-m-d H:i:s',strtotime($srch_data['from_date']));
      if(!empty($srch_data['to_date']))
        $to_date = date('Y-m-d H:i:s',strtotime($srch_data['to_date']));
      $search = @$srch_data['text_search'];
      $product = @$srch_data['product'];
      $status = @$srch_data['status'];
      $merchant = @$srch_data['merchantid'];
      
      if(!empty($from_date))
      {
        $conditions['DATE_FORMAT(Product_review.review_date,"%Y-%m-%d") >='] = date('Y-m-d',strtotime($from_date));
      }
      if(!empty($to_date)) 
      {
        $conditions['DATE_FORMAT(Product_review.review_date,"%Y-%m-%d") <='] = date('Y-m-d',strtotime($to_date));
      } 
      if($status!='')
      {
        $conditions['Product_review.status'] = $status;
      }
      if(!empty($search))
      {
        $conditions['OR']['Product_review.title LIKE'] = '%'.$search.'%';
        $conditions['OR']['Product_review.comment LIKE'] = '%'.$search.'%';
      }
      if($product!='')
      {
        $conditions['Product.slug like'] = '%'.str_replace(' ','%',trim($product)).'%';
      }
      if($merchant!="")
      {
        $conditions['Product.retailer_id'] = $merchant;
      }
    }
    
   //print_r($conditions);
    
    try{
    $this->Paginator->settings = array(
                  'conditions'=>$conditions,
                  'order'=>'Product_review.review_date DESC',
                  
                  'limit' => 30,
                  'recursive'=>2
                );
    
    }
    catch (Exception $e){
      echo 'Caught exception: ',  $e->getMessage(), "\n";
      
      };
      
    $data = $this->paginate('Product_review');
     $this->set('product_review',$data);
      }
       function getReviewProducts($pslug,$merhantid="Not null")
     {
       $this->layout="ajax";
       $data=$this->Product_review->find('all', array(
                          'conditions' => array(                          
                          'Product.slug like ' => '%'.$pslug.'%',
                          //'Product.retailer_id'=>$merhantid,
                        ),
                        'fields' => array(
                          'Product.slug',
                          //'Product.Product_lang.*'
                        )
                        ));
       //print_r($data);
      $this->set('products',$data);               
      $this->render('../Merchant/get_reviews_products');                  
     }
      public function merchants(){
        $this->set('menu_title','Merchant');
          $this->loadmodel('Merchant_login');
         
             $this->set(array(
                'menu_title'=>'Merchant Manager',
                'inner_section_name'=>'Merchant List',              
                ));       
            
              $condition=$this->request['url'];
              extract($condition);
          
          $text_search=isset($text_search)?$text_search:"";
         // echo $status;
           $this->Paginator->settings = array(
              'conditions' => array('or'=>array('first_name LIKE' => '%'.$text_search.'%','last_name LIKE' => '%'.$text_search.'%','email_id LIKE' => '%'.$text_search.'%','url LIKE' => '%'.$text_search.'%'),(isset($status) and $status!="")?'status':'status not '=>isset($status)?$status:NULL),
              'limit' => 20,
              'order'=>array('Merchant_login.id'=>'desc')
           );
          $this->set('merchent_list', $this->paginate('Merchant_login'));  
          //$this->set('merchant_data',$data);

      }
       public function add_merchant(){
            $this->set('menu_title','Add Merchant');
          $this->set('admin_button','Add');
            $this->loadmodel('Merchant_login');
       
        if($this->request->is('post')){
          $data=$this->request->data;
           if (isset($_FILES['image_url'])) {
              $imageName= $this->requestAction(array('controller'=>'admin', 'action'=>'uploadImage'),
      array('pass' => array('image_url','uploads/profile')));
                 }
          unset($data['profile_id']);
          unset($data['username']);
          unset($data['email_id']);
        $datacheck=$this->Merchant_login->find('first',array('conditions'=>array('or'=>array('email_id'=>trim($this->request->data['email_id']),'username'=>trim($this->request->data['username'])))));
        //print_r(count($datacheck));
       
        if(count($datacheck)==0)
          {
         $data1=array('Merchant_login'=>array('username'=>trim($this->request->data['username']),'email_id'=>trim($this->request->data['email_id'])),
        'Profile'=>$data);
         //echo "<pre>";
        // print_r($data1);
         $check1=$this->Merchant_login->save($data1['Merchant_login']);
         if($check1)
          $data1['Profile']['merchant_id']=$this->Merchant_login->getInsertID();
          $data1['Profile']['image_url']=@$imageName;
          // print_r($data1);
          $check=$this->Merchant_login->Profile->save($data1['Profile']);
          if($check){
            $this->Session->setFlash('Merchant Added Successfully!', 'default', array(), 'msg');
           // $this->redirect('/admin/merchant');
           // exit();
          }
         }
         else
         {
          $this->Session->setFlash('The Username or Email id you want to add Its allready present, Please use another !! ', 'default', array(), 'bad');
         }
        }
        $this->render('update_merchant');
       }
      public function update_merchant($id){
        $this->set('menu_title','Update Merchant');
          $this->set('admin_button','Update');
          $this->loadmodel('Merchant_login');
       
        if($this->request->is('post')){
          $data=$this->request->data;

          $data['id']=$data['profile_id'];
          unset($data['profile_id']);
          unset($data['username']);
          unset($data['email_id']);
           unset($data['status']);
        $datacheck=$this->Merchant_login->find('first',array('conditions'=>array('or'=>array('email_id'=>trim($this->request->data['email_id']),'username'=>trim($this->request->data['username'])),'Merchant_login.id !='=>$id)));
        //print_r(count($datacheck));
       
        if(count($datacheck)==0)
          {
         $data1=array('Merchant_login'=>array('username'=>trim($this->request->data['username']),'email_id'=>trim($this->request->data['email_id']),'status'=>$this->request->data['status'],'id'=>$id),
        'Profile'=>$data);
        // echo "<pre>";
        //// print_r($data);
         //print_r($data1);
         //echo "</pre>";
         $check1=$this->Merchant_login->save($data1['Merchant_login']);
         if($check1)
          $this->loadmodel('Merchant');
          $getId=$this->Merchant->find('first',array('conditions'=>array('Merchant.merchant_id'=>$data1['Profile']['id'])));
         // print_r($getId);
        $data1['Profile']['id']=$getId['Merchant']['id'];
        if (isset($_FILES['image_url']['name']) && $_FILES['image_url']['name']!="") {
              $imageName= $this->requestAction(array('controller'=>'admin', 'action'=>'uploadImage'),
      array('pass' => array('image_url','uploads/profile')));
              $data1['Profile']['image_url']= $imageName;
              //if(isset($data['updateImage']) and $data['updateImage']!="" )
                //unlink(Router::url('/')."/".$data['updateImage']);
                 }
          $check=$this->Merchant_login->Profile->save($data1['Profile']);
          if($check){
            $this->Session->setFlash('Merchant Updated Successfully!', 'default', array(), 'msg');
            $this->redirect('/admin/merchants');
            exit();
          }
         }
         else
         {
          $this->Session->setFlash('The Username or Email id you want to Updated Its allready present, Please use another !! ', 'default', array(), 'bad');
         }
        }
        $check=$this->Merchant_login->find('first',array('conditions'=>array('Merchant_login.id'=>$id)));
        $this->set('user_data',$check);
      }

     public function add_to_slider_merchant($id=""){
        if($id)
        {
           $this->loadmodel('Merchant_login');
           $this->Merchant_login->id=$id;
           $check=$this->Merchant_login->save(array('add_to_slider'=>1));
           if($check)
           {
            $this->Session->setFlash('Merchant Added to slider Successfully!', 'default', array(), 'msg');
            $this->redirect('/admin/merchants');
            exit();
           }
        }
     }
     public function remove_to_slider_merchant($id=""){
        if($id)
        {
           $this->loadmodel('Merchant_login');
           $this->Merchant_login->id=$id;
           $check=$this->Merchant_login->save(array('add_to_slider'=>0));
           if($check)
           {
            $this->Session->setFlash('Merchant remove from slider Successfully!', 'default', array(), 'msg');
            $this->redirect('/admin/merchants');
            exit();
           }
        }
     }
     
      //Its private pass generater function.....
    private function generatePassword ($length = 8)
    {

      // start with a blank password
      $password = "";

      // define possible characters - any character in this string can be
      // picked for use in the password, so if you want to put vowels back in
      // or add special characters such as exclamation marks, this is where
      // you should do it
      $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";

      // we refer to the length of $possible a few times, so let's grab it now
      $maxlength = strlen($possible);
    
      // check for length overflow and truncate if necessary
      if ($length > $maxlength) {
        $length = $maxlength;
      }
    
      // set up a counter for how many characters are in the password so far
      $i = 0; 
      
      // add random characters to $password until $length is reached
      while ($i < $length) { 

        // pick a random character from the possible ones
        $char = substr($possible, mt_rand(0, $maxlength-1), 1);
          
        // have we already used this character in $password?
        if (!strstr($password, $char)) { 
          // no, so it's OK to add it onto the end of whatever we've already got...
          $password .= $char;
          // ... and increase the counter by one
          $i++;
        }

      }

      // done!
      return $password;
    }
      public function forgot_merchant($id){
           $this->loadmodel('Merchant_login');
       $check=$this->Merchant_login->find('first',array('conditions'=>array('Merchant_login.id'=>$id)));
                  if(count($check)>0){
                      $pass=$this->generatePassword();
                      $pass1=md5($pass.$check['Merchant_login']['key']);
                      if($pass1)
                      {
                          $this->Merchant_login->id=$check['Merchant_login']['id'];
                          $check1=$this->Merchant_login->save(array('password'=>$pass1));
                          if($check1){
                              //$Email = new CakeEmail();
                              //$Email->viewVars(array('password' => $pass));
                              //$Email  ->emailFormat('both')
                                   //   ->to($check['Merchant_login']['email_1'])                                 
                                    //  ->send();
                             

                              $this->Session->setFlash('New Password will send to Merchant mail ( "'.$pass.'" )', 'default', array(), 'msg');
                             $this->redirect('/admin/merchants');
                             exit();
                          }
                          else
                          {
                              $this->Session->setFlash('There is a problem, Please try again!!', 'default', array(), 'bad');
                               $this->redirect('/admin/merchants');
                             exit();
                          }
                      }
              }

            
       
        $this->render('merchant');
      }
      public function delete_merchant($id){
        $this->set('menu_title','Delete Merchant');
            $this->loadmodel('Merchant_login');
        $check=$this->Merchant_login->delete(array('id'=>$id));
        if($check)
        {
           $this->Session->setFlash('Merchant Deleted Successfully!', 'default', array(), 'msg');
          $this->redirect('/admin/merchants');
           exit();
        }
      }
      /*------End merchent area------*/




      /*---------------------------- CMS Section -------------------------*/
        
        /********BANNER MANAGER********/
        public function banner_manager(){
          $this->set('menu_title','Banner Manager');
          //$this->set('admin_button','Create');
          $this->loadmodel('Banner');
         // $data=$this->Banner->find('all');
           $condition=$this->request['url'];
          extract($condition);
          $lang_id=isset($lang_id)?$lang_id:1;
          $text_search=isset($text_search)?$text_search:"";
          
           $this->Paginator->settings = array(
              'conditions' => array('or'=>array('Banner_lang.banner_title LIKE' => '%'.$text_search.'%',
                                                'Banner.banner_link LIKE' =>'%'.$text_search.'%',
                                                
                                                
                                              ),'Banner_lang.lang_id'=>$lang_id,(isset($status) and $status!="")?'Banner.status':'Banner.status !='=>isset($status)?$status:""),
              'limit' => 15,
              'order' => array('Banner.id' => 'DESC'),
           );
          $this->set('banner_list', $this->paginate('Banner.Banner_lang'));
           $lang=$this->Language->find('all');
           $this->set('lang', $lang);
         // $this->set('banner_list',$data);
        }

         public function add_banner(){
          $this->set('menu_title','Add Banner');
          $this->set('admin_button','Create');
          $this->loadmodel('Banner');
           if($this->request->is('post')){
            //print_r($_FILES['bimage']);
             if (isset($_FILES['bimage'])) {
              $imageName= $this->requestAction(array('controller'=>'admin', 'action'=>'uploadImage'),
      array('pass' => array('bimage','uploads/banners')));
                 }
                 if (isset($_FILES['bimage_port'])) {
              $imageName_port= $this->requestAction(array('controller'=>'admin', 'action'=>'uploadImage'),
      array('pass' => array('bimage_port','uploads/banners')));
                 }
              $dbval1['banner_title'] =  htmlspecialchars(strip_tags(trim($this->request->data('banner_title'))));
              $dbval1['banner_description'] =  htmlspecialchars($this->request->data('banner_description'));
             
              $dbval['banner_link'] =  $this->request->data('blink');
              $dbval['status'] =  $this->request->data('bstatus');
              $dbval['banner_img']= $imageName;
              $dbval['banner_img_port']= $imageName_port;
              $dbval['created_date'] = date('Y-m-d');
              $check=$this->Banner->save($dbval);
              if($check)
              {
                 $dbval1['banner_id']=$this->Banner->id;
                 $dbval1['lang_id']=1;
                 $check=$this->Banner->Banner_lang->save($dbval1);
                 $this->Session->setFlash('Banner added Successfully!', 'default', array(), 'msg');
              }
           }

            $lang=$this->Language->find('all');
           $this->set('lang', $lang);
        }

        public function update_banner($id,$page=1){
        $this->set('menu_title','Update Banner');
        $this->set('admin_button','Update');
        $this->loadmodel('Banner');
        //print_r($this->request->data);
       

        if($this->request->is('post'))
        {
          $data=$this->Banner->find('first',array('conditions'=>array('Banner.id'=>$id)));
          if (isset($_FILES['bimage']) and $_FILES['bimage']['tmp_name']!="") {
              $imageName= $this->requestAction(array('controller'=>'admin', 'action'=>'uploadImage'),
      array('pass' => array('bimage','uploads/banners')));
           }  
          if (isset($_FILES['bimage_port'])) {
            $imageName_port= $this->requestAction(array('controller'=>'admin', 'action'=>'uploadImage'),
    array('pass' => array('bimage_port','uploads/banners')));
           }    
              $dbval1['banner_title'] =  htmlspecialchars(strip_tags(trim($this->request->data('banner_title'))));
              $dbval1['banner_description'] =  htmlspecialchars($this->request->data('banner_description'));
             
              $dbval['banner_link'] =  $this->request->data('blink');
              $dbval['status'] =  $this->request->data('bstatus');
             
              if(isset($imageName) and $imageName!="")
              {
                $dbval['banner_img'] = $imageName;  
                unlink(WWW_ROOT.$data['Banner']['banner_img']);
              } 
               if(isset($imageName_port) and $imageName_port!="")
              {
                $dbval['banner_img_port']= $imageName_port;
                unlink(WWW_ROOT.$data['Banner']['banner_img_port']);

              }
              $dbval['created_date'] = date('Y-m-d');
              $this->Banner->id=$id;
              $check=$this->Banner->save($dbval);

              if($check)
              {
                  $dbval1['banner_id']=$id;
                  $dbval1['lang_id']=$this->request->data('lang_id');
                  $dbval1['id']=$this->request->data('banner_lang_id'); 
                  //print_r($dbval1);
                  $check=$this->Banner->Banner_lang->save($dbval1);
                  if($check)
                  {
                    $this->Session->setFlash('Banner Updated Successfully!', 'default', array(), 'msg');
                    $this->redirect('/admin/banner_manager/page:'.$page);
                    exit();
                  }
              }
            
          }
           $data=$this->Banner->find('first',array('conditions'=>array('Banner.id'=>$id)));
             $lang=$this->Language->find('all');
             $this->set('lang', $lang);  
             $this->set('banner_data',$data);
             $this->render('add_banner');
  }

  public function delete_banner($id){
    $this->set('menu_title','Delete Banner');       
        $this->loadmodel('Banner');
        $check=$this->Banner->delete(array('id'=>$id));
        if($check)
        {
          $this->Session->setFlash('Banner Deleted Successfully!', 'default', array(), 'msg');
          $this->redirect('/admin/banner_manager');
           exit();
        }
  }
          /********END BANNER MANAGER********/



          /********PAGE MANAGER********/

          public function page_manager(){
              
              $this->set(array(
                'menu_title'=>'Page Manager',
                'inner_section_name'=>'Pages List',              
                ));       
              $this->loadmodel('Page');
             // $this->loadmodel('Page_lang');
              $condition=$this->request['url'];
              extract($condition);
           $lang_id=isset($lang_id)?$lang_id:1;
          $text_search=isset($text_search)?$text_search:"";
         // echo $status;
           $this->Paginator->settings = array(
              'conditions' => array('Page_lang.pg_title LIKE' => '%'.$text_search.'%','Page_lang.lang_id'=>$lang_id,(isset($status) and $status!="")?'Page.status':'Page.status not '=>isset($status)?$status:NULL),
              'limit' => 20,
              'recursive'=>2
           );

          $this->set('page_list', $this->paginate('Page.Page_lang'));
           $this->loadmodel('Language');
               $lang=$this->Language->find('all');
             
               $this->set('lang', $lang);
            
          }
           public function add_page(){
            $this->set('menu_title','Add Page');
            $this->set('admin_button','Create');        
            $this->loadmodel('Page');
            if($this->request->is('post')){
             // echo "<pre>"; print_r($this->request->data);
          //  print_r($_FILES); echo "</pre>";
            if(isset($_FILES['pg_img']['name']) and $_FILES['pg_img']['name']!="")
            {
              $imageName= $this->requestAction(array('controller'=>'admin', 'action'=>'uploadImage'),
      array('pass' => array('pg_img','uploads\page')));
             
            }
            $attrImg=$_FILES['attr'];
            $imagesNames=array();
            if(isset($attrImg) && !empty($attrImg['name']))
            {
              foreach($attrImg['name'] as $key=>$val)
              {
               if(isset($attrImg['name'][$key]) and $attrImg['name'][$key]['img']!=""){
                  $imgarr=array('name'=>$attrImg['name'][$key]['img'],
                              'type'=>$attrImg['type'][$key]['img'],
                              'tmp_name'=>$attrImg['tmp_name'][$key]['img'],
                              'error'=>$attrImg['error'][$key]['img'],
                              'size'=>$attrImg['size'][$key]['img']
                              );
                 // print_r('')
                   $imagesNames[$key]['img']=@$this->requestAction(array('controller'=>'admin', 'action'=>'uploadImage'),
                  array('pass' => array($imgarr,'uploads/page/attr')));
                  }
              }
            }
              //print_r($imagesNames);
              // $this->request->data('pg_img')= isset($imageName)?$imageName:"";
              $dbval=$this->request->data;
              
                  foreach($dbval['attr'] as $k=>$val)
                  {                    
                    $dbval['attr'][$k]['img']=@$imagesNames[$k]['img'];
                    $dbval['attr'][$k]['values']=$val['values'];
                    $dbval['attr'][$k]['key']=$val['key'];
                    $dbval['attr'][$k]['subtitle']=$val['subtitle'];  
                  }
               //$dbval['attr']=array_merge_recursive($dbval['attr'],$imagesNames);
               //print_r($dbval['attr'] );
              $dbval1['page_attrs']=htmlspecialchars(json_encode(array_values($dbval['attr'])));
              $dbval['update_date'] = date('Y-m-d');
              $dbval['pg_img']=isset($imageName)?$imageName:"";
               $dbval1['pg_title']=strip_tags(trim($dbval['pg_title']));

              $dbval1['pg_descriptions']=htmlspecialchars($dbval['pg_detail']);

              $dbval1['meta_description']=htmlspecialchars($dbval['meta_description']);
              $dbval1['meta_keyword']=htmlspecialchars($dbval['meta_keyword']);

              $dbval1['lang_id']=1;
              unset($dbval['pg_title']);
              unset($dbval['pg_detail']);
              unset($dbval['meta_description']);
              unset($dbval['meta_keyword']);
              unset($dbval['attr']);
              //print_r($dbval);
              $check=$this->Page->save($dbval);

              if($check)
              {
                $dbval1['pg_id']= $this->Page->id;
                $check1=$this->Page->Page_lang->save($dbval1);
                 if($check)
                 {
                   $this->Session->setFlash('Page added Successfully!', 'default', array(), 'msg');
                 }
              }

           }
        }

         public function update_page($id,$page=1){
          $this->set('menu_title','Update Page');
          $this->set('admin_button','Update');        
          $this->loadmodel('Page');
          $condition=$this->request['url'];
                  extract($condition);
                   $lang_id=isset($lang_id)?$lang_id:1;
           if($this->request->is('post')){
           // print_r($_FILES['pg_img']);
             if (isset($_FILES['pg_img']) and $_FILES['pg_img']['name']!="") {

                $imageName= $this->requestAction(array('controller'=>'admin', 'action'=>'uploadImage'),
      array('pass' => array('pg_img','uploads\page')));
                  
              }
              
             // $this->request->data('pg_img')= isset($imageName)?$imageName:"";
              $dbval=$this->request->data;
              $dbval['update_date'] = date('Y-m-d');
              if(isset($imageName) and $imageName!=""){
              $dbval['pg_img']=isset($imageName)?$imageName:"";
              }
              else
              {
                unset($dbval['pg_img']);
              }
               $attrImg=$_FILES['attr'];
            $imagesNames=array();
            if(isset($attrImg) && !empty($attrImg['name']))
            {
              foreach($attrImg['name'] as $key=>$val)
              {
               if(isset($attrImg['name'][$key]) and $attrImg['name'][$key]['img']!=""){
                  $imgarr=array('name'=>$attrImg['name'][$key]['img'],
                              'type'=>$attrImg['type'][$key]['img'],
                              'tmp_name'=>$attrImg['tmp_name'][$key]['img'],
                              'error'=>$attrImg['error'][$key]['img'],
                              'size'=>$attrImg['size'][$key]['img']
                              );
                 // print_r('')
                   $imagesNames[$key]['img']=@$this->requestAction(array('controller'=>'admin', 'action'=>'uploadImage'),
                  array('pass' => array($imgarr,'uploads/page/attr')));
                  }
              }
            }
           //print_r($dbval['attr']);
                   foreach($dbval['attr'] as $k=>$val)
                  {
                    if(isset($imagesNames[$k]['img']))
                    {
                       unlink(Router::url('/')."/".$dbval['attr'][$k]['img']);
                       $dbval['attr'][$k]['img']=@$imagesNames[$k]['img'];
                    }  
                    //echo $val['values'];
                     $dbval['attr'][$k]['values']=$val['values'];
                    $dbval['attr'][$k]['key']=$val['key'];
                    $dbval['attr'][$k]['subtitle']=$val['subtitle'];            
                  }
              $dbval1['page_attrs']=htmlspecialchars(json_encode(array_values($dbval['attr'])));
              //print_r( $dbval1['page_attrs']);
              $dbval1['pg_title']=strip_tags(trim($dbval['pg_title']));
              $dbval1['pg_descriptions']=htmlspecialchars($dbval['pg_detail']);
               $dbval1['meta_description']=htmlspecialchars($dbval['meta_description']);
              $dbval1['meta_keyword']=htmlspecialchars($dbval['meta_keyword']);
              $dbval1['lang_id']=$lang_id;
              $dbval1['id']=$dbval['page_lang_id'];
              $dbval1['pg_id']=$id;
              unset($dbval['pg_title']);
              unset($dbval['pg_detail']);
              unset($dbval['page_lang_id']);
              unset($dbval['meta_description']);
              unset($dbval['meta_keyword']);
              unset($dbval['attr']);
             // unset($dbval['pg_detail']);
              //print_r($dbval);
              $this->Page->id=$id;
              $check=$this->Page->save($dbval);
              if($check)
              {
                $check=$this->Page->Page_lang->save($dbval1);
                 $this->Session->setFlash('Page Updated Successfully!', 'default', array(), 'msg');
                 //$this->redirect('/admin/Page_manager/page:'.$page);
                 // exit();
              }

           }
           $data=$this->Page->find('first',array('conditions'=>array('Page.id'=>$id)));
           $this->set('page_data',$data);
           $this->loadmodel('Language');
           $lang=$this->Language->find('all');
             
           $this->set('lang', $lang);  
           $this->render('add_page');
        }
        public function delete_page($id,$page=1){
            $this->set('menu_title','Delete Page');       
                $this->loadmodel('Page');
                $check=$this->Page->delete(array('id'=>$id));
                if($check)
                {
                   $this->Session->setFlash('Page Deleted Successfully!', 'default', array(), 'msg');
                  $this->redirect('/admin/Page_manager/page:'.$page);
                   exit();
                }
          }
          /********END PAGE MANAGER********/
          /********************** FAQ MANAGER*********************/
          public function faq_manager(){
               $this->set('menu_title','FAQ MANAGER');
               $this->set('admin_button','save');
                App::import('Model', 'Faq_category');
               $this->loadmodel('Faq');
                $condition=$this->request['url'];
                  extract($condition);
                   $lang_id=isset($lang_id)?$lang_id:1;
                  // $cat_id=isset($cat_id)?$cat_id:"";

                  $text_search=isset($text_search)?$text_search:"";      
              $this->Paginator->settings = array(
                 'conditions' => array('Faq_lang.question LIKE' => '%'.$text_search.'%','Faq_lang.lang_id'=>$lang_id,(isset($cat_id) and $cat_id!="")?'Faq.category_id':'Faq.category_id !='=>isset($cat_id)?$cat_id:"",(isset($status) and $status!="")?'Faq.status':'Faq.status !='=>isset($status)?$status:""),
                  'limit' => 10
               );
                //print_r($this->paginate('Faq'));
                $data=$this->paginate('Faq.Faq_lang');
                $this->loadmodel('Faq_category');
                $i=0;
                foreach($data as $val){
                 $data1= $this->Faq_category->Faq_category_lang->find('all',array('conditions'=>array('cat_id'=>$val['Faq']['category_id'],'lang_id'=>$lang_id)));
                 //print_r($data1);
                 $data[$i]=array_merge($data[$i], $data1[0]);
                $i++;
                }
                $data1=array();
                 $faq_data= $this->Faq->find('all',array('conditions'=>array((isset($status) and $status!="")?'Faq.status':'Faq.status !='=>isset($status)?$status:"")));
                 foreach($faq_data as $val){
                   $data2=$this->Faq_category->Faq_category_lang->find('first',array('conditions'=>array('cat_id'=>$val['Faq']['category_id'],'lang_id'=>$lang_id)));
                   //print_r($data2);
                   array_push($data1, $data2);
                 }
                 echo "<pre>";
                // print_r($faq_data);
                   echo "</pre>";
                 $this->set('faq_cat_data_all',$data1 );
               $this->set('faq_cat',$data );
               $this->set('faq_info',$data );
                $this->loadmodel('Language');
               $lang=$this->Language->find('all');
             
               $this->set('lang', $lang);
               

          }
           public function add_faq(){
               $this->set('menu_title','FAQ MANAGER');
               $this->set('admin_button','Create');
               $this->loadmodel('Faq');   
                if($this->request->is('post')){

                  // print_r($this->request->data);
                   $value=$this->request->data;
                   $value1['question']=strip_tags($value['question']);
                   $value1['answer']=htmlspecialchars($value['answer']);
                 
                   $value['created_date']=date('Y-m-d');
                   $slug=$this->toAscii($value['question']);
                   $validate=$this->Faq->find('first',array('conditions'=>array('Faq.slug'=>$slug)));
                   $value['slug']=$slug;
                   $validater="";
                   unset($value['question']);
                   unset($value['answer']);
                  if(!empty($validate))
                   {
                      $validate=$this->Faq->find('first',array('conditions'=>array('Faq.slug'=>$value['slug'],'category_id'=>$value['category_id'])));
                       if(!empty($validate)){
                          
                          $this->Session->setFlash('Duplicate Questions are not allowd in each category!', 'default', array(), 'bad');
                           $validater=1;
                       }
                       else
                       {
                          $value['slug']=$slug."-".$value['category_id'];
                       }
                   }
                   if($validater!=1)
                   {
                     //print_r($value);
                      //$this->Faq->create();
                      $check=$this->Faq->save($value);


                      if($check){
                           $faqid=$this->Faq->id;
                          $value1['faq_id']=$faqid;
                          $value1['lang_id']=1;
                          $value1['status']=1;

                          $this->loadmodel('Faq_lang');
                          // print_r($value1);
                          $check=$this->Faq_lang->save($value1);
                          if($check){
                           $this->Session->setFlash('FAQ Added Successfully!', 'default', array(), 'msg');
                          }
                      
                      }
                  }
                }

               $this->loadmodel('Faq_category'); 
               $data=$this->Faq_category->Faq_category_lang->find('all',array('conditions'=>array('lang_id'=>1,'Faq_category.status'=>1)));      
               $this->set('faq_cat_names', $data);       

           }
           public function update_faq($id){
          $this->set('menu_title','Update FAQ');
          $this->set('admin_button','Update');        
          $this->loadmodel('Faq');
           $condition=$this->request['url'];
                  extract($condition);
                   $lang_id=isset($lang_id)?$lang_id:1;
           if($this->request->is('post')){
           // print_r($_FILES['pg_img']);
                   $value=$this->request->data;
                   $value['question']=strip_tags($value['question']);
                   $value['answer']=htmlspecialchars($value['answer']);
                   $value['modified_date']=date('Y-m-d');
                   //$value['faq.status']=$value['status'];
                   unset($value['status']);
                   if($lang_id==1)
                   {
                       $slug=$this->toAscii($value['question']);
                       $validate=$this->Faq->find('first',array('conditions'=>array('Faq.slug'=>$slug,'Faq.id !='=>$id)));
                       $value['slug']=$slug;
                       $validater="";
                      if(!empty($validate))
                       {
                          $validate=$this->Faq->find('first',array('conditions'=>array('Faq.slug'=>$value['slug'],'category_id'=>$value['category_id'],'Faq.id !='=>$id)));
                           if(!empty($validate)){
                              
                              $this->Session->setFlash('Duplicate Questions are not allowd in each category!', 'default', array(), 'bad');
                               $validater=1;
                           }
                           else
                           {
                              $value['slug']=$slug."-".$value['category_id'];
                           }
                     }
                   }else
                   {
                    $validater=1;
                   }
                   if($validater!=1)
                   {
                     // print_r($value);
                      $value['faq_id']=$id;
                     if($this->request->data['faq_lang_id']!=""){
                       $this->Faq->Faq_lang->id=$this->request->data['faq_lang_id'];
                      }
                 
                      $check=$this->Faq->Faq_lang->save($value);
                      if($check){
                        $value['status']=$this->request->data['status'];
                        $this->Faq->id=$id;
                        $this->Faq->save($value);
                        $this->Session->setFlash('FAQ Updated Successfully!', 'default', array(), 'msg');
                        //  $this->redirect('/admin/faq_manager');
                        //  exit();
                      }
                  }
              
            
           }
               $data=$this->Faq->find('first',array('conditions'=>array('Faq.id'=>$id)));
              /* echo "<pre>";
               print_r($data);
               echo "</pre>";*/
               $this->set('faq_data',$data);
               $this->loadmodel('Faq_category'); 

               $data=$this->Faq_category->Faq_category_lang->find('all',array('conditions'=>array('lang_id'=>1)));      
               $this->set('faq_cat_names', $data);   
               

               $this->loadmodel('Language');
               $lang=$this->Language->find('all');
             
               $this->set('lang', $lang);  
               $this->render('add_faq');
        }
           public function delete_faq($id){
                $this->set('menu_title','Delete FAQ');       
                    $this->loadmodel('Faq');
                    $check=$this->Faq->delete(array('id'=>$id));
                    if($check)
                    {
                       $this->Session->setFlash('FAQ Deleted Successfully!', 'default', array(), 'msg');
                      $this->redirect('/admin/Faq_manager');
                       exit();
                    }
              }
    
            public function add_faq_category(){
               $this->set('menu_title','FAQ CATEGORY MANAGER');
               $this->set('admin_button','Create');
               $this->loadmodel('Faq_category'); 
               if($this->request->is('post')){
                 // print_r($this->request->data);
                   $value=$this->request->data;
                   $slug=$this->toAscii($value['category_name']);
                    $value['slug']=$slug;
                   $validate=$this->Faq_category->find('all',array('conditions'=>array('Faq_category.slug LIKE'=>$slug."%")));
                  
                   if(!empty($validate))
                   {
                     $value['slug']=$slug.(count($validate)+1);
                     // $this->Session->setFlash('Duplicate Category not allowed!', 'default', array(), 'bad');
                  }
                  
                   $value1['category_name']= strip_tags($value['category_name']);
                   unset($value['category_name']);
                      if(empty($value['parent_id']))
                         $value['parent_id']=0;
                      $value['created_date']=date('Y-m-d');
                    $check=$this->Faq_category->save($value);
                   $fcatid= $this->Faq_category->id;
                  if($check){
                      $value1['cat_id']=$fcatid;
                      $value1['lang_id']=1;
                      $value1['status']=1;
                       $this->loadmodel('Faq_category_lang'); 
                       $check=$this->Faq_category_lang->save($value1);
                     $this->Session->setFlash('FAQ Category Added Successfully!', 'default', array(), 'msg');
                  }
                  
               }
               $data=$this->Faq_category->Faq_category_lang->find('all',array('conditions'=>array('lang_id'=>1,'Faq_category.status'=>1)));       
               $this->set('faq_cat_names', $data);


            }
              public function update_faq_cat($id){
          $this->set('menu_title','Update FAQ Category');
          $this->set('admin_button','Update');        
          $this->loadmodel('Faq_category'); 
          
           if($this->request->is('post')){
           // print_r($_FILES['pg_img']);
                   $value=$this->request->data;
                   $slug=$this->toAscii(htmlspecialchars_decode(strip_tags($value['category_name'])));
                   $validate=$this->Faq_category->find('first',array('conditions'=>array('Faq_category.slug'=>$slug,'Faq_category.id !='=>$id)));
                   
                   if(!empty($validate))
                   {
                      $slug=$slug.(count($validate)+1);
                      //$this->Session->setFlash('Duplicate Category not allowed!', 'default', array(), 'bad');
                  }
                  
                  if($slug)
                   $value['slug']=$slug;
                   if(empty($value['parent_id']))
                      $value['Faq_category']['parent_id']=0;
                  else
                  {
                      $value['Faq_category']['parent_id']=$value['parent_id'];
                  }
                     // $value['created_date']=date('Y-m-d');
                 // $this->Faq_category->id=$id;
                  $value['cat_id']=$id;
                  $value['Faq_category']['id']=$id;
                  if($this->request->data['cat_lang_id']!=""){
                    $value['id']=$this->request->data['cat_lang_id'];
                  }
                  //print_r($value);
                  $check=$this->Faq_category->Faq_category_lang->saveAll($value);

                  if($check){
                     $this->Session->setFlash('FAQ Category updated Successfully!', 'default', array(), 'msg');
                    $this->redirect('/admin/faq_category_manager');
                     exit();
                  }
                  
            
           }
               $data=$this->Faq_category->find('first',array('conditions'=>array('Faq_category.id'=>$id)));
               $this->set('faq_cat_data',$data);
              
              $data=$this->Faq_category->Faq_category_lang->find('all',array('conditions'=>array('lang_id'=>1,'Faq_category.status'=>1)));        
               $this->set('faq_cat_names', $data);   

               $this->loadmodel('Language');
               $lang=$this->Language->find('all');
                $this->set('lang', $lang);  
           $this->render('add_faq_category');

        }
            public function delete_faq_cat($id){
                $this->set('menu_title','Delete FAQ');       
                    $this->loadmodel('Faq_category');
                    $check=$this->Faq_category->delete(array('id'=>$id));
                    if($check)
                    {
                       $this->Session->setFlash('FAQ Category Deleted Successfully!', 'default', array(), 'msg');
                      $this->redirect('/admin/faq_category_manager');
                       exit();
                    }
              }
            public function faq_category_manager(){
               $this->set('menu_title','FAQ CATEGORY MANAGER');
               $this->set('admin_button','Create');
               $this->loadmodel('Faq_category');  
                $condition=$this->request['url'];
               // print_r($condition);
                  extract($condition);
                  $lang_id=isset($lang_id)?$lang_id:1;

                  $text_search=isset($text_search)?$text_search:"";      
                $this->Paginator->settings = array(
              'conditions' => array('Faq_category_lang.category_name LIKE' => '%'.$text_search.'%','Faq_category_lang.lang_id'=>$lang_id,
              (isset($status) and $status!="")?'Faq_category.status':'Faq_category.status !='=>isset($status)?$status:""),
              'limit' => 15
              );
              $data=$this->paginate('Faq_category.Faq_category_lang');
              $i=0;
              foreach($data as $val){
                 $data1= $this->Faq_category->Faq_category_lang->find('first',array('conditions'=>array('Faq_category.id'=>$val['Faq_category']['parent_id'],'Faq_category_lang.lang_id'=>$lang_id)));
                 
                 $data[$i]['Parent']=isset($data1['Faq_category_lang'])?$data1['Faq_category_lang']:array('category_name'=>"");
                 $i++;
              }
             /*echo "<pre>";
                 print_r($data);
               echo "</pre>"; */
                $this->loadmodel('Language');
               $lang=$this->Language->find('all');
                $this->set('lang', $lang);  
                $this->set('faq_cat_info', $data);
            }



          /**********************END FAQ MANAGER*********************/


      /*--------------------------End CMS------------------------------*/
       /**********************PRODUCT MANAGER*********************/

       /*------------------PRODUCT CATEGORY MANAGER-----------------*/
        public function add_product_category(){
               $this->set('menu_title','PRODUCT CATEGORY MANAGER');
               $this->set('admin_button','Create');
               $this->loadmodel('Product_category'); 
               if($this->request->is('post')){
                
                   $value=$this->request->data;
                   $slug=$this->toAscii(trim($value['category_name']));
                    $value['slug']=$slug;
                   $validate=$this->Product_category->find('all',array('conditions'=>array('Product_category.slug LIKE'=>$slug."%")));
                  
                   if(!empty($validate))
                   {
                     $value['slug']=$slug.(count($validate)+1);
                     
                  }
                  $catimagepath=@$this->requestAction(array('controller'=>'admin', 'action'=>'uploadImage'),
      array('pass' => array('cat_image','uploads/products/category')));
                   $value['image_url']=$catimagepath;
				   
				   //cat icon upload
                  $caticonpath=@$this->requestAction(array('controller'=>'admin', 'action'=>'uploadImage'),
      array('pass' => array('cat_icon','uploads/products/category/icon')));
                   $value['icon_url']=$caticonpath;
				   
				   
				   
                   $value1['category_name']= strip_tags(trim($value['category_name']));
                   $value1['description']=htmlspecialchars(strip_tags($value['description']));
                   $value1['meta_description']=htmlspecialchars(strip_tags($value['meta_description']));
                   $value1['meta_keyword']=htmlspecialchars(strip_tags($value['meta_keyword']));
                   unset($value['category_name']);
                   unset($value['description']);
                   unset($value['meta_description']);
                   unset($value['meta_keyword']);
                      if(empty($value['parent_id']))
                         $value['parent_id']=0;
                      $value['created_date']=date('Y-m-d');
                    $check=$this->Product_category->save($value);
                   $fcatid= $this->Product_category->id;
                  if($check){
                      $value1['cat_id']=$fcatid;
                      $value1['lang_id']=1;
                      $value1['status']=1;
                       $this->loadmodel('Product_category_lang'); 
                       $check=$this->Product_category_lang->save($value1);
                     $this->Session->setFlash('Product Category Added Successfully!', 'default', array(), 'msg');
                  }
                  
               }
			   
              //$data=$this->Product_category->Product_category_lang->find('all',array('conditions'=>array('lang_id'=>1,'Product_category.status'=>1)));       
             /*$treelist = $this->Product_category->generateTreeList();             
              foreach( $treelist as $key=>$val){
                   $cat_details= $this->Product_category->Product_category_lang->find('first',array('conditions'=>array('cat_id'=>$key,'lang_id'=>1)) );
                   if( !empty($cat_details))
                   {
                   //print_r($cat_details);
                   $final[$key]=str_replace($key, $cat_details['Product_category_lang']['category_name'], $val);
                   }
                   //$final[$key]= $cat_details[0]['Product_category_lang']['category_name'];
              }
              $this->set('product_cat_names', $final);*/


				$product_categories = $this->Product_category->Product_category_lang->Find('all', 
											array(
											'conditions' => array('Product_category.parent_id' => 0),
											'order' => array('Product_category.cat_order'=>'asc'),
										)
									); 
									
				//echo '<pre>'; print_r($product_categories); echo '</pre>'; exit;
								
				$this->set("product_cat_info",$product_categories);


            }
     public function getCategoryById($id="",$lang_id=1,$cond="normal"){
     $this->loadmodel('Product_category'); 
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
      public function update_product_cat($id){
          $this->set('menu_title','Update Product Category');
          $this->set('admin_button','Update');        
          $this->loadmodel('Product_category'); 
		  
		  $cat_path = $this->Product_category->getPath($id);
		  
		  $all_parentid = '';
		  
		 // if(!empty($cat_path))
		 //	 $all_parentid = Hash::extract($cat_path, '{n}.Product_category.id');
		  
		  $this->set('all_parentid',$cat_path); 
		  
		 // echo '<pre>'; print_r($cat_path); echo '</pre>'; exit;
		  
         // @$lang_id=isset($this->request->data['lang_id'])?$this->request->data['lang_id']:1;
          $lang_id=isset($this->request->data['lang_id'])?$this->request->data['lang_id']:1;
           if($this->request->is('post')){ 
                   $value=$this->request->data;  
                   if(isset($lang_id) and $lang_id==1) 
                   {            
                     $slug=$this->toAscii(trim($value['category_name']));
                     $validate=$this->Product_category->find('first',array('conditions'=>array('Product_category.slug'=>$slug,'Product_category.id !='=>$id)));
                   
                    if(!empty($validate))
                    {                  
                        $slug=$slug.(count($validate)+1);
                    }
                    
                    if($slug)
                    {
                        $value['Product_category']['slug']=$slug;
                    }
                   }
                  if(empty($value['parent_id'])){
                      $value['Product_category']['parent_id']=0;
                  }
                  else
                  {
                      $value['Product_category']['parent_id']=$value['parent_id'];
                  }
                   
                  $value['cat_id']=$id;
                  $value['Product_category']['status']=$value['status'];              
                  $value['Product_category']['id']=$id;  
				             
                  if(isset($_FILES['cat_image']['name']) and $_FILES['cat_image']['name']!="")
				  {
					   $catimagepath=@$this->requestAction(array('controller'=>'admin', 'action'=>'uploadImage'),
		  array('pass' => array('cat_image','uploads/products/category')));
					   $value['Product_category']['image_url']=($catimagepath)?$catimagepath:"";
                  }
                  else
                  {
                      unset($value['Product_category']['image_url']);
                  }
                                   
                  if(isset($_FILES['cat_icon']['name']) and $_FILES['cat_icon']['name']!="")
				  {
					   $catimagepath=@$this->requestAction(array('controller'=>'admin', 'action'=>'uploadImage'),
		  array('pass' => array('cat_icon','uploads/products/category/icon')));
					   $value['Product_category']['icon_url']=($catimagepath)?$catimagepath:"";
                  }
                  else
                  {
                      unset($value['Product_category']['icon_url']);
                  }
                                   
                   $value['description']=strip_tags($value['description']);

                
                   unset($value['cat_lang_id']);
                   unset($value['parent_id']);
                   unset($value['image_url']);
				   unset($value['icon_url']);
                   
                  if($this->request->data['cat_lang_id']!=""){
                    $value['id']=$this->request->data['cat_lang_id'];
                  }
                  //print_r($value);
                  $check=$this->Product_category->Product_category_lang->saveAll($value);      
                 // debug($check);         
                  if($check){
                     $this->Session->setFlash('Product Category updated Successfully!', 'default', array(), 'msg');
                     $this->redirect('/admin/product_category_manager');
                     exit();
                  }
                }
                  $data=$this->Product_category->find('first',array('conditions'=>array('Product_category.id'=>$id)));
				  
				 //echo '<pre>'; print_r($data); echo '</pre>'; exit;
				  
                 // $data['Product']['parent']=$this->getCategoryById($data['Product']['parent_id'],1,'high');
                  $this->set('product_cat_data',$data);
                 
                 // $data_12=$this->Product_category->children($id);
                  //$res= Hash::extract($data_12, '{n}.Product_category.id');
                  /*$treelist = $this->Product_category->generateTreeList();
              
                   foreach( $treelist as $key=>$val){
                       $cat_details= $this->Product_category->Product_category_lang->find('all',array('conditions'=>array('cat_id'=>$key,'lang_id'=>$lang_id)) );
                       if(isset($id) and ($id==$cat_details[0]['Product_category_lang']['cat_id'] or $id==$cat_details[0]['Product_category']['parent_id'] or in_array($cat_details[0]['Product_category']['id'] , $res)))
                         continue;                        
                         $final[$key]=str_replace($key, $cat_details[0]['Product_category_lang']['category_name'], $val);
                   }*/


				   
				$product_categories = $this->Product_category->Product_category_lang->Find('all', 
											array(
											'conditions' => array('Product_category.parent_id' => 0),
											'order' => array('Product_category.cat_order'=>'asc'),
										)
									); 
									
				
								
				$this->set("product_cat_info",$product_categories);
				   

                  @ $this->set('product_cat_names', $final); 

                   $this->loadmodel('Language');
                   $lang=$this->Language->find('all');
                   $this->set('lang', $lang);  
                   $this->render('add_product_category');
           

        }
            public function delete_product_cat($id){
                $this->set('menu_title','Delete Product');       
                    $this->loadmodel('Product_category');
                    $check=$this->Product_category->delete(array('id'=>$id));
                    if($check)
                    {
                       $this->Session->setFlash('Product Category Deleted Successfully!', 'default', array(), 'msg');
                       $this->redirect('/admin/Product_category_manager');
                       exit();
                    }
              }
            public function product_category_manager()
			{
				$this->set('menu_title','PRODUCT DEPARTMENT MANAGER');
				// $this->set('admin_button','Create');
				$this->loadmodel('Product_category');  
				$condition=$this->request['url'];
				// print_r($condition);
				extract($condition);
				$lang_id=isset($lang_id)?$lang_id:1;
				
				$text_search=isset($text_search)?$text_search:"";      
				
				/*$this->Paginator->settings = array(
									'conditions' => array('Product_category.parent_id' =>0,'Product_category_lang.lang_id'=>$lang_id),
									'order' => 'Product_category_lang.category_name ASC'
				);
				
				$data=$this->paginate('Product_category.Product_category_lang'); */           
				
				$data = $this->Product_category->Product_category_lang->find('all',array(
									'conditions' => array('Product_category.parent_id' =>0,'Product_category_lang.lang_id'=>$lang_id),
									'order' => 'Product_category.cat_order ASC'
							));
				
				//echo '<pre>'; print_r($data); echo '</pre>'; exit;
				
				$this->loadmodel('Language');
				$lang=$this->Language->find('all');
				$this->set('lang', $lang);  
				//$this->set('lang_id', $lang_id);  
				$this->set('product_cat_info', $data);
            }
			
			public function getAJAXCategorysChild($pid,$cno,$lang_id)
			{
				//$lang_id = '';
				
				$this->layout="ajax";
				$this->loadmodel('Product_category');
				$product_categories = $this->Product_category->Product_category_lang->Find('all', 
											array(
											'conditions'=>array(
												'Product_category.parent_id'=>$pid,
												'Product_category_lang.lang_id'=>$lang_id
                        

											),
											'order' => array('Product_category.cat_order'=>'asc'),
										)
									); 
									
			//	echo '<pre>'; print_r($product_categories); echo '</pre>'; 
			//	$parents = $this->Product_category->getPath($pid);
				$this->set("catlist",$product_categories);
				$this->set("pid",$pid);
				$this->set("cno",$cno);
				$this->set("lang_id",$lang_id);
				$this->render('get_ajax_child_category');
		}
		
			public function getAJAXCategorysChildForm($lang_id,$pid,$cno,$parent_id='')
			{
				$lang_id = '';
				$this->layout="ajax";
				$this->loadmodel('Product_category');
				$product_categories = $this->Product_category->Product_category_lang->Find('all', 
											array(
											'conditions'=>array(
												'Product_category.parent_id'=>$pid,
												//'Product_category_lang.lang_id'=>$lang_id
											),
											'order' => array('Product_category.cat_order'=>'asc'),
										)
									); 
									
				//echo '<pre>'; print_r($product_categories); echo '</pre>'; exit;
								
				$this->set("catlist",$product_categories);
				$this->set("pid",$pid);
				if(!empty($parent_id))
					$this->set("parent_id",$parent_id);
				$this->set("cno",$cno);
				$this->set("lang_id",$lang_id);
				$this->render('get_ajax_child_category_form');
		}
		
		function active_product_cat($cid)
		{
			$value['id'] = $cid;
			$value['status'] = 1;
			$check=$this->Product_category->save($value);      
			// debug($check);         
			if($check){
				$this->Session->setFlash('Product Category activated Successfully!', 'default', array(), 'msg');
				$this->redirect('/admin/product_category_manager');
				//exit();
			}
		}

		function inactive_product_cat($cid)
		{
			$value['id'] = $cid;
			$value['status'] = 0;
			$check=$this->Product_category->save($value);      
			// debug($check);         
			if($check){
				$this->Session->setFlash('Product Category deactivated Successfully!', 'default', array(), 'msg');
				$this->redirect('/admin/product_category_manager');
				//exit();
			}
		}


            public function product_brand(){
                $this->set('menu_title','Product Brand');

               $this->loadmodel('Product_brand');
                $condition=$this->request['url'];
                  extract($condition);
                   $lang_id=isset($lang_id)?$lang_id:1;
                  // $cat_id=isset($cat_id)?$cat_id:"";

                  $text_search=isset($text_search)?$text_search:"";      
              $this->Paginator->settings = array(
                 'conditions' => array('Product_brand_lang.brand_title LIKE' => '%'.$text_search.'%','Product_brand_lang.lang_id'=>$lang_id,(isset($status) and $status!="")?'Product_brand.status':'Product_brand.status !='=>isset($status)?$status:""),
                  'limit' => 10,
                  'order'=>array('Product_brand.id'=>'desc')
               );
                //print_r($this->paginate('Faq'));
                $data=$this->paginate('Product_brand.Product_brand_lang');
               
                
       
               $this->set('brand_info',$data );
                $this->loadmodel('Language');
               $lang=$this->Language->find('all');
             
               $this->set('lang', $lang);
               
            }
            public function add_product_brand(){
                $this->set('menu_title','Add Product Brand');
                $this->set('admin_button','Create');     
    
               $this->loadmodel('Product_brand');   
                if($this->request->is('post')){

                  // print_r($this->request->data);
                   $value=$this->request->data;
                   $value1['brand_title']=strip_tags(trim($value['brand_title']));
                   $value1['description']=htmlspecialchars($value['description']);

                   $value1['meta_description']=htmlspecialchars($value['meta_description']);
                   $value1['meta_keyword']=htmlspecialchars($value['meta_keyword']);
                 
                   $value['created_date']=date('Y-m-d');
                   $slug=$this->toAscii(trim($value['brand_title']));
                   $validate=$this->Product_brand->find('first',array('conditions'=>array('Product_brand.slug'=>$slug)));
                   $value['slug']=$slug;
                   $validater="";
                   unset($value['brand_title']);
                   unset($value['description']);
                    unset($value['meta_description']);
                   unset($value['meta_keyword']);
                  if(!empty($validate))
                   { 
                    $this->Session->setFlash('Duplicate Brand are not allowd!', 'default', array(), 'bad');
                    $validater=1;
                   }
                   if($validater!=1)
                   {
                     //print_r($value);
                      //$this->Faq->create();
                    $imagePath=@$this->requestAction(array('controller'=>'admin', 'action'=>'uploadImage'),
      array('pass' => array('image_url','uploads/products/brand')));
                     if($imagePath){                     
                      $value['image_url']=$imagePath;
                   }
                   //print_r($_FILES['favicon']);
                   $check=$this->Product_brand->save($value);
                   if($check){
                          $brandid=$this->Product_brand->id;
                          $value1['brand_id']=$brandid;
                          $value1['lang_id']=1;
                          $value1['status']=1;
                          $this->loadmodel('Product_brand_lang');
                          // print_r($value1);
                          $check=$this->Product_brand_lang->save($value1);
                          if($check){
                           $this->Session->setFlash('Brand Added Successfully!', 'default', array(), 'msg');
                          }
                      
                      }
                  }
                }

               //$this->loadmodel('Faq_category'); 
               //$data=$this->Faq_category->Faq_category_lang->find('all',array('conditions'=>array('lang_id'=>1,'Faq_category.status'=>1)));      
               //$this->set('faq_cat_names', $data);     
            }
     public function update_product_brand($id,$page=1){
          $this->set('menu_title','Update Brand');
          $this->set('admin_button','Update');        
          $this->loadmodel('Product_brand');
          $condition=$this->request['url'];
                  extract($condition);
                   $lang_id=isset($lang_id)?$lang_id:1;
           if($this->request->is('post')){
           // print_r($_FILES['pg_img']);
                   $value=$this->request->data;
                   $value['brand_title']=strip_tags(trim($value['brand_title']));
                   $value['description']=htmlspecialchars($value['description']);
                   $value['meta_description']=htmlspecialchars($value['meta_description']);
                   $value['meta_keyword']=htmlspecialchars($value['meta_keyword']);
                   $value['created_date']=date('Y-m-d');
                     $validater="";
                   if($lang_id==1){
                    $slug=@$this->toAscii(trim($value['brand_title']));
                   $validate=$this->Product_brand->find('first',array('conditions'=>array('Product_brand.slug'=>$slug,'Product_brand.id !='=>$id)));
                   $value['slug']=$slug;

                  if(!empty($validate))
                   {                 
                          
                     $this->Session->setFlash('Duplicate Questions are not allowd in each category!', 'default', array(), 'bad');
                     $validater=1;
                       
                   }
                   }
                   
               
                   if($validater!=1)
                   {
                     // print_r($value);
                  //  print_r($_FILES['image_url']);
                    if(!empty($_FILES['image_url']))
                    {
                     $imagePath=@$this->requestAction(array('controller'=>'admin', 'action'=>'uploadImage'),
      array('pass' => array('image_url','uploads/products/brand')));
                     if($imagePath){                     
                      $value['image_url']=$imagePath;
                   }
                 }
                      $value['brand_id']=$id;
                     if($this->request->data['brand_lang_id']!=""){
                       $this->Product_brand->Product_brand_lang->id=$this->request->data['brand_lang_id'];
                      }
                 
                      $check=$this->Product_brand->Product_brand_lang->save($value);
                      if($check){
                        $this->Product_brand->id=$id;
                        $check=$this->Product_brand->save($value);
                      if($check){
                        $this->Session->setFlash('Brand Updated Successfully!', 'default', array(), 'msg');
                        $this->redirect('/admin/product_brand/page:'.$page);
                          exit();
                      }
                    }
                  }
              
            
           }
               $data=$this->Product_brand->find('first',array('conditions'=>array('Product_brand.id'=>$id)));
              /* echo "<pre>";
               print_r($data);
               echo "</pre>";*/
               $this->set('brand_data',$data);          
               

               $this->loadmodel('Language');
               $lang=$this->Language->find('all');
             
               $this->set('lang', $lang);  
               $this->render('add_product_brand');
        }

        public function delete_product_brand($id,$page=1)
        {
            $this->set('menu_title','Delete Brand');       
            $this->loadmodel('Product_brand');
            $check=$this->Product_brand->delete(array('id'=>$id));
            if($check)
            {
               $this->Session->setFlash('Brand Deleted Successfully!', 'default', array(), 'msg');
              $this->redirect('/admin/product_brand/page:'.$page);
               exit();
            }
           
           

        }
            /*--------------END OF PRODUCT CATEGORY---------------*/

       /**********************END PROFUCT MANAGER*****************/

  /*-#_#_#_#_#_#_#_#_#_#_#_#_#_#_#_#__#_#_#_#_#_#_#_#_#_#__#_#_#_#_#_#_#_#_#_#_#__#_#_#_#__#_#_#_#_#_#_#_#__#_#_#_#_#-*/

      /*--------------------------Site Settings------------------------------*/
          /*@param: $name -> name of the field 
                              or 
                           array('name'=>'',
                           'type'=>'',
                           'tmp_name'=>'',
                           'error'=>'',
                           'size'=>'');
            @param: $uploadFolder -> pass your folder path in "webroot"
                                      Ex: "uploads/images" 
            @param: $type-> pass the type array filter.
                            default: array("image/gif", "image/jpeg","image/jpeg", "image/png");         
          */
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
          public function getSiteSettingData(){
              $this->loadmodel('Setting');
              return $this->Setting->find('first');
          }
          public function tagline(){
             $this->set('menu_title','Tag Lines'); 
             $this->set('admin_button','save');
             if($this->request->is('post')){
                @$selected=$this->request->data['tagline'];
                $titles=$this->request->data['tagline_title'];
                $color_code=$this->request->data['color_code'];
                $ids=isset($this->request->data['id'])?$this->request->data['id']:"";
                $titles_ar=$this->request->data['tagline_title_ar'];
				/*$total = count($titles);
				
				for($i = 0; $i<$total; $i++)
				{
						
				}*/
				
				foreach($titles as $key=>$val){
                  if(isset($ids[$key]))
                  {
                    $dbval[$key]['id']=$ids[$key];
                  }
                  if($key==$selected)
                  {
                    $dbval[$key]['status']=1;
                  }
                  else
                  {
                    $dbval[$key]['status']=0;
                   /* if($selected=='0' and $key=='0')
                    {
                      $dbval[$key]['status']=1;
                    }*/
                  }
                  $dbval[$key]['tag_line']=$val;
                  if(isset($titles_ar[$key]))
                  {
                    $dbval[$key]['tag_line_ar']=$titles_ar[$key];
                  }
                  $dbval[$key]['color_code']=$color_code[$key];
                }
				
				//echo '<pre>'; print_r($dbval); echo '</pre>'; exit;
				
               $check=$this->Tagline->saveMany($dbval);
               if($check)
               {
                 $this->Session->setFlash('Tags added Successfully', 'default', array(), 'msg');
               }
             }

              $data=$this->Tagline->find("all");
              $this->set('tag_data',$data);
          }
            public function delete_tagline($id=""){
                $this->Tagline->id=$id;
                $check=$this->Tagline->delete();
                if($check)
                {
                  $this->Session->setFlash('Tags deleted Successfully', 'default', array(), 'msg');
                  $this->redirect('/admin/tagline');
                  exit();
                }
            }
          public function site_settings(){
               $this->set('menu_title','General Settings'); 
               $this->set('admin_button','save');
            
               if($this->request->is('post')){
                   $this->loadmodel('Setting');
                   $logoName=@$this->requestAction(array('controller'=>'admin', 'action'=>'uploadImage'),
      array('pass' => array('logo','uploads/site')));
                   //print_r($_FILES['favicon']);
                   $fabiconName=@$this->requestAction(array('controller'=>'admin', 'action'=>'uploadImage'),
      array('pass' => array('favicon','',array('image/x-icon'))));
                   $dbval=$this->request->data;
                    
                   $dbval['allow_capcha']=json_encode($dbval['allow_capcha']) ;
                   if($logoName){                     
                      $dbval['logo']=$logoName;
                   }
                   if($fabiconName){                     
                      $dbval['favicon']=str_replace("/", "", $fabiconName);
                   }
                   //print_r($dbval);
                   if(!isset($dbval['allow_reg_log'])){
                      $dbval['allow_reg_log']=0;
                   }
                   $this->Setting->id=1;
                   $check=$this->Setting->save($dbval);
                   if($check)
                   $this->Session->setFlash('Genral Settings Updated Successfully!', 'default', array(), 'msg');
               }
               $data=$this->requestAction(array('controller'=>'admin', 'action'=>'getSiteSettingData'));
               $this->set('setting_info',$data);
          }
          public function system_settings(){
              $this->set('menu_title','System Settings'); 
              $this->set('admin_button','save'); 
               $this->loadmodel('Language');
               $lang=$this->Language->find('all');
               //print_r($lang);
               $data=$this->requestAction(array('controller'=>'admin', 'action'=>'getSiteSettingData'));
               if($this->request->is('post')){
                   $this->loadmodel('Setting');
                  $this->Setting->id=1;
                 $check=$this->Setting->save($this->request->data); 
                 if($check)
                   $this->Session->setFlash('System Settings Updated Successfully!', 'default', array(), 'msg');              
               }
               $this->set('setting_info',$data);
               $this->set('lang_info',$lang);
          }
          public function seo_settings(){
                $this->set('menu_title','Seo Settings'); 
                $this->set('admin_button','save'); 
                $this->loadmodel('Seo_setting');
              if($this->request->is('post')){
                  extract($this->request->data);
                  $dbval['allow_meta_key']=isset($allow_meta_key)?$allow_meta_key:0;
                  $dbval['allow_meta_desc']=isset($allow_meta_desc)?$allow_meta_desc:'0';
                  $dbval['allow_robert']=isset($allow_robert)?$allow_robert:0;
                  $dbval['allow_canonikal_url']=isset($allow_canonikal_url)?$allow_canonikal_url:0;
                  $dbval['allow_opengraph_setting']=isset($allow_opengraph_setting)?$allow_opengraph_setting:0;
                  $dbval['allow_google_analitics']=isset($allow_google_analitics)?$allow_google_analitics:0;
                  $dbval['allow_site_map']=isset($allow_site_map)?$allow_site_map:0;
                  
                  if(isset($meta_key)){
                  $dbval['meta_key']=htmlspecialchars($meta_key);
                  }
                   if(isset($meta_desc)){
                  $dbval['meta_desc']=htmlspecialchars($meta_desc);
                   }
                   if(isset($google_analitics)){
                  $dbval['google_analitics']=htmlspecialchars($google_analitics);
                  }
                  if(isset($allow_site_map)){
                      if($_FILES['site_map_path']['name']!=""){
       $dbval['site_map_path']=@$this->requestAction(array('controller'=>'admin', 'action'=>'uploadImage'),
       array('pass' => array('site_map_path','uploads/seo/sitemap',array('text/xml','application/xml'))));
                  }
                  }
                 // print_r($dbval);
                $this->Seo_setting->id=1; 
                $check=$this->Seo_setting->save($dbval);
                 if($check)
                   $this->Session->setFlash('Seo Settings Updated Successfully!', 'default', array(), 'msg');

                }
                $data=$this->Seo_setting->find('first');             
                $this->set('seo_info',$data);
          }
          public function delete_lang($id){
              $this->loadmodel('Language');
              $this->Language->id=$id;
             $check=$this->Language->delete();
             if($check){
              $this->Session->setFlash('record deleted Successfully', 'default', array(), 'msg');
                   $this->redirect('/admin/language_settings');
                   exit();
                   
             }
             $this->render('language_settings');
          }
          public function language_settings(){
              $this->set('menu_title','Language Settings'); 
              $this->set('admin_button','save');
               $this->loadmodel('Language');
              if($this->request->is('post'))
              {
               //echo "<pre>";
              // print_r($this->request->data);
                extract($this->request->data);
                extract($_FILES);
               // print_r($_FILES);
               // echo "</pre>";
             $count=0;
             $updatecount=0;
             $totalcount=count($lang_name);
              foreach($lang_name as $key=>$val) {
                 if(isset($id[$key]))
                 {
                   $updatecount++;
                   $dbval[$key]['id']=$id[$key];
                 }
                 else
                 {

                   $search=$this->Language->find('first',array('conditions'=>array('lang_name'=>ucfirst($val))));
                 }

                  $dbval[$key]['lang_name']=ucfirst($val);
                  $dbval[$key]['lang_short_name']=$lang_short_name[$key];
                  if(isset($lang_flag['name'][$key]) and $lang_flag['name'][$key]!=""){
                  $imgarr=array('name'=>$lang_flag['name'][$key],
                              'type'=>$lang_flag['type'][$key],
                              'tmp_name'=>$lang_flag['tmp_name'][$key],
                              'error'=>$lang_flag['error'][$key],
                              'size'=>$lang_flag['size'][$key]
                              );
                   $dbval[$key]['lang_flag']=@$this->requestAction(array('controller'=>'admin', 'action'=>'uploadImage'),
                  array('pass' => array($imgarr,'uploads/language/flags')));
                  }
                   if(isset($lang_file['name'][$key]) and $lang_file['name'][$key]!=""){
                  $filearr=array('name'=>$lang_file['name'][$key],
                              'type'=>$lang_file['type'][$key],
                              'tmp_name'=>$lang_file['tmp_name'][$key],
                              'error'=>$lang_file['error'][$key],
                              'size'=>$lang_file['size'][$key]
                              );
                 

                  $dbval[$key]['lang_file']=@$this->requestAction(array('controller'=>'admin', 'action'=>'uploadImage'),
                  array('pass' => array($filearr,'uploads/language/files',array('text/plain'))));
                  }
                 
                  if(@$dbval[$key]['lang_file']!='0' and @$dbval[$key]['lang_flag']!='0' and @count($search)<=0)
                  {    
                  }
                  else if(!isset($dbval[$key]['id']))
                  {
                          $count++;
                          unset($dbval[$key]);
                  }
                }
                //print_r($dbval);
               if(($totalcount-$updatecount)!=0 or $updatecount!=0){
               
                 $check=$this->Language->saveMany($dbval); 
                 if($check)
                  {   if($updatecount==0 and ($totalcount-$count)!=0){            
                      $this->Session->setFlash('Language added Successfully!', 'default', array(), 'msg');
                      }
                      else if($updatecount==$totalcount)
                      {
                          $this->Session->setFlash(($updatecount>1)?$updatecount.' records  updated Successfully!':$updatecount.' record updated Successfully!', 'default', array(), 'msg');
                      }
                      else if((($totalcount-$updatecount)-$count)!=0)
                      {
                          $rec=($totalcount-$updatecount)-$count;
                          $inst=($rec>1)?$rec.' records Added Successfully!':$rec.' record Added Successfully!';
                          $update=($updatecount>1)?$updatecount.' records updated Successfully!':$updatecount.' record updated Successfully!';
                          $this->Session->setFlash($inst."<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$update, 'default', array(), 'msg');
                      }
                  }
               }
                  if($count>0)
                  {
                      $this->Session->setFlash(($count>1)?$count.' records not added Successfully (please Check your file type or duplicate language name)':$count.' record not added Successfully (please Check your file type or duplicate language name)', 'default', array(), 'bad');
                  }
              }
              $data=$this->Language->find('all');
              $this->set('Language_info',$data); 
          }
          public function delete_social($id){
              $this->loadmodel('Social_setting');
              $this->Social_setting->id=$id;
             $check=$this->Social_setting->delete();
             if($check){
              $this->Session->setFlash('record deleted Successfully', 'default', array(), 'msg');
                   $this->redirect('/admin/social_settings');
                   exit();
                   
             }
             $this->render('social_settings');
          }
          public function social_settings(){
              $this->set('menu_title','Social Settings'); 
              $this->set('admin_button','save');
              //$data=$this->requestAction(array('controller'=>'admin', 'action'=>'getSiteSettingData'));
              $this->loadmodel('Social_setting');
              if($this->request->is('post'))
              {
               //echo "<pre>";
             // print_r($this->request->data);
                extract($this->request->data);
                extract($_FILES);
               // print_r($_FILES);
               // echo "</pre>";
             $count=0;
             $updatecount=0;
             $totalcount=count($title);
              foreach($title as $key=>$val) {
                 if(isset($id[$key]))
                 {
                   $updatecount++;
                   $dbval[$key]['id']=$id[$key];
                 }
                 else
                 {

                   $search=$this->Social_setting->find('first',array('conditions'=>array('title'=>ucfirst($val))));
                 }

                  $dbval[$key]['title']=ucfirst($val);
                  $dbval[$key]['link_slide']=$link_slide[$key];
                  $dbval[$key]['social_order']=$social_order[$key];
                  $dbval[$key]['status']=$status[$key];
                  $dbval[$key]['add_date']=date('Y-m-d');
                  if(isset($image['name'][$key]) and $image['name'][$key]!=""){
                  $imgarr=array('name'=>$image['name'][$key],
                              'type'=>$image['type'][$key],
                              'tmp_name'=>$image['tmp_name'][$key],
                              'error'=>$image['error'][$key],
                              'size'=>$image['size'][$key]
                              );
                   $dbval[$key]['image']=@$this->requestAction(array('controller'=>'admin', 'action'=>'uploadImage'),
                  array('pass' => array($imgarr,'uploads/social')));
                  }
                  
                 
                  if(@$dbval[$key]['image']!='0' and @count($search)<=0)
                  {    
                  }
                  else if(!isset($dbval[$key]['id']))
                  {
                          $count++;
                          unset($dbval[$key]);
                  }
                }
                //print_r($dbval);
               if(($totalcount-$updatecount)!=0 or $updatecount!=0){
               
                 $check=$this->Social_setting->saveMany($dbval); 
                 if($check)
                  {   if($updatecount==0 and ($totalcount-$count)!=0){            
                      $this->Session->setFlash('Records added Successfully!', 'default', array(), 'msg');
                      }
                      else if($updatecount==$totalcount)
                      {
                          $this->Session->setFlash(($updatecount>1)?$updatecount.' records  updated Successfully!':$updatecount.' record updated Successfully!', 'default', array(), 'msg');
                      }
                      else if((($totalcount-$updatecount)-$count)!=0)
                      {
                          $rec=($totalcount-$updatecount)-$count;
                          $inst=($rec>1)?$rec.' records Added Successfully!':$rec.' record Added Successfully!';
                          $update=($updatecount>1)?$updatecount.' records updated Successfully!':$updatecount.' record updated Successfully!';
                          $this->Session->setFlash($inst."<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$update, 'default', array(), 'msg');
                      }
                  }
               }
                  if($count>0)
                  {
                      $this->Session->setFlash(($count>1)?$count.' records not added Successfully (please Check your file type or duplicate Title)':$count.' record not added Successfully (please Check your file type or duplicate Title)', 'default', array(), 'bad');
                  }
              }
            //  $data=$this->Social_setting->find('all');
               $this->Paginator->settings = array('limit' => -1);
               $this->set('social_info', $this->paginate('Social_setting'));
             // $this->set('social_info',$data); 
          }


   
      /*--------------------------End Site Settings------------------------------*/


  /*---------- TAG MANAGER---------*/

  public function tagmanager(){
    $this->set('menu_title','Tag Manger'); 
    $this->set('inner_section_name','Tags');
    if($this->request->is('post')){
      if(@$this->request->data['delete'])
      {
        
        $dbval=$this->request->data;
         $this->Tag->id=$dbval['tag_id'];
         $check=$this->Tag->delete();
         if($check){
            $this->Session->setFlash('Tag Deleted Successfully', 'default', array(), 'msg');
          }
      }
      else if(@$this->request->data['add_tags_update'])
       {
        $dbval=$this->request->data;
         //$dbval['title']=strip_tags(trim($this->request->data['title']));
        // $dbval['slug']=strip_tags(trim($this->request->data['slug']));
         $dbval['date']=date('Y-m-d');
         $dbval['status']=1;
       
         $dbval1['tags']=json_encode($dbval['all_tages']);         
           unset($dbval['all_tages']);
         $dbval1['lang_id']=1;
           $this->Tag->id=$dbval['tag_id'];
         $check=$this->Tag->save($dbval);
         if($check){
          $dbval1['id']=$dbval['tag_id_lang'];
          $check1=$this->Tag->Tag_lang->save($dbval1);
          if($check1){
            $this->Session->setFlash('Tag Added Successfully', 'default', array(), 'msg');
          }
         
       }
       }
       elseif(@$this->request->data['add_tags_submit'])
       {
         //print_r($this->request->data);
         $dbval=$this->request->data;
         $dbval['title']=strip_tags(trim($this->request->data['title']));
         $dbval['slug']=strip_tags(trim($this->request->data['slug']));
         $dbval['date']=date('Y-m-d');
         $dbval['status']=1;
       
         $dbval1['tags']=json_encode($dbval['all_tages']);         
           unset($dbval['all_tages']);
         $dbval1['lang_id']=1;
        if(!$this->Tag->findBySlug($dbval['slug']))
        {
         $check=$this->Tag->save($dbval);
         if($check){
          $dbval1['tag_id']=$this->Tag->id;
          $check1=$this->Tag->Tag_lang->save($dbval1);
          if($check1){
            $this->Session->setFlash('Tag Added Successfully', 'default', array(), 'msg');
          }
         }
       }
     }
    }
    $data=$this->Tag_lang->find('all',array('conditions'=>array('Tag.status'=>1)));
    $this->set('tages',$data);
  } 
  /*----------End TAG MANAGER---------*/



      /*-------------------Bulk_call Ajax------------------------------*/

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
  public function bulk_add_slider(){
          $this->layout = 'ajax';
         if($this->request->is('post')){
             $val_arr=$this->request->data('ids');
             $model= $this->request->data('model');        
             $val_arr=json_decode($val_arr);           
             $this->loadmodel($model);
             $check=0;
             foreach($val_arr as $val){
               $ch=$this->{$model}->find('first',array('conditions'=>array('status'=>1,$model.'.id'=>$val)));
                if(!empty($ch))
                {
                $this->{$model}->id=$val;
                $this->{$model}->save(array('add_to_slider'=>'1'));
                $check=1;
                }
             }
             if($check==1)
             {
               echo 1;
             }else
             {
               echo 0;
             }
         }
         $this->render('ajax');
      }
  public function bulk_remove_slider(){
          $this->layout = 'ajax';
         if($this->request->is('post')){
             $val_arr=$this->request->data('ids');
             $model= $this->request->data('model');        
             $val_arr=json_decode($val_arr);           
             $this->loadmodel($model);
             foreach($val_arr as $val){
                $this->{$model}->id=$val;
                $this->{$model}->save(array('add_to_slider'=>'0'));
             }
            echo 1;
         }
         $this->render('ajax');
      }



      /*---------------------AJAX END-----------------------------------*/
	  
	  public function click_track()
	  {
			$this->set('menu_title','Click Track Report');
			$conditions = '';
			if(!empty($this->params->query))
			{
				//echo "<pre>";print_r($this->params);echo "</pre>"; exit;	
				$srch_data = $this->params->query;
				if(!empty($srch_data['from_date']))
					$from_date = date('Y-m-d H:i:s',strtotime($srch_data['from_date']));
				if(!empty($srch_data['to_date']))
				{
					$to_date = date('Y-m-d',strtotime($srch_data['to_date']));
					$to_date = $to_date.' 59:59:59';
				}
				$search = '';
				if(!empty($srch_data['product']))
					$search = $srch_data['product'];
				
				if(!empty($from_date))
				{
					$conditions['Click_track.click_time >='] = $from_date;
				}
				if(!empty($to_date)) 
				{
					$conditions['Click_track.click_time <= '] = $to_date;
				} 
				
				if(!empty($search))
				{
					$pslug_val = explode(' ',$search);
					/*if(count($pslug_val)>1)
					{
						$i = 0;
						foreach($pslug_val as $pval)
						{
							$cond['OR'][$i]['and']['Product_lang.title LIKE'] = '%'.$pval.'%';	
							$i++;
						}
					}
					else
					{
						$cond['Product_lang.title LIKE'] = '%'.$search.'%';	
					}*/
					$cond['Product_lang.title LIKE'] = '%'.str_replace(' ','%',$search).'%';	
					
					$pid = $this->Product->Product_lang->find('list',
												array(
													'fields'=>array(
														'Product_lang.product_id'
													),
													'conditions'=> $cond
												));
					//echo "<pre>";print_r($pid);echo "</pre>"; exit;	
					//$conditions['Click_track.product_id in'] = $pid;
				}
				
				if(!empty($srch_data['merchant_id']))
				{
					$conditions['Click_track.merchant_id'] = $srch_data['merchant_id'];	
				}
				if(!empty($srch_data['product_id']))
				{
					$conditions['Click_track.product_id'] = $srch_data['product_id'];	
				}
				
				if(!empty($srch_data['todo']))
				{
					$this->viewClass = 'Media';
					$reports = $this->Click_track->find('all',array(
											'fields' => array(
												'Click_track.*',
												'COUNT(DISTINCT Click_track.id) AS click_count',
											),
											'conditions' => $conditions,
											'order'=>'Click_track.id DESC',
											'group'=>'Click_track.product_id '
										));
					
					//echo "<pre>";print_r($reports);echo "</pre>"; exit;	
					
					//Export to Excel file
					if($srch_data['todo'] == 'export')
					{
						App::import('Vendor', 'PHPExcel/Classes/PHPExcel');
						App::import('Vendor', 'PHPExcel/Classes/PHPExcel/Cell/AdvancedValueBinder.php');
						App::import('Vendor', 'PHPExcel/Classes/PHPExcel/IOFactory');
						PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );
						$objPHPExcel = new PHPExcel();
						$objPHPExcel->getProperties()->setCreator('');
						$objPHPExcel->getProperties()->setLastModifiedBy('');
						$objPHPExcel->getProperties()->setTitle('Click Track Report'." ".date('Y-m-d'));
						$objPHPExcel->getProperties()->setSubject('Click Track Report'."  ".date('Y-m-d'));
						$objPHPExcel->getProperties()->setDescription('Click Track Report'."  ".date('Y-m-d'));
						$objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
						$objPHPExcel->getProperties()->setCategory("REPORT");
						$objPHPExcel->setActiveSheetIndex(0);
						
						$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(40);
						$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
						$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
						$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
						
						$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Product Name');
						$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Merchant Name');
						$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Click Count');
						$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Last Visit');
						
						
						if(!empty($reports))
						{
							$keys = 1;
							foreach($reports as $report)
							{
								$keys++;
								$ptitle = $this->Ctrl->getProductTitle($report['Click_track']['product_id']);
								$mname = $this->Ctrl->getMerchantName($report['Click_track']['merchant_id']);
								
								if($report['Click_track']['click_time']!='0000-00-00 00:00:00')
									$click_time = date("d/m/Y H:i", strtotime($report['Click_track']['click_time']));
								
								if($ptitle!='')
								{							 
									$objPHPExcel->getActiveSheet()->setCellValue('A'.$keys, $ptitle);
									$objPHPExcel->getActiveSheet()->setCellValue('B'.$keys, $mname);
									$objPHPExcel->getActiveSheet()->setCellValue('C'.$keys, $report[0]['click_count']);
									$objPHPExcel->getActiveSheet()->setCellValue('D'.$keys, $click_time);
								}
							}
							$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
						   // $objWriter->save('php://output'); 
							$file_name="click_track_".date('Y-m-d').".xls";
							$objWriter->save('uploads/reports' . DS.$file_name);
						
							// Render app/webroot/files/example.docx
							$params = array(
								'id'        => $file_name,
								'name'      => '"click_track_"'.date('Y-m-d-H-i-s').'"',
								'extension' => 'xls',
								'mimeType'  => array('xls'=>'application/vnd.ms-excel'),    
								'path'      => 'uploads/reports' . DS
							);
							$this->set($params); 
							
						}
					}
					//Download as pdf
					if($srch_data['todo'] == 'pdf')
					{
						//App::import('Vendor', 'dompdf-master');
						//App::import('Vendor', 'dompdf-master/dompdf_config.inc.php');
						require_once("../Vendor/dompdf-master/dompdf_config.inc.php");
						
						$html = '<table class="tablesorter ordered" id="" style="font-size: 14px;" cellspacing="0"> 
								  <thead> 
									<tr><td colspan="4"><h2>Click Track report</h2></td></tr>
									<tr> 
										<td width="250"><strong>Product Name</strong></td>            
									   
										<td width="100"><strong>Merchant Name</strong></td> 
										<td width="100" align="center"><strong>Click Count</strong></td> 
										<td><strong>Last Visit</strong></td>             
									</tr> 
								  </thead>';
						
						if(!empty($reports))
						{
							foreach($reports as $report)
							{
								$ptitle = $this->Ctrl->getProductTitle($report['Click_track']['product_id']);
								$mname = $this->Ctrl->getMerchantName($report['Click_track']['merchant_id']);
								$click_count = $report[0]['click_count'];
								
								if($report['Click_track']['click_time']!='0000-00-00 00:00:00')
									$click_time = date("d/m/Y H:i", strtotime($report['Click_track']['click_time']));
								
								if($ptitle!='')
								{
									$html .= '<tr>
												<td>'.$ptitle.'</td>
												<td>'.$mname.'</td>
												<td align="center">'.$click_count.'</td>
												<td>'.$click_time.'</td>
											</tr>';
								}
							}
							$html .= '</table>';
						}
						
						if ( !empty( $html )) 
						{
						
							$file_name="click_track_".date('Y-m-d');
							//$file_location = "upload/reports/".$file_name.".pdf";
						
						  if ( get_magic_quotes_gpc() )
							$html = stripslashes($html);
						  
						  $dompdf = new DOMPDF();
						  $dompdf->load_html($html);
						  $dompdf->set_paper('letter', 'portrait');
						  $dompdf->render();
						
						  
						//To save pdf file
						 // $pdf = $dompdf->output();
						 // file_put_contents($file_location, $pdf);
						//To save pdf file
						
						//To download
						  $dompdf->stream($file_name.".pdf", array("Attachment" => true));
						
						  //exit(0);
						}
					}
				}
			}
				
	   		$this->Paginator->settings = array(
											'fields' => array(
												'Click_track.*',
												'COUNT(DISTINCT Click_track.id) AS click_count',
											),
											'conditions' => $conditions,
											'order'=>'Click_track.id DESC',
											'group'=>'Click_track.product_id ',
											'limit' => 20
										);
			$data = $this->paginate('Click_track');
			$this->set('reports',$data);	
			
			$merchant_id = $this->Click_track->find('list',
													array(
														'fields' => array(
															'Click_track.merchant_id'
														),
														'group' => 'Click_track.merchant_id'
													)
												);
			
			$merchants = $this->Merchant->find('all',
												array(
													'conditions'=> array(
															'Merchant.id in' => $merchant_id
														)
												));
			$this->set('merchants',$merchants);	
			
			$product_id = $this->Click_track->find('list',
													array(
														'fields' => array(
															'Click_track.product_id'
														),
														'group' => 'Click_track.product_id'
													)
												);
			
			$products = $this->Product->Product_lang->find('all',
												array(
													
													'conditions'=> array(
														'Product.id in' => $product_id
													)
												));
			$this->set('products',$products);	
			//echo "<pre>";print_r($products);echo "</pre>"; exit;	
	  }
	  
	  function getProductList($pslug)
	  {
			$pslug_val = explode(' ',$pslug);
			
			$product_id = $this->Click_track->find('list',
													array(
														'fields' => array(
															'Click_track.product_id'
														),
														'group' => 'Click_track.product_id'
													)
												);
			
			$cond['Product.id in'] = $product_id;
			$cond['Product_lang.lang_id'] = 1;
			if(count($pslug_val)>1)
			{
				$i = 0;
				foreach($pslug_val as $pval)
				{
					$cond['OR'][$i]['and']['Product.slug LIKE'] = '%'.$pval.'%';	
					$i++;
				}
			}
			else
			{
				$cond['Product.slug LIKE'] = '%'.$pslug.'%';	
			}
			$products = $this->Product->Product_lang->find('all',
												array(
													
													'conditions'=>$cond
												));
			//echo count($pslug_val);
			//echo "<pre>";print_r($products);echo "</pre>"; exit;
			if(!empty($products))
			{
				echo '<ul>';
				foreach($products as $product)
				{
					?>
                    <li onclick="selectProduct('<?=$product['Product']['id']?>','<?=stripslashes($product['Product_lang']['title'])?>');"><?=stripslashes($product['Product_lang']['title'])?></li>
                    <?php
				}
				echo '</ul>';
			}	
			$this->set('products',$products);	exit;
	  }

    public function backuprestor(){
        $this->set('menu_title','Backup and Restore');
        $conditions=array();
        $srch_data = $this->params->query;
      if(!empty($srch_data['from_date']))
        $from_date = date('Y-m-d H:i:s',strtotime($srch_data['from_date']));
      if(!empty($srch_data['to_date']))
        $to_date = date('Y-m-d H:i:s',strtotime($srch_data['to_date']));
        if(!empty($from_date))
        {
          $conditions['DATE_FORMAT(Backup_restor.date,"%Y-%m-%d") >='] = date('Y-m-d',strtotime($from_date));
        }
        if(!empty($to_date)) 
        {
          $conditions['DATE_FORMAT(Backup_restor.date,"%Y-%m-%d") <='] = date('Y-m-d',strtotime($to_date));
        } 
        $this->Paginator->settings = array(                      
                      'conditions' => $conditions,
                      'order'=>'Backup_restor.id DESC',                      
                      'limit' => 20
                    );
      $data = $this->paginate('Backup_restor');
      $this->set('backup_list',$data);  
    }
    /**
 * Dumps the MySQL database that this controller's model is attached to.
 * This action will serve the sql file as a download so that the user can save the backup to their local computer.
 *
 * @param string $tables Comma separated list of tables you want to download, or '*' if you want to download them all.
 */
public function database_mysql_dump($tables = '*') {

    $return = '';

    $modelName = $this->modelClass;

    $dataSource = $this->{$modelName}->getDataSource();
    $databaseName = $dataSource->getSchemaName();


    // Do a short header
    $return .= '-- Database: `' . $databaseName . '`' . "\n";
    $return .= '-- Generation time: ' . date('D jS M Y H:i:s') . "\n\n\n";


    if ($tables == '*') {
        $tables = array();
        $result = $this->{$modelName}->query('SHOW TABLES');
        foreach($result as $resultKey => $resultValue){
            $tables[] = current($resultValue['TABLE_NAMES']);
        }
    } else {
        $tables = is_array($tables) ? $tables : explode(',', $tables);
    }

    // Run through all the tables
    foreach ($tables as $table) {
        $tableData = $this->{$modelName}->query('SELECT * FROM ' . $table);

        $return .= 'DROP TABLE IF EXISTS ' . $table . ';';
        $createTableResult = $this->{$modelName}->query('SHOW CREATE TABLE ' . $table);
        $createTableEntry = current(current($createTableResult));
        $return .= "\n\n" . $createTableEntry['Create Table'] . ";\n\n";

        // Output the table data
        foreach($tableData as $tableDataIndex => $tableDataDetails) {

            $return .= 'INSERT INTO ' . $table . ' VALUES(';

            foreach($tableDataDetails[$table] as $dataKey => $dataValue) {

                if(is_null($dataValue)){
                    $escapedDataValue = 'NULL';
                }
                else {
                    // Convert the encoding
                    $escapedDataValue = mb_convert_encoding( $dataValue, "UTF-8", "ISO-8859-1" );

                    // Escape any apostrophes using the datasource of the model.
                    $escapedDataValue = $this->{$modelName}->getDataSource()->value($escapedDataValue);
                }

                $tableDataDetails[$table][$dataKey] = $escapedDataValue;
            }
            $return .= implode(',', $tableDataDetails[$table]);

            $return .= ");\n";
        }

        $return .= "\n\n\n";
    }

    // Set the default file name
    $path="backup/";
    $fileName = $databaseName . '-backup-' . date('Y-m-d_H-i-s') . '.sql';
    $handle = fopen($path.$fileName,'w+');
    $is_write=fwrite($handle,$return);    
    fclose($handle);
    if($is_write)
    {
      $data['file_name']=str_replace(".sql",'', $fileName);
      $data['file_size']=filesize($path.$fileName);
      $data['file_path']=$path.$fileName;
      $data['date']=date('Y-m-d h:i:s');

      $check=$this->Backup_restor->save($data);
      if($check){
         $this->Session->setFlash('Your Backup saved Successfully', 'default', array(), 'msg');
         $this->redirect('/admin/backuprestor');
         exit();
      }
    }
    // Serve the file as a download
    //$this->rander('ajax');
   $this->autoRender = false;
    /*$this->response->type('Content-Type: text/x-sql');
    $this->response->download($fileName);
    $this->response->body($return);*/
}

  public function restoreDb($id){
        $back_data=$this->Backup_restor->find('first',array('conditions'=>array('id'=>$id)));
        //print_r($back_data);
        App::import('Vendor', 'databaseImporter');
        $filename  =  $back_data['Backup_restor']['file_path']; // Filename of dump, default: dump.sql
        $compress  = false; // Import gz compressed file, default: false
        App::import('Model', 'ConnectionManager');
        $con = new ConnectionManager;
        $cn = $con->getDataSource('default');
        //$connection = @mysql_connect($dbhost,$dbuser,$dbpass);
         $dump = new phpMyImporter($cn,$filename,$compress);

         $dump->utf8 = true; // Uses UTF8 connection with MySQL server, default: true

         $check=$dump->doImport();
         if($check)
         {
            $this->Session->setFlash('Your Backup Restored Successfully', 'default', array(), 'msg');
            $this->redirect('/admin/backuprestor');
            exit();
         }
         $this->autoRender = false;
  }
  public function downloadDbBackups($id) {
     $back_data=$this->Backup_restor->find('first',array('conditions'=>array('id'=>$id)));
      $this->viewClass = 'Media';
      // Render app/webroot/files/example.docx
      $params = array(
          'id'        => $back_data['Backup_restor']['file_name'].".sql",
          'name'      => $back_data['Backup_restor']['file_name'],
          'extension' => 'sql',
          'mimeType'  => array(
              'docx' => 'application/octet-stream'
          ),
          'path'      => 'backup' . DS
      );
      $this->set($params);
  }
  public function ajax_add_category_name($cat_id){
    $this->layout="ajax";
    $dbval=$this->request->data;
    /*print_r($dbval);
    echo $cat_id;*/
    //$this->Product_category_lang->id=""
   // echo $dbval['txt'];
    try{
    $check=$this->Product_category->Product_category_lang->updateAll(
    array('Product_category_lang.category_name' => "'".$dbval['txt']."'"),
    array('Product_category_lang.cat_id' => $cat_id,'Product_category_lang.lang_id' =>  $dbval['lang'])
    );
    }
    catch (Exception $e) {
    //echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
    if($check)
    {
      echo "1";
    }
    $this->render('ajax');
  }
   public function update_order_ajax(){
    $this->layout="ajax";
     $dbval=$this->request->data;
     //print_r($dbval);
     extract($dbval);
     $dataCount=0;
    // print_r($cat_li);
     if(isset($cat_li))
     {

     foreach ($cat_li as $key => $value) {
      //echo $value;
      /*$check=$this->Product_category->updateAll(
        array('Product_category.cat_order'=>($key+1),'Product_category.parent_id'=>$parent),
        array('Product_category.id'=>$value) 
        );*/
      $this->Product_category->clear();
      $this->Product_category->id = $value; // id of Extreme fishing
      $newParentId = $this->Product_category->field(
        'id',
        array('id' => $parent)
      );

      $check=$this->Product_category->save(array('parent_id' => $newParentId,'cat_order'=>($key+1)));
     
      if($check)
      {
        $dataCount++;
      }

     }

     if($dataCount!=0)
     {
     
      echo 1;
     }
     }
     $this->render('ajax');

   }
   public function ajax_add_cat_by_parent(){
    $this->layout="ajax";
    $dbval=$this->request->data;
    //print_r($dbval);
    extract($dbval);
     $slug=$this->toAscii($catname);
                  
                   $validate=$this->Product_category->find('all',array('conditions'=>array('Product_category.slug LIKE'=>$slug."%")));
                  
                   if(!empty($validate))
                   {
                     $slug=$slug.(count($validate)+1);
                     
                  }
                   $value['slug']=$slug;
                   $value['parent_id']=$pid;
                   $value['status']=1;
                   $check=$this->Product_category->save($value);
                   $fcatid= $this->Product_category->id;
                  if($check){
                      $value1['category_name']=$catname;
                      $value1['cat_id']=$fcatid;
                      $value1['lang_id']=1;
                      $value1['status']=1;
                       $this->loadmodel('Product_category_lang'); 
                       $check=$this->Product_category_lang->save($value1);
                       if($check)
                       {
                       // $this->Product_category->recover();
                        echo 1;
                       }
                    // $this->Session->setFlash('Product Category Added Successfully!', 'default', array(), 'msg');
                  }

    $this->render('ajax');
   }
   public function ajax_delete_cat(){
     $this->layout="ajax";
    $dbval=$this->request->data;
    extract($dbval);
     $check=$this->Product_category->delete(array('id'=>$pid));
                    if($check)
                    {
                      echo 1;
                    }
                    $this->render('ajax');
   }
    public function visitors_report(){
       $this->set('menu_title','Visitors Report');
       $this->set('inner_section_name','Visitors Count By Products');
       //$data['products']=$this->Unique_visitor->find('all',);
       $this->Paginator->settings = array(
        'fields'=>array('DISTINCT unique_id','count(unique_id) as vcount','Product.*'),
        'group'=>array('product_id'),
        'limit' => 20
           );
          $this->set('visitors', $this->paginate('Unique_visitor'));
       //$this->set($data);
    }
   private function getCURLData($url)
{

  //$url = "https:<somesite/page";

// In this example we are referring to a page that handles xml
//$headers = array( "Content-Type: text/html",);

// Initialise Curl
$curl = curl_init();
if ($curl === false)
{
    throw new Exception(' cURL init failed');
}

// Configure curl for website
curl_setopt($curl, CURLOPT_URL, $url);

// Set up to view correct page type
//curl_setopt($curl, CURLOPT_HTTPHEADER, &$headers);

// Turn on SSL certificate verfication
//curl_setopt($curl, CURLOPT_CAPATH, plugin_dir_path(__FILE__)."cacert.pem");
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, TRUE);

// Tell the curl instance to talk to the server using HTTP POST
//curl_setopt($curl, CURLOPT_POST, 1);

// 1 second for a connection timeout with curl
//curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);

// Try using this instead of the php set_time_limit function call
curl_setopt($curl, CURLOPT_TIMEOUT, 60);

// Causes curl to return the result on success which should help us avoid using the writeback option
//curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

return $result = curl_exec($curl);

curl_close($curl);
}
    public function traslateBygoogleApi(){
      ini_set('max_execution_time','1000');
      /*$this->layout="ajax";
      $key="AIzaSyBN5a7s2sgYbnc0ZGSV7vMipI4XKVIuLL8";
      $this->Product_category->recursive=-1;
      App::import('Vendor', 'languageTranslater');

      $yourApiKey = $key; 
      $sourceData = "Helo How r u??";
      $source = 'en';       
      $target = 'ar';       
      $translator = new LanguageTranslator($yourApiKey);       
      $targetData = $translator->translate($sourceData,$target,$source);*/

    $productCategory=$this->Product_category->find('all',array('fields'=>array('(Select category_name from mc_product_category_langs  where cat_id=Product_category.id ) as cat_name'),'conditions'=>array('(select count(*) from mc_product_category_langs where cat_id=Product_category.id )'=>1)));
    //echo "<pre>";print_r($productCategory); echo "</pre>";
     // $url="https://www.googleapis.com/language/translate/v2?key=".$key."&source=en&target=ar&q=Hello%20world";
    // $ret=$this->getCURLData($url);
      //Einbinden der Translate-Klasse.
//require_once('translate.class.php');
App::import('Vendor', 'tarnslate');

      //Objekt des Translators erzeugen.
      //Parameter 1: Anwendungs-ID der registrierten Anwendung.
      //Parameter 2: Anwendungsschluessel der registrierten Anwendung.
$BingTranslator = new BingTranslator('hoppaytranslate', 'J9KITue9soonKlBt7JIOg52sOplmmJuZKKSCZa5Mo/M=');
 foreach ($productCategory as $key => $value) {
  $translation = $BingTranslator->getTranslation('en', 'ar', $value[0]['cat_name']);
  //$translation=$value[0]['cat_name'];
  $data['lang_id']=2;
  $data['category_name']=htmlspecialchars($translation);
  $data['status']=1;
  $data['cat_id']=$value['Product_category']['id'];
  //echo "<pre>";print_r($data);echo "</pre>";
  $this->Product_category->Product_category_lang->clear();
  $check=$this->Product_category->Product_category_lang->save($data);
  if($check)
  {
    echo "<b>Success <b><br>";
    echo "----------------------- <br>";
    echo "<pre>";print_r($data);echo "</pre>";
  }
  else
  {
    echo "<b style='color:#f00'>Failed</b> <br>";
    echo "----------------------- <br>";
    echo "<pre>";print_r($data);echo "</pre>";
  }
 }
//Uebersetzen eines Worts.
/////
 
//Ausgeben des uebersetzten Worts (Hallo).
/////echo $translation;
    // print_r($targetData);
       $this->render('ajax');
    }
    function send_mail(){
      $this->layout="ajax";
      $data=$this->request->data;
      echo $this->Ctrl->sendMail($data['toemail'],$data['subject'],nl2br($data['description']),$data['fromemail']);
      $this->render('ajax');
    }
  }
