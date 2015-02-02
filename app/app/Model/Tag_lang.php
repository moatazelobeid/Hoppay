<?php
App::uses('AppModel', 'Model');
class Tag_lang extends AppModel {
	public $tablePrefix = 'mc_';
	public $belongsTo = array(
        'Tag' => array(
            'className' => 'Tag',
            'foreignKey' => 'tag_id',
           
        )	
    );
}
?>