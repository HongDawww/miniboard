<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"]."/miniboard/src/");
define("ERROR_MSG_PARAM","Parameter Error :%s");
require_once(ROOT."db.php"); //함수가 정의된 파일 불러오기


$conn = null;
$http_method = $_SERVER["REQUEST_METHOD"]; //입력되는 메소드 확인
$arr_err_msg = [];

if($http_method === "POST") {
	try {
			$bid = isset($_POST["b_id"]) ? $_POST["b_id"] : "";
			$pw = isset($_POST["b_pw"]) ? $_POST["b_pw"] : "";
			$title = isset($_POST["b_title"]) ? $_POST["b_title"] : ""; //제목
			$content = isset($_POST["b_content"]) ? $_POST["b_content"] : ""; //컨텐트

		
			if($title === ""){
				$arr_err_msg[] = sprintf(ERROR_MSG_PARAM,"title");
			}
			if($content === ""){
				$arr_err_msg[] = sprintf(ERROR_MSG_PARAM,"content");
			}
			if(count($arr_err_msg)>=1) {
				throw new Exception(implode("<br>",$arr_err_msg));
			}


			if(!my_db_conn($conn)){
				throw new Exception("DB Error : PDOinstance");
			}
			
			$conn->beginTransaction();

			$arr_param = [
				// "id" => $_POST["id"]
				"b_id" => $_POST["b_id"]
				,"b_pw" => $_POST["b_pw"]
				,"b_title" => $_POST["b_title"]
				,"b_content" => $_POST["b_content"]
			];

			if(!db_insert_boards($conn,$arr_param)){
				throw new Exception("DB Error : Insert miniboard");
				}
			$conn->commit();

			header("Location:list.php");
			exit;

		}catch(Exception $e) {
			if ($conn) {
				$conn->rollBack();
			}
			echo $e->getMessage();
			exit;
		}finally {
			db_destroy_conn($conn);
		}
		} 



?>

<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
	<title>작성페이지</title>
</head>
<body>
	<main>
		<form action="insert.php" method="post">
			<table>
				<tr>
					<th>
						<label for="b_id">아이디</label>
					</th>
					<td>
						<input type="text" name="b_id" id="b_id">
					</td>
				</tr>
				<tr>
					<th>
						<label for="b_pw">비밀번호</label>
					</th>
					<td>
						<input type="password" name="b_pw" id="b_pw">
					</td>
				</tr>
				<tr>
					<th>
						<label for="b_title">제목</label>
					</th>
					<td>
						<input type="text" name="b_title" id="b_title" size = "58">
					</td>
				</tr>
				<tr>
					<th>
						<label for="b_content">내용</label>
					</th>
					<td>
						<textarea name="b_content" id="b_content" cols="63" rows="30"></textarea>
					</td>
				</tr>
				
			</table>
			<section class="insert-section">
				<button type="submit">작성</button>
				<a href="list.php">취소</a>
			</section>
		</form>
	</main>
</body>
</html>