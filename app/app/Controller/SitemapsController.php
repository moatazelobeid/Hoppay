<?php 
class SitemapsController extends AppController{ 

    var $name = 'Sitemaps'; 
    var $uses = array('Product', 'Product_category'); 
    var $helpers = array('Time'); 
    var $components = array('RequestHandler'); 

    function index (){   
    $this->layout="sitemap";   
    $product=$this->Product->find('all',array('conditions'=>array('Product.status'=>1,'Product.category_id !='=>"",'Product.brand !='=>"")));
      $this->set('products',$product);
        /*$this->set('posts', $this->Post->find('all', array( 'conditions' => array('is_published'=>1,'is_public'=>'1'), 'fields' => array('date_modified','id'))));
        $this->set('pages', $this->Info->find('all', array( 'conditions' => array('ispublished' => 1 ), 'fields' => array('date_modified','id','url'))));*/
//debug logs will destroy xml format, make sure were not in drbug mode 
$this->RequestHandler->respondAs('xml');
Configure::write ('debug', 2); 
    } 
} 
?>