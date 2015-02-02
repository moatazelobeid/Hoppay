<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $metas_all=array('htitle'=>'','hdescription'=>'','hkeyword'=>'','hlang'=>'');
	
	 public function beforeFilter(){     
            parent::beforeFilter();
          $this->set($this->metas_all);
      }
	function beforeRender () {
       $this->_setErrorLayout();

    }

	function _setErrorLayout() { 
	    if($this->name == 'CakeError') { 
	        $this->layout = 'error_temp';  
	        $this->loadModel('Setting');
			$config_settings=$this->Setting->find('all',array('conditions' => array('Setting.id' =>'1')));
			$this->set("setting",$config_settings[0]);
	    }
	    //echo "<pre>"; print_r($this); echo "</pre>";exit;
	}
}
