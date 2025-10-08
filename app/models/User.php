<?php
/**
 * User Model
 */

class User extends Model {
    protected $table = 'users';
    
    public function authenticate($username, $password) {
        $user = $this->findOneBy('username', $username);
        
        if ($user && password_verify($password, $user['password'])) {
            $this->updateLastLogin($user['id']);
            return $user;
        }
        
        $user = $this->findOneBy('email', $username);
        if ($user && password_verify($password, $user['password'])) {
            $this->updateLastLogin($user['id']);
            return $user;
        }
        
        return false;
    }
    
    public function createUser($data) {
        $data['password'] = password_hash($data['password'], HASH_ALGO, ['cost' => HASH_COST]);
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->create($data);
    }
    
    public function updateLastLogin($userId) {
        return $this->update($userId, ['last_login' => date('Y-m-d H:i:s')]);
    }
    
    public function existsByEmail($email) {
        return $this->findOneBy('email', $email) !== false;
    }
    
    public function existsByUsername($username) {
        return $this->findOneBy('username', $username) !== false;
    }
    
    public function existsByCurp($curp) {
        return $this->findOneBy('curp', $curp) !== false;
    }
    
    public function getUsersByRole($role) {
        return $this->findBy('role', $role);
    }
    
    public function updatePassword($userId, $newPassword) {
        $hashedPassword = password_hash($newPassword, HASH_ALGO, ['cost' => HASH_COST]);
        return $this->update($userId, ['password' => $hashedPassword]);
    }
}
