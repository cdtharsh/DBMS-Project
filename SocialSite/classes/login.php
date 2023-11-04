<?php

class Login
{
    private $error = "";

    public function evaluate($data)
    {
        require_once "classes/connect.php"; // Include your Database class

        $email = $data['email'];
        $password = $data['password'];

        // Check if email and password are provided
        if (!empty($email) && !empty($password)) {
            $DB = new Database("localhost", "root", "", "chatbook_db");

            // Look up the user by email
            $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
            $result = $DB->read($query);

            if ($result && count($result) === 1) {
                $row = $result[0];

                // Verify the hashed password
                if (password_verify($password, $row['password'])) {
                    // Password matches, set user session
                    $_SESSION['chatbook_userid'] = $row['userid'];
                } else {
                    $this->error .= "Password doesn't match!<br>";
                }
            } else {
                $this->error .= "No user with that email was found!<br>";
            }
        } else {
            $this->error .= "Both email and password are required!<br>";
        }

        return $this->error;
    }

    public function check_login($id)
    {
        require_once "classes/connect.php"; // Include your Database class

        if (is_numeric($id)) {
            $DB = new Database("localhost", "root", "", "chatbook_db");

            // Look up the user by user ID
            $query = "SELECT * FROM users WHERE userid = '$id' LIMIT 1";
            $result = $DB->read($query);

            if ($result && count($result) === 1) {
                $user_data = $result[0];
                return $user_data;
            } else {
                header("Location: login.php");
                die;
            }
        } else {
            header("Location: login.php");
            die;
        }
    }
}
