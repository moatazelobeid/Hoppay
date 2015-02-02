<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
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
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
  //Router::connect('/', array('controller' => 'homes', 'action' => 'index'));
/*$menus = ''; 
//Cache::delete('routemenus'); You can uncomment this to delete cache if you change menus 
if($menus = Cache::read('routemenus') === false){ 
    echo 'load from db'; 
    $menusModel = ClassRegistry::init('Menu'); 
    $menus = $menusModel->find('all', array('conditions' => array('parent_id' => '1'))); 
    Cache::write('routemenus', $menus); 
} 

foreach($menus as $menuitem){ 
    Router::connect('/' . $menuitem['Menu']['code'] . '/:action/*', array('controller' => $menuitem['MenuType']['code'], 'action' => 'index')); 
} */

//Router::connect('/', array('controller' => 'homepage', 'action' => 'index'));



  Router::connect('/admin/menu', array('controller' => 'menu','admin'=>true));
  Router::connect('/admin/menu/:action/*', array('controller' => 'menu','admin'=>true));
  //Router::connect('/admin/:controller', array('admin'=>true));
  //Router::connect('/admin/:controller/:action/*', array('admin'=>true));
  Router::connect('/admin', array('controller' => 'Admin', 'action' => 'index'));
	Router::connect(
    '/:lang', 
    array('controller' => 'homes', 'action' => 'index','lang'=>'en'),   
    array(  'lang' => '[a-z]{2}')
    
    );
  
     Router::connect(
    '/:lang/merchant/store', 
    array('controller' => 'Store', 'action' => 'index','lang'=>'en'),   
    array(  'lang' => '[a-z]{2}')    
    );
    Router::connect(
    '/:lang/merchant/my-products/:action/*', 
       array('controller' => 'products','lang'=>'en','merchant'=>true),      
       array( 'lang' => '[a-z]{2}' )    
    );
     Router::connect(
    '/:lang/merchant/my-products', 
       array('controller' => 'products', 'action' => 'index','lang'=>'en','merchant'=>true),      
       array( 'lang' => '[a-z]{2}' )
    
    );
/*Router::connect(
    "/{$prefix}/:controller",
    array('action' => 'index', 'prefix' => $prefix, $prefix => true)
);
Router::connect(
    "/{$prefix}/:controller/:action/*",
    array('prefix' => $prefix, $prefix => true)
);*/
    
      /*Router::connect(
      '/:lang/merchant/:controller', 
      array('lang'=>'en'),   
      array( 'lang' => 'en')
      
      );*/
    Router::connect(
    '/:lang/merchant', 
    array('controller' => 'merchant', 'action' => 'index','lang'=>'en'),   
    array( 'lang' => '[a-z]{2}')
    
    );
   
	Router::connect(
    '/:lang/:controller/:action/*', 
    array('lang' => 'en'),   
    array( 'lang' => '[a-z]{2}')
    
    );
 /* Router::connect(
    "/:lang/{$prefix}/:controller/:action",
    array('action' => 'index', 'prefix' => $prefix, $prefix => true)
  );
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));


	Router::connect(  
	    '/robots.txt',  
	    array(  
	        'controller' => 'seo',  
	        'action' => 'robots'  
	    )  
	); 
/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */

	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
