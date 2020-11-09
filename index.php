<?php

require_once "functions.php";

$linkObj = new shortenerLinks();
if(!empty($_POST['l'])) { // если присутствует ссылка в адресной строке

    $link = $linkObj->getFullUrl(htmlspecialchars($_POST['l']));

    if($link != "Вы указали недействительный URL")
        LocalRedirect($link); // Перенаправляем пользователя
    else
        printf($link);

}
else if(!empty($_POST['submit'])) { // Если отправили форму с ссылкой
    if(empty($_POST['link'])) {
        printf("Вы не указали ссылку");
    }

    return $linkObj->createURL($_POST['link']); // Затем выставим эти данные в темплейт


} else {
    // Просто выводим темплейт сайта
}
?>
