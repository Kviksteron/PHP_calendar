<?php

session_start();

if(isset($_GET['user_name']))
{
	$_SESSION['user_name'] = $_GET['user_name'];
	$user = $_SESSION['user_name'];
}
else
{
	$user = "";
}

$delete_user = "";
$visits_num = 0;

$connection = mysqli_connect("localhost", "root", "");
$sql = "CREATE DATABASE IF NOT EXISTS coursework_db";
$query = mysqli_query($connection, $sql);

if($query)
{
	$sql = "CREATE TABLE IF NOT EXISTS user_data 
			(
				visits_q INT(11) NOT NULL,
				user_name VARCHAR(255) NOT NULL,
				PRIMARY KEY (user_name)
			)";

	$connection = mysqli_connect("localhost", "root", "", "coursework_db");
	$query = mysqli_query($connection, $sql);

	$sql  = "SELECT *  FROM user_data WHERE user_name = '$user'";
	$query = mysqli_query($connection, $sql);

	if(isset($_GET['addUser']))
	{
		$count = mysqli_num_rows($query);

		if ($count > 0)
		{
			$sql = "UPDATE user_data SET visits_q = visits_q + 1 WHERE user_name = '$user'";
			$query = mysqli_query($connection, $sql);
		}
		else
		{
			mysqli_query($connection,
			"INSERT INTO user_data
			(visits_q, user_name)
			VALUES 
			(1, '$user')");
		}
	}
	elseif ((isset($_GET['searchUser'])))
	{
		$result = $query->fetch_assoc();

		if(!$result)
		{
			echo "Пользователь с данным именем не был найден<br>";
		}
		else
		{
			echo "Пользователь найден!<br>
				 Имя: " . $result['user_name'] . "<br>
				 Кол-во посещений: " . $result['visits_q'] . "<br>";
		}
	}
	else
	{
		$result = mysqli_query($connection, "SELECT * FROM user_data");
		while($row = $result->fetch_assoc())
		{
			$value = $row['user_name'];
		    echo "<p><strong>Имя: </strong>" . $row['user_name'] . "<br>
				  <strong>Кол-во посещений: </strong>" . $row['visits_q'] . "<br>
				  <form action='delete.php' method=GET>
				  <input type='submit' name='' value='Удалить пользователя $value'>
	    		  <input type='hidden' name='delete' value='$value'>
	   	 	   	  </form><br>";
		}
	}
}

session_unset();

if (isset($_GET['addUser']))
{
	echo "Пользователь $user посетил страницу!<br><br>
		 <a href=main.php>Вернуться на главную страницу</a>";
}
else
{
	echo "<br><a href=main.php>Вернуться на главную страницу</a>";
}

?>