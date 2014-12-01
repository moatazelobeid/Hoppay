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
  class NewsletterController extends AppController {
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
    public $uses = array('Faq_category','Tagline','faq_lang','Banner','Faq_category_lang','faq','Merchant_login','Merchant','Language','Email_template','Newsletter','Setting','Scheduled_email');
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
     }


		public function admin_index()
		{
			$this->set(array(
				'menu_title'=>'Newsletter Manager',
				'inner_section_name'=>'Subscriber List',              
			)); 
			
			$condition=$this->request['url'];
			extract($condition);
			//$lang_id=isset($lang_id)?$lang_id:1;
			$text_search=isset($text_search)?$text_search:"";
			// echo $status;
			$this->Paginator->settings = array(
				'conditions' => array('Newsletter.email_id LIKE' => '%'.$text_search.'%',(isset($stype) and $stype!="")?'Newsletter.stype':'Newsletter.stype not '=>isset($stype)?$stype:NULL
				,(isset($status) and $status!="")?'Newsletter.status':'Newsletter.status not '=>isset($status)?$status:NULL),
				'limit' => 20
			);
			$this->set('subscriber_list', $this->paginate('Newsletter'));
		}
		
		public function admin_update($id="")
		{
			$this->set('menu_title','Update Subscriber');
			$this->set('admin_button','Update'); 
			if($this->request->is('post'))
			{
            	$data=$this->request->data;
					$check=$this->Newsletter->save($data);
			}
		}
		
		 public function admin_delete($id)
		 {
			 $this->loadmodel('Newsletter');
			 $check=$this->Newsletter->delete(array('id'=>$id));
			   if($check)
				  {
					$this->Session->setFlash('Successfully Deleted! ', 'default', array(), 'msg');
					$this->redirect('/admin/newsletter/');
					exit();
				  }
		 }
		 
		public function admin_email_template()
		{
			$this->set(array(
				'menu_title'=>'Email Template Manager',
				'inner_section_name'=>'Email Template List',              
			)); 
			
			$condition=$this->request['url'];
			extract($condition);
			//$lang_id=isset($lang_id)?$lang_id:1;
			$text_search=isset($text_search)?$text_search:"";
			// echo $status;
			$this->Paginator->settings = array(
				'conditions' => array((isset($status) and $status!="")?'Email_template.status':'Email_template.status not '=>isset($status)?$status:NULL,
				'OR' => array('Email_template.email_subject LIKE' => '%'.$text_search.'%','Email_template.email_body LIKE' => '%'.$text_search.'%')),
				'limit' => 20
			);
			$this->set('email_template_list', $this->paginate('Email_template'));
		}
		
		public function admin_add_email_template()
		{
			$this->set('menu_title','Add Email Template');
			$this->set('admin_button','Create'); 
			if($this->request->is('post'))
			{
            	$data=$this->request->data; 
				//print_r($data);
				$data['created_date'] = date('Y-m-d H:i:s');
				$check=$this->Email_template->save($data);
				
				$this->Session->setFlash('Email Template Added Successfully!', 'default', array(), 'msg');
			} 
		}
		
		public function admin_update_email_template($id="")
		{
			$this->set('menu_title','Update Email Template');
			$this->set('admin_button','Update'); 
			
			
			if($this->request->is('post'))
			{
            	$data=$this->request->data;
				$check=$this->Email_template->save($data);
				//print_r($data);
				$this->Session->setFlash('Email Template Updated Successfully!', 'default', array(), 'msg');
			}
			
			$check=$this->Email_template->find('first',array('conditions'=>array('Email_template.id'=>$id)));
			$this->set('temp_data',$check['Email_template']);

		}
		
		 public function admin_delete_template($id)
		 {
			 $this->loadmodel('Email_template');
			 $check=$this->Email_template->delete(array('id'=>$id));
			   if($check)
				  {
					$this->Session->setFlash('Successfully Deleted! ', 'default', array(), 'msg');
					$this->redirect('/admin/email_template/');
					exit();
				  }
		 }
		 
		 function admin_send_bulk_email()
		 {
			$this->set('menu_title','Send Bulk Email');
			$this->set('admin_button','Send'); 
			
			$user_list=$this->Newsletter->find('all',array('conditions'=>array('Newsletter.stype'=>'User','Newsletter.status'=>'1')));
			$this->set('user_list',$user_list);
			
			$merchant_list=$this->Newsletter->find('all',array('conditions'=>array('Newsletter.stype'=>'Merchant','Newsletter.status'=>'1')));
			$this->set('merchant_list',$merchant_list);
			
			$email_templates=$this->Email_template->find('all',array('conditions'=>array('Email_template.status'=>'1')));
			$this->set('email_templates',$email_templates);
			
			//get from email id
			$config_settings=$this->Setting->find('all',array('conditions' => array('Setting.id' =>'1')));
			
			$from_email = $config_settings[0]['Setting']['site_email'];
			
			//send bulk email
			if($this->request->is('post'))
			{
				$data=$this->request->data;
				
				$user_type = '';
				
				if($data['group'] == 1)
				{
					$email_list=$this->Newsletter->find('all',
							array(
							'conditions'=>array('Newsletter.status'=>'1')));
							
					if(!empty($email_list))
					{
						$i = 0; $emails = '';
						foreach($email_list as $email_id)
						{
							$emails[$i] = $email_id['Newsletter']['id'];
							$i++;
						}	
					}		
							
				}
				if($data['group'] == 2)
				{
					$user_type = 'User';
					
					if(in_array('All',$data['user_id']))
					{
						$email_list=$this->Newsletter->find('all',
								array(
								'fields' => array(email_id),
								'conditions'=>array('Newsletter.stype'=>'User','Newsletter.status'=>'1')));
						
						if(!empty($email_list))
						{
							$i = 0; $emails = '';
							foreach($email_list as $email_id)
							{
								$emails[$i] = $email_id['Newsletter']['email_id'];
								$i++;
							}	
						}		
					}
					else
					{
						$emails = $data['user_id'];
					}
				}
				if($data['group'] == 3)
				{
					$user_type = 'Merchant';
					
					if(in_array('All',$data['merchant_id']))
					{
						$email_list=$this->Newsletter->find('all',
								array(
								'fields' => array(email_id),
								'conditions'=>array('Newsletter.stype'=>'Merchant','Newsletter.status'=>'1')));
					
						if(!empty($email_list))
						{
							$i = 0; $emails = '';
							foreach($email_list as $email_id)
							{
								$emails[$i] = $email_id['Newsletter']['email_id'];
								$i++;
							}	
						}		
					
					}
					else
					{
						$emails = $data['merchant_id'];
					}
				}
				
				if(!empty($emails))
				{
					//$email = implode(', ',$emails);
					
					$subject = $data['email_subject'];
					$email_body = $data['email_body'];
					$email_temp = $data['email_temp'];
					
					$email_templates = $this->Email_template->find('first',array('conditions'=>array('Email_template.id'=>$email_temp)));
					
					$email_content = stripslashes($email_templates['Email_template']['email_body']);
					
					$content=ereg_replace('{content}',$email_body,$email_content);
					
					$success_count = 0;
					$failed_count = 0;
					
					foreach($emails as $email)
					{
						
						if(empty($user_type))
						{
							$user_detail = $this->Ctrl->getUserType($email);
							
							//echo '<pre>'; print_r($user_detail); echo '</pre>';
							
							$user_type = $user_detail['stype'];
							$email = $user_detail['email_id'];
						}
						else
						{
							$to_email = $email;
						}
						$content=ereg_replace('{user_type}',$user_type,$content);
						
						$email_status = $this->Ctrl->sendMail($email,$subject,$content,$from_email);
					
						if($email_status == 1)
						{
							$success_count ++;
						}
						else
						{
							$failed_count++;	
						}
					}
					
					$msg = 'Bulk Email Status: '.$success_count.' success and '.$failed_count.' failed.';
					
					$this->Session->setFlash($msg, 'default', array(), 'msg');	
					//$check=$this->Email_template->save($data);
				}
			}
		 }
		 
		 function admin_set_schedule_email()
		 {
			$this->set('menu_title','Set Schedule Email');
			$this->set('admin_button','Set'); 
			
			$user_list=$this->Newsletter->find('all',array('conditions'=>array('Newsletter.stype'=>'User','Newsletter.status'=>'1')));
			$this->set('user_list',$user_list);
			
			$merchant_list=$this->Newsletter->find('all',array('conditions'=>array('Newsletter.stype'=>'Merchant','Newsletter.status'=>'1')));
			$this->set('merchant_list',$merchant_list);
			
			$email_templates=$this->Email_template->find('all',array('conditions'=>array('Email_template.status'=>'1')));
			$this->set('email_templates',$email_templates);
			
			//get from email id
			$config_settings=$this->Setting->find('all',array('conditions' => array('Setting.id' =>'1')));
			
			$from_email = $config_settings[0]['Setting']['site_email'];
			
			//send bulk email
			if($this->request->is('post'))
			{
				$data=$this->request->data;
				
				$user_type = '';
				$email_data = '';
				if($data['group'] == 1)
				{
					
					$email_data['user_group'] = $data['group'];
					$email_data['email_subject'] = $data['email_subject'];
					$email_data['email_body'] = $data['email_body'];
					$email_data['email_temp'] = $data['email_temp'];
					$email_data['schedule_time'] = $data['schedule_time'];
					$email_data['created_date'] = date('Y-m-d H:i:s');
					$email_data['status'] = $data['status'];

					$this->Scheduled_email->save($email_data);
							
				}
				if($data['group'] == 2)
				{
					$user_type = 'User';
					
					if(in_array('All',$data['user_id']))
					{
						/*$email_list=$this->Newsletter->find('all',
								array(
								'fields' => array(email_id),
								'conditions'=>array('Newsletter.stype'=>'User','Newsletter.status'=>'1')));
						
						if(!empty($email_list))
						{
							$i = 0; $emails = '';
							foreach($email_list as $email_id)
							{
								$emails[$i] = $email_id['Newsletter']['email_id'];
								$i++;
							}	
						}*/	
						
						$email_data['user_group'] = $data['group'];
						$email_data['email_id'] = 'All';
						$email_data['email_subject'] = $data['email_subject'];
						$email_data['email_body'] = $data['email_body'];
						$email_data['email_temp'] = $data['email_temp'];
						$email_data['schedule_time'] = $data['schedule_time'];
						$email_data['created_date'] = date('Y-m-d H:i:s');
						$email_data['status'] = $data['status'];

						$this->Scheduled_email->save($email_data);
							
					}
					else
					{
						$emails = $data['user_id'];
						
						$email_data['user_group'] = $data['group'];
						$email_data['email_id'] = implode(',',$emails);
						$email_data['email_subject'] = $data['email_subject'];
						$email_data['email_body'] = $data['email_body'];
						$email_data['email_temp'] = $data['email_temp'];
						$email_data['schedule_time'] = $data['schedule_time'];
						$email_data['created_date'] = date('Y-m-d H:i:s');
						$email_data['status'] = $data['status'];

						$this->Scheduled_email->save($email_data);
					}
				}
				if($data['group'] == 3)
				{
					$user_type = 'Merchant';
					
					if(in_array('All',$data['merchant_id']))
					{
					/*	$email_list=$this->Newsletter->find('all',
								array(
								'fields' => array(email_id),
								'conditions'=>array('Newsletter.stype'=>'Merchant','Newsletter.status'=>'1')));
					
						if(!empty($email_list))
						{
							$i = 0; $emails = '';
							foreach($email_list as $email_id)
							{
								$emails[$i] = $email_id['Newsletter']['email_id'];
								$i++;
							}	
						}*/		
						
						
						$email_data['user_group'] = $data['group'];
						$email_data['email_id'] = 'All';
						$email_data['email_subject'] = $data['email_subject'];
						$email_data['email_body'] = $data['email_body'];
						$email_data['email_temp'] = $data['email_temp'];
						$email_data['schedule_time'] = $data['schedule_time'];
						$email_data['created_date'] = date('Y-m-d H:i:s');
						$email_data['status'] = $data['status'];

						$this->Scheduled_email->save($email_data);
					
					}
					else
					{
						$emails = $data['merchant_id'];
						
						$email_data['user_group'] = $data['group'];
						$email_data['email_id'] = implode(',',$emails);
						$email_data['email_subject'] = $data['email_subject'];
						$email_data['email_body'] = $data['email_body'];
						$email_data['email_temp'] = $data['email_temp'];
						$email_data['schedule_time'] = $data['schedule_time'];
						$email_data['created_date'] = date('Y-m-d H:i:s');
						$email_data['status'] = $data['status'];

						$this->Scheduled_email->save($email_data);
					
					}
				}
				/*if(!empty($emails))
				{
					//$email = implode(', ',$emails);
					
					$subject = $data['email_subject'];
					$email_body = $data['email_body'];
					$email_temp = $data['email_temp'];
					
					$email_templates = $this->Email_template->find('first',array('conditions'=>array('Email_template.id'=>$email_temp)));
					
					$email_content = stripslashes($email_templates['Email_template']['email_body']);
					
					$content=ereg_replace('{content}',$email_body,$email_content);
					
					$success_count = 0;
					$failed_count = 0;
					
					//$msg = 'Bulk Email Status: '.$success_count.' success and '.$failed_count.' failed.';
					$msg = 'Scheduled email set successfully.';
					$this->Session->setFlash($msg, 'default', array(), 'msg');	
					//$check=$this->Email_template->save($data);
				}*/
				
				$this->Session->setFlash('Schedule Email is Set Successfully! ', 'default', array(), 'msg');
			}
		 }
		
		 function admin_update_schedule_email($id)
		 {
			$this->set('menu_title','Update Schedule Email');
			$this->set('admin_button','Update'); 
			
			$user_list=$this->Newsletter->find('all',array('conditions'=>array('Newsletter.stype'=>'User','Newsletter.status'=>'1')));
			$this->set('user_list',$user_list);
			
			$merchant_list=$this->Newsletter->find('all',array('conditions'=>array('Newsletter.stype'=>'Merchant','Newsletter.status'=>'1')));
			$this->set('merchant_list',$merchant_list);
			
			$email_templates=$this->Email_template->find('all',array('conditions'=>array('Email_template.status'=>'1')));
			$this->set('email_templates',$email_templates);
			
			//get from email id
			$config_settings=$this->Setting->find('all',array('conditions' => array('Setting.id' =>'1')));
			
			$from_email = $config_settings[0]['Setting']['site_email'];
			
			//send bulk email
			if($this->request->is('post'))
			{
				$data=$this->request->data;
				
				$user_type = '';
				$email_data = '';
				
				$email_data['id'] = $data['id'];
				
				if($data['group'] == 1)
				{
					
					$email_data['user_group'] = $data['group'];
					$email_data['email_subject'] = $data['email_subject'];
					$email_data['email_body'] = $data['email_body'];
					$email_data['email_temp'] = $data['email_temp'];
					$email_data['schedule_time'] = $data['schedule_time'];
					$email_data['created_date'] = date('Y-m-d H:i:s');
					$email_data['status'] = $data['status'];

					$this->Scheduled_email->save($email_data);
							
				}
				if($data['group'] == 2)
				{
					$user_type = 'User';
					
					if(in_array('All',$data['user_id']))
					{
						/*$email_list=$this->Newsletter->find('all',
								array(
								'fields' => array(email_id),
								'conditions'=>array('Newsletter.stype'=>'User','Newsletter.status'=>'1')));
						
						if(!empty($email_list))
						{
							$i = 0; $emails = '';
							foreach($email_list as $email_id)
							{
								$emails[$i] = $email_id['Newsletter']['email_id'];
								$i++;
							}	
						}*/	
						
						$email_data['user_group'] = $data['group'];
						$email_data['email_id'] = 'All';
						$email_data['email_subject'] = $data['email_subject'];
						$email_data['email_body'] = $data['email_body'];
						$email_data['email_temp'] = $data['email_temp'];
						$email_data['schedule_time'] = $data['schedule_time'];
						$email_data['created_date'] = date('Y-m-d H:i:s');
						$email_data['status'] = $data['status'];

						$this->Scheduled_email->save($email_data);
							
					}
					else
					{
						$emails = $data['user_id'];
						
						$email_data['user_group'] = $data['group'];
						$email_data['email_id'] = implode(',',$emails);
						$email_data['email_subject'] = $data['email_subject'];
						$email_data['email_body'] = $data['email_body'];
						$email_data['email_temp'] = $data['email_temp'];
						$email_data['schedule_time'] = $data['schedule_time'];
						$email_data['created_date'] = date('Y-m-d H:i:s');
						$email_data['status'] = $data['status'];

						$this->Scheduled_email->save($email_data);
					}
				}
				if($data['group'] == 3)
				{
					$user_type = 'Merchant';
					
					if(in_array('All',$data['merchant_id']))
					{
					/*	$email_list=$this->Newsletter->find('all',
								array(
								'fields' => array(email_id),
								'conditions'=>array('Newsletter.stype'=>'Merchant','Newsletter.status'=>'1')));
					
						if(!empty($email_list))
						{
							$i = 0; $emails = '';
							foreach($email_list as $email_id)
							{
								$emails[$i] = $email_id['Newsletter']['email_id'];
								$i++;
							}	
						}*/		
						
						
						$email_data['user_group'] = $data['group'];
						$email_data['email_id'] = 'All';
						$email_data['email_subject'] = $data['email_subject'];
						$email_data['email_body'] = $data['email_body'];
						$email_data['email_temp'] = $data['email_temp'];
						$email_data['schedule_time'] = $data['schedule_time'];
						$email_data['created_date'] = date('Y-m-d H:i:s');
						$email_data['status'] = $data['status'];

						$this->Scheduled_email->save($email_data);
					
					}
					else
					{
						$emails = $data['merchant_id'];
						
						$email_data['user_group'] = $data['group'];
						$email_data['email_id'] = implode(',',$emails);
						$email_data['email_subject'] = $data['email_subject'];
						$email_data['email_body'] = $data['email_body'];
						$email_data['email_temp'] = $data['email_temp'];
						$email_data['schedule_time'] = $data['schedule_time'];
						$email_data['created_date'] = date('Y-m-d H:i:s');
						$email_data['status'] = $data['status'];

						$this->Scheduled_email->save($email_data);
					
					}
				}
				/*if(!empty($emails))
				{
					//$email = implode(', ',$emails);
					
					$subject = $data['email_subject'];
					$email_body = $data['email_body'];
					$email_temp = $data['email_temp'];
					
					$email_templates = $this->Email_template->find('first',array('conditions'=>array('Email_template.id'=>$email_temp)));
					
					$email_content = stripslashes($email_templates['Email_template']['email_body']);
					
					$content=ereg_replace('{content}',$email_body,$email_content);
					
					$success_count = 0;
					$failed_count = 0;
					
					//$msg = 'Bulk Email Status: '.$success_count.' success and '.$failed_count.' failed.';
					$msg = 'Scheduled email set successfully.';
					$this->Session->setFlash($msg, 'default', array(), 'msg');	
					//$check=$this->Email_template->save($data);
				}*/
				
				$this->Session->setFlash('Schedule Email Updated Successfully! ', 'default', array(), 'msg');
			}
			
			
			$check=$this->Scheduled_email->find('first',array('conditions'=>array('Scheduled_email.id'=>$id)));
			$this->set('semail_data',$check['Scheduled_email']);

			
			
			
		 }
		
		
		
	function admin_schedule_email_list()
	{
			$this->set(array(
				'menu_title'=>'Schedule Email List',
				'inner_section_name'=>'Schedule Email List',              
			)); 
			
			$condition=$this->request['url'];
			extract($condition);
			//$lang_id=isset($lang_id)?$lang_id:1;
			$text_search=isset($text_search)?$text_search:"";
			// echo $status;
			$this->Paginator->settings = array(
				'conditions' => array((isset($status) and $status!="")?'Scheduled_email.status':'Scheduled_email.status not '=>isset($status)?$status:NULL,
				'OR' => array('Scheduled_email.email_subject LIKE' => '%'.$text_search.'%','Scheduled_email.email_body LIKE' => '%'.$text_search.'%')),
				'limit' => 20
			);
			$this->set('email_list', $this->paginate('Scheduled_email'));
	}
		
		 public function delete_schedule_email($id)
		 {
			 $this->loadmodel('Scheduled_email');
			 $check=$this->Scheduled_email->delete(array('id'=>$id));
			   if($check)
				  {
					$this->Session->setFlash('Successfully Deleted! ', 'default', array(), 'msg');
					$this->redirect('/admin/schedule_email_list/');
					exit();
				  }
		 }
		 
   }