<?php
// Function to display the form for answering the questions
function display_question_form() {
    ob_start(); // Start output buffering

    // Check if the form is submitted
    if (isset($_POST['submit'])) {
        // Validate and sanitize the input data (you can add more validation as needed)
        $team = sanitize_text_field($_POST['team']);
        $question_1 = sanitize_text_field($_POST['question_1']);
        $user_name = sanitize_text_field($_POST['user_name']);
        $ratings = array();
        for ($i = 1; $i <= 6; $i++) { // Updated for the five questions
            // Validate each question's rating (you can add more validation as needed)
            $rating = isset($_POST['question_' . $i]) ? intval($_POST['question_' . $i]) : 0;
            $ratings["question_$i"] = $rating;
        }

        // Insert the data into the "answers" table
        global $wpdb;
        $table_name = $wpdb->prefix . 'answers';
        $wpdb->insert(
            $table_name,
            array(
                'team' => $team,
                'question_1' => $question_1,
                'question_2' => $ratings['question_2'],
                'question_3' => $ratings['question_3'],
                'question_4' => $ratings['question_4'],
                'question_5' => $ratings['question_5'],
                'question_6' => $ratings['question_6'],
                'user_name' => $user_name,
            )
        );

        $redirect_url = site_url('/thanks/');
        ?>
        <script>
            window.location.href = "<?php echo $redirect_url; ?>";
        </script>
        <?php
    
        exit; // Ensure that the redirect is executed
    }

    // Display the form
    ?>
<style scoped>
:root{
    --inputpadding: 10px !important;
    --labelmargin: 1rem !important;
}

*{
    font-weight: 500;
}
#user_name::placeholder,  #question_1::placeholder{
    font-weight: 500;
}
form{
    /* background-color: #26262638 !important; */
    padding: var(--inputpadding);
    border-radius: 10px;
}

label{
    margin-top: var(--labelmargin);
}
    #user_name, #team{
        width: 100%;
        padding: var(--inputpadding);
        border: 1px solid black;
    }
    #question_1{
        display: flex;
        justify-content: start;
        align-items: start;
        align-content: flex-start;
        width: 100%;
        padding: var(--inputpadding);
        border: 1px solid black;
    }
    #start_rating_heading{
        margin-top: var(--labelmargin);
    }

    select option{
        text-transform: uppercase;
    }


    /* Add custom CSS styles for star ratings */
    input[type="radio"].star {
        display: none; /* Hide the default radio button */
    }

    label.star {
        font-size: 2rem;
        color: black;
        margin-left: 5px;
        cursor: pointer;
    }

    label.star:before {
        content: '\2606'; /* Unicode character for empty star */
    }

    input[type="radio"].star:checked ~ label.star:before {
        content: '\2605'; /* Unicode character for filled star */
        color: #FFD700; /* Yellow color for filled star */
    }

    /* Reverse the order of the stars */
    .star-rating-container {
        display: flex;
        flex-direction: row-reverse;
        justify-content: start;
        align-items: start;

    }


    #submit_answers_btn{
        width: 100%;
        padding: var(--inputpadding);
        background-color: transparent !important;
        color: black !important;
    }

