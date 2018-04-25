<?php
require_once("../func.php");
$status = 1;
$msg = "出现未知错误";
$data = "";
$id = $_GET["id"];
$type_id = $_GET["type_id"];
$name = $_GET["name"];
$url = $_GET["url"];
$mysqli=new mysqli($DB_HOST,$DB_USER,$DB_PASS,$DB_NAME,$DB_PORT);
$mysqli->set_charset("utf8");
if ($mysqli->connect_errno){
    $msg = "数据库连接失败，请检查配置文件";
}
else{
    if (is_empty($id) || is_empty($type_id) ||is_empty($name) || is_empty($url)){
        $msg = "参数错误";
    }
    else{
        $stmt=$mysqli->prepare("SELECT * FROM site WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!($row = $result->fetch_assoc())){
            $msg = "tan90°_(:3」∠)_";
        }
        else{
            $stmt=$mysqli->prepare("UPDATE site SET type_id = ?, name = ?, url = ? WHERE id = ?");
            $stmt->bind_param('issi',$type_id, $name, $url, $id);
            $stmt->execute();
            $status = 0;
            $msg = "修改成功";
            $data = array(
                'id' => $id,
                'type_id' => $type_id,
                'name' => $name,
                'url' => $url);
        }
    }
    mysqli_close($mysqli);
}
echo json_encode(array(
    'status' => $status,
    'msg' => $msg,
    'data' => $data
));