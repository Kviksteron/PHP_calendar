<?php

session_start();

$admin_password = "Admin123";

if(isset($_GET['delete']))
{
	$_SESSION['delete'] = $_GET['delete'];
}

$delete_user = $_SESSION['delete'];

if(!isset($_POST['passwd']))
{
	echo "<h2>Введите пароль администратора для удаления пользователя $delete_user</h2>
		  <form method=POST>
		  <input type=password name=pass>
		  <input type=submit name=passwd value='Ввод'>
		  </form>
		  <br><a href=list.php>Назад</a>";
}
else
{
	if($_POST['pass'] == $admin_password)
	{
		$sql = "DELETE FROM user_data WHERE user_name = '$delete_user'";
		$connection = mysqli_connect("localhost", "root", "", "coursework_db");
		$query = mysqli_query($connection, $sql);

		echo "Пользователь $delete_user был удалён.<br><a href=list.php>Назад</a>";
	}
	else
	{
		echo "Неверный пароль<br><a href=delete.php>Назад</a>";
		unset($_POST['passwd']);
	}
}

?>