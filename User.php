<?php
require_once 'Database.php';

class User extends Database {
    public function register($email, $password, $fullname, $level = 2) {
        $password = md5($password); // Note: MD5 is not secure, use password_hash() in production
        
        $check_level = $this->koneksi->query("SELECT * FROM level_detail WHERE id_level = $level");
        if ($check_level->num_rows == 0) {
            return "Invalid user level";
        }
        
        $stmt = $this->koneksi->prepare("INSERT INTO user_detail (user_email, user_password, user_fullname, level) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $email, $password, $fullname, $level);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return "Registrasi gagal: " . $stmt->error;
        }
    }

    public function login($email, $password) {
        $password = md5($password); // Note: MD5 is not secure, use password_verify() in production
        
        $stmt = $this->koneksi->prepare("SELECT * FROM user_detail WHERE user_email = ? AND user_password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }

    public function getUser($id) {
        $stmt = $this->koneksi->prepare("SELECT * FROM user_detail WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }

    public function updateUser($id, $email, $fullname, $level) {
        $stmt = $this->koneksi->prepare("UPDATE user_detail SET user_email = ?, user_fullname = ?, level = ? WHERE id = ?");
        $stmt->bind_param("ssii", $email, $fullname, $level, $id);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return "Update gagal: " . $stmt->error;
        }
    }

    public function deleteUser($id) {
        $stmt = $this->koneksi->prepare("DELETE FROM user_detail WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return "Hapus user gagal: " . $stmt->error;
        }
    }

    public function getAllUsers() {
        $result = $this->koneksi->query("SELECT * FROM user_detail");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>