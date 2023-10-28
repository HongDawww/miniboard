<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"] . "/miniboard/src/");
define("ERROR_MSG_PARAM", "파라미터 오류: %s");
require_once(ROOT."db.php");

$conn = null;
$http_method = $_SERVER["REQUEST_METHOD"];
$arr_err_msg = [];

try {
    if (!my_db_conn($conn)) {
        throw new Exception("DB 오류: PDO 인스턴스");
    }

    if($http_method === "GET"){
        $id = isset($_GET["id"]) ? $_GET["id"] : "";
        $page = isset($_GET["page"]) ? $_GET["page"] : "";
        $b_id = isset($_GET['b_id']) ? $_GET["b_id"] : "";
        // $title = isset($_GET["b_title"]) ? $_GET["b_title"] : "";
        // $content = isset($_GET["b_content"]) ? $_GET["b_content"] : "";
        // $bid = isset($_GET["b_id"]) ? $_GET["b_id"] : "";

        if ($id === "") {
            $arr_err_msg[] = sprintf(ERROR_MSG_PARAM, "id");
        }
        if ($page === "") {
            $arr_err_msg[] = sprintf(ERROR_MSG_PARAM, "page");
        }
      
        if (count($arr_err_msg) >= 1) {
            throw new Exception(implode("<br>", $arr_err_msg));
         }

    } else {
        $id = isset($_POST["id"]) ? $_POST["id"] : "";
        $page = isset($_POST["page"]) ? $_POST["page"] : "";
        $title = isset($_POST["b_title"]) ? $_POST["b_title"] : "";
        $content = isset($_POST["b_content"]) ? $_POST["b_content"] : "";
        // $b_id = isset($_POST["b_id"]) ? $_POST["b_id"] : "";

            
        if($id === "") {
            $arr_err_msg[] = sprintf(ERROR_MSG_PARAM, "id");
        }
        if($page === "") {
            $arr_err_msg[] = sprintf(ERROR_MSG_PARAM, "page");
        }
        if (count($arr_err_msg) >= 1) {
            throw new Exception(implode("<br>", $arr_err_msg));
        }
        if($title === "") {
            $arr_err_msg[] = sprintf(ERROR_MSG_PARAM, "b_title");
        }
        if($content === "") {
            $arr_err_msg[] = sprintf(ERROR_MSG_PARAM, "b_content");
        }
        // if($b_id === "") {
        //     $arr_err_msg[] = sprintf(ERROR_MSG_PARAM, "b_id");
        // }
        
        if(count($arr_err_msg) === 0) {
            

            $arr_param = [
                "id" => $id
                ,"b_title" => $_POST["b_title"]
                ,"b_content" => $_POST["b_content"]
                ,"b_id" => $_POST["b_id"]
            ]; 
    
            $conn->beginTransaction();

            if (!db_update_boards_id($conn, $arr_param)) {
                throw new Exception("DB 오류: Update_boards_id");
            }
            $conn->commit();
    
            header("Location: detail.php?id={$id}&page={$page}");
            exit;
            
        }
    }
        
        $arr_param = [
            "id" => $id,
           
        ];

        $result = db_select_boards_id($conn, $arr_param);

  

        if($result === false) {
            throw new Exception("DB Error : PDO SELECT_id");
        } else if(!(count($result) === 1)) {
            throw new Exception("DB Error : PDO Select_id Count,".count($result));
        }
        $item = $result[0];
       
} catch (Exception $e) {
    if ($http_method === "POST") {
        $conn->rollBack(); // 에러 발생 시 롤백
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
	<title>수정페이지</title>
</head>
<body>
	<main>
	<form action="/miniboard/src/update.php" method="post">
			<table>
			<input type="hidden" name="id" id="id" value="<?php echo $id;?>">
			<input type="hidden" name="page" id="page" value="<?php echo $page;?>">
            <input type="hidden" name="b_id" id="b_id" value="<?php echo $b_id;?>">
			
				<tr>
					<th>번호</th>
					<td><?php echo $item["id"]?></td>
				</tr>
				<tr>
					<th>작성자</th>
					<td><?php echo $item["b_id"]?></td>
				</tr>
				<tr>
					<th>제목</th>
					<td>
						<input type="text" name="b_title" id="b_title" value="<?php echo $item["b_title"];?>">
					</td>
				</tr>
				<tr>
					<th>내용</th>
					<td><textarea name="b_content" id="b_content" cols="30" rows="10"><?php echo $item["b_content"];?></textarea></td>
				</tr>
			</table>
			<section>
				<button type="submit">완료</button>
				<a href="/miniboard/src/detail.php?id=<?php echo $item["id"];?>&page=<?php echo $page;?>">수정취소</a>
				
			</section>
		</form>
	</main>
</body>
</html>