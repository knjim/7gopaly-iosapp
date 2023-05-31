<?php


class DbOperation
{
    private $conn;

    function __construct()
    {
        require_once dirname(__FILE__) . '/Constants.php';
        require_once dirname(__FILE__) . '/DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }

    /*
     * This method is added
     * We are taking username and password
     * and then verifying it from the database
     * */

    public function userLogin($username, $password)
    {
        /*$password = md5($pass);*/
        $stmt = $this->conn->prepare("SELECT g_name FROM user WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    /*
     * After the successful login we will call this method
     * this method will return the user data in an array
     * */

    public function getUserByUsername($username)
    {
        $stmt = $this->conn->prepare("SELECT username, g_name, sex, age, phone, mail FROM user WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($uname, $g_name, $sex, $age, $phone, $mail);
        $stmt->fetch();
        $user = array();
		$user['username'] = $uname;
        $user['g_name'] = $g_name;
        $user['sex'] = $sex;
        $user['age'] = $age;
		$user['phone'] = $phone;
		$user['mail'] = $mail;
        return $user;
    }

     public function createUser($username, $password, $g_name, $sex, $age, $phone, $mail)
    {
        if (!$this->isUserExist($username, $g_name, $phone, $mail)) {
            /*$password = md5($pass);*/
            $stmt = $this->conn->prepare("INSERT INTO user (username, password, g_name, sex, age, phone, mail) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $username, $password, $g_name, $sex, $age, $phone, $mail);
            if ($stmt->execute()) {
                return USER_CREATED;
            } else {
                return USER_NOT_CREATED;
            }
        } else {
            return USER_ALREADY_EXIST;
        }
    }


    private function isUserExist($username, $g_name, $phone, $mail)
    {
        $stmt = $this->conn->prepare("SELECT g_name FROM user WHERE username = ? OR g_name = ? OR phone = ? OR mail = ?");
        $stmt->bind_param("ssss", $username, $g_name, $phone, $mail);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }


}