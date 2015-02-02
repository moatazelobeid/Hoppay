<?php
App::uses('AppModel', 'Model');
class Product extends AppModel {
	public $tablePrefix = 'mc_';
	public $belongsTo = array(
        'Product_category' => array(
            'className' => 'Product_category',
            'foreignKey' => 'category_id'
        ),'Offer' => array(
            'className' => 'Offer',
            'foreignKey' => 'offer_id',           
        )
        ,'Product_brand' => array(
            'className' => 'Product_brand',
            'foreignKey' => 'brand'
        ),
        'Merchant' => array(
            'className' => 'Merchant',
            'foreignKey' => 'retailer_id'
        ),

    );
   /* public $hasAndBelongsToMany = array(
       
                'associationForeignKey' => 'product_id',
               
            
        )
    );*/
    public $hasMany = array(
        'Product_lang' => array(
            'className' => 'Product_lang',
            'foreignKey' => 'product_id',
            'conditions' => array('Product_lang.status' => '1'),
            'order' => "",
            'limit' => '-1',
            'dependent' => true
        ),
        'Product_review' => array(
            'className' => 'Product_review',
            'foreignKey' => 'product_id',
            'conditions' => array('Product_review.status' => 1),
            'order' => "",
            'limit' => '-1',
            'dependent' => true
        ),        
        'Unique_visitor' => array(
            'className' => 'Unique_visitor',
            'foreignKey' => 'product_id',
            'conditions' => array(),
            'group' => array('unique_id,ip'),
            'limit' => '-1',
            'dependent' => true
        ),
    );

    /* public function all() {
        $model = $this;
        return Cache::remember('product', function() use ($model){
            return $model->find('all', array(
                'order' => 'Product.id DESC',
                'limit' => 10
            ));
        }, 'long');
    }
    public function afterSave($created, $options = array()) {
    if ($created) {
        $configs = Cache::groupConfigs('Product');
        foreach ($configs['Product'] as $config) {
            Cache::clearGroup('Product', $config);
        }
    }
}*/
  
     
}
?>