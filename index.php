<?php

$link = mysqli_connect("127.0.0.1", "root", "root", "mydeal");

if (!$link) {
    echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
    echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

$res = $link->query("SELECT projects FROM projects WHERE user_id=1");
while ($res_proj = $res->fetch_assoc()) {
  $projects[]=$res_proj['projects'];
}


$i=0;
$res = $link->query("SELECT t.status, t.name, t.file, t.srok, p.projects AS p_projects FROM tasks t INNER JOIN projects p ON t.project_id = p.id WHERE t.user_id=1");
while ($res_tasks = $res->fetch_assoc()) {
  $tasks[$i]['task']=$res_tasks['name'];
  $tasks[$i]['date']=$res_tasks['srok'];
  $tasks[$i]['category']=$res_tasks['p_projects'];
  $tasks[$i]['sucsess']=$res_tasks['status'];
  $i++;
}

mysqli_close($link);


// показывать или нет выполненные задачи
$title="Дела в порядке";
$user_name="Константин";
$krit=24*60*60;
$show_complete_tasks = rand(0, 1);

function count_projects($tasks, $project_name) {
  $count=0;
  foreach ($tasks as $task):
    if ($task['category']==$project_name) {$count++;}
  endforeach;
  return $count;
}
include_once("helpers.php");
$content=include_template("main.php", array('projects' => $projects, 'tasks'=>$tasks, 'show_complete_tasks'=>$show_complete_tasks, 'krit' => $krit));
print(include_template("layout.php", array('title' => $title, 'content'=>$content, 'user_name'=>$user_name)));
?>
