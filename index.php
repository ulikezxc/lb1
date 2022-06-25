<?php
$db = new PDO("mysql:host=127.0.0.1;dbname=school", "root", "");

if (isset($_POST["week_dayAdd"])) {
    $statement = $db->prepare("INSERT INTO lesson (week_day, lesson_number, auditorium, disciple, `type`) VALUES (?, ?, ?, ?, ?)");
    $statement->execute([$_POST["week_dayAdd"], $_POST["lesson_numberAdd"], $_POST["auditoriumAdd"], $_POST["discipleAdd"], $_POST["typeAdd"]]);
    $lessonId = $db->lastInsertId();
    $statement = $db->prepare("INSERT INTO lesson_teacher (FID_Teacher, FID_Lesson1) VALUES (?, ?)");
    $statement->execute([$_POST["teacherAdd"], $lessonId]);
    $statement = $db->prepare("INSERT INTO lesson_groups (FID_Groups, FID_Lesson2) VALUES (?, ?)");
    $statement->execute([$_POST["groupAdd"], $lessonId]);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LABA1</title>
</head>
<body>
<br>
<form action="" method="post">
    <input type="text" name="group" placeholder="Группа">
    <input type="submit"><br>
</form>
<?php
if (isset($_POST["group"])) {
    $statement = $db->prepare("SELECT week_day, lesson_number, auditorium, disciple, type
    FROM lesson INNER JOIN lesson_groups ON ID_Lesson = FID_Lesson2
    INNER JOIN groups ON FID_Groups = ID_Groups
    WHERE `title` = ?");
    $statement->execute([$_POST["group"]]);
    echo "<table>";
    echo " <tr><th>День</th><th>Пара</th><th>Аудитория</th><th>Дисциплина</th><th>Тип</th></tr> ";

    while ($data = $statement->fetch()) {
        echo " <tr><td>{$data['week_day']}</td><td> {$data['lesson_number']} </td><td> {$data['auditorium']} </td><td> {$data['disciple']} </td><td> {$data['type']} </td></tr> ";
    }
    echo "</table>";
}
?>
<br>
<form action="" method="post">
    <input type="text" name="teacher" placeholder="Преподаватель">
    <input type="submit"><br>
</form>
<?php
if (isset($_POST["teacher"])) {
    $statement = $db->prepare("SELECT week_day, lesson_number, auditorium, disciple, type
    FROM lesson INNER JOIN lesson_teacher ON ID_Lesson = FID_Lesson1
    INNER JOIN teacher ON FID_Teacher = ID_Teacher
    WHERE name = ?");
    $statement->execute([$_POST["teacher"]]);
    echo "<table>";
    echo " <tr><th>День</th><th>Пара</th><th>Аудитория</th><th>Дисциплина</th><th>Тип</th></tr> ";    while ($data = $statement->fetch()) {
        echo " <tr><td> {$data['week_day']}  </td><td> {$data['lesson_number']} </td><td> {$data['auditorium']} </td><td> {$data['disciple']} </td>  <td> {$data['type']} </td></tr> ";
    }
    echo "</table>";
}
?>
<br>
<form action="" method="post">
    <input type="text" name="auditorium" placeholder="Аудитория">
    <input type="submit"><br>
</form>
<?php
if (isset($_POST["auditorium"])) {
    $statement = $db->prepare("SELECT week_day, lesson_number, auditorium, disciple, type 
    FROM lesson
    WHERE auditorium = ?");
    $statement->execute([$_POST["auditorium"]]);
    echo "<table>";
    echo " <tr><th>День</th><th>Пара</th><th>Аудитория</th><th>Дисциплина</th><th>Тип</th></tr> ";    while ($data = $statement->fetch()) {
        echo " <tr><td> {$data['week_day']}  </td> <td> {$data['lesson_number']} </td><td> {$data['auditorium']} </td><td> {$data['disciple']} </td> <td> {$data['type']} </td></tr> ";
    }
    echo "</table>";
}
?>
<br>
<form action="" method="post">
    <input type="text" name="week_dayAdd" placeholder="День"><br>
    <input type="number" name="lesson_numberAdd" placeholder="Номер лекции"><br>
    <input type="text" name="auditoriumAdd" placeholder="Аудиторий"><br>
    <input type="text" name="discipleAdd" placeholder="Дисциплина"><br>
    <input type="text" name="typeAdd" placeholder="Тип"><br>
    <input type="text" name="teacherAdd" placeholder="Преподаватель"><br>
    <input type="text" name="groupAdd" placeholder="Группа"><br>
    <input type="submit" value="Добавить"><br>
</form>
</body>
</html>