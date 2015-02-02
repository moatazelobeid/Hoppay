<?php
App::uses('AppModel', 'Model');
class Page_lang extends AppModel {
	public $tablePrefix = 'mc_';
	public $belongsTo = array(
        'Page' => array(
            'className' => 'Page',
            'foreignKey' => 'pg_id'
        )	
    );
}
?>