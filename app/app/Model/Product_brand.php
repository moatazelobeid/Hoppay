<?php

App::uses('AppModel', 'Model');

class Product_brand extends AppModel {    

	public $tablePrefix = 'mc_';

	 public $hasMany = array(

        'Product_brand_lang' => array(

            'className' => 'Product_brand_lang',

            'foreignKey' => 'brand_id',

            'conditions' => array('Product_brand_lang.status' => '1'),

            'order' => "",

            'limit' => '-1',

            'dependent' => true

        ),

        'Product' => array(

            'className' => 'Product',

            'foreignKey' => 'brand',

            //'conditions' => array('Product.status' => '1',' Product.deleted' => '0'),

            'conditions' => array('Product.status' => '1'),

            'order' => "",

            'limit' => '-1',

            'dependent' => true

        )

    );

	function getProductCount($id)

	{

		

		$this->Product->recursive = -1;

		$data = $this->Product->find('count', array(

				'conditions'=>array(

					'Product.brand'=>$id,

					'Product.status'=>1,
                    'Product.category_id !='=>'',
					//'Product.deleted'=>0

				)

			)

		);

		

		return $data;

	}

}

?>