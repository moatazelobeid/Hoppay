<?php
App::uses('AppModel', 'Model');
class Product_category_lang extends AppModel {
	public $tablePrefix = 'mc_';
	public $belongsTo = array(
        'Product_category' => array(
            'className' => 'Product_category',
            'foreignKey' => 'cat_id'
        )
    );
}
?>