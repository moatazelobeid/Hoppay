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
class PagesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	//public $uses = array();

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 * @throws NotFoundException When the view file could not be found
 *	or MissingViewException in debug mode.
 */
    public $helpers = array('Html', 'Form','Session','Paginator','Fck','Template');
	//public $cacheAction = "0.1 hour";
	public $uses=array('Product_category','Product','Offer','Setting','Menu','Page');
	public $components = array('Session','Paginator','Cookie');
    public function beforeFilter(){     
         parent::beforeFilter();
         $this->layout = 'page';
         $config_settings=$this->Setting->find('all',array('conditions' => array('Setting.id' =>'1')));
		$this->set("setting",$config_settings[0]);

			$footer_menu=$this->Menu->find('threaded',array('conditions'=>array('Menu_position.slug'=>'home-footer','Menu_position.status'=>1,'Menu.status'=>1),'order' => array('Menu.order ASC')));
         //print_r($footer_menu);
        $this->set('footer_menu',$footer_menu);
    }
	public function display() {
		 $path = func_get_args();
		
		$count = count($path);
		if (!$count) {
			return $this->redirect('/');
		}
		$data= $this->Menu->find('first',array('conditions'=>array('Menu.slug'=>$path[0])));
		if(!empty($data))
		{
		  $data1=$this->Page->find('first',array('conditions'=>array('Page.id'=>$data['Page']['id'])));
	    }
	    else
	    {
	    	 
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
		$this->set('menu_data',$data);
		 $this->set('page_data',$data1);
		try {
			if($data1['Page']['page_template']!="")
			{
				 $this->render('/Templates/'.$data1['Page']['page_template']);
			}else
			{
				 $this->render('view');
			}
			 
		} catch (MissingViewException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new NotFoundException();
		}
	}
}
