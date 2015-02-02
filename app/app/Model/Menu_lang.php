<?php
App::uses('AppModel', 'Model');
class Menu_lang extends AppModel {
	public $tablePrefix = 'mc_';
	public $belongsTo = array(
        'Menu' => array(
            'className' => 'Menu',
            'foreignKey' => 'menu_id'
        )
    );
}
?>