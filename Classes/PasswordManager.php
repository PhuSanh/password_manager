<?php

class PasswordManager {

	public $username;
	public $hashPassword;
	public $userLine;

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
	public function login($username, $password) {
		$path = "password.txt";
		if(!file_exists($path)) {
			throw new \Exception("File not found. Don't have user");
		}

		$file = fopen($path, "r") or die("Can't open file");

		$this->username = $username;
		$this->hashPassword = trim($this->encrypt($password));

		$index = 0;
		while (!feof($file)) {
			$line = fgets($file);
			if(!isset($line) || empty($line)) continue;

			$info = explode(" ", $line);
			
			if(($this->username === $info[0]) && (trim($info[1]) === $this->hashPassword)) {
				$this->userLine = $index;
				return true;
			}
			$index++;
		}
		return false;
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
		$this->storeInfo($this->userLine);
		return true;
	}

	/**
	* Store username and password in file password.txt
	**/
	protected function storeInfo($line = null) {
		if(empty($this->username)) {
			throw new \Exception("Username is required", -1);
		}

		if(empty($this->hashPassword)) {
			throw new \Exception("Hash password is required", -1);
		}

		$content = $this->username . " " . $this->hashPassword . "\n";
		$fileName = "password.txt";
		if($line !== null) {
			$fileContent = file($fileName);
			$count = count($fileContent);
			$file = fopen($fileName, "w+") or die("Can't not create file");
			$fileContent[$line] = $content;
			$y = 0;
			while ($y < $count) {
				fwrite($file, $fileContent[$y]);
				$y++;
			}
			fclose($file);
		} else {
			$file = fopen($fileName, "a+") or die("Can't not create file");

			fwrite($file, $content);
			fclose($file);
		}
	}

}