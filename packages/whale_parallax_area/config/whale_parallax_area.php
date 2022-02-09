<?php
defined('C5_EXECUTE') or die(_("Access Denied."));
/*
THIS IS A SAMPLE FILE, CONTAINS AVAILABLE CONFIGS FOR THIS ADD-ON.
For using any of this configs for this add-on, copy this file to /application/config/ and change them to match your requirement.
//var_dump(Config::get('whale_parallax_area.permission'));

- permission: 
	who can access/modify galleries at dashboard:
		0: all users
		1: only super admin and owner
		2: only owner
- notice_list:
	print a notice above dashboard grid for users
- notice_form
	print a notice above dashboard add/edit form for users
*/
return array(
    'permission' => 0,
    'notice_list' => '',
    'notice_form' => '',
);
