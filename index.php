<?php

$link = mysqli_connect("127.0.0.1", "root", "root", "mydeal");
$projects=[];
$tasks=[];
$user_id=2;

if (!$link) {
    echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
    echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
//Получаем id и название категорий
$res = $link->query("SELECT projects, id FROM projects WHERE user_id=".$user_id);

if ($res) {
  while ($res_proj = $res->fetch_assoc()) {
    $projects[]=$res_proj;
  }
}
//Получаем число задач в категории
$res = $link->query("SELECT project_id, COUNT(*) as count FROM tasks WHERE user_id=".$user_id." GROUP BY project_id");
if ($res) {
  while ($res_tasks = $res->fetch_assoc()) {
    $count_tasks[$res_tasks['project_id']]=$res_tasks['count'];
  }
}
//Формируем SQL запрос по задачам в зависимости от наличия гет-параметра
if (isset($_GET['project_id'])) {
  $sql="SELECT t.status, t.name, t.file, t.srok, t.project_id, p.projects AS p_projects FROM tasks t INNER JOIN projects p ON t.project_id = p.id WHERE t.user_id=".$user_id." and t.project_id=".$_GET['project_id'];
  $res = $link->query($sql);
  if (!$res) {
    header('HTTP/1.0 404 Not Found');
  }
} else {
  $sql="SELECT t.status, t.name, t.file, t.srok, t.project_id, p.projects AS p_projects FROM tasks t INNER JOIN projects p ON t.project_id = p.id WHERE t.user_id=".$user_id;
  $res = $link->query($sql);
}
//получаем задачи
if ($res) {
  while ($res_tasks = $res->fetch_assoc()) {
    $tasks[$i]['task']=$res_tasks['name'];
    $tasks[$i]['date']=$res_tasks['srok'];
    $tasks[$i]['category']=$res_tasks['p_projects'];
    $tasks[$i]['sucsess']=$res_tasks['status'];
    $tasks[$i]['project_id']=$res_tasks['project_id'];
    $i++;
  }
}


mysqli_close($link);
//Добавляем в массив project количество задач
foreach ($projects as $key=>$project) {
  if (isset($count_tasks[$project['id']])) {
    $project['count']=$count_tasks[$project['id']];
  } else {
    $project['count']=0;
  }
  $projects[$key]=$project;
}


// показывать или нет выполненные задачи
$title="Дела в порядке";
$user_name="Константин";
$krit=24*60*60;
$show_complete_tasks = rand(0, 1);


include_once("helpers.php");
$content=include_template("main.php", array('projects' => $projects, 'tasks'=>$tasks, 'show_complete_tasks'=>$show_complete_tasks, 'krit' => $krit));
print(include_template("layout.php", array('title' => $title, 'content'=>$content, 'user_name'=>$user_name)));
?>
