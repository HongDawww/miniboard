<?php

//----------------------------------- db 연결 함수-------------------------------
function my_db_conn( &$conn ){
	$db_host = "localhost";
	$db_user = "root";
	$db_pw = "php504";
	$db_name = "miniboard";
	$db_charset ="utf8mb4";
	$db_dns = "mysql:host=".$db_host.";dbname=".$db_name.";charset=".$db_charset;

	try{
		//PDO 를 사용하여 db 에 연결할 때 설정하는 옵션들을 배열로 정의
		$db_option = [
			PDO::ATTR_EMULATE_PREPARES => false
			,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
			,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		];
		//db접속 을 위해  PDO 클래스의 인스턴스를 생성하고 $conn 변수에 담는다
		$conn = new PDO($db_dns,$db_user,$db_pw,$db_option);
		return true;
	} catch (Exception $e) {
		$conn = null;
	} return false;
}
//----------------------------------- db 연결 함수-------------------------------


//----------------------------------- db count 함수-------------------------------
function db_select_boards_cnt(&$conn) {
	$sql = " SELECT COUNT(id) AS cnt FROM miniboard WHERE delete_flg = '0' ";
	try{
	$stmt = $conn->query($sql);
	$result = $stmt->fetchAll();

	return (int)$result[0]["cnt"];

	} catch (Exception $e){
		return false;
	}
}

//----------------------------------------------------------------------------------

//----------------------------------- db 페이지 조회-------------------------------
function db_select_boards_paging(&$conn,&$arr_param){
	try {
		$sql = 
		" SELECT "
		." id "
		." ,b_title "
		." ,b_date "
		." ,b_content"
		." ,b_hit"
		." ,b_id"
		." FROM "
		." miniboard "
		." WHERE "
		." delete_flg = '0' "
		." ORDER BY "
		." id DESC "
		." LIMIT :list_cnt OFFSET :offset "
		;


		$arr_ps = [
			":list_cnt" => $arr_param["list_cnt"]
			,":offset" => $arr_param["offset"]
		];

		$stmt = $conn->prepare($sql);
		$stmt->execute($arr_ps);
		$result = $stmt->fetchAll();
		return $result;
		
	}  catch(Exception $e){
		return false;
	}
}
//----------------------------------------------------------------------------------

//---------------------------------db 레코드 작성-----------------------------------
function db_insert_boards(&$conn, &$arr_param){
	$currentDate = date("Y-m-d H:i:s");
    $sql = "INSERT INTO miniboard (b_id, b_pw, b_title, b_content, b_date) VALUES (:b_id, :b_pw, :b_title, :b_content, NOW())";


	$arr_ps = [
		":b_id" => $arr_param["b_id"]
		,":b_pw" => $arr_param["b_pw"]
        ,":b_title" => $arr_param["b_title"]
        ,":b_content" => $arr_param["b_content"]
	];

	try {
		$stmt = $conn->prepare($sql);
		$result = $stmt->execute($arr_ps);
		return $result;
	}catch (Exception $e){
		echo $e->getMessage();
		return false;
	}
}
//----------------------------------------------------------------------------------
//----------------------------------db 파기-----------------------------------------
function db_destroy_conn(&$conn) {
	$conn = null;
}

//----------------------------------------------------------------------------------

//------------------------------레코드 작성--------------------------------------------
function db_select_boards_id(&$conn,&$arr_param){
	$sql = 
	" SELECT "
	." id "
	." ,b_title "
	." ,b_content "
	." ,b_id "
	." ,b_date "
	." ,b_hit "
	." FROM "
	." miniboard "
	." WHERE "
	." id = :id "
	." AND "
	." delete_flg = '0' "
	;
	
	$arr_ps = [
		":id" => $arr_param["id"]
		];

	try {
		$stmt = $conn->prepare($sql);
		$stmt->execute($arr_ps);
		$result = $stmt->fetchAll();
		return $result;
	} catch (Exception $e) {
		echo $e->getMessage();
		return false;
	}
}
//----------------------------------------------------------------------------------

//---------------------------------레코드 수정----------------------------------------
function db_update_boards_id(&$conn, &$arr_param) {
    $sql =
        " UPDATE miniboard SET b_title = :b_title, b_content = :b_content, b_id = :b_id WHERE id = :id AND delete_flg = '0' ";

    $arr_ps = [
        ":b_title" => $arr_param["b_title"],
        ":b_content" => $arr_param["b_content"],
        ":b_id" => $arr_param["b_id"],
        ":id" => $arr_param["id"]
    ];

    try {
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute($arr_ps);
        return $result;
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
}
//----------------------------------------------------------------------------------

//---------------------------------삭제 -------------------------------------------
function db_delete_boards_id(&$conn,&$arr_param){
	$sql = 
	" UPDATE miniboard "
	." SET "
	." delete_at = now() "
	." ,delete_flg = '1' "
	." WHERE "
	." id = :id "
	;

	$arr_ps = [
		":id" => $arr_param["id"]
	];

	try {
		$stmt = $conn->prepare($sql);
		$result = $stmt->execute($arr_ps);
		return $result;
	} catch(Exception $e) {
		echo $e->getMessage();
		return false;
	}
}

//----------------------------------------------------------------------------------
?>