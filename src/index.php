<!-- index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список контактов</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Подключаем стили -->
</head>
<body>
    <h1>Список контактов</h1>

<?php
 $errors = []; // Массив для хранения ошибок
    // Проверяем, были ли отправлены данные формы
 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$name = htmlspecialchars(trim($_POST['name']));
		$phone = htmlspecialchars(trim($_POST['phone']));

		// Проверка наличия имени и номера телефона
		if (empty($name)) {
			$errors[] = "Имя обязательно для заполнения";
		}
		if (empty($phone)) {
			$errors[] = "Номер телефона обязателен для заполнения";
		}

		// Валидация формата номера телефона
		if (!preg_match('/^\+7\d{10}$/', $phone)) {
			$errors[] = "Неправильный формат номера телефона. Формат: +7xxxxxxxxxx";
		}

		// Минимальная длина имени контакта
		if (mb_strlen($name) < 3) {
			$errors[] = "Минимальная длина имени контакта - 3 символа";
		}
		
		// Получаем текущий список контактов
		$contacts = file('contacts.txt', FILE_IGNORE_NEW_LINES);
		$id = count($contacts) + 1; // Генерируем id на основе количества существующих контактов
		
		// Если есть ошибки, выводим их
		if (!empty($errors)) {
			foreach ($errors as $error) {
				echo "<p style='color: red;'>$error</p>";
			}
		} else {
			// Если ошибок нет, добавляем контакт
			$newContact = array('id' => $id, 'name' => $name, 'phone' => $phone);
			$contactsFile = fopen('contacts.txt', 'a');
			fwrite($contactsFile, json_encode($newContact) . PHP_EOL);
			fclose($contactsFile);
			}	
		}
		
			// Если запрос delete и он не пустой
		if (isset($_GET['delete']) && !empty($_GET['delete'])) {
			$contactToDelete = $_GET['delete'];
			
			// Получаем текущий список контактов
			$contacts = file('contacts.txt', FILE_IGNORE_NEW_LINES);
			
			// Открываем файл для записи
			$contactsFile = fopen('contacts.txt', 'w');
			
			// Проходим по всем контактам и записываем их обратно, исключая удаляемый контакт
			foreach ($contacts as $contact) {
				$contactData = json_decode($contact, true);
				if ($contactData['id'] != $contactToDelete) {
					fwrite($contactsFile, $contact . PHP_EOL);
				}
			}
			
			// Закрываем файл
			fclose($contactsFile);
			
			// После удаления перенаправляем пользователя на эту же страницу
			header("Location: contacts.php");
		}
?>

    <form action="contacts.php" method="post">
        <label for="name">Имя:</label>
        <input type="text" id="name" name="name" required>
        <label for="phone">Номер телефона:</label>
        <input type="text" id="phone" name="phone" required>
        <button type="submit">Добавить контакт</button>
    </form>

    <h2>Существующие контакты:</h2>
    <table>
        <tr>
            <th>id</th>
            <th>Имя</th>
            <th>Номер телефона</th>
            <th>Удалить</th>
        </tr>
        <?php
        // Открываем файл с массивом контактов
        $contactsFile = fopen('contacts.txt', 'r');

        // Читаем файл построчно и выводим контакты в таблицу
		while (!feof($contactsFile)) {
			$contact = fgets($contactsFile);
			if (!empty($contact)) {
				$contactData = json_decode($contact, true);
				echo '<tr>';
				echo '<td>' . $contactData['id'] . '</td>'; 
				echo '<td>' . $contactData['name'] . '</td>';
				echo '<td>' . $contactData['phone'] . '</td>';
				echo '<td><a href="contacts.php?delete=' . $contactData['id'] . '">Удалить</a></td>';
				echo '</tr>';
			}
		}

        // Закрываем файл
        fclose($contactsFile);
        ?>
    </table>
</body>
</html>