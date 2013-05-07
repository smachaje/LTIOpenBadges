<?php
function badgewidgethack_convert_email_to_openbadges_id($email) {
  $postdata = http_build_query(
	    array(
	        'email' => $email
	    )
	);

	$opts = array('http' =>
	    array(
	        'method'  => 'POST',
	        'header'  => 'Content-type: application/x-www-form-urlencoded',
	        'content' => $postdata
	    )
	);

	$context  = stream_context_create($opts);
	$emailjson = file_get_contents('http://beta.openbadges.org/displayer/convert/email', false, $context);
	$emaildata = json_decode($emailjson);
	return $emaildata->userId;
}

function badgewidget_return_groups_given_badge_id($userid) {
	$url = "http://beta.openbadges.org/displayer/" . $userid . "/groups.json";
	$groupjson = file_get_contents($url);
	$groupdata = json_decode($groupjson,true);
	return $groupdata;
}

function get_badges($userid,$group) {
        $url = 'http://beta.openbadges.org/displayer/' . $userid . '/group/' . $group . '.json';
        $bjson = file_get_contents($url);
        $bdata = json_decode($bjson,true);
        return $bdata;
}
?>
<body>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<?php

if (isset($_POST['lis_person_contact_email_primary']))
{
$email=$_POST['lis_person_contact_email_primary']);
} else {
die("Please configure the LTI app to allow user email.");
}

echo '<center><h4>Badges for '.$email.':</h4><table border=0 cellpadding=10 width=400 >';

$userid = badgewidgethack_convert_email_to_openbadges_id($email);
$data = badgewidget_return_groups_given_badge_id($userid);

if ($limit = count($data[groups])) {
	

	$i = 0;
	while ($i < $limit) {
	                $group = $data[groups][$i][groupId];
	                $groupname = $data[groups][$i][name];
	                $i = $i + 1;
			include("badgewidget.php");
	}

echo "</table></center>";

} else{
	echo "<p>You have no public groups in <a href='http://beta.openbadges.org'>your backpack</a>. Try making one public and adding a badge to it.</p>";
}

?>
