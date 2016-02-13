<?php

$db->execute("
	CREATE TABLE `exec_job` (
		`job_id` int(10) unsigned NOT NULL auto_increment,
		`task_id` int(10) unsigned NOT NULL,
		`created_at` datetime NOT NULL,
		`executed_at` datetime NULL,
		`response` blob NULL,
		`locked_till` datetime NULL,
		PRIMARY KEY (job_id) USING BTREE
	) ENGINE = InnoDB;
	
	CREATE TABLE `exec_settings` (
		`key` varchar(255) NOT NULL,
		`value` longblob NULL,
		PRIMARY KEY (`key`) USING BTREE
	) ENGINE = MyISAM;
	
	CREATE TABLE `exec_task` (
		`task_id` int(10) unsigned NOT NULL auto_increment,
		`script` varchar(255) NOT NULL,
		`title` varchar(255) NOT NULL,
		`executed_at` datetime NULL,
		PRIMARY KEY (task_id) USING BTREE
	) ENGINE = InnoDB;
	
	
");
