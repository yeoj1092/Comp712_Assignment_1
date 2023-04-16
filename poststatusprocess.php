<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>
    <title>Post Status</title>
    <link rel="stylesheet" href="style.css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>
    <div class="content">
        <div class="title">
            <h1>Status Posting System</h1>
        </div>
        <div class="navbar">
            <a href="index.html" class="button">Home page</a>
            <a href="poststatusform.php" class="button">Post a new status</a>
            <a href="searchstatusform.html" class="button">Search status</a>
            <a href="about.html" class="button">about the assessment</a>
        </div>

        <?php

        //initialize varables from poststatusform.php
        $status_code = strtoupper($_POST["statuscode"]);
        $status = $_POST["status"];
        $share = $_POST["share"];
        $date = $_POST["date"];
        $p_like = $_POST["p_like"];
        $p_comments = $_POST["p_comments"];
        $p_share = $_POST["p_share"];

        //input error message.
        $error_message = "";

        //checks if status code is empty
        if (empty($status_code)) {
            $error_message .= "<p style='color:red'>ERROR: Status is empty. Please set a status code with the following format. e.g. S0001.</p>";
            //checks status code format
        } else if (!preg_match('/^S[0-9]{4}$/', $status_code)) {
            $error_message .= "<p style='color:red'>ERROR: Wrong format. Please set a status code with the following format. e.g. S0001.</p>";
        }

        //checks if status is empty
        if (empty($status)) {
            $error_message .= "<p style='color:red'>ERROR: Status is empty. Please fill in status.</p>";

            //checks if status code contains only spaces.
        } else if (ctype_space($status)) {
            $error_message .= "<p style='color:red'>ERROR: Wrong format. Status cannot start with a space.</p>";

            //checks if stauts code contains other specials characters.
        } else if (!preg_match('/^[a-zA-Z0-9\s\.,!?]*$/', $status)) {
            $error_message .= "<p style='color:red'>ERROR: Wrong format. Status can only contain alphanumericals, comma, period(full stop), exclamation mark and question mark.</p>";
        }

        //checks if date is valid
        list($year, $month, $day) = explode('-', $date);
        if (empty($date)) {
            $error_message .= "<p style='color:red'>ERROR: Date was not set or does not exist. Please Set a valid date.</p>";
        }

        //checks if share is selected
        if ($share == "") {
            $error_message .= "<p style='color:red'>ERROR: Share button was empty. Please select a share button.</p>";
        }

        //prints error message before entering into database
        if (!empty($error_message)) {
            echo $error_message;
        } else {

            //login details for database
            require_once('../../conf/account.inc.php');
            $conn = @mysqli_connect(
                $sql_host,
                $sql_user,
                $sql_pass,
                $sql_db
            );

            //database connection
            if (!$conn) {
                //database error message
                echo "<p style='color:red'>ERROR: Failed to connect</p>";
            } else {
                //database connected

                //checking for database 
                $table_exists = mysqli_query($conn, "SELECT * FROM $sql_table;");
                if (!$table_exists) {

                    //creating table in database
                    $create_table = "CREATE TABLE statuspost (Statuscode VARCHAR(5) PRIMARY KEY, Status VARCHAR(255), Share VARCHAR(7), Date DATE, p_like VARCHAR(20), p_comments VARCHAR(20), p_share VARCHAR(20))";
                    mysqli_query($conn, $create_table);
                }

                //checks if status code is already inside the database
                $code_query = "SELECT Statuscode FROM $sql_table WHERE Statuscode = '$status_code';";
                $code_results = mysqli_query($conn, $code_query);

                //this checks inside the row if there is a results that matches.
                if (mysqli_num_rows($code_results)) {
                    echo "<p style='color:red'>ERROR: Status code '$status_code' already exist in database:<br>";
                    echo "Please try another Status code.</p>";
                } else {

                    //insert user inputs into database
                    $insert_query = "INSERT INTO `$sql_table` (`Statuscode`, `Status`, `Share`, `Date`, `p_like`, `p_comments`, `p_share`) VALUES ('$status_code','$status','$share','$date','$p_like','$p_comments','$p_share');";
                    $insert_results = mysqli_query($conn, $insert_query);


                    //checks if query is inserted into the database.
                    if (!$insert_results) {
                        //Failed error message
                        echo "<p style='color:red'>ERROR: ", $insert_query, " Failed</p>";
                    } else {
                        //Successful 
                        echo "<p>Congratulation! The status has been posted!</p>";
                    }
                }
            }

            //close results and connections
            mysqli_free_result($code_results);
            mysqli_free_result($insert_results);
            mysqli_close($conn);
        }

        ?>
        <div class="bottombar">

            <a href="poststatusform.php"><input type="submit" value="Post a new status" class="button"></a>
            <a href="index.html"><input type="submit" value="Return to Home Page" class="button"></a>
        </div>

    </div>



</body>

</html>