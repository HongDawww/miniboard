<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"]."/miniboard/src/");
define("ERROR_MSG_PARAM","Parameter Error :%s");
require_once(ROOT."db.php"); 

$arr_err_msg = [];

try {
	$conn = null;

		if(!my_db_conn($conn)) {
			throw new Exception("DB Error : PDO instance");
		}
		$http_method = $_SERVER["REQUEST_METHOD"];

		if($http_method === "GET") {
			$id = isset($_GET["id"]) ? $_GET["id"] : "";
			$page = isset($_GET["page"]) ? $_GET["page"] : "";

			if($id === ""){
				$arr_err_msg[] = sprintf(ERROR_MSG_PARAM,"id");
			}
			if($id === ""){
				$arr_err_msg[] = sprintf(ERROR_MSG_PARAM,"page");
			}
			if(count($arr_err_msg) >= 1){
				throw new Exception(implode("<br>", $arr_err_msg));
			}

			$arr_param = [
				"id" => $id
			];
			$result = db_select_boards_id($conn, $arr_param);

			if($result === false) {
				throw new Exception("DB Error : Select id");
			} else if (!(count($result)) === 1) {
				throw new Exception("DB Error : Select id Count");
			}
			$item = $result[0];

		} else {
			$id = isset($_POST["id"]) ? $_POST["id"] : "";
			if($id === ""){
				$arr_err_msg[] = sprintf(ERROR_MSG_PARAM, "id");
			}
			if(count($arr_err_msg) >= 1) {
				throw new Exception(implode("<br>",$arr_err_msg));
			}

			$conn->beginTransaction();

			$arr_param = [
				"id" => $id
			];

			if(!db_delete_boards_id($conn,$arr_param)) {
				throw new Exception("DB Error : Delete Boards id");
			}

			$conn->commit();
			header("Location: /miniboard/src/list.php");
			exit;
		}
	} catch(Exception $e) {
		if($http_method === "POST") {
			$conn->rollBack();
		}
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
	<title>삭제페이지</title>
</head>
<body>
	<main>
		<table>
			<caption>
				삭제하면 영구적으로 복구할 수 없습니다.
				<br>
				정말로 삭제하시겠습니까?
				<br>
				<br>
			</caption>
			<tr>
				<th> 게시글 번호 </th>
				<td><?php echo $item["id"]?></td>
			</tr>
			<tr>
				<th>작성일</th>
				<td><?php echo $item["b_date"] ?></td>
			</tr>
			<tr>
				<th>제목</th>
				<td><?php echo $item["b_title"] ?></td>
			</tr>
			<tr>
				<th>내용</th>
				<td><?php echo $item["b_content"] ?></td>
			</tr>
		</table>
			<section>
				<form action="delete.php" method="post">
					<input type="hidden" name="id" value="<?php echo $id; ?>">
					<button type="submit">동의</button>
					<a href="/mini_board/src/detail.php/?id=<?php echo $id;?>&page=<?php echo $page; ?>">취소</a>
				</form>
			</section>
	</main>
</body>
</html>