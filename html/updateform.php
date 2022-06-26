<?php

require_once __DIR__ . "/../includes/db-inc.php";
require_once __DIR__ . "/../config.php";

session_start();

if (!isset($_SESSION["email"])) {
  header("location: {$baseUrl}?page=signin&result=failed&msg=loginfaild");
  die();
}
if (isset($_GET["termin"])) {
  $appointmentId = $_GET["termin"];

  $sqlQuery = "SELECT * from usertermins WHERE appointmentId = $appointmentId ;";

  $terminInfo = mysqli_fetch_assoc(mysqli_query($dbConnect, $sqlQuery));
  $terminTopic = $terminInfo['terminTopic'];
  $terminLocation = $terminInfo['terminLocation'];
  $startDateTime = $terminInfo['startDateTime'];
  $endDateTime = $terminInfo['endDateTime'];
  $comments = $terminInfo['importantComments'];
  $participants = $terminInfo['participants'];
}
?>

<!DOCTYPE html>
<html>

<head>

</head>

<body>

  <div class="container">
    <form action="<?= $baseUrl ?>includes/termindelete-inc.php" method="POST" enctype="multipart/form-data">
      <h3>update <?= $terminTopic ?> </h3>

      <label for="topic"><b>Subject</b></label>
      <input name="topic" type="text" value="<?= $terminTopic ?>" />
      <br />
      <label for="starttime"><b>Starts at</b></label>
      <input name="startdate" type="datetime" value="<?= $startDateTime ?>" />
      <br />
      <label for="endtime"><b>Ends at</b></label>
      <input name="enddate" type="datetime" value="<?= $endDateTime ?>" />
      <br />
      <label for="location"><b>Location</b></label>
      <input name="place" type="text" value="<?= $terminLocation ?>" />
      <br />
      <label for="participants"><b>Participants</b></label>
      <input name="participants" type="text" value="<?= $participants ?>" />
      <br />
      <label for="comments"><b>Additional comments</b></label>
      <input name="explanation" type="text" placeholder="explanation" value="<?= $comments ?>" />
      <br />
      <label for="attachments"><b>Attachments</b></label>
      <input name="attachments" type="file" required />
      <b>File Size < 10MB</b>
          <br />
          <select name="runningstatus">
            <option>select running status</option>
            <option value="open">It is still open</option>
            <option value="closed">It is already closed</option>
          </select>
          <select name="status">
            <option>select flexibility status</option>
            <option value="flexible">flexible</option>
            <option value="not flexible">not flexible</option>
            <option value="postponded">Postponed</option>
            <option value="cancelled">cancelled</option>
            <option value="done">done</option>

          </select>
          <br />
          <button name="submit" value='"<?= $appointmentId ?>"."sendupdate"' type="submit" class="btn">
            update termin information
          </button>
    </form>
    <br>
    <br>
    <button onclick="history.back()">GoTo Dashboard</button>
  </div>

</body>

</html>