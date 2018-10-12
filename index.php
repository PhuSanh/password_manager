<?php

require 'Classes/PasswordManager.php';

try {

	$passwordManager = new PasswordManager();

	// Create user
	echo "----- Create user -----" . PHP_EOL;
	$username = readline("Username: ");
	$password = readline("Password: ");
	$isCreateSuccess = $passwordManager->createUser($username, $password);
	if($isCreateSuccess) {
		echo 'Create new user successfully. User info is stored in password.txt file.' . PHP_EOL;
	} else {
		throw new \Exception('Create user failed');
	}

	// Verify (Login)
	echo "----- Login with user " . $username . " -----" . PHP_EOL;
	$loginPassword = readline("Password: ");
	$isLoginSuccess = $passwordManager->login($loginPassword);
	if($isLoginSuccess) {
		echo 'Login successfully' . PHP_EOL;
	} else {
		throw new \Exception('Login failed. Password not match');
	}

	// Change password
	echo "----- Change password -----" . PHP_EOL;
	$newPassword = readline("New password: ");
	$isChangePasswordSuccess = $passwordManager->setNewPassword($newPassword);
	if($isChangePasswordSuccess) {
		echo 'Change new password successfully. New user info is stored in password.txt file.' . PHP_EOL;
	} else {
		throw new \Exception('Set new password failed');
	}

} catch(\Exception $e) {
	die ('Exit with error: ' . $e->getMessage() . PHP_EOL);
}