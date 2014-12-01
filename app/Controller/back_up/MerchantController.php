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
class MerchantController extends AppController {
public $helpers = array('Html', 'Form','Session','Paginator','Fck','Template');
 public $components = array('Session','Paginator','Cookie','RequestHandler');
/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array('Merchant','Product_review','Reviewed_user','Page','Offer','Merchant_login','Product_category','Product_category','Product_brand','Product_brand_lang','Product','Product_lang','Menu','Menu_position','Newsletter','Click_track');

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
             $this->loadModel('Setting');
    $config_settings=$this->Setting->find('all',array('conditions' => array('Setting.id' =>'1')));
    $this->set("setting",$config_settings[0]);  
            $merchant_menu=$this->Menu->find('threaded',array('conditions'=>array('Menu_position.slug'=>'merchant-top','Menu_position.status'=>1,'Menu.status'=>1),'order' => array('Menu.order ASC')));
            //print_r($merchant_menu);
            $this->set('merchant_menu',$merchant_menu);
            if(in_array($this->params['action'],array('comming_soon','PrivacyPolicy','TermsAndConditions','HelpCenter','faq','ContactUs','HintsTips','partners','HowItWorks','DataFeedSpecification','SuccessStories')))
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
                 
                // print_r($data_off);
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
                 
                // print_r($data_off);
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
        $this->common=new CommonFunction($this->merchantid);
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
  //end of password generate..
	public function index() {
       $data= $this->Menu->find('first',array('conditions'=>array('Menu.menu_controller'=>$this->params['controller'],'Menu.menu_action'=>$this->params['action'])));
       //print_r($data);
       $data1=$this->Page->find('first',array('conditions'=>array('Page.id'=>$data['Page']['id'])));
      // print_r($data1);
       $this->set('menu_data',$data);
       $this->set('page_data',$data1);
	}
	public function dashbord() {
		//echo $this->merchant_id;
        //$this->set('text_data',array('title'=>'Welcome '.ucfirst($this->merchant_data['Merchant']['first_name'])));
		$this->set('text_data',array('title'=>'Dashboard'));
	}
	public function logout(){    	
    	$this->Session->delete('Merchant');
    	$this->Session->destroy();
        //$this->Cookie->delete('Admin');
       // $this->Cookie->destroy();
    	$this->Session->setFlash('Sign out Successfully', 'default', array(), 'msg');
    	$this->redirect( array('controller' => 'merchant', 'action' => 'login','lang'=>isset($this->params['lang'])?$this->params['lang']:'en'));
        exit();
    }
	public function login(){
		@$this->Cookie->delete('step_4');
		  if($this->request->is('POST'))
     		{
     		
     			$check=$this->Merchant_login->find('first',array('conditions'=>array('username'=>$this->request->data['username'])));
     			if(count($check)>0){
                  //  if($check['Merchant_login']['status']==1)
                   // {

     				$pass=$this->request->data['password'];
     				$pass=md5($pass.$check['Merchant_login']['key']);
     				
     				if($pass==$check['Merchant_login']['password'])
     				{
                        $last_login= $check['Merchant_login']['login_date'];
                        //$login_date=;
                        $this->Merchant_login->id=$check['Merchant_login']['id'];
                        $check_date=$this->Merchant_login->save(array('login_date'=>date('Y-m-d H:i:s'),'last_login'=>$last_login));
     					if($check_date){
                        $username = $this->Session->write(array('Merchant'=>array('id'=>$check['Merchant_login']['id'],'email'=>$check['Merchant_login']['email_id'])));
     					//$this->Session->setFlash('Login successfull!!', 'default', array(), 'msg');
     					$this->redirect( array('controller' => 'merchant', 'action' => 'dashbord','lang'=>isset($this->params['lang'])?$this->params['lang']:'en'));
     					//$this->redirect('/'.$this->params['lang'].'/merchant/dashbord');
     					exit();
                        }
     				}
     				else
     				{
     					 $this->Session->setFlash('Please Enter Correct Password!!', 'default', array(), 'bad');
     				}

                   // }
                   // else
                   // {
                    //    $this->Session->setFlash(' You have not activated your account.<a href="'.$this->webroot.'en/merchant/send_activation/'.$check['Merchant_login']['id'].'">Click here</a> and Mena Compare will send a new activation link to the registered email address.', 'default', array(), 'bad');
                   // }
     			}
     			else
     			{
     				$this->Session->setFlash('Please Enter Correct Username!!', 'default', array(), 'bad');
     			}
     		}

	}
public function change_password(){
$this->set('text_data',array('title'=>'Change password'));
if($this->request->is('post')){
     $check=$this->Merchant_login->find('first',array('conditions'=>array('Merchant_login.id'=>$this->merchantid)));
     //print_r($check);
                 if(!empty($check)){
                    $pass=$this->request->data['old_pass'];
                    $pass_new=$this->request->data['new_pass'];
                    $pass_re=$this->request->data['re_new_pass'];
                    if($pass!=$pass_new)
                    {
                    if($pass_new==$pass_re)
                    {
                       
                        $pass=md5($pass.$check['Merchant_login']['key']);
                       
                        if($pass==$check['Merchant_login']['password'])
                        {
                          ///   print_r($this->request->data);
                            $new_pass=md5($pass_new.$check['Merchant_login']['key']);
                            $this->Merchant_login->id=$this->merchantid;
                            $check1=$this->Merchant_login->save(array('password'=>$new_pass));
                            if($check1)
                            {
                                  $this->Session->setFlash('Your New Password Successfully Changed!!', 'default', array(), 'msg');
                            }
                        }
                        else
                        {
                            $this->Session->setFlash('Your current password doesn&amp;t match!!', 'default', array(), 'bad');
                        }
                    }
                    else
                    {
                        $this->Session->setFlash('Current password and new password are same .Please enter new password', 'default', array(), 'bad');
                    }
                }
                else
                {
                    $this->Session->setFlash('Current password and new password should not be same .Please enter new password', 'default', array(), 'bad');
                }
     }
}
$this->render('dashbord_change_password');

}

