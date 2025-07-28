<?php
declare(strict_types=1);
session_start();
require_once 'config.php';
class Auth
{
    private \mysqli $conn;

    public function __construct(private readonly Database $db)
    {
        $this->conn = $db->conn;
    }

    public function getConnection(): \mysqli
    {
        return $this->conn;
    }

    // register user module
    public function register(
        string $name,
         string $email,
        string $password,
         ?string $vkey='', 
        ?string $image = '',
         ?string $bio = '',
        ?string $pin = null, 
        ?int $verified = 0, 
        string $date_created = ''
    ): bool {
        if (empty($email) || empty($password)) {
            return false;
        }

        $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $bio = htmlspecialchars($bio, ENT_QUOTES, 'UTF-8');
        $image = $image ?? '';
        $vkey = md5(time() . $email);
        $verified = 0;
        

        // Check if email already exists
        $stmt = $this->conn->prepare("SELECT id FROM user_profile WHERE email = ?");
        if (!$stmt) {
            throw new \RuntimeException("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->close();
            return false;
        }
        $stmt->close();

        // Hash the password, but do NOT hash pin — it’s generated below.
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Generate a random 4-digit pin if not passed
        $pin = str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);

        // Use provided date or default to current
        $created = $date_created ?: (new \DateTimeImmutable())->format('Y-m-d H:i:s');

        // Prepare insert query
        $stmt = $this->conn->prepare("
            INSERT INTO user_profile (name, email, password, image, bio, pin, vkey, verified, date_created)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        if (!$stmt) {
            throw new \RuntimeException("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("sssssisss", $name, $email, $hashedPassword, $image, $bio, $pin, $vkey, $verified, $created);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

         // log in user module
    public function login(string $email, string $password): bool
    {
        $stmt = $this->conn->prepare("SELECT id, password FROM user_profile WHERE email = ?");
        if (!$stmt) {
            throw new \RuntimeException("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($id, $hashedPassword);
        $stmt->fetch();
        $stmt->close();

        if (isset($hashedPassword) && password_verify($password, $hashedPassword)) {
            $_SESSION['u_id'] = $id;
            return true;
        }

        return false;
    }

     // log out user module
    public function logout(): void
    {
        session_unset();
        session_destroy();
    }



    // set user module
    public function isLoggedIn(): bool
    {
        return isset($_SESSION['u_id']);
    }



    // get signed in user module
    public function getUserId(): ?int
    {
        return $_SESSION['u_id'] ?? null;
    }


    // forgot password module

    public function forgotPassword( 
    string $email,
    string $vkey= '',
    string $created_at= ''): bool
    {

        $checkEmail = $this->conn->prepare("SELECT email FROM user_profile WHERE email = ?");
        $checkEmail->bind_param("s", $email);
        $checkEmail->execute();
        $result = $checkEmail->get_result();

     if ($result->num_rows === 0) {
        
          return false;
          exit;
     }
         
        $insertEmail = $this->conn->prepare("INSERT INTO forgot_password (email, vkey, created_at) VALUES (?, ?, ?)");
        $insertEmail->bind_param("sss", $email, $vkey, $created_at);
        
        if ($insertEmail->execute()) {
            return true;
        } else {
            return false;
        }
    }

        // message sending  module
    public function sendMessage(string $sender_email, string $name,
    string $subject, string $compose, string $receiver_email, int $has_read = 0, int $is_receiver_deleted = 0,
    int $is_sender_deleted = 0, string $date = ''
    ): bool {
        $date = $date ?: date('Y-m-d H:i:s');
        $stmt = $this->conn->prepare("INSERT INTO messages (sender_email, name, subject, compose, receiver_email, has_read, is_receiver_deleted, is_sender_deleted, date)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return false;
        }
    
        $stmt->bind_param(
            'ssssssiss',  $sender_email,  $name,  $subject,
            $compose, $receiver_email,  $has_read, $is_receiver_deleted,
            $is_sender_deleted, $date
        );
    
        $result = $stmt->execute();
        $stmt->close();
    
        return $result;
    }


    // contact processing module
    public function contactUs(string $firstname,
    string $lastname,
    string $subject,
    string $email,
    string $message,
    string $date = '') :bool {   
         $date = $date ?: date('Y-m-d H:i:s');
         $contactProcess = $this->conn->prepare("INSERT INTO contact (firstname, lastname, subject, email, message, date)
         VALUES (?, ?, ?, ?, ?, ?)");
         $contactProcess->bind_param("ssssss",$firstname, $lastname, $subject, $email, $message, $date);
         if($contactProcess->execute()){
           return true;
         }

         else{
            return false;
         }
    }


    public function subscribe(string $email, string $date = '') :bool{
        $date = $date ?: date('Y-m-d H:i:s');
        $subscribeProcess = $this->conn->prepare("INSERT INTO subscription (email,date)
         VALUES (?, ?)");
         $subscribeProcess->bind_param("ss",$email, $date);
         if($subscribeProcess->execute()){
           return true;
         }

         else{
            return false;
         }
    }

}
    

?>
