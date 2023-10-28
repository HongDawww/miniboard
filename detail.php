<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"]."/miniboard/src/");
define("ERROR_MSG_PARAM","Parameter Error :%s");
require_once(ROOT."db.php"); //함수가 정의된 파일 불러오기

$no = "";
$conn = null;
$arr_err_msg = [];

try {
	if(!my_db_conn($conn)){
		throw new Exception("DB Error : PDO instance");
	}
	$id = isset($_GET["id"]) ? $_GET["id"] : "";
	$page = isset($_GET["page"]) ? $_GET["page"] : "";

	// if (empty($id)) {
	// 	$arr_err_msg[] = sprintf(ERROR_MSG_PARAM, "id");
	// }
	// if (empty($page)) {
	// 	$arr_err_msg[] = sprintf(ERROR_MSG_PARAM, "page");
	// }
	if($id === ""){
		$arr_err_msg[]= sprintf(ERROR_MSG_PARAM,"id");
	}
	if($page === ""){
		$arr_err_msg[]= sprintf(ERROR_MSG_PARAM,"page");
	}
	if(count($arr_err_msg) >= 1) {
		throw new Exception(implode("<br>",$arr_err_msg));
	}

	$arr_param = [
		"id" => $id
	];

	$result = db_select_boards_id($conn, $arr_param);
	if($result === false){
		throw new Exception("DB Error : PDO Select_id");
	} else if (!(count($result) === 1)){
		throw new Exception("DB Error : PDO Select_id count");
	}
	$item = $result[0];
	
} catch (Exception $e) {
	echo $e->getMessage();
	exit;
} finally {
	db_destroy_conn($conn);
}

?>

<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
	<title>상세페이지</title>
</head>
<body>
	<main>
		
		<table>
			<tr>
				<th>번호</th>
				<td><?php echo $item["id"];?></td>
			</tr>
			<tr>
				<th>제목</th>
				<td><?php echo $item["b_title"];?></td>
			</tr>
			<tr>
				<th>내용</th>
				<td><?php echo $item["b_content"];?></td>
			</tr>
			<tr>
				<th>작성일자</th>
				<td><?php echo $item["b_date"];?></td>
			</tr>
		</table>
		<section>
			<a href="/miniboard/src/update.php/?id=<?php echo $id;?>&page=<?php echo $page;?>">수정</a>
			<a href="/miniboard/src/list.php">취소</a>
			<a href="/miniboard/src/delete.php/?id=<?php echo $id;?>&page=<?php echo $page;?>">삭제</a>
		</section>
		
	</main>
	
</body>
</html>