	public function forgot_password($id=""){
		
		  if($this->request->is('POST'))
     		{
     		
     			$check=$this->Merchant_login->find('first',array('conditions'=>array('or'=>array('username'=>$this->request->data['email'],'email_id'=>$this->request->data['email']) )));
     			if(count($check)>0){
     				$pass=$this->generatePassword();
     				$pass1=md5($pass.$check['Merchant_login']['key']);
     				if($pass1)
     				{
     					$this->Merchant_login->id=$check['Merchant_login']['id'];
     					$check1=$this->Merchant_login->save(array('password'=>$pass1));
     					if($check1){
     						               $headers = "From: Menacompare <info@maasinfotech.com>\r\n";
                                          //  $headers .= "Reply-To: ". strip_tags($_POST['req-email']) . "\r\n";
                                          //  $headers .= "CC: susan@example.com\r\n";
                                            $headers .= "MIME-Version: 1.0\r\n";
                                            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                                            $subject = "Menacompare Forgot Password";
                                            $message = "Dear 
                                            ".$check['Profile']['first_name'].",<br><br>
                                            Your password has been reset successfully. <br>Please DO NOT share your password with anyone, Mena compare is NEITHER liable for any loss arising from your sharing of your password with anyone, NOR from its consequent unauthorized use.<br>
                                            <b>Password:</b> ".$pass."
                                            <br><br>Regards,<br> Menacompare.";
                                            // message lines should not exceed 70 characters (PHP rule), so wrap it
                                            $message = wordwrap($message, 70);
                                        // send mail
                                          $check_email=  mail($check['Merchant_login']['email_id'],$subject,$message, $headers);
                           

     						$this->Session->setFlash('Your password has been reset successfully.Please check your email.', 'default', array(), 'msg');
     					}
     					else
     					{
     						$this->Session->setFlash('There is a problem, Please try again!!', 'default', array(), 'bad');
     					}
     				}
     				     				
     			}
     			else
     			{
     				$this->Session->setFlash('Please Enter Correct Username or Email id!!', 'default', array(), 'bad');
     			}
     		}
            else if($id){
                $check=$this->Merchant_login->find('first',array('conditions'=>array('Merchant_login.id'=>$id)));
                if(count($check)>0){
                    $pass=$this->generatePassword();
                    $pass1=md5($pass.$check['Merchant_login']['key']);
                    if($pass1)
                    {
                        $this->Merchant_login->id=$check['Merchant_login']['id'];
                        $check1=$this->Merchant_login->save(array('password'=>$pass1));
                        if($check1){
                                          //  $from = "Menacompare <info@maasinfotech.com>"; // sender
                                            $headers = "From: Menacompare <info@maasinfotech.com>\r\n";
                                          //  $headers .= "Reply-To: ". strip_tags($_POST['req-email']) . "\r\n";
                                          //  $headers .= "CC: susan@example.com\r\n";
                                            $headers .= "MIME-Version: 1.0\r\n";
                                            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                                            $subject = "Menacompare Forgot Password";
                                            $message = "Dear 
                                            ".$check['Profile']['first_name'].",\n 
                                            Your password reseted successfully.\n 
                                            Don't diclare your Password. \n 
                                            <b>Password:</b> ".$pass."
                                            \n\n Regards,\n Menacompare.";
                                            // message lines should not exceed 70 characters (PHP rule), so wrap it
                                            $message = wordwrap($message, 70);
                                        // send mail
                                          $check_email=  mail($data7['email_id'],$subject,$message, $headers);
                           

                            $this->Session->setFlash('New Password will send to Merchant mail ( "'.$pass.'" )', 'default', array(), 'msg');
                            return 1;
                        }
                        else
                        {
                            $this->Session->setFlash('There is a problem, Please try again!!', 'default', array(), 'bad');
                             return 0;
                        }
                    }
            }

	}
}
	public function signup($step=1) {
		//print_r($this->Cookie->read());
		if(($this->Cookie->read('step_4')!="success"))
		{
			if(($this->Cookie->read('step_4')=="email_duplicate"))
			{
				        $this->Session->setFlash('This Email Allready Exists!!', 'default', array(), 'bad');
				        $this->redirect( array('controller' => 'merchant', 'action' => 'signup','lang'=>isset($this->params['lang'])?$this->params['lang']:'en',1));
	     		    	//$this->redirect('/'.$this->params['lang'].'/merchant/signup/1');
            	        exit;
			}
		   if($this->request->is('POST'))
     		{   
                //print_r($this->request->data);
     			if($step==2)
     			{
	     			$check=$this->Merchant_login->find('first',array('conditions'=>array('email_id'=>$this->request->data['email_id'])));
	     			if(count($check)==0)
	     			{
	     			  $this->Cookie->write('step_'.($step-1),$this->request->data);
	     		    }
	     		    else
	     		    {
	     		    	$this->Cookie->write('step_'.($step-1),$this->request->data);
	     		    	$this->Session->setFlash('Email id already Exists.', 'default', array(), 'bad');
	     		    	 $this->redirect( array('controller' => 'merchant', 'action' => 'signup','lang'=>isset($this->params['lang'])?$this->params['lang']:'en',1));
	     		    	//$this->redirect('/'.$this->params['lang'].'/merchant/signup/1');
            	        exit;
	     		    	
	     		    }
	     		    $check=$this->Merchant_login->find('first',array('conditions'=>array('url'=>$this->request->data['url'])));
	     			if(count($check)==0)
	     			{
	     			  $this->Cookie->write('step_'.($step-1),$this->request->data);
	     		    }
	     		    else
	     		    {
	     		    	$this->Cookie->write('step_'.($step-1),$this->request->data);
	     		    	$this->Session->setFlash('This URL already Exists', 'default', array(), 'bad');
	     		    	 $this->redirect( array('controller' => 'merchant', 'action' => 'signup','lang'=>isset($this->params['lang'])?$this->params['lang']:'en',1));
	     		    	//$this->redirect('/'.$this->params['lang'].'/merchant/signup/1');
            	        exit;
	     		    	
	     		    }

     			}
     			else if($step==4)
     			{
     				$check=$this->Merchant_login->find('first',array('conditions'=>array('username'=>$this->request->data['username'])));
	     			if(count($check)==0)
	     			{
	     			  $this->Cookie->write('step_'.($step-1),$this->request->data);
	     		    }
	     		    else
	     		    {
	     		    	$this->Cookie->write('step_'.($step-1),$this->request->data);
	     		    	$this->Session->setFlash('This Username already Exists.', 'default', array(), 'bad');
	     		    	//$this->redirect('/'.$this->params['lang'].'/merchant/signup/3');
	     		    	 $this->redirect( array('controller' => 'merchant', 'action' => 'signup','lang'=>isset($this->params['lang'])?$this->params['lang']:'en',3));
            	        exit;
	     		    	
	     		    }
     			}else
     			{
     			   $this->Cookie->write('step_'.($step-1),$this->request->data);
     			}
     		if($this->Cookie->check('step_3')){
     			if($step==4)
     			{
     				$data1=$this->Cookie->read();
     				
     				$data2=array_map('strip_tags', $data1['step_1']);
     				$data3=array_map('strip_tags', $data1['step_2']);
     				$data4=array_map('strip_tags', $data1['step_3']);     				    			
     				$data6=array_merge($data2,$data3,$data4);
                       // print_r($data6);
     				$data7=array();
     				$data7['key']=md5(rand());
     				$data7['password']=md5($data6['password'].$data7['key']);
     				$data7['email_id']=$data6['email_id'];
     				$data7['username']=$data6['username'];
     				$data7['is_agreed']=$data6['is_agreed'];
     				$data7['created_date']=date('Y-m-d');
     				
     				unset($data6['re_password']);
     				unset($data6['varify_email_id']);
                    unset($data6['email_id']);
     				
                    $datas=$this->Merchant_login->find('first',array('conditions'=>array('or'=>array('email_id'=>$data7['email_id'],'username'=>$data7['username']))));
     					//print_r($data7);
     					if(count($datas)==0)
     					{	//$this->Merchant_login->set($data7);
     						$check=$this->Merchant_login->save($data7);
     						if($check)
     						{
	     						$data6['merchant_id']=$this->Merchant_login->id;
	     						$check=$this->Merchant->save($data6);
	     						if($check){
	     						    
	     							
	     							//$this->Cookie->delete('step_4');
	     				            $this->Cookie->write('step_4','success');
	     				           	if($this->Cookie->read('step_4')=='success')
	     				           	{
                                          

                                           // $headers = "From: Menacompare <info@maasinfotech.com>\r\n";
                                          //  $headers .= "Reply-To: ". strip_tags($_POST['req-email']) . "\r\n";
                                          //  $headers .= "CC: susan@example.com\r\n";
                                           // $headers .= "MIME-Version: 1.0\r\n";
                                           // $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                                           // $subject = "Menacompare Merchant Activation";
                                           /*  $message = "Dear ".$data6['first_name'].",<br><br>
                                            You have successfully Registered at Menacompare.<br>
                                            To access your merchant AC, Please Click below Activation URL, <br> <a href='http://maasinfotech24x7.com/menacompare/en/merchant/activate/".$data7['key']."'>http://maasinfotech24x7.com/menacompare/en/merchant/activate/".$data7['key']."</a><br><br> Regards,<br> Menacompare.";

                                            // message lines should not exceed 70 characters (PHP rule), so wrap it
                                            $message = wordwrap($message, 70);
                                        // send mail
                                   $check_email=  mail($data7['email_id'],$subject,$message,$headers);*/
                                    $merch=$this->Merchant_login->find('first',array('conditions'=>array('email_id'=>$data7['email_id'])));
            	     				//$last_login= date('');
                                    //$login_date=;
                                    $this->Merchant_login->id=$merch['Merchant_login']['id'];
                                    $check_date=$this->Merchant_login->save(array('login_date'=>date('Y-m-d H:i:s'),'last_login'=>date('Y-m-d H:i:s')));
                                    if($check_date)
									{
                                    	$username = $this->Session->write(array('Merchant'=>array('id'=>$merch['Merchant_login']['id'],'email'=>$merch['Merchant_login']['email_id'])));
                        				//$this->Session->setFlash('Login successfull!!', 'default', array(), 'msg');
						
										$newsltr_data['email_id'] = $data7['email_id'];
										$newsltr_data['stype'] = 'Merchant';
										$newsltr_data['status'] = 1;
										$newsltr_data['date'] = date('Y-m-d H:i:s');
										$newsltr_data['ip_adress'] = $this->RequestHandler->getClientIp();
										$this->Newsletter->save($newsltr_data);
                                       }
                                        $this->Cookie->delete('step_1');
		     							$this->Cookie->delete('step_2');	     				           
		     							$this->Cookie->delete('step_3');
	     				           		//$this->redirect('/'.$this->params['lang'].'/merchant/signup/4');
	     				           		//$this->redirect( array('controller' => 'merchant', 'action' => 'signup','lang'=>isset($this->params['lang'])?$this->params['lang']:'en',4));
	     				           		//exit();

	     				           	}
	     				          
	     				           
	     						}
	     						
     					   }
     					   else
     					   {
     					   //	echo "eror";
     					   }
     					}
     					else
     					{
     						 $this->Cookie->write('step_4','email_duplicate');
     					}
     				if(($this->Cookie->read('step_4')=="email_duplicate"))
						{
							        $this->Session->setFlash('This Email Allready Exists!!', 'default', array(), 'bad');
							        $this->redirect( array('controller' => 'merchant', 'action' => 'signup','lang'=>isset($this->params['lang'])?$this->params['lang']:'en',1));
				     		    	//$this->redirect('/'.$this->params['lang'].'/merchant/signup/1');
			            	        exit;
						}
     		       }
     	       }
              }   

		   }else
		   {
		                        	$this->Cookie->delete('step_1');
	     							$this->Cookie->delete('step_2');	     				           
	     							$this->Cookie->delete('step_3');
	     							$this->Cookie->delete('step_0');
		   }
  	
	     							
		
		    if($this->Cookie->check('step_'.$step))
		    {
		    	$data=$this->Cookie->read('step_'.$step);
		    }
		    if(isset($data))
		    {
     	      $this->set('step_'.$step,$data);
            }
           if(($this->Cookie->read('step_4')=="success")){
           	if($step!=4){
           		 $this->redirect( array('controller' => 'merchant', 'action' => 'signup','lang'=>isset($this->params['lang'])?$this->params['lang']:'en',4));
           		//$this->redirect('/'.$this->params['lang'].'/merchant/signup/4');
            	exit;
           	}else
           	{
           		$this->render('signup4');
           	}
           }           
           elseif($this->Cookie->check('step_'.($step-1)) or $step==1)
		    { 

               $this->render('signup'.$step);
            }
            else
            {
            	 $this->redirect( array('controller' => 'merchant', 'action' => 'signup','lang'=>isset($this->params['lang'])?$this->params['lang']:'en',($step-1)));
            	//$this->redirect('/'.$this->params['lang'].'/merchant/signup/'.($step-1));
            	exit;
            }
         
          }
     public function my_account(){
      $this->set('text_data',array('title'=>'My Account'));
      
     }
     public function change_profile_pic(){
      $this->set('text_data',array('title'=>'Change profile photo'));
      if($this->request->is('post'))
       {
      //  print_r($_FILES['profile_pic']);
        $catimagepath=@$this->requestAction(array('controller'=>'merchant', 'action'=>'uploadImage'),
    array('pass' => array('profile_pic','uploads/profile')));
        if($catimagepath){
            $this->Merchant_login->Profile->id=$this->merchantid;
          $check= $this->Merchant_login->Profile->save(array('image_url'=>$catimagepath));
           if($check){
                     $this->Session->setFlash('Your profile image successfully added', 'default', array(), 'msg');
           
           }
           else
           {
              $this->Session->setFlash('Not Uploaded!!', 'default', array(), 'bad');
           }
        }
        else
        {
             $this->Session->setFlash('Not Uploaded!!', 'default', array(), 'bad');
        }
       }
        $data=$this->Merchant->find('first',array('conditions'=>array('Merchant.merchant_id'=>$this->merchantid)));
        $this->set('merchant',$data);
     }
    public function edit_account(){
           $this->set('text_data',array('title'=>'Edit Account'));
           if($this->request->is('post'))
           {
           
            $datacheck=$this->Merchant_login->find('first',array('conditions'=>array('or'=>array('email_id'=>$this->request->data['email_id'],'url'=>$this->request->data['url']),'Merchant_login.id !='=>$this->merchantid)));
               if(empty($datacheck))
               {
                $this->request->data['Merchant_login']=array('email_id'=>$this->request->data['email_id'],'id'=>$this->merchantid);
                $check=$this->Merchant_login->Profile->save($this->request->data);
                $check=$this->Merchant_login->save($this->request->data['Merchant_login']);
                if($check){
                     $this->Session->setFlash('The Account Information Updated Successfully', 'default', array(), 'msg');
                }
               }else
               {
                 $this->Session->setFlash('The Email Id or URL you want to change is Allready Exists.', 'default', array(), 'bad');
               }
           }
        $data=$this->Merchant->find('first',array('conditions'=>array('Merchant.merchant_id'=>$this->merchantid)));
        $this->set('merchant',$data);
    }
	
