<?php
include_once('includes/config.php');
include_once('includes/classes/FormSanitizer.php');
include_once('includes/classes/Constants.php');
class Account
{
    private $con;
    private $errorArray = array();

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function updateDetails($fn, $ln, $em, $un)
    {
        $this->validateUsername($fn);
        $this->validateNewEmail($em, $un);

        if (empty($this->errorArray)) {
            $query = $this->con->prepare("UPDATE users SET firstName = :fn, lastName = :ln, email = :em
                                        WHERE username = :un");
            $query->bindValue(":fn", $fn);
            $query->bindValue(":ln", $ln);
            $query->bindValue(":em", $em);
            $query->bindValue(":un", $un);

            return $query->execute();
        }

        return false;
    }

    public function updateUser($em, $area, $type)
    {
        if (empty($this->errorArray)) {
            $query = $this->con->prepare("UPDATE users SET area = :area, type =:type
                                        WHERE email = :em");

            $query->bindValue(":em", $em);
            $query->bindValue(":area", $area);
            $query->bindValue(":type", $type);

            return $query->execute();
        }

        return false;
    }

    public function register($tk, $un, $em, $pw, $ty, $requestNum, $area = '')
    {
        $this->validateUsername($un);
        $this->validateEmail($em);
        $this->validatePassword($pw);

        if (empty($this->errorArray)) {
            return $this->insertUserDetils($tk, $un, $em, $pw, $ty, $requestNum, $area);
        }

        return false;
    }

    public function login($un, $pw)
    {
        $query = $this->con->prepare("SELECT * FROM users WHERE username=:un AND password=:pw");

        $query->bindValue(":un", $un);
        $query->bindValue(":pw", $pw);

        $query->execute();

        if ($query->rowCount() == 1) {
            return true;
        }

        array_push($this->errorArray, Constants::$loginFailed);

        return false;
    }

    public function insertUserDetils($tk, $un, $em, $pw, $ty, $requestNum, $area = '')
    {
        $query = $this->con->prepare("INSERT INTO users (token,username,email, password, type, requestNum, area) VALUES (:tk, :un, :em, :pw, :ty, :requestNum, :area)");

        $query->bindValue(":tk", $tk);
        $query->bindValue(":un", $un);
        $query->bindValue(":em", $em);
        $query->bindValue(":pw", $pw);
        $query->bindValue(":ty", $ty);
        $query->bindValue(":requestNum", $requestNum);
        $query->bindValue(":area", $area);

        return $query->execute();
    }

    public function deleteUser($usernames)
    {
        if ($usernames && is_array($usernames)) {
            foreach ($usernames as $username) {
                $query = $this->con->prepare("DELETE FROM users WHERE username=:username");
                $query->bindValue(":username", $username);
                $result = $query->execute();

                if (!$result) {
                    return false;
                }
            }

            return true;
        } else {
            return false;
        }
    }

    public function validateUsername($un)
    {
        $query = $this->con->prepare('SELECT * FROM users WHERE username = :un');
        $query->bindValue(':un', $un);

        $query->execute();

        if ($query->rowCount() != 0) {
            array_push($this->errorArray, constants::$usernameTaken);
        }
    }

    public function validateEmail($em)
    {
        if (!filter_var($em, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, constants::$emailInvalid);
        }

        $query = $this->con->prepare('SELECT * FROM users WHERE email = :em');
        $query->bindValue(':em', $em);

        $query->execute();

        if ($query->rowCount() != 0) {
            array_push($this->errorArray, constants::$emailTaken);
        }
    }

    public function validateNewEmail($em, $tk)
    {
        if (!filter_var($em, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, constants::$emailInvalid);
        }

        $query = $this->con->prepare('SELECT * FROM users WHERE email = :em AND token !=:tk');
        $query->bindValue(':em', $em);
        $query->bindValue(':un', $tk);

        $query->execute();

        if ($query->rowCount() != 0) {
            array_push($this->errorArray, constants::$emailTaken);
        }
    }

    public function validatePassword($pw)
    {
        if (strlen($pw) < 2 || strlen($pw) > 25) {
            array_push($this->errorArray, constants::$passwordLength);
            return;
        }
    }

    public function getError($error)
    {
        if (in_array($error, $this->errorArray)) {
            return "<span class='errorMessage'>$error</span>";
        }
    }

    public function getFirstError()
    {
        if (!empty($this->errorArray)) {
            return $this->errorArray[0];
        }
    }

    public function getAccount($notOwner = false, $notAdmin = false, $inspector = false, $getName = false)
    {
        $sql = "SELECT * FROM users ";

        if ($notOwner) {
            $sql .= "WHERE type != 'owner' ";
        }

        if ($notAdmin) {
            $sql .= "AND type != 'admin' ";
        }

        if ($inspector) {
            $sql .= "AND type = 'inspector' ";
        }

        $query = $this->con->prepare($sql);

        $query->execute();

        $html = "<div>";

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $name = $row["username"];
            $email = $row["email"];
            $type = $row["type"];

            if ($getName) {
                $html .= "<option value='$email'>$name</option>";
            } else {
                $html .= "<option value='$email'>$email - $type</option>";
            }
        }

        return $html . "</div>";
    }

    public function getAccountByType($type)
    {

        $query = $this->con->prepare("SELECT * FROM users WHERE type=:type");

        $query->bindValue(':type', $type);
        $query->execute();

        $html = "";

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $name = $row["username"];
            $html .= $name;
        }

        return $html;
    }

    public function getAccountNum($admin = false)
    {
        $sql = "SELECT * FROM users ";

        if ($admin) {
            $sql .= "WHERE type = 'admin'";
        }

        $query = $this->con->prepare($sql);

        // $query->bindValue(':admin', $admin);

        $query->execute();

        return $query->rowCount() + 1;
    }

    public function getAccountDetails($em, $name = false, $password = false, $area = false, $type = false, $requestNum = false)
    {
        $query = $this->con->prepare("SELECT * FROM users WHERE email = :em");

        $query->bindValue(':em', $em);

        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);

        if ($name) {
            return $row["username"];
        }
        if ($password) {
            return $row["password"];
        }
        if ($area) {
            return $row["area"];
        }
        if ($type) {
            return $row["type"];
        }
        if ($requestNum) {
            return $row["requestNum"];
        }
    }

    public function getAccountEmail($un)
    {
        $query = $this->con->prepare("SELECT * FROM users WHERE username = :un");

        $query->bindValue(':un', $un);

        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);
        if (!empty($row)) {
            return $row["email"];
        }
    }

    public function getMainAccount($type)
    {

        $query = $this->con->prepare("SELECT * FROM users WHERE type=:type AND main ='yes'");

        $query->bindValue(':type', $type);
        $query->execute();

        $html = "";

        $row = $query->fetch(PDO::FETCH_ASSOC);
        $name = $row["username"];
        $html .= $name;


        return $html;
    }
    public function getTransferAccount($type, $email)
    {

        $query = $this->con->prepare("SELECT * FROM users WHERE type=:type AND email != :email");

        $query->bindValue(':type', $type);
        $query->bindValue(':email', $email);
        $query->execute();

        $html = "";

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $name = $row["username"];
            $email = $row["email"];
            $html .= "<option value='$name'>$name</option>";
        }
        return $html;
    }
    public function getAllAccounts()
    {

        $query = $this->con->prepare("SELECT * FROM users ");

        $query->execute();

        $rows = array();

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $rows[] = $row;
        }

        return $rows;
    }
}
?>