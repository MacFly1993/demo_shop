Тестовое задание 1.

Тестовое задание: Разработка простого веб-приложения "Список контактов"

Задание:
Ваша задача - разработать простое веб-приложение для управления списком контактов. Приложение должно быть реализовано с использованием PHP и HTML.

Функциональные требования:
1. Главная страница должна содержать форму для добавления нового контакта.
2. Форма добавления контакта должна содержать поля для ввода имени и номера телефона контакта.
3. После добавления контакта он должен отображаться в списке уже существующих контактов.
4. Каждый контакт в списке должен иметь кнопку "Удалить", при нажатии на которую контакт будет удален.
5. Список контактов должен иметь табличное представление с возможностью сортировки по имени контакта.

Технические требования:
1. Реализуйте веб-приложение с использованием PHP и HTML (верстку сделать с помощью Bootstrap).
2. Для временного хранения контактов используйте массив или сессии вместо базы данных.
3. Используйте формы и обработку данных на стороне сервера с помощью PHP.
4.  Добавьте валидацию введенных данных на стороне сервера:
-	проверка наличия имени и номера телефона
-	валидация формата номера телефона ( +7хххххххххх)
-	минимальная длина имени контакта 3 символа