	public function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			return $this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));

		try {
			$this->render(implode('/', $path));
		} catch (MissingViewException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new NotFoundException();
		}
	}
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

        public function data_feed_setup(){
                $this->set('text_data',array('title'=>'Product Data feed'));
            if($this->request->is('post')){  
                  //   print_r($_FILES['data_feed']);
                App::import('Vendor', 'PHPExcel/Classes/PHPExcel/IOFactory');
               // uploads/products/datafeed/Basefeed.xls
                if($_FILES['data_feed']['type']=="application/vnd.ms-excel")
                {
                $inputFileName = $_FILES['data_feed']['tmp_name'];
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                /**  Create a new Reader of the type that has been identified  **/
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                /**  Load $inputFileName to a PHPExcel Object  **/
                $objPHPExcel = $objReader->load($inputFileName);

                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                // Check Id present or not in all rows.
                $sheetData=  $this->common->filterMyFeed($sheetData); 
                if(!empty($sheetData)){
                    //check all ides are uniqe and remove the duplicate one.
                    $sheetData = $this->common->filterMyFeed($sheetData,'unique');
                    if(!empty($sheetData)){
                        $sheetData = $this->common->filterMyFeed($sheetData,'required');
                         if(!empty($sheetData)){
                          //assemble in a correct format.
                            $sheetData =  $this->common->filterMyFeed($sheetData,'filter');
                              if(!empty($sheetData))
                              {
                                  $sheetData =  $this->common->filterMyFeed($sheetData,'assembele');
                                  if(!empty($sheetData))
                                  {
                                     // here we chek category and get the category id accordinglly
                                        $sheetData=array_values($sheetData);
                                        $results = Hash::extract($sheetData, '{n}.Product.category_id');                         
                                        $data=$this->categoryCheckAndGetId($results);  

                                        foreach ($data as $key => $value) {
                                            if($value!="")
                                            $sheetData[$key]['Product']['category_id']=$value; 
                                            else{
                                                $sheetData[$key]['Product']['category_id']="";
                                                $sheetData[$key]['Product']['is_error']=1;
                                               // unset($sheetData[$key]);
                                            }  
                                        }
                                        if(!empty($sheetData))
                                        {
                                            // here we get brand_id if exist
                                            $sheetData=array_values($sheetData);
                                            $results = Hash::extract($sheetData, '{n}.Product.brand');
                                            $data=$this->BrandCheckandGetid($results); 

                                            foreach ($data as $key => $value) {                               
                                            $sheetData[$key]['Product']['brand']=$value;                                 
                                            }
                                            if(!empty($sheetData))
                                            {
                                                foreach ($sheetData as $key => $value) {
                                                        $this->Product->clear();
                                                   $data=$this->Product->find('first',array('conditions'=>array('Product.merchant_product_id'=>$value['Product']['merchant_product_id'],'Product.retailer_id'=>$this->merchantid)));
                                                 
                                                   if(!empty($data))
                                                   {
                                                     $this->Product->id=$data['Product']['id'];
                                                     $check=$this->Product->save($value['Product']);
                                                    if($check)
                                                    {
                                                        foreach ($data['Product_lang'] as $k => $val) {
                                                           $this->Product_lang->clear();
                                                           $this->Product_lang->id=$val['id'];
                                                           $this->Product_lang->delete();
                                                        }
                                                         $prod_id=$data['Product']['id'];
                                                     
                                                        foreach ($value['Product_lang'] as $k => $val) {

                                                          $this->Product_lang->clear();
                                                          $val['product_id']=$prod_id;
                                                         
                                                          $check=$this->Product_lang->save($val);
                                                        } 
                                                        if($check)
                                                        {
                                                             $this->Session->setFlash('Your data feed successfully inserted', 'default', array(), 'msg');
                                                        }
                                                       
                                                    }
                                                   }
                                                   else
                                                   {
                                                  

                                                     $check=$this->Product->save($value['Product']);
                                                    if($check)
                                                    {
                                                        $prod_id=$this->Product->getLastInsertID();
                                                       
                                                        foreach ($value['Product_lang'] as $k => $val) {
                                                             $this->Product_lang->clear();
                                                          $val['product_id']=$prod_id;
                                                         
                                                          $check=$this->Product_lang->save($val);
                                                        } 
                                                        if($check)
                                                        {
                                                             $this->Session->setFlash('Your data feed successfully inserted', 'default', array(), 'msg');
                                                        }
                                                       

                                                    }
                                                   }
                                                   
                                                }
                                            }
                                        }
                                        else
                                        {
                                            $this->Session->setFlash('Please Give currect category as per our categorry section !! Please read our specifications..', 'default', array(), 'bad');
                                        }
                                  }else
                                  {
                                    $this->Session->setFlash('We found your data was not in correct format!! Please read our specifications..', 'default', array(), 'bad');
                                  }
                              }
                              else
                              {
                                $this->Session->setFlash('We found your data was not in correct format!! Please read our specifications..', 'default', array(), 'bad');
                              }

                         } 
                         else
                         {
                            $this->Session->setFlash('Please fill all requred field! Please check and Import it again.', 'default', array(), 'bad');
                         }
                    }else
                    {
                         $this->Session->setFlash('We found your data with with duplicate Id! Please check and Import it again.', 'default', array(), 'bad');
                    }

                }
                else
                {
                     $this->Session->setFlash('We found you have not give unique Id of your product! Please check and Import it again.', 'default', array(), 'bad');
                }
                  
            }else
        {
             $this->Session->setFlash('Please upload only .xls or .csv. ', 'default', array(), 'bad');
        }
        }
               


        }
        public function categoryCheckAndGetId($data_find=array()){
            
            $data_array=array();
            foreach ($data_find as $key => $value) {
                $exp=explode(" > ", $value);

                $data=$this->Product_category->Product_category_lang->find('first',array('conditions'=>array('Product_category_lang.category_name'=>end($exp))));
                
                    if(!empty($data))
                    {
                    $final=$this->Product_category->getPath($data['Product_category_lang']['cat_id']);
                    if(!empty($final))
                    {
                        $results = Hash::extract($final, '{n}.Product_category.slug');
                       
                        $exp=array_map(array($this,"slugCreate"),  $exp);
                        $result = Hash::contains($exp, $results);
                        if($result)
                        {
                            $data_array[]=$data['Product_category_lang']['cat_id'];
                        }
                        else
                        {
                            $data_array[]="";
                        }
                    }
                    else
                    {
                        $data_array[]="";
                    }
                }
                else
                {
                    $data_array[]="";
                }
               
            }
          
        return $data_array;

        }
        function slugCreate($v){
            return $this->common->slugCreater($v);
        }
        public function BrandCheckandGetid($data_find=array())
        {
            $data_array=array();
            foreach ($data_find as $key => $value) {
                $data= $this->Product_brand->Product_brand_lang->find('first',array('conditions'=>array('Product_brand_lang.brand_title'=>$value)));
                if(!empty($data))
                $data_array[]=$data['Product_brand_lang']['brand_id'];
                else
                $data_array[]="";
            }
           return $data_array;
        }

       public function activate($key="")
       {
            if($key!="")
            {
                $check=$this->Merchant_login->updateAll(array('status'=>1),array('key'=>$key));
                if($check)
                {
                    $this->Session->setFlash('You are successfully Activated', 'default', array(), 'msg');
                }
            }else
            {
                 $this->Session->setFlash('Please mention your activation key!!', 'default', array(), 'bad');
            }

              $this->redirect( array('controller' => 'merchant', 'action' => 'login','lang'=>isset($this->params['lang'])?$this->params['lang']:'en'));
              exit;
       }

        public function send_activation($id="")
       {
            if($id!="")
            {
                $check=$this->Merchant_login->find('first',array('conditions'=>array('Merchant_login.id'=>$id)));
               // print_r($check);
                if(!empty($check))
                {

                                                                                   
                                           

                                        // More headers
                                           $headers = "From: Menacompare <info@maasinfotech.com>\r\n";
                                          //  $headers .= "Reply-To: ". strip_tags($_POST['req-email']) . "\r\n";
                                          //  $headers .= "CC: susan@example.com\r\n";
                                            $headers .= "MIME-Version: 1.0\r\n";
                                            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                                            $subject = "Menacompare Merchant Activation";
                                            $message = "Dear ".$check['Profile']['first_name'].",<br><br>
                                            You have successfully Registered at Menacompare.<br>
                                            To access your merchant account, Please Click below Activation URL, <br> <a href='http://maasinfotech24x7.com/menacompare/en/merchant/activate/".$check['Merchant_login']['key']."' >http://maasinfotech24x7.com/menacompare/en/merchant/activate/".$check['Merchant_login']['key']."</a><br><br> Regards,<br> Mena Compare.";
                                            // message lines should not exceed 70 characters (PHP rule), so wrap it
                                            $message = wordwrap($message, 70);
                                        // send mail
                    $check_email=  mail($check['Merchant_login']['email_id'],$subject,$message,$headers);
                    $this->Session->setFlash('An activation link will send you soon. Please Check your email account.', 'default', array(), 'msg');
                }
            }else
            {
                // $this->Session->setFlash('Please mention your activation key!!', 'default', array(), 'bad');
            }
           
            $this->redirect( array('controller' => 'merchant', 'action' => 'login','lang'=>isset($this->params['lang'])?$this->params['lang']:'en'));
            exit;
       }
       public function reviewRatings(){
        
		//echo "<pre>";print_r($this->params->query);echo "</pre>"; //exit;
		
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
						'Product.retailer_id'=>$this->merchantid),
						'order'=>'Product.slug asc',
						'fields'=>array('Product_review.product_id','Product.slug'),
						'group' => array(
						'Product_review.product_id')
						));  
        $this->set('product_list',$product_list);
		
		$conditions['Product.retailer_id'] = $this->merchantid;
		
		if(!empty($this->params->query))
		{
			//echo "<pre>";print_r($this->params->query);echo "</pre>"; exit;	
			$srch_data = $this->params->query;
			if(!empty($srch_data['from_date']))
				$from_date = date('Y-m-d H:i:s',strtotime($srch_data['from_date']));
			if(!empty($srch_data['to_date']))
				$to_date = date('Y-m-d H:i:s',strtotime($srch_data['to_date']));
			$search = $srch_data['search'];
			$product = $srch_data['product'];
			$status = $srch_data['status'];
			
			if(!empty($from_date))
			{
				$conditions['Product_review.review_date >='] = $from_date;
			}
			if(!empty($to_date)) 
			{
				$conditions['Product_review.review_date <= '] = $to_date;
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
				$conditions['Product.slug'] = $product;
			}
		}
		
		//print_r($conditions);
		
		try{
		$this->Paginator->settings = array(
									'conditions'=>$conditions,
									'order'=>'Product_review.review_date DESC',
									
									'limit' => 10
								);
		
		}
		catch (Exception $e){
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			
			};
			
		$data = $this->paginate('Product_review');
         //echo "<pre>";print_r($data);echo "</pre>"; exit;
        $this->set('product_review',$data);
       }
       public function offer_and_deals()
       {
        $this->set('text_data',array('title'=>'Offer and Deals'));
        $this->render('comming_soon');
       }
       public function reports()
       {
        	$this->set('text_data',array('title'=>'Report'));
       		// $this->render('comming_soon');
			
			$conditions['Click_track.merchant_id'] = $this->merchantid;
			
			if(!empty($this->params->query))
			{
				//echo "<pre>";print_r($this->params->query);echo "</pre>"; exit;	
				$srch_data = $this->params->query;
				if(!empty($srch_data['from_date']))
					$from_date = date('Y-m-d H:i:s',strtotime($srch_data['from_date']));
				if(!empty($srch_data['to_date']))
				{
					$to_date = date('Y-m-d',strtotime($srch_data['to_date']));
					$to_date = $to_date.' 59:59:59';
				}
				$search = '';
				if(!empty($srch_data['search']))
					$search = $srch_data['search'];
				
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
					$conditions['Product.slug LIKE'] = '"%'.$search.'%"';
				}
				
			}
			//echo "<pre>";print_r($conditions);echo "</pre>"; exit;		
	   		$this->Paginator->settings = array(
											'fields' => array(
												'Click_track.*',
												'COUNT(DISTINCT Click_track.id) AS click_count'
											),
											'conditions' => $conditions,
											'order'=>'Click_track.id DESC',
											'group'=>'Click_track.product_id ',
											'limit' => 20
										);
			$data = $this->paginate('Click_track');
			$this->set('reports',$data);	
							
       }
	   public function delete_report($id)
	   {
            $this->Click_track->id=$id;
            $check=$this->Click_track->delete();
            if($check)
            {
                $this->Session->setFlash('Record Deleted Successfully!', 'default', array(), 'msg');
                $this->redirect('/en/merchant/reports');
                exit;
            }else
            {
                $this->Session->setFlash('Record Deleted Successfully!', 'default', array(), 'msg');
                $this->redirect('/en/merchant/reports');
                exit;
            }
            //$this->render('ajax');
	   }
       public function notifications()
       {
        $this->set('text_data',array('title'=>'Notifications'));
        $this->render('comming_soon');
       }

       public function comming_soon()
       {
        $this->set('text_data',array('title'=>'Coming Soon'));
        $this->render('comming_soon');
        $data= $this->Menu->find('first',array('conditions'=>array('Menu.menu_controller'=>$this->params['controller'],'Menu.menu_action'=>$this->params['action'])));
       //print_r($data);
       $data1=$this->Page->find('first',array('conditions',array('Page.id'=>$data['Page']['id'])));
      // print_r($data1);
       $this->set('menu_data',$data);
       $this->set('page_data',$data1);
       }

       public function HowItWorks()
       {
        $this->set('text_data',array('title'=>'How It Works'));
        $data= $this->Menu->find('first',array('conditions'=>array('Menu.menu_controller'=>$this->params['controller'],'Menu.menu_action'=>$this->params['action'])));
       //print_r($data);
        $data1=$this->Page->find('first',array('conditions'=>array('Page.id'=>$data['Page']['id'])));
      // print_r($data1);
       $this->set('menu_data',$data);
       $this->set('page_data',$data1);
       
       }
        public function DataFeedSpecification()
       {
        $this->set('text_data',array('title'=>'Coming Soon'));
        $data= $this->Menu->find('first',array('conditions'=>array('Menu.menu_controller'=>$this->params['controller'],'Menu.menu_action'=>$this->params['action'])));
       //print_r($data);
       $data1=$this->Page->find('first',array('conditions'=>array('Page.id'=>$data['Page']['id'])));
      // print_r($data1);
       $this->set('menu_data',$data);
       $this->set('page_data',$data1);
       
       }
       public function SuccessStories()
       {
        $this->set('text_data',array('title'=>'Success Stories'));
        $data= $this->Menu->find('first',array('conditions'=>array('Menu.menu_controller'=>$this->params['controller'],'Menu.menu_action'=>$this->params['action'])));
       //print_r($data);
       $data1=$this->Page->find('first',array('conditions'=>array('Page.id'=>$data['Page']['id'])));
      // print_r($data1);
       $this->set('menu_data',$data);
       $this->set('page_data',$data1);
       
       }
		public function faq($faqcatid='')
		{
			//echo $faqid; exit;
			//$this->set('text_data',array('title'=>'Coming Soon'));
			$this->loadModel('Faq_category');
			$faq_categories = $this->Faq_category->Find('all', 
								array(
								'conditions'=>array(
									'Faq_category.status'=>1,
								),
								'order' => array('Faq_category.cat_order'=>'asc')
							)
						); 
			$this->set('faq_categories',$faq_categories);
			$this->loadModel('Faq');
			
			if(!empty($faqcatid))
			{
				$faqs = $this->Faq->Find('all', 
								array(
								'conditions'=>array(
									'Faq_category.slug'=>$faqcatid,
									'Faq.status'=>1
								),
								'order' => array('Faq.faq_order'=>'asc')
							)
						); 
			}
			else
			{
				$faqs = $this->Faq->Find('all', 
								array(
								'conditions'=>array(
									'Faq.status'=>1
								),
								'order' => array('Faq.faq_order'=>'asc')
							)
						); 
			}
			$this->set('faqcatid',$faqcatid);
			$this->set('faqs',$faqs);
            $data= $this->Menu->find('first',array('conditions'=>array('Menu.menu_controller'=>$this->params['controller'],'Menu.menu_action'=>$this->params['action'])));
               //print_r($data);
               $data1=$this->Page->find('first',array('conditions'=>array('Page.id'=>$data['Page']['id'])));
              // print_r($data1);
               $this->set('menu_data',$data);
               $this->set('page_data',$data1);
			//echo '<pre>'; print_r($faqs); echo '</pre>';
		}
       public function HelpCenter()
       {
            $this->set('text_data',array('title'=>'Success Stories'));
            $data= $this->Menu->find('first',array('conditions'=>array('Menu.menu_controller'=>$this->params['controller'],'Menu.menu_action'=>$this->params['action'])));
               //print_r($data);
               $data1=$this->Page->find('first',array('conditions'=>array('Page.id'=>$data['Page']['id'])));
              // print_r($data1);
               $this->set('menu_data',$data);
               $this->set('page_data',$data1);

       
       }
       public function HintsTips()
       {
            $this->set('text_data',array('title'=>'Success Stories'));
            $data= $this->Menu->find('first',array('conditions'=>array('Menu.menu_controller'=>$this->params['controller'],'Menu.menu_action'=>$this->params['action'])));
               //print_r($data);
               $data1=$this->Page->find('first',array('conditions'=>array('Page.id'=>$data['Page']['id'])));
              // print_r($data1);
               $this->set('menu_data',$data);
               $this->set('page_data',$data1);

       
       }
       public function partners()
       {
        $this->set('text_data',array('title'=>'partners'));
         $data= $this->Menu->find('first',array('conditions'=>array('Menu.menu_controller'=>$this->params['controller'],'Menu.menu_action'=>$this->params['action'])));
               //print_r($data);
               $data1=$this->Page->find('first',array('conditions'=>array('Page.id'=>$data['Page']['id'])));
              // print_r($data1);
               $this->set('menu_data',$data);
               $this->set('page_data',$data1);
       
       }
        public function ContactUs()
       {
        $this->set('text_data',array('title'=>'ContactUs'));
        $data= $this->Menu->find('first',array('conditions'=>array('Menu.menu_controller'=>$this->params['controller'],'Menu.menu_action'=>$this->params['action'])));
               //print_r($data);
               $data1=$this->Page->find('first',array('conditions'=>array('Page.id'=>$data['Page']['id'])));
              // print_r($data1);
               $this->set('menu_data',$data);
               $this->set('page_data',$data1);

       
       }
       public function TermsAndConditions()
       {
        $this->set('text_data',array('title'=>'ContactUs'));
       
       }
       public function PrivacyPolicy()
       {
        $this->set('text_data',array('title'=>'ContactUs'));
       
       }

       public function active($type="",$id=""){
        $this->layout="ajax";
         $this->Product_review->id=$id;
        if($type=="sn_inactive")
        {       
           $check=$this->Product_review->save(array('status'=>1));
        }
        else if($type=="sn_active")
        {
          $check=$this->Product_review->save(array('status'=>0));
        }
        if($check)
        {
            echo true;
        }else
        {
            echo false;
        }
        $this->render('ajax');
       }
	   
	   function getReviewProducts($pslug)
	   {
		   $this->layout="ajax";
		   $data=$this->Product_review->find('all', array(
		   										'conditions' => array(
													'Product_review.status'=>1,
													'Product.slug like ' => '%'.$pslug.'%'
												),
												'fields' => array(
													'Product.slug',
													//'Product_lang.*'
												)
		   									));
			$this->set('products',$data);								
			$this->render('get_reviews_products');									
	   }
}

