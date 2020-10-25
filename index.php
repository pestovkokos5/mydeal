<?php
// показывать или нет выполненные задачи
$title="Дела в порядке";
$user_name="Константин";
$show_complete_tasks = rand(0, 1);
$projects=array("Входящие", "Учеба", "Работа", "Домашние дела", "Авто");
$tasks=array(
  0=>array(
    'task'=>'Собеседование в IT компании',
    'date'=> '01.12.2019',
    'category'=> 'Работа',
    'sucsess' => false
  ),
  1=>array(
    'task'=>'Выполнить тестовое задание',
    'date'=> '25.12.2019',
    'category'=> 'Работа',
    'sucsess' => false
  ),
  2=>array(
    'task'=>'Сделать задание первого раздела',
    'date'=> '21.12.2019',
    'category'=> 'Учеба',
    'sucsess' => true
  ),
  3=>array(
    'task'=>'Встреча с другом',
    'date'=> '22.12.2019',
    'category'=> 'Входящие',
    'sucsess' => false
  ),
  4=>array(
    'task'=>'Купить корм для кота',
    'date'=> null,
    'category'=> 'Домашние дела',
    'sucsess' =>false
  ),
  5=>array(
    'task'=>'Заказать пиццу',
    'date'=> null,
    'category'=> 'Домашние дела',
    'sucsess' =>false
  ),
);
function count_projects($tasks, $project_name) {
  $count=0;
  foreach ($tasks as $task):
    if ($task['category']==$project_name) {$count++;}
  endforeach;
  return $count;
}
include_once("helpers.php");
$content=include_template("main.php", array('projects' => $projects, 'tasks'=>$tasks, 'show_complete_tasks'=>$show_complete_tasks));
print(include_template("layout.php", array('title' => $title, 'content'=>$content, 'user_name'=>$user_name)));
?>
