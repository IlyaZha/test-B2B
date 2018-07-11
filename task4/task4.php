<?php
/*
	Проведите рефакторинг, исправьте баги и продокументируйте в стиле PHPDoc код, приведённый ниже (таблица users здесь аналогична таблице users из задачи №1).
	Примечание: код написан исключительно в тестовых целях, это не "жизненный пример" :)
	function load_users_data($user_ids) {
		$user_ids = explode(',', $user_ids);
		foreach ($user_ids as $user_id) {
			$db = mysqli_connect("localhost", "root", "123123", "database");
			$sql = mysqli_query($db, "SELECT * FROM users WHERE id=$user_id");
			while($obj = $sql->fetch_object()){
				$data[$user_id] = $obj->name;
			}
			mysqli_close($db);
		}
		return $data;
	}
	// Как правило, в $_GET['user_ids'] должна приходить строка
	// с номерами пользователей через запятую, например: 1,2,17,48
	$data = load_users_data($_GET['user_ids']);
	foreach ($data as $user_id=>$name) {
		echo "<a href=\"/show_user.php?id=$user_id\">$name</a>";
	}
	Плюсом будет, если укажете, какие именно уязвимости присутствуют в исходном варианте (если таковые, на ваш взгляд, имеются), и приведёте примеры их проявления.
 */


/**
 * @param string $host
 * @param string $user
 * @param string $pass
 * @param string $db_name
 * @return PDO
 */
function mysql_connect($host, $user, $pass, $db_name) {
	$format = sprintf('mysql:host=%s;dbname=%s;charset=utf8', $host, $db_name);

	return new PDO($format, $user, $pass);
}

/**
 * @param string $user_ids
 * @return string[]
 */
function load_users_data($user_ids) {
	$data = [];
	$db = mysql_connect("localhost", "root", "123123", "database");

	$user_ids = explode(',', $user_ids);
	$user_ids = array_map(function ($item) {
		return (int) $item;
	}, $user_ids);

	$placeholders = str_repeat ('?, ',  count ($user_ids) - 1) . '?';
	$stmt = $db->prepare("SELECT id, name FROM users WHERE id IN($placeholders)");
	if ($stmt->execute($user_ids)) {
		while ($obj = $stmt->fetch()) {
			$data[$obj['id']] = $obj['name'];
		}
	}

	$db = null;
	$stmt = null;
	return $data;
}


// Как правило, в $_GET['user_ids'] должна приходить строка
// с номерами пользователей через запятую, например: 1,2,17,48
$data = load_users_data($_GET['user_ids']);
foreach ($data as $user_id=>$name) {
	echo "<a href=\"/show_user.php?id=$user_id\">$name</a>";
}

/*
В первоначальном коде присутсвует mysql-инъекция. Все параметры для mysql-запросов должны экранироваться.
Пользователь мог передать вместо одного id не число, а строку. Например "1,2,3 or name='admin'" - тогда sql запрос получился бы SELECT * FROM users WHERE
id=3 or name='admin'. При помощи данного запроса пользователь может получить ссылку на администратора. Вообще при помощи mysql-инъекций можно вытащить лишние
 данные из бд или подменить данные, если уязвимость есть в insert/update-запросе.
 */