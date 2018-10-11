<?php

require 'Classes/PasswordManager.php';

try {

	$passwordManager = new PasswordManager();

	// Create user
	$isCreateSuccess = $passwordManager->createUser('PhuSanh', 'thisIspassword123@');
	if($isCreateSuccess) {
		echo 'Create new user successfully. User info is stored in password.txt file.' . PHP_EOL;
	} else {
		throw new \Exception('Create user failed');
	}

	// Verify (Login)
	$isLoginSuccess = $passwordManager->login('thisIspassword123@');
	if($isLoginSuccess) {
		echo 'Login successfully' . PHP_EOL;
	} else {
		throw new \Exception('Login failed. Password not match');
	}

	// Change password
	$isChangePasswordSuccess = $passwordManager->setNewPassword('456#$newPassword');
	if($isChangePasswordSuccess) {
		echo 'Change new password successfully. New user info is stored in password.txt file.' . PHP_EOL;
	} else {
		throw new \Exception('Set new password failed');
	}

} catch(\Exception $e) {
	die('Exit with error: ' . $e->getMessage() . PHP_EOL);
}