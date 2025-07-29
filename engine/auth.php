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
        string $state = '',
        string $lga = '',
        string $address = '',
        string $bio = '',
        string $phone = '',
        string $occupation = '',
        string $dob = '',
        string $family = '',
        string $image = '',
        ?string $pin = null,
        ?string $vkey = '',
        ?int $verified = 0,
        string $date_created = ''
    ): bool {
        if (empty($email) || empty($password)) {
            return false;
        }
    
        // Sanitize and prepare values
        $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $bio = htmlspecialchars($bio, ENT_QUOTES, 'UTF-8');
        $address = htmlspecialchars($address, ENT_QUOTES, 'UTF-8');
        $occupation = htmlspecialchars($occupation, ENT_QUOTES, 'UTF-8');
        $family = htmlspecialchars($family, ENT_QUOTES, 'UTF-8');
        $state = htmlspecialchars($state, ENT_QUOTES, 'UTF-8');
        $lga = htmlspecialchars($lga, ENT_QUOTES, 'UTF-8');
        $phone = htmlspecialchars($phone, ENT_QUOTES, 'UTF-8');
        $dob = htmlspecialchars($dob, ENT_QUOTES, 'UTF-8');
        $image = $image ?? '';
        $vkey = $vkey ?: md5(time() . $email);
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
    
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
        // Generate 4-digit pin if not provided
        $pin = $pin ?? str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);
    
        // Use provided or default creation date
        $created = $date_created ?: (new \DateTimeImmutable())->format('Y-m-d H:i:s');
    
        // Insert into database
        $stmt = $this->conn->prepare("
            INSERT INTO user_profile (
                name, email, password, image, state, lga, address,
                bio, phone, occupation, dob, family, pin, vkey, verified, date_created
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
    
        if (!$stmt) {
            throw new \RuntimeException("Prepare failed: " . $this->conn->error);
        }
    
        $stmt->bind_param(
            "ssssssssssssssiss",
            $name, $email, $hashedPassword, $image, $state, $lga, $address,
            $bio, $phone, $occupation, $dob, $family, $pin, $vkey, $verified, $created
        );
    
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

    // newsletter processing module
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
    //  getting time ago  function
    public function timeAgo(string $date): string {
        $datetime1 = new DateTime($date);
        $datetime2 = new DateTime(); // now
        $interval = $datetime1->diff($datetime2);
    
        if ($interval->y > 0) {
            return $interval->y . ' year' . ($interval->y > 1 ? 's' : '') . ' ago';
        } elseif ($interval->m > 0) {
            return $interval->m . ' month' . ($interval->m > 1 ? 's' : '') . ' ago';
        } elseif ($interval->d > 0) {
            return $interval->d . ' day' . ($interval->d > 1 ? 's' : '') . ' ago';
        } elseif ($interval->h > 0) {
            return $interval->h . ' hour' . ($interval->h > 1 ? 's' : '') . ' ago';
        } elseif ($interval->i > 0) {
            return $interval->i . ' minute' . ($interval->i > 1 ? 's' : '') . ' ago';
        } else {
            return 'Just now';
        }
    }
  //  getting years ago  function
    public function yearsAgo(string $date): string {
        $from = new DateTime($date);
        $now = new DateTime();
    
        $years = $from->diff($now)->y;
    
        return $years === 0 ? "Less than a year old" : "$years year" . ($years > 1 ? "s" : "") . " old";
    }
    
}
    

?>
