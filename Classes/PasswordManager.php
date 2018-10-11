<?php

class PasswordManager {

	public $username;
	public $hashPassword;

	/**
	* Create user with username and password
	**/
	public function createUser($username, $password) {
		$this->username = $username;
		return $this->setNewPassword($password);
	}

	/**
	* Encrypt password: use md5
	**/
	protected function encrypt($password) {
		return md5($password);
	}

	/**
	* Verify password has the same value with member variable: hashPassword
	**/
	protected function verifyPassword($password) {
		$hashPassword = $this->encrypt($password);
		return $this->hashPassword === $hashPassword;
	}

	/**
	* Validate password with 4 rules
	**/
	public function validatePassword($password) {
		if(preg_match('/\\s/', $password)) {
			throw new \Exception('The password must not contain any whitespace.');
		}
		if(strlen($password) < 6) {
			throw new \Exception('The password must be at least 6 characters long.');
		}
		if(!preg_match('/[a-z]+/', $password) || !preg_match('/[A-Z]+/', $password)) {
			throw new \Exception('The password must contain at least one uppercase and at least one lowercase letter.');
		}
		if(!preg_match('/[0-9]+/', $password) || !preg_match('/[\W]/', $password)) {
			throw new \Exception('The password must have at least one digit and symbol.');
		}

		return true;
	}

	/**
	* Login: verify password
	**/
	public function login($password) {
		return $this->verifyPassword($password);
	}

	/**
	* Set password for create user and change password
	**/
	public function setNewPassword($password) {
		$isValidatePassword = $this->validatePassword($password);

		if(!$isValidatePassword) {
			return false;
		}

		$this->hashPassword = $this->encrypt($password);
		$this->storeInfo();
		return true;

	}

	/**
	* Store username and password in file password.txt
	**/
	protected function storeInfo() {
		if(empty($this->username)) {
			throw new \Exception('Username is required', -1);
		}

		if(empty($this->hashPassword)) {
			throw new \Exception('Hash password is required', -1);
		}

		$file = fopen('password.txt', 'w') or die('Can\'t not create file');
		fwrite($file, 'username: ' . $this->username . ' - password: ' . $this->hashPassword);
		fclose($file);
	}

}