<?php
/**
 * Feedback Form
 *
 * @package   Feedback Form
 * @author    Shane Stevens.
 * @copyright Stellenbosch Business School | @2023
 *
 * @wordpress-plugin 
 * Plugin Name: FeedbackForm
 * Description: This is a feedback form...idk what else to add here :)
 * Version: 1.0
 * Author: Shane Stevens.
 * License: Free
 */



// _________________________________________
// IMPORT ALL FILES HERE !IMPORTANT HAS TO BE ONTOP OF THE PAGE BEFORE ANY OTHER CODE IS ADDED
// eg.  require_once plugin_dir_path(__FILE__) . './file.php';

// 1CREATE
require_once plugin_dir_path(__FILE__) . './includes/01create/question_form.php'; 
// 2READ
require_once plugin_dir_path(__FILE__) . './includes/02read/Answers.php'; 
require_once plugin_dir_path(__FILE__) . './includes/02read/Thank-you.php'; 

// 3UPDATE

// 4DELETE
require_once plugin_dir_path(__FILE__) . './includes/04delete/delete.php'; 

// _________________________________________
// CREATE DATABASE TABLES ON ACTIVATING PLUGIN
function create_table_on_activate()
{
    // connect to WordPress database
    global $wpdb;

    // set table names
    $answers = $wpdb->prefix . 'answers'; // The table name is wp_admin

    $charset_collate = $wpdb->get_charset_collate();

     // mysql create tables query
    $sql = "CREATE TABLE $answers (
    id INT NOT NULL AUTO_INCREMENT,
    team VARCHAR(255),
    question_1 VARCHAR(255) NOT NULL,
    question_2 TINYINT,
    question_3 TINYINT,
    question_4 TINYINT,
    question_5 TINYINT,
    question_6 TINYINT,
    user_name VARCHAR(255),
    PRIMARY KEY (id)
            ) $charset_collate;";


    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    $result = dbDelta($sql);
    if (is_wp_error($result)) {
        echo 'There was an error creating the tables';
        return;
    }
}

register_activation_hook(__FILE__, 'create_table_on_activate');


// _________________________________________
// (!IMPORTANT DO NOT TOUCH)  CREATE PAGE FUNCTION  (!IMPORTANT DO NOT TOUCH)
function create_page($title_of_the_page, $content, $parent_id = NULL)
{
	$objPage = get_page_by_title($title_of_the_page, 'OBJECT', 'page');
	if (!empty($objPage)) {
		echo "Page already exists:" . $title_of_the_page . "<br/>";
		return $objPage->ID;
	}
	$page_id = wp_insert_post(
		array(
			'comment_status' => 'close',
			'ping_status' => 'close',
			'post_author' => 1,
			'post_title' => ucwords($title_of_the_page),
			'post_name' => strtolower(str_replace(' ', '-', trim($title_of_the_page))),
			'post_status' => 'publish',
			'post_content' => $content,
			'post_type' => 'page',
			'post_parent' => $parent_id //'id_of_the_parent_page_if_it_available'
		)
	);
	echo "Created page_id=" . $page_id . " for page '" . $title_of_the_page . "'<br/>";
	return $page_id;
}


// _________________________________________
// ACTIVATE PLUGIN
function on_activating_your_plugin()
{
    // _________________________________________
	//  CREATE WP PAGES AUTOMATICALLY ANLONG WITH SHORT CODE TO DISPLAY THE CONTENT
	// eg.  create_page('page-name', '[short-code]');
    // _________________________________________
    
    // 1CREATE
    create_page('question_form', '[question_form]');

    // 2READ
    create_page('answers', '[answers]');
    create_page('thanks', '[thanks]');
  


    // 3UPDATE


}
register_activation_hook(__FILE__, 'on_activating_your_plugin');




// _________________________________________
// DEACTIVATE PLUGIN
function on_deactivating_your_plugin()
{
    // _________________________________________
	//  DELETE WP PAGES AUTOMATICALLY ANLONG WITH SHORT CODE TO DISPLAY THE CONTENT
	// eg. 	
    // $page_name = get_page_by_path('page_name');
	// wp_delete_post($page_name->ID, true);
    // _________________________________________

    // 1CREATE
    $question_form = get_page_by_path('question_form');
	wp_delete_post($question_form->ID, true); // question_form

    // 2READ
    $answers = get_page_by_path('answers');
	wp_delete_post($answers->ID, true); // answers
    $thanks = get_page_by_path('thanks');
	wp_delete_post($thanks->ID, true); // thanks


    // 3UPDATE


}
register_deactivation_hook(__FILE__, 'on_deactivating_your_plugin');

?>