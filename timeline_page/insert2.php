<?php
	error_reporting(0);
	require __DIR__ . '/vendor/autoload.php';
//	use Google_Service_Calendar_Event;

	$conn = mysqli_connect("localhost", "root", "", "testing");
	if(! $conn ) {
		die('Could not connect: ' . mysqli_error());
	}
	$projectid=mysqli_real_escape_string($conn,$_POST['projectid']);
	$Activity = mysqli_real_escape_string($conn,$_POST['Activity']);
	$Date = mysqli_real_escape_string($conn,$_POST['Date']);
	$time=mysqli_real_escape_string($conn,$_POST['time']);
	$Location = mysqli_real_escape_string($conn,$_POST['Location']);
	$type=mysqli_real_escape_string($conn,$_POST['type']);
	$sql ="INSERT INTO timeline( projectid, Activity, Date, Activity_time, Location, Attendance, time, impact, money,revenue, type, note) VALUES('$projectid','$Activity','$Date','$time','$Location','','','0','0','0','$type','')";
	$calender="SELECT E_mail FROM member WHERE p_id='$projectid' ";
	$gmail=mysqli_query($conn,$calender);
	$fetch=mysqli_fetch_assoc($gmail);
	$count=mysqli_num_rows($gmail);
	$email_ids=array();
	foreach($gmail as $send){
		if($send['E_mail']!=NULL){
			$email_ids[]=$send['E_mail'];
		}
	}
	$attendees = array();
	foreach($email_ids as $getter){
		$attendee = array();
		$attendee["email"] = $getter;
		$attendees[]=$attendee;
	}

	print_r($attendees);

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

	$var=array(
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
		'attendees' => $attendees,
		'reminders' => array(
		  'useDefault' => FALSE,
		  'overrides' => array(
			array('method' => 'email', 'minutes' => 24 * 60),
			array('method' => 'popup', 'minutes' => 10),
		  ),
		),
		
	);
//	  var_dump($var['attendees']);
	$event = new Google_Service_Calendar_Event($var);

	$calendarId = 'primary';
	$event = $service->events->insert($calendarId, $event, ['sendUpdates' => 'all']);

//	printf('Event created: %s\n', $event->htmlLink);
	  header("location:display.php");
?>
