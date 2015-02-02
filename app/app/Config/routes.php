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
Router::parseExtensions('rss','xml'); 
  
    Router::connect('/admin/newsletter', array('controller' => 'Newsletter','admin'=>true));    
    Router::connect('/admin/newsletter/:action/*', array('controller' => 'Newsletter','admin'=>true));


   
    Router::connect('/admin/menu', array('controller' => 'menu','admin'=>true));
    Router::connect('/admin/menu/:action/*', array('controller' => 'menu','admin'=>true));
   /* Router::connect('/admin/merchant', array('controller' => 'merchant','admin'=>true));*/
    Router::connect('/admin/merchant/:action/*', array('controller' => 'merchant','admin'=>true));
    Router::connect('/admin/products', array('controller' => 'products','admin'=>true));
    Router::connect('/admin/products/:action/*', array('controller' => 'products','admin'=>true));
    //Router::connect('/admin/:controller', array('admin'=>true));
    //Router::connect('/admin/:controller/:action/*', array('admin'=>true));
    Router::connect('/admin', array('controller' => 'Admin', 'action' => 'index'));
    Router::connect('/admin/:action/*', array('controller' => 'Admin'));
  	Router::connect(
    '/:lang', 
    array('controller' => 'homes', 'action' => 'index','lang'=>'en'),   
    array(  'lang' => '[a-z]{2}')
    
    );
	Router::connect(
    '/:lang/homes/:action', 
    array('controller' => 'homes','lang'=>'en'),   
    array(  'lang' => '[a-z]{2}')
    
    );
    Router::connect(
    '/:lang/homes/:action/*', 
    array('controller' => 'homes','lang'=>'en'),   
    array(  'lang' => '[a-z]{2}')
    
    );
	  
    Router::connect(
    '/:lang/merchant/offers/:action/*', 
    array('controller' => 'offers', 'action' => 'index','lang'=>'en','merchant'=>true),   
    array(  'lang' => '[a-z]{2}')    
    );
     Router::connect(
    '/:lang/merchant/offers/*', 
    array('controller' => 'offers', 'action' => 'index','lang'=>'en','merchant'=>true),   
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
    '/:lang/merchant/my-products/*', 
       array('controller' => 'products', 'action' => 'index','lang'=>'en','merchant'=>true),      
       array( 'lang' => '[a-z]{2}' )
    
    );
     Router::connect(
    '/:lang/merchant/products/*', 
       array('controller' => 'products','lang'=>'en','merchant'=>true),      
       array( 'lang' => '[a-z]{2}' )    
    );
      Router::connect(
    '/:lang/merchant/products/:action/*', 
       array('controller' => 'products','lang'=>'en','merchant'=>true),      
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
    '/:lang/merchant/:action/*', 
    array('controller' => 'merchant','lang' => 'en'),   
    array( 'lang' => '[a-z]{2}')
    
    );

     
    Router::connect(
    '/:lang/products', 
    array('controller' => 'products', 'action' => 'index','lang'=>'en'),   
    array( 'lang' => '[a-z]{2}')
    
    );

    Router::connect(
    '/:lang/products/:id-:slug', // E.g. /blog/3-CakePHP_Rocks
    array('controller' => 'products', 'action' => 'compare','lang'=>'en'),
    array(
        // order matters since this will simply map ":id" to
        // $articleId in your action
        'pass' => array('id', 'slug'),
        'id' => '[0-9]+',
        'lang' => '[a-z]{2}'
    )
   );
     Router::connect(
    '/:lang/:type-:slug-:cat_id-:dtype-:short', // E.g. /blog/3-CakePHP_Rocks
    array('controller' => 'products', 'action' => 'productlist','lang'=>'en'),
    array(
        // order matters since this will simply map ":id" to
        // $articleId in your action
        'pass'  => array('type', 'slug','cat_id','dtype','short'),
        'type'  => '(?i:(category|brand|search-for))',
        'dtype' => '(?i:(block|list))',
        'short' => '(?i:(popular|plow|phigh|ldiscount|hdiscount))',
        'cat_id'=>'[0-9]+',
        'lang' => '[a-z]{2}'
    )
   );
    Router::connect(
    '/:lang/:type-:slug-:cat_id-:dtype', // E.g. /blog/3-CakePHP_Rocks
    array('controller' => 'products', 'action' => 'productlist','lang'=>'en'),
    array(
        // order matters since this will simply map ":id" to
        // $articleId in your action
        'pass' => array('type', 'slug','cat_id','dtype'),
        'type' => '(?i:(category|brand|search-for))',
        'dtype' => '(?i:(block|list))',
        'cat_id'=>'[0-9]+',
        'lang' => '[a-z]{2}'
    )
   );
     Router::connect(
    '/:lang/:type-:slug-:cat_id-:short', // E.g. /blog/3-CakePHP_Rocks
    array('controller' => 'products', 'action' => 'productlist','lang'=>'en'),
    array(
        // order matters since this will simply map ":id" to
        // $articleId in your action
        'pass' => array('type', 'slug','cat_id','short'),
        'type' => '(?i:(category|brand|search-for))',
        'dtype' => '(?i:(block|list))',
        'short' => '(?i:(popular|plow|phigh|ldiscount|hdiscount))',
        'cat_id'=>'[0-9]+',
        'lang' => '[a-z]{2}'
    )
   );
     Router::connect(
    '/:lang/:type-:slug-:cat_id', // E.g. /blog/3-CakePHP_Rocks
    array('controller' => 'products', 'action' => 'productlist','lang'=>'en'),
    array(
        // order matters since this will simply map ":id" to
        // $articleId in your action
        'pass' => array('type', 'slug','cat_id'),
        'type' => '(?i:(category|brand|search-for))',
        'dtype' => '(?i:(block|list))',
        'cat_id'=>'[0-9]+',
        'lang' => '[a-z]{2}'
    )
   );
     Router::connect(
    '/:lang/products/:type-:slug-:dtype-:short', // E.g. /blog/3-CakePHP_Rocks
    array('controller' => 'products', 'action' => 'productlist','lang'=>'en'),
    array(
        // order matters since this will simply map ":id" to
        // $articleId in your action
        'pass' => array('type', 'slug','dtype','short'),
        'type' => '(?i:(category|brand|search-for))',
        'short' => '(?i:(popular|plow|phigh|ldiscount|hdiscount))',
        'dtype' => '(?i:(block|list))',
        'lang' => '[a-z]{2}'
    )
   );
    Router::connect(
    '/:lang/products/:type-:slug-:dtype', // E.g. /blog/3-CakePHP_Rocks
    array('controller' => 'products', 'action' => 'productlist','lang'=>'en'),
    array(
        // order matters since this will simply map ":id" to
        // $articleId in your action
        'pass' => array('type', 'slug','dtype'),
        'type' => '(?i:(category|brand|search-for))',
        'dtype' => '(?i:(block|list))',
        'lang' => '[a-z]{2}'
    )
   );
     Router::connect(
    '/:lang/:type-:slug-:dtype-:short', // E.g. /blog/3-CakePHP_Rocks
    array('controller' => 'products', 'action' => 'productlist','lang'=>'en'),
    array(
        // order matters since this will simply map ":id" to
        // $articleId in your action
        'pass' => array('type', 'slug','dtype'),
        'type' => '(?i:(category|brand|search-for))',
        'dtype' => '(?i:(block|list))',
        'type' => '(?i:(category|brand|search-for))',
        'lang' => '[a-z]{2}'
    )
   );
    Router::connect(
    '/:lang/:type-:slug-:dtype', // E.g. /blog/3-CakePHP_Rocks
    array('controller' => 'products', 'action' => 'productlist','lang'=>'en'),
    array(
        // order matters since this will simply map ":id" to
        // $articleId in your action
        'pass' => array('type', 'slug','dtype'),
        'type' => '(?i:(category|brand|search-for))',
        'dtype' => '(?i:(block|list))',
        'lang' => '[a-z]{2}'
    )
   );
     Router::connect(
    '/:lang/:type-:slug-:short', // E.g. /blog/3-CakePHP_Rocks
    array('controller' => 'products', 'action' => 'productlist','lang'=>'en'),
    array(
        // order matters since this will simply map ":id" to
        // $articleId in your action
        'pass' => array('type', 'slug','short'),
        'type' => '(?i:(category|brand|search-for))',
        'short' => '(?i:(popular|plow|phigh|ldiscount|hdiscount))',
        'lang' => '[a-z]{2}'
    )
   );
   Router::connect(
    '/:lang/:type-:slug', // E.g. /blog/3-CakePHP_Rocks
    array('controller' => 'products', 'action' => 'productlist','lang'=>'en'),
    array(
        // order matters since this will simply map ":id" to
        // $articleId in your action
        'pass' => array('type', 'slug'),
        'type' => '(?i:(category|brand|search-for))',
        'lang' => '[a-z]{2}'
    )
   );
   Router::connect(
    '/:lang/products/:type-:slug-:short', // E.g. /blog/3-CakePHP_Rocks
    array('controller' => 'products', 'action' => 'productlist','lang'=>'en'),
    array(
        // order matters since this will simply map ":id" to
        // $articleId in your action
        'pass' => array('type', 'slug','short'),
        'type' => '(?i:(category|brand|search-for))',
        'short' => '(?i:(popular|plow|phigh|ldiscount|hdiscount))',
        'lang' => '[a-z]{2}'
    )
   );
   Router::connect(
    '/:lang/products/:type-:slug', // E.g. /blog/3-CakePHP_Rocks
    array('controller' => 'products', 'action' => 'productlist','lang'=>'en'),
    array(
        // order matters since this will simply map ":id" to
        // $articleId in your action
        'pass' => array('type', 'slug'),
        'type' => '(?i:(category|brand|search-for))',
        'lang' => '[a-z]{2}'
    )
   );

    Router::connect(
    '/:lang/products/:action/*', 
    array('controller' => 'products','lang' => 'en'),   
    array( 'lang' => '[a-z]{2}')
    
    );
    Router::connect('/:lang/p/*', array('controller' => 'pages', 'action' => 'display','lang'=>'en'));
	


 /* Router::connect(
    "/:lang/{$prefix}/:controller/:action",
    array('action' => 'index', 'prefix' => $prefix, $prefix => true)
  );
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	


	Router::connect(  
	    '/robots.txt',  
	    array(  
	        'controller' => 'seo',  
	        'action' => 'robots'  
	    )  
	); 
	Router::parseExtensions('xml');
    Router::connect('/sitemap', array('controller' => 'sitemaps', 'action' => 'index','ext' => 'xml')); 
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
