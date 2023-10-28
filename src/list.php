<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"] . "/miniboard/src/");
require_once(ROOT."db.php"); //함수가 정의된 파일 불러오기
//--------------페이징처리---------------
$conn = null;
$list_cnt = 10;
$page_num = 1;
$arr_err_msg=[];

try{if(!my_db_conn($conn)){
    throw new Exception("DB Error : PDO Instancs");
 } 
 $page = isset($_GET["page"]) ? $_GET["page"] : "1"; //기본으로 페이지1을 설정
 // ------------------예외 상황 처리 ------------------
    if($page === ""){ //page값이 없으면
     $arr_err_msg[] = sprintf(ERROR_MSG_PARAM,"page");
 
    }
    if(count($arr_err_msg) >= 1){
     throw new Exception(implode("<br>",$arr_err_msg));
    }
  //--------------------총 게시글 수 -------------------
 $boards_cnt = db_select_boards_cnt($conn);
 if($boards_cnt === false) {
     throw new Exception("DB Error : SELECT miniboard COUNT");
 }   
  //--------------------------------------------------
     $max_page_num = ceil($boards_cnt / $list_cnt); //최대 페이지
     $offset = ($page - 1) * $list_cnt;
     $prev_page_num = $page - 1 > 0 ? $page - 1 : 1;
     $next_page_num = $page + 1 > $max_page_num ? $max_page_num : $page + 1;
 
 // $offset = ($page_num-1) * $list_cnt; 
 
 // $prev_page_num = $page_num - 1 > 0 ? $page_num -1 : 1; //이전페이지로
 
 // $next_page_num = $page_num + 1 > $max_page_num ? $max_page_num : $page_num + 1; //다음
 
 
 $arr_param = [
     "list_cnt" => $list_cnt
     ,"offset" => $offset
 ];
 
 $result = db_select_boards_paging($conn,$arr_param);
 
 
 if($result === false) {
     // 게시글 조회 에러
     var_dump($result);
     throw new Exception("DB Error : Select boards Paging");
 }
} catch(Exception $e) {
echo $e->getMessage(); // 예외발생 메세지 출력
exit; // 처리 종료
} finally {
db_destroy_conn($conn); // DB 파기
}

?>

<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
	<title>게시판</title>
</head>
<body>
<article class = "main-article">
    <div class = "list"> 
        <h1> 게 시 판 </h1>

            <table>
                <thead>
                    <tr>
                        <th class ="no">번호</th>
                        <th class="title">제목</th>
                        <th class="content">내용</th>
                        <th class="writer">작성일</th>
                        <th class="write-date">조회</th>
                        <th class="hit">작성자</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <?php
                         foreach ($result as $item) {
                            // 각 행의 데이터를 처리하는 코드
                                        
                        ?>

                        <td class ="id"><?php echo $item["id"];?></td>
                       
                        <td class="b_title">
                                <a href="detail.php/?id=<?php echo $item["id"];?>&page=<?php echo $page_num;?>">
                                    <?php echo $item["b_title"]; ?>
                                 </a>
                        </td>
                        <td class="b_content"><?php echo $item["b_content"];?></td>
                        <td class="b_date"><?php echo $item["b_date"];?></td>
                        <td class="b_hit"><?php echo $item["b_hit"];?></td>
                        <td class="b_id"><?php echo $item["b_id"];?></td>
                    </tr>
                    <?php
                         }
                    ?>
                </tbody>
            </table>
            <section class="button">
                <a href="list.php?page=<?php echo $prev_page_num ?>">이전</a>
                <?php  
                    for($i=1; $i <= $max_page_num; $i++){
                       
                        ?>
                   
                   
                   <a href="list.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                <?php
                     }
                ?>
                <a href="list.php?page=<?php echo $next_page_num ?>">다음</a>
            </section>
            <div class="write-btn">
                <a href="insert.php">글쓰기</a>
            </div>

    </div>
</article>
</body>
</html>