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
class MenuController extends AppController {
 public $helpers = array('Html', 'Form','Session','Paginator','Fck','Template');
 public $components = array('Session','Paginator','Cookie','Ctrl');
   public $paginate = array(
        'fields' => array('User.id', 'User.created'),
        'limit' => 25,
        'order' => array(
            'User.id' => 'desc'
        )
    );
 public $sitetitle="Menacompare";
 //public $pagina_show=10;
 public $userid;

 
/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array('Menu','Menu_lang','Page','Language','Menu_position');
    public $urlgen="";
/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 * @throws NotFoundException When the view file could not be found
 *	or MissingViewException in debug mode.
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
         $this->loadModel('Setting');
    $config_settings=$this->Setting->find('all',array('conditions' => array('Setting.id' =>'1')));
    $this->set("setting",$config_settings[0]);  
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
      private function cont_list() {
        $aControllers = $this->Ctrl->get();
       return $aControllers;
      }
     public function admin_index(){

      $this->set(array(
              'menu_title'=>'Menu Manager',
              'inner_section_name'=>'Menu List',              
              ));   

           $condition=$this->request['url'];
            extract($condition);
        $lang_id=isset($lang_id)?$lang_id:1;
        $text_search=isset($text_search)?$text_search:"";
       // echo $status;
       $this->Paginator->settings = array(
            'conditions' => array('Menu_lang.menu_title LIKE' => '%'.$text_search.'%','Menu_lang.lang_id'=>$lang_id,(isset($status) and $status!="")?'Menu.status':'Menu.status not '=>isset($status)?$status:NULL),
            'limit' => 20,
             'order' => 'Menu.lft ASC'
         );
       $data=$this->paginate('Menu.Menu_lang');
        
        $val_data=$this->Menu->generateTreeList(null,null,null,'&lt;span style=&quot;color:#DDCBCB&quot;&gt;___&lt;/span&gt;'); 
         foreach($data as $key=>$val)
            {
               $data[$key]['Menu_lang']['menu_title']= htmlspecialchars_decode( str_replace($val['Menu']['id'], $val['Menu_lang']['menu_title'], $val_data[$val['Menu']['id']]));
            }
            $this->set('menu_info',$data );
         $lang=$this->Language->find('all');
         $this->set('lang', $lang);
     /* echo "<pre>";
        $this->cont_list();
      echo "</pre>";*/
     }

