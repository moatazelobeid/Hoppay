<?php
App::uses('AppModel', 'Model');
class Product_category extends AppModel {
    public $actsAs = array('Tree');
	public $tablePrefix = 'mc_';
	public $belongsTo = array(
        'Parent' => array(
            'className' => 'Product_category',
            'foreignKey' => 'parent_id'
        )
    );
    public $hasMany = array(
        'Product_category_lang' => array(
            'className' => 'Product_category_lang',
            'foreignKey' => 'cat_id',
            'conditions' => array('Product_category_lang.status' => '1'),
            'order' => "",
            'limit' => '-1',
            'dependent' => true
        )
    );
 
}
?>