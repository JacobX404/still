<meta http-equiv="Content-type" content="text/html; charset=utf-8" />

<style type="text/css">
body { background-color: black; } .text { box-shadow: 1px 1px 5px green; }
</style>

<?php

define('INCLUDE_CHECK', true);
include 'mcs_config.php';
$dbfile = "mcs_database.txt";

$authorized = false;
$cookie_password_hash = $_COOKIE['mcs_password_hash'];
if(isset($cookie_password_hash) && $cookie_password_hash == md5(md5($admin_password))) {
	$authorized = true;
} else {
	$password = $_POST['password'];
	if($password == $admin_password) {
		setcookie("mcs_password_hash", md5(md5($password)), time() + 3600);
		header('Location: mcs_admin.php');
	} else if($password != '') {
		echo "<div style='color:white;'>Пароль не верный!</div>";
	}
}

if($authorized) {	
	echo "<div style='color:white;'>Вы авторизованы.</div><br/>";
	if(file_exists($dbfile)) {
		$del = $_POST['del'];
		if($del != '') {
			$file_readed = file_get_contents($dbfile);
			$file_readed = str_replace("$del\n", "", $file_readed);
			file_put_contents($dbfile, $file_readed);
			header('Location: mcs_admin.php');
		}
		
		$f = fopen($dbfile, "r");
		while(!feof($f)) {
			$readed = fgets($f);
			if($readed != '') {
				echo "<form method='POST' name='kekes' action='mcs_admin.php'><input value='" . htmlspecialchars($readed, ENT_QUOTES) . "' type='text' name='del' class='text' id='quick_message' readonly><input type='submit' value='Удалить' class='submit'></form>";
			}
		}
		fclose($f);
	}
} else {
	echo "<form method='POST' name='login' id='login_form' action='mcs_admin.php'>  
    <div style='color:white;' class='label'>Введите пароль:</div>
    <input type='password' name='password' class='text' id='quick_message'>
    <input type='submit' value='Войти' class='submit'>
	</form>";
}

?>
