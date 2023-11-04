<?php

class Signup
{
    private $error = "";

    public function evaluate($data)
    {
        // Validate and sanitize user data
        $first_name = ucfirst(trim($data['first_name']));
        $last_name = ucfirst(trim($data['last_name']));
        $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        $password = $data['password'];
        $gender = $data['gender']; // Add gender field

        // Perform data validation
        if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($gender)) {
            $this->error .= "All fields are required!<br>";
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->error .= "Invalid email address!<br>";
            }

            if (!preg_match("/^[a-zA-Z ]+$/", $first_name) || !preg_match("/^[a-zA-Z ]+$/", $last_name)) {
                $this->error .= "First and last names should only contain letters and spaces!<br>";
            }
        }

        if (empty($this->error)) {
            // No validation errors, create the user
            $this->create_user($first_name, $last_name, $email, $password, $gender);
        }

        return $this->error;
    }

    public function create_user($first_name, $last_name, $email, $password, $gender)
    {
        // Generate a unique user ID
        $userid = $this->create_userid();

        // Hash the password securely using bcrypt
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Create a URL address
        $url_address = strtolower($first_name) . "." . strtolower($last_name);

        // Use mysqli to insert user data into the database
        $DB = new mysqli("localhost", "root", "", "chatbook_db");

        if ($DB->connect_error) {
            die("Database connection failed: " . $DB->connect_error);
        }

        $query = "INSERT INTO users (userid, first_name, last_name, email, password, gender, url_address) VALUES ('$userid', '$first_name', '$last_name', '$email', '$hashed_password', '$gender', '$url_address')";

        if ($DB->query($query) === true) {
            // User successfully created
            $_SESSION['chatbook_userid'] = $userid;
        } else {
            $this->error .= "Failed to create a user. Please try again later.<br>";
        }

        $DB->close();
    }

    private function create_userid()
    {
        $length = rand(4, 19);
        $number = "";
        for ($i = 1; $i < $length; $i++) {
            $new_rand = rand(0, 9);
            $number .= $new_rand;
        }

        return $number;
    }
}
