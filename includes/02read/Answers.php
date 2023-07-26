<?php
// Function to fetch and display the answers data in a table
function display_answers_data() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'answers';

    $results = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);

    if (empty($results)) {
        return '<p>No answers found.</p>';
    }

    $output = '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">';
    $output .= '<div id="table-container"><table class="table-bordered table-responsive">';
    $output .= '<tr>';
    $output .= '<th>ID</th>';
    $output .= '<th>Team</th>';
    $output .= '<th>Question 1</th>';
    $output .= '<th>Question 2</th>';
    $output .= '<th>Question 3</th>';
    $output .= '<th>Question 4</th>';
    $output .= '<th>Question 5</th>';
    $output .= '<th>Question 6</th>';
    $output .= '<th>Total Score(25)</th>';
    $output .= '<th>Percentage</th>';
    $output .= '<th>User Name</th>';
    $output .= '<th id="th-operators">OPERATORS</th>';
    $output .= '</tr>';

    foreach ($results as $row) {
        $total_score = $row['question_2'] + $row['question_3'] + $row['question_4'] + $row['question_5'] + $row['question_6'];
        $percentage = ($total_score / 25) * 100;
        $rounded_percentage = round($percentage, 2);

        $output .= '<tr>';
        $output .= '<td>' . $row['id'] . '</td>';
        $output .= '<td>' . $row['team'] . '</td>';
        $output .= '<td>' . $row['question_1'] . '</td>';
        $output .= '<td>' . $row['question_2'] . '</td>';
        $output .= '<td>' . $row['question_3'] . '</td>';
        $output .= '<td>' . $row['question_4'] . '</td>';
        $output .= '<td>' . $row['question_5'] . '</td>';
        $output .= '<td>' . $row['question_6'] . '</td>';
        $output .= '<td>' . $total_score . '</td>';
        $output .= '<td>' . $rounded_percentage . '%</td>';
        $output .= '<td>' . $row['user_name'] . '</td>';
        $output .= '<td id="td-operators">';
        $output .= '<button class="btn btn-danger" onclick="deleteAnswer(' . $row['id'] . ')">Delete</button>';
        $output .= '</td>';
        $output .= '</tr>';
    }

    $output .= '</table></div>';
    ?>
    <style scoped>
        th {
            padding: 10px;
        }
        @media only screen and (max-width: 1023px){
            #table-container{
            width: 100%;
           overflow-x: scroll;
        }
}
      
    </style>
    <?php
    $output .= '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>';
    $output .= '<script>
        function deleteAnswer(answerId) {
            if (confirm("Are you sure you want to delete this answer?")) {
                fetch("' . admin_url('admin-ajax.php') . '", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "action=delete_answer&answer_id=" + answerId
                })
                .then(function (response) {
                    window.location.reload();
                })
                .catch(function (error) {
                    console.error("Error deleting answer:", error);
                });
            }
        }
    </script>';

    return $output;
}

add_shortcode('answers', 'display_answers_data');

// Add AJAX handler to delete answer
add_action('wp_ajax_delete_answer', 'delete_answer_callback');
add_action('wp_ajax_nopriv_delete_answer', 'delete_answer_callback');
function delete_answer_callback() {
    if (isset($_POST['answer_id']) && is_numeric($_POST['answer_id'])) {
        $answer_id = intval($_POST['answer_id']);
        global $wpdb;
        $table_name = $wpdb->prefix . 'answers';
        $wpdb->delete(
            $table_name,
            array('id' => $answer_id),
            array('%d')
        );
        echo "success";
    }
    wp_die();
}
