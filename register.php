<?php


//importing required script
require_once '../htdocs/DbOperation.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!verifyRequiredParams(array('username', 'password', 'g_name', 'sex', 'age', 'phone', 'mail'))) {
        //getting values
        $username = $_POST['username'];
        $password = $_POST['password'];
		$g_name = $_POST['g_name'];
		$sex = $_POST['sex'];
        $age = $_POST['age'];
        $phone = $_POST['phone'];
        $mail = $_POST['mail'];

        //creating db operation object
        $db = new DbOperation();

        //adding user to database
        $result = $db->createUser($username, $password, $g_name, $sex, $age, $phone, $mail);

        //making the response accordingly
        if ($result == USER_CREATED) {
            $response['error'] = false;
            $response['message'] = '用戶創建成功';
        } elseif ($result == USER_ALREADY_EXIST) {
            $response['error'] = true;
            $response['message'] = '用戶已存在';
        } elseif ($result == USER_NOT_CREATED) {
            $response['error'] = true;
            $response['message'] = '發生了一些錯誤';
        }
    } else {
        $response['error'] = true;
        $response['message'] = '缺少必需的參數';
    }
} else {
    $response['error'] = true;
    $response['message'] = '非法請求';
}

//function to validate the required parameter in request
function verifyRequiredParams($required_fields)
{

    //Getting the request parameters
    $request_params = $_REQUEST;

    //Looping through all the parameters
    foreach ($required_fields as $field) {
        //if any requred parameter is missing
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {

            //returning true;
            return true;
        }
    }
    return false;
}

echo json_encode($response);