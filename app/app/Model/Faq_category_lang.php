<?php
App::uses('AppModel', 'Model');
class Faq_category_lang extends AppModel {
	public $tablePrefix = 'mc_';
	public $belongsTo = array(
        'Faq_category' => array(
            'className' => 'Faq_category',
            'foreignKey' => 'cat_id'
        )
    );
}
?>