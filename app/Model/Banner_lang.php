<?php
App::uses('AppModel', 'Model');
class Banner_lang extends AppModel {
	public $tablePrefix = 'mc_';
	public $belongsTo = array(
        'Banner' => array(
            'className' => 'Banner',
            'foreignKey' => 'banner_id'
        )	
    );
}
?>