</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-10 ">
           <form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="post">
    <!-- Form fields for team selection and user name -->
    <label for="user_name">Full Name:</label><br>
        <input type="text" name="user_name" id="user_name" placeholder="Enter your full name here..." required><br>

    <label for="team">Select Team:</label><br>
            <select name="team" id="team" required>
            <option value="">Select a team</option>
            <option value="team 1">team 1</option>
            <option value="team 2">team 2</option>
            <option value="team 3">team 3</option>
            <option value="team 4">team 4</option>
            <option value="team 5">team 5</option>
            <option value="team 6">team 6</option>
            <option value="team 7">team 7</option>
            <option value="team 8">team 8</option>
            <option value="team 9">team 9</option>
            <option value="team 10">team 10</option>
            <option value="team 11">team 11</option>
            <option value="team 12">team 12</option>
            <option value="team 13">team 13</option>
            <option value="team 14">team 14</option>
            <option value="team 15">team 15</option>
            <option value="team 16">team 16</option>
            <option value="team 17">team 17</option>
            <option value="team 18">team 18</option>
        </select><br>
    <p id="start_rating_heading">Answer the following questions:</p>
    <!-- Updated for the five questions -->
    <label for="question_1">1. Enter the name of your selected company for the team assignment</label><br>
    <div class="star-rating-container">
     <input type="text" name="question_1" id="question_1" placeholder="Enter your company name here..." required>
    </div>
    <br>
    <label for="question_2">2. How effective do they describe the (double) materiality of climate change for the company (rate from 1 to 5)?</label><br>
    <div class="star-rating-container">
        <?php for ($rating = 5; $rating >= 1; $rating--) : ?>
            <input type="radio" name="question_2" value="<?php echo $rating; ?>" class="star" id="question_2_<?php echo $rating; ?>">
            <label class="star" for="question_2_<?php echo $rating; ?>"></label>
        <?php endfor; ?>
    </div>
    <br>

    <label for="question_3">3. To what degree is climate change included in their risk management, including reference to the TCFD requirements (rate from 1 to 5)?</label><br>
    <div class="star-rating-container">
        <?php for ($rating = 5; $rating >= 1; $rating--) : ?>
            <input type="radio" name="question_3" value="<?php echo $rating; ?>" class="star" id="question_3_<?php echo $rating; ?>">
            <label class="star" for="question_3_<?php echo $rating; ?>"></label>
        <?php endfor; ?>
    </div>
    <br>

    <label for="question_4">4. Do they indicate what their long-term (e.g. 2050) climate objectives are, especially GHG reduction targets and their commitment to net zero (rate from 1 to 5)?</label><br>
    <div class="star-rating-container">
        <?php for ($rating = 5; $rating >= 1; $rating--) : ?>
            <input type="radio" name="question_4" value="<?php echo $rating; ?>" class="star" id="question_4_<?php echo $rating; ?>">
            <label class="star" for="question_4_<?php echo $rating; ?>"></label>
        <?php endfor; ?>
    </div>
    <br>

    <label for="question_5">5. Do they report financial values for the present and/or future impact of climate change on their financial results (rate from 1 to 5)?</label><br>
    <div class="star-rating-container">
        <?php for ($rating = 5; $rating >= 1; $rating--) : ?>
            <input type="radio" name="question_5" value="<?php echo $rating; ?>" class="star" id="question_5_<?php echo $rating; ?>">
            <label class="star" for="question_5_<?php echo $rating; ?>"></label>
        <?php endfor; ?>
    </div>
    <br>

    <label for="question_6">6. How convincing is their climate change disclosure to a responsible investor (rate from 1 to 5)?</label><br>
    <div class="star-rating-container">
        <?php for ($rating = 5; $rating >= 1; $rating--) : ?>
            <input type="radio" name="question_6" value="<?php echo $rating; ?>" class="star" id="question_6_<?php echo $rating; ?>">
            <label class="star" for="question_6_<?php echo $rating; ?>"></label>
        <?php endfor; ?>
    </div>
    <br>

    <button type="submit" name="submit" value="Submit" id="submit_answers_btn">
    <span class="box" >
        SUBMIT!
    </span>
</button>

</form>
 
        </div>
    </div>
</div>
<!-- submit btn css -->
<style scoped>
    .box {
  width: 100%;
  height: auto;
  float: left;
  transition: .5s linear;
  position: relative;
  display: block;
  overflow: hidden;
  padding: 15px;
  text-align: center;
  margin: 0 5px;
  background: transparent !important;
  text-transform: uppercase;
  font-weight: 900;
  box-shadow: 0px 0px 10px black;
}

.box:before {
  position: absolute;
  content: '';
  left: 0;
  bottom: 0;
  height: 4px;
  width: 100%;
  border-bottom: 4px solid transparent;
  border-left: 4px solid transparent;
  box-sizing: border-box;
  transform: translateX(100%);
}

.box:after {
  position: absolute;
  content: '';
  top: 0;
  left: 0;
  width: 100%;
  height: 4px;
  border-top: 4px solid transparent;
  border-right: 4px solid transparent;
  box-sizing: border-box;
  transform: translateX(-100%);
}

.box:hover {
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
}

.box:hover:before {
  border-color: #262626;
  height: 100%;
  transform: translateX(0);
  transition: .5s transform linear, .5s height linear .5s;
}

.box:hover:after {
  border-color: #262626;
  height: 100%;
  transform: translateX(0);
  transition: .5s transform linear, .5s height linear .5s;
}

button {
  color: black;
  text-decoration: none;
  cursor: pointer;
  outline: none;
  border: none;
  background: transparent;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<?php
    return ob_get_clean(); // Return the buffered content as a string
}
add_shortcode('question_form', 'display_question_form');
?>
