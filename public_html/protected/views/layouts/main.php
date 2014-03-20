<?php
/**
 * @var CController $this
 * @var string $content
 */
// Если идет аяксовый запрос, то сразу просто отдаем контент без лишней нагрузки на сервер
if (Yii::app()->request->isAjaxRequest) {
	echo $content;
}
else { // Если не аякс, то рисуем верстку
	?>
	<!DOCTYPE html>
	<html lang="ru">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title><?php echo $this->pageTitle; ?></title>
		<meta name="language" content="ru"/>
	</head>
	<body>
	<!-- Основной контент -->
	<div class="container-fluid">
		<?php echo $content; ?>
	</div>
	</body>
	</html>

<?php } ?>