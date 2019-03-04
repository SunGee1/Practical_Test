<?php 

session_start();

if(!isset($_SESSION["user"]))
{
	header("Location: login.php");
}

require("settings.php");

$bet_placed = $_POST['bet_placed'];
$user = $_SESSION['user'];
$user_money = $_POST['user_money'];

$rnd_num = mt_rand(1, 6);

$reward = 0;
switch ($rnd_num)
{
	case 1:
		$reward = $bet_placed * 0.01;
		break;
	case 2:
		$reward = $bet_placed * 0.25;
		break;
	case 3:
		$reward = $bet_placed * 0.5;
		break;
	case 4:
		$reward = $bet_placed * 1;
		break;
	case 5:
		$reward = $bet_placed * 2;
		break;
	case 6:
		$reward = $bet_placed * 3;
		break;
}
$user_new_money = ($user_money + $reward) - $bet_placed;
$query = "UPDATE user SET money = {$user_new_money} WHERE id = {$user->id}";
$db_con->query($query);

// var_dump("BE----".$bet_placed);
// var_dump("REWARD----".$reward);
// var_dump("USERMONEY----".$user_money);
// var_dump("NEWMONEUY----".$user_new_money);
$result = new stdClass();

$result->user_money = $user_new_money;
$result->reward = $reward - $bet_placed;


// var_dump("rnd: " . $rnd_num . "\nreward: " . (float)$reward);
	

die(JSON_encode($result));
?>