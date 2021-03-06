<?php

return array(
	'tables' => array(
		'users' => array(
			'columns' => array(
				'id' => array('pk' => true),
				'jira_url' => array('type' => 'text', 'null' => false),
				'jira_user' => array('type' => 'text', 'null' => false),
				'index_query' => array('type' => 'text'),
				'index_project' => array('type' => 'text'),
				'index_filter' => array('unsigned' => true),
				'last_sync' => array('unsigned' => true),
				'jira_timezone' => array('type' => 'text'),
				'created' => array('unsigned' => true, 'default' => 0),
				'cache__custom_field_ids' => array('type' => 'blob'),
				'cache__agile_boards' => array('type' => 'blob'),
			),
			'indexes' => array(
				'user' => array(
					'unique' => true,
					'columns' => array('jira_url', 'jira_user'),
				),
			),
		),
		'options' => array(
			'columns' => array(
				'user_id' => array('unsigned' => true),
				'name' => array('type' => 'text', 'null' => false),
				'value' => array('type' => 'text'),
			),
			'indexes' => array(
				'option' => array(
					'unique' => true,
					'columns' => array('user_id', 'name'),
				),
			),
		),
		'filters' => array(
			'columns' => array(
				'user_id' => array('unsigned' => true),
				'filter_id' => array('unsigned' => true),
				'name' => array('type' => 'text', 'null' => false),
				'jql' => array('type' => 'text', 'null' => false),
			),
			'indexes' => array(
				'filter' => array(
					'unique' => true,
					'columns' => array('user_id', 'filter_id'),
				),
			),
		),
		'variables' => array(
			'columns' => array(
				'id' => array('pk' => true),
				'user_id' => array('unsigned' => true),
				'name' => array('type' => 'text', 'null' => false),
				'regex' => array('type' => 'text', 'null' => false),
				'replacement' => array('type' => 'text', 'null' => false),
				'value' => array('type' => 'text', 'null' => false, 'default' => 0),
				'auto_update_type' => array('type' => 'text', 'null' => false, 'default' => ''),
				'last_update' => array('unsigned' => true, 'default' => 0),
			),
		),
	),
);

