<?php
function delete_answers($id)
{
    // ____________________________________________________________________________
    // connect to database.
    global $wpdb;
    // check connection
    if (!$wpdb) {
        $wpdb->show_errors();
    }

    // ____________________________________________________________________________
    // Table name
    $table_name = $wpdb->prefix . 'answers';
    // SQL query to delete the row with the specified ID
    $wpdb->delete($table_name, array('id' => $id));

}

if (isset($_GET['action']) && $_GET['action'] == 'delete(answers)' && isset($_GET['id'])) {
    delete_answers($_GET['id']);
    // Redirect to the student details page after deletion
    header('location:' . site_url() . '/answers/');
    exit;
}

?>