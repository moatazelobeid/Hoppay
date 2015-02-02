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

            /*'conditions' => array('Product_category_lang.status' => '1'),*/

            'order' => "",

            'limit' => '-1',

            'dependent' => true

        ),

		

        'Product' => array(

            'className' => 'Product',

            'foreignKey' => 'category_id',

            'conditions' => array('Product.status' => '1',' Product.deleted' => '0'),

            //'conditions' => array('Product.status' => '1'),

            'order' => "",

            'limit' => '-1',

            'dependent' => true

        )

    );

 

	function getProductCount($id, $direct=false)

	{

		if (!$direct) {

			$ids = array($id);

			$children = $this->children($id);

			foreach ($children as $child) {

				$ids[] = $child['Product_category']['id'];

			}

			$id = $ids;

		}

		$this->Product->recursive = -1;

		$data = $this->Product->find('count', array(

				'conditions'=>array(

					'Product.category_id'=>$id

				)

			)

		);

		

		return $data;

	}

     public function all() {

        $model = $this;

        return Cache::remember('product_category', function() use ($model){

            return $model->find('all', array(

                'order' => 'Post.updated DESC',

                'limit' => 10

            ));

        }, 'long');

    }

 	public function afterSave($created, $options = array()) {

    if ($created) {

        /*$configs = Cache::groupConfigs('Product_category');

        foreach ($configs['Product_category'] as $config) {

            Cache::clearGroup('Product_category', $config);

        }*/

    }

    }

  

}

?>