     public function admin_add(){
        $this->set('menu_title','Add menu');
        $this->set('admin_button','Create'); 
        if($this->request->is('post')){
            $data=$this->request->data;
           // echo "<pre>";print_r($data);echo "</pre>";
            /*$che_slug=$this->Menu->find('first',array('conditions'=>array('slug'=>$data['slug'],'menu_position_id'=>$data['menu_position_id'])))
            if(!empty($che_slug))
            {
               $this->Session->setFlash('Page added Successfully!', 'default', array(), 'bad');
            }*/
            $data['parent_id']=($data['parent_id']=="")?0:$data['parent_id'];
             $data['menu_access']=($data['menu_access']=="")?0:$data['menu_access'];
            
            $data1['lang_id']=1;
            $data1['menu_title']=trim(strip_tags($data['menu_title']));
            unset($data['menu_title']);
            $check=$this->Menu->save($data);
            if($check)
            {
               $data1['menu_id']=$this->Menu->id;
                 $check1=$this->Menu->Menu_lang->save($data1);
                 if($check1)
                 {
                  $this->Session->setFlash('Menu added Successfully!', 'default', array(), 'msg');
                 }

            }
        }
        $this->set('controllers',$this->cont_list()); 
        $pages=$this->Page->Page_lang->find('all',array('conditions'=>array('lang_id'=>1)));
        $this->set('pages',$pages);
        $position=$this->Menu_position->find('all');
        $this->set('position',$position);
        $final=array();
        $treelist = $this->Menu->generateTreeList();             
            foreach( $treelist as $key=>$val){
                 $menu_details= $this->Menu->Menu_lang->find('all',array('conditions'=>array('menu_id'=>$key,'lang_id'=>1)) );
                 $final[$key]=str_replace($key, $menu_details[0]['Menu_lang']['menu_title'], $val);
            }
       $this->set('menu_parent_names', $final);

     }
     public function admin_update($id=""){
      //echo $id;
      $this->set('menu_title','Update menu');
      $this->set('admin_button','Update'); 
      if($this->request->is('post')){
            $data=$this->request->data;          
            $data['parent_id']=($data['parent_id']=="")?0:$data['parent_id'];
            $data['menu_access']=($data['menu_access']=="")?0:$data['menu_access']; 
            $data1['menu_title']=trim(strip_tags($data['menu_title']));

            unset($data['menu_title']);
            $this->Menu->id=$id;  
            $check=$this->Menu->save($data);
            if($check)
            {
               $data1['menu_id']=$id;
               $data1['id']=$data['menu_lang_id'];
               $check1=$this->Menu->Menu_lang->save($data1);
               if($check1)
                {
                  $this->Session->setFlash('Menu Updated Successfully!', 'default', array(), 'msg');
                }
                else
                {
                  $this->Session->setFlash('Menu not updated Successfully!', 'default', array(), 'bad');
                }
            }else
            {
              $this->Session->setFlash('Menu not updated ! Please try again', 'default', array(), 'bad');
            }
        }
      $lang=$this->Language->find('all');
      $this->set('lang', $lang);
       $position=$this->Menu_position->find('all');
        $this->set('position',$position);
      $this->set('controllers',$this->cont_list()); 
      $pages=$this->Page->Page_lang->find('all',array('conditions'=>array('lang_id'=>1)));
      $this->set('pages',$pages);
      $data=$this->Menu->find('first',array('conditions'=>array('Menu.id'=>$id)));
      $this->set('menu_info',$data);
        $final=array();

        $treelist = $this->Menu->generateTreeList();      
        // print_r($treelist);       
            foreach( $treelist as $key=>$val){
                 $menu_details= $this->Menu->Menu_lang->find('all',array('conditions'=>array('menu_id'=>$key,'lang_id'=>1)) );
               
                 $final[$key]=str_replace($key, $menu_details[0]['Menu_lang']['menu_title'], $val);
            }
      $this->set('menu_parent_names', $final);
      $this->render('admin_add');

     }
     public function admin_delete($id){
         $check=$this->Menu->delete(array('id'=>$id));
           if($check)
              {
                $this->Session->setFlash('Successfully Deleted! ', 'default', array(), 'msg');
                $this->redirect('/admin/menu/');
                exit();
              }
     }
     public function admin_position($slug="",$id=""){

      if($slug=="add")
        {
           $this->set('menu_title','Add menu');
           $this->set('admin_button','Create'); 
           if($this->request->is('post'))
           {
            $data=$this->request->data;
            $data['title']=strip_tags(trim($data['title']));
            $data['slug']=strip_tags(trim($data['slug'],'-'));
            $data['date_updated']=date('Y-m-d');
            $check_slug=$this->Menu_position->find('first',array('conditions'=>array('slug'=>$data['slug'])));
            if(empty($check_slug)){
              $check=$this->Menu_position->save($data);
              if($check)
              {
                $this->Session->setFlash('Successfully Added! ', 'default', array(), 'msg');
                $this->redirect('/admin/menu/position/add');
                exit();
              }
            }else
            {
               $this->Session->setFlash('You have not enter any duplicate name here.', 'default', array(), 'bad');
            }
               
           }
           $this->render('admin_position_add');
        }
        else if($slug=="update"){
           $this->set('menu_title','Update menu');
           $this->set('admin_button','Update'); 
           $datas=$this->Menu_position->find('first',array('conditions'=>array('id'=>$id)));
           $this->set('menu_position_data',$datas);
           if($this->request->is('post')){
            $data=$this->request->data;
            $data['title']=strip_tags(trim($data['title']));
            $data['slug']=strip_tags(trim($data['slug'],'-'));
            $data['date_updated']=date('Y-m-d');
            $check_slug=$this->Menu_position->find('first',array('conditions'=>array('slug'=>$data['slug'],'id !='=>$id)));
            if(empty($check_slug)){
              $this->Menu_position->id=$id;
              $check=$this->Menu_position->save($data);
              if($check)
              {
                $this->Session->setFlash('Successfully Updated! ', 'default', array(), 'msg');
                $this->redirect('/admin/menu/position/list');
                exit();
              }
            }else
            {
               $this->Session->setFlash('Please Enter a unique name here', 'default', array(), 'bad');
            }
           }

           $this->render('admin_position_add');
        }
        else if($slug=="delete")
        {
          $check=$this->Menu_position->delete(array('id'=>$id));
           if($check)
              {
                $this->Session->setFlash('Successfully Deleted! ', 'default', array(), 'msg');
                $this->redirect('/admin/menu/position/list');
                exit();
              }
        }
        else if($slug=="list")
        {
             $this->set(array(
              'menu_title'=>'Menu Position Manager',
              'inner_section_name'=>'Menu Position List',              
              ));  
           $condition=$this->request['url'];
            extract($condition);
        $lang_id=isset($lang_id)?$lang_id:1;
        $text_search=isset($text_search)?$text_search:"";
       // echo $status;
       $this->Paginator->settings = array(
            'conditions' => array('Menu_position.title LIKE' => '%'.$text_search.'%',(isset($status) and $status!="")?'Menu_position.status':'Menu_position.status not '=>isset($status)?$status:NULL),
            'limit' => 5
         );
        $this->set('position_data', $this->paginate('Menu_position'));
          // $this->set('position_data',$data);
        }

     }
}