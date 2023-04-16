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

      <form action="poststatusprocess.php" method="POST" novalidate>
         <div class="center">
            <br>
            <fieldset>
               <legend><b>Status Code:</b></legend>
               <input type="text" name="statuscode" placeholder="S####" style="text-transform:uppercase" maxlength="5" autocomplete="off" class="statuscode" autofocus /><br>
               <small>*Required</small><br>
            </fieldset>


            <fieldset>
               <legend><b>Status:</b></legend>
               <textarea name="status" class="textarea" placeholder="Type a status...."></textarea><br>

               <small>*Required</small><br>
            </fieldset>


            <fieldset>
               <legend><b> Share:</b></legend>
               <input type="radio" name="share" value="Public" /> Public
               <input type="radio" name="share" value="Friends" /> Friends
               <input type="radio" name="share" value="Only Me" /> Only Me
            </fieldset>


            <fieldset>
               <legend><b>Date:</b></legend>
               <input type="date" name="date" value=<?php echo date("Y-m-d") ?> max="9999-12-31" /><br>
            </fieldset>


            <fieldset>
               <legend><b>Permission Type:</b></legend>
               <input type="checkbox" name="p_like" value="Allow Like" />Allow Like
               <input type="checkbox" name="p_comments" value="Allow Comments" />Allow Comments
               <input type="checkbox" name="p_share" value="Allow Share" />Allow Share
            </fieldset>


            <br>
            <input type="submit" value="Submit" class="button" />
            <input type="reset" value="Reset" class="button" />

            <p>
            <div class="bottombar">
               <a href="index.html"><input type="submit" value="Return to Home Page" class="button"></a>
            </div>
         </div>
   </div>

   </form>
</body>

</html>