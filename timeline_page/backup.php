<?php
	error_reporting(0);
	require __DIR__ . '/vendor/autoload.php';
//	use Google_Service_Calendar_Event;

	$conn = mysqli_connect("localhost", "root", "", "testing");
	if(! $conn ) {
		die('Could not connect: ' . mysqli_error());
	}
	$projectid=$_POST['projectid'];
	$Activity = $_POST['Activity'];
	$Date = $_POST['Date'];
	$Location = $_POST['Location'];
	$type=$_POST['type'];
	$sql ="INSERT INTO timeline( projectid, Activity, Date, Location, Attendance, time, impact, money,revenue, type, note) VALUES('$projectid','$Activity','$Date','$Location','','','0','0','0','$type','')";
	$calender="SELECT E_mail FROM member WHERE p_id='$projectid' ";
	$gmail=mysqli_query($conn,$calender);
	$fetch=mysqli_fetch_assoc($gmail);
	$count=mysqli_num_rows($gmail);
//	$email_ids=array();
//	foreach($gmail as $send){
//		$email_ids[]=$send;
//	}
//	$e_ids=var_dump($email_ids);
	for($i=0;$i<$count;$i++){
		$e=$fetch[$i];
		$email_ids[$i]=$e['E_mail'];
	}
//	$print= print_r($email_ids);
	if (mysqli_query($conn, $sql)) {
		echo "New record created successfully";
	} else {
		echo "Error: " .mysqli_error($conn);
	}
	mysqli_close($conn);
	

	/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient()
{
    $client = new Google_Client();
    $client->setApplicationName('Google Calendar API PHP Quickstart');
    $client->setScopes(Google_Service_Calendar::CALENDAR);
    $client->setAuthConfig('credentials.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

   // $guzzleClient = new \vendor\guzzlehttp\guzzle\src\Client(array('curl'=>array(CURLOPT_SSL_VERIFYPEER => false)));
   $guzzleClient = new \GuzzleHttp\Client(array('curl'=>array(CURLOPT_SSL_VERIFYPEER => false)));
    $client->setHttpClient($guzzleClient);

    // Load previously authorized token from a file, if it exists.
    // The file token.json stores the user's access and refresh tokens, and is
    // created automatically when the authorization flow completes for the first
    // time.
    $tokenPath = 'token.json';
    if (file_exists($tokenPath)) {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
    }

    // If there is no previous token or it's expired.
    if ($client->isAccessTokenExpired()) {
        // Refresh the token if possible, else fetch a new one.
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        } else {
            // Request authorization from the user.
            $authUrl = $client->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            print 'Enter verification code: ';
            $authCode = trim(fgets(STDIN));

            // Exchange authorization code for an access token.
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            $client->setAccessToken($accessToken);

            // Check to see if there was an error.
            if (array_key_exists('error', $accessToken)) {
                throw new Exception(join(', ', $accessToken));
            }
        }
        // Save the token to a file.
        if (!file_exists(dirname($tokenPath))) {
            mkdir(dirname($tokenPath), 0700, true);
        }
        file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    }
    return $client;
}

	$client = getClient();
	$service = new Google_Service_Calendar($client);

	$event = new Google_Service_Calendar_Event(array(
		'summary' => $Activity,
		'location' => $Location,
		'description' => $type,
		'start' => array(
		  'dateTime' => $Date.'T15:00:00+05:30',
		  'timeZone' => 'Time zone in India (GMT+5:30)',
		),
		'end' => array(
		  'dateTime' => $Date.'T16:00:00+05:30',
		  'timeZone' => 'Time zone in India (GMT+5:30)',
		),
		'recurrence' => array(
		  'RRULE:FREQ=DAILY;COUNT=1'
		),
		'attendees' => array(
			array('email' => 'sanketbhondge123@gmail.com'),
			array('email' => '16ychauhan@gmail.com'),
			array('email' => 'nachiketdandare99@gmail.com')
		  ),
		'reminders' => array(
		  'useDefault' => FALSE,
		  'overrides' => array(
			array('method' => 'email', 'minutes' => 24 * 60),
			array('method' => 'popup', 'minutes' => 10),
		  ),
		),
		
	  ));

	$calendarId = 'primary';
	$event = $service->events->insert($calendarId, $event, ['sendUpdates' => 'all']);

	printf('Event created: %s\n', $event->htmlLink);
	//  header("refresh:2; url=display.php");
?>

<!-- update into db backup -->

<?php
	$conn = mysqli_connect("localhost", "root", "","testing");  
	if(!$conn){  
		die('Could not connect: '.mysqli_connect_error());  
	}
?>
<html>
	<head></head>
	<body>
		<form  action="" method="GET">
			<div align="center"><h3> Add further details</h3></div>
			<label><b>Event id :</b></label>
                <input type="text" placeholder="Activity/Meeting" name="eid" value=<?php echo $_GET['eid']; ?>><br />
			<label><b>Activity/Meeting :</b></label>
			   <input type="text" placeholder="Activity/Meeting" name="eActivity" value=<?php echo $_GET['eActivity'];?>><br />
			<label><b>Date :</b></label>
				<input type="date" placeholder="date" name="eDate" value=<?php echo $_GET['eDate']; ?>><br />
			<label><b>Location :</b></label>
				<input type="text" placeholder="Location" name="eLocation" value=<?php echo $_GET['eLocation']; ?>><br />
			<label><b>Attended people list :</b></label>
				<input type="text" placeholder="Attended people" name="Attendance" required><br />
			<label><b>Time spent:</b></label>
				<input type="time" placeholder="time spent" name="time" required><br />
			<label><b>People Impacted:</b></label>
				<input type="text" placeholder="people Impacted" name="impact" required><br />
			<label><b>Money Spent:</b></label>
				<input type="text" placeholder="money spent" name="money" required><br />
				<label><b>revenue generated:</b></label>
				<input type="text" placeholder="revenue generated" name="revenue" required><br />
			<label><b>Note:</b></label>
				<input type="text" placeholder="Note" name="note" required><br />
				<input type="submit"  name="submit" value="Update">
        </form>
        <?php
			if(isset($_GET['submit'])){
				$id=$_GET["eid"];
                $Activity=$_GET["eActivity"];
                $Date=$_GET["eDate"];
                $Location=$_GET["eLocation"];
                $Attendance=$_GET["Attendance"];
                $time=$_GET["time"];
                $impact=$_GET["impact"];
				$money=$_GET["money"];
				$revenue=$_GET["revenue"];
				$note=$_GET["note"];
				$query= "UPDATE timeline SET Activity='$Activity', Date='$Date', Location='$Location', Attendance='$Attendance', time='$time', impact='$impact', money='$money',revenue='$revenue',note='$note' WHERE timeline.id='$id'";
                if(mysqli_query($conn,$query)){
					echo "<b>Record Updated Successfully.</b>";
                }
				else{
					echo "not updated";
                }
				mysqli_close($conn);
			}
			else{
				echo "Click Update to update the info.";
            }
        ?>
	</body>
</html>
