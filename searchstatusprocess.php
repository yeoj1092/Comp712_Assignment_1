<!DOCTYPE html>

<head>
    <title>MySQL Databases with PHP</title>
    <link rel="stylesheet" href="style.css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>
    <div class="content">
        <div class="title">
            <h1>Status Information</h1>
        </div>

        <div class="navbar">
            <a href="index.html" class="button">Home page</a>
            <a href="poststatusform.php" class="button">Post a new status</a>
            <a href="searchstatusform.html" class="button">Search status</a>
            <a href="about.html" class="button">about the assessment</a>
        </div>

        <?php
        //initialize varables from searchstatusform.html
        $user_search = $_GET["search"];

        // check if variable is not empty and NULL
        if (empty($user_search)) {

            //user empty searched error message
            echo "<p>Error:Cannot be empty. Please enter a keyword to search.</p>";
        } else {


            //database connection
            require_once('../../conf/account.inc.php');
            $conn = @mysqli_connect(
                $sql_host,
                $sql_user,
                $sql_pass,
                $sql_db
            );

            if ($conn) {
                // DATABASE CONNECTED!

                // check if database table exists
                $table_exists = mysqli_query($conn, "SELECT * FROM $sql_table;");
                if (!$table_exists) {
                    echo "<p>Error: no records of database</p>";
                } else {
                    //checks if user enters empty space.
                    if (ctype_space($user_search)) {
                        echo "<br><p style='color:red'>ERROR: Search cannot be empty whitespaces.</p><br>";
                        //checks for user input for accepted characters
                    } else if (!preg_match('/^[a-zA-Z0-9\s\.,!?]*$/', $user_search)) {
                        echo "<p style='color:red'>ERROR: Search can only contain alphanumericals, comma, period(full stop), exclamation mark and question mark.</p>";
                    } else {
                        //database table exist

                        //checks all from database table where column Status has a certain keyword searched by user
                        $search_query = "SELECT * FROM $sql_table WHERE Status LIKE '%$user_search%'";
                        $search_results = mysqli_query($conn, $search_query);

                        //counter for results matches
                        $status_matched = 0;

                        if (!mysqli_num_rows($search_results)) {
                            // show error no matches found in database table with user keyword
                            echo "<p>No status could be found that matches $user_search</p>";
                        } else {
                            echo "<br><div class='scroll'>";
                            //getting results from sql
                            while ($row = mysqli_fetch_array($search_results)) {

                                //counter
                                $status_matched += 1;

                                //prints database results for user searched keyword
                                echo "<p>Status: " . $row["Status"],
                                "<br>Status code: " . $row["Statuscode"] . "<br>",
                                "<br>Share: " . $row["Share"],
                                "<br>Date Posted: " . date("jS F, Y", strtotime($row["Date"])),
                                "<br>Permissions: " . $row["p_like"] . " " . $row["p_comments"] . " " . $row["p_share"],
                                "</p><hr>";
                            }
                            //shows matches of users results
                            echo "</div>";
                            echo "<p class='center'>Matches found: $status_matched</p>";
                        }
                    }
                }
            } else {
                // database error message
                echo "<p>Database connection failure</p>";
            }
            //close results and connections
            mysqli_free_result($search_results);
            mysqli_close($conn);
        }


        ?>
        <div class="bottombar">
            <a href="searchstatusform.html"><input type="submit" value="Search Status" class="button"></a>
            <a href="index.html"><input type="submit" value="Return to Home Page" class="button"></a>
        </div>
    </div>

</body>

</html>