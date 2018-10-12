<?php

require 'Classes/PasswordManager.php';

function returnMessage() {

}

try {

	echo "----- ACTION MENU -----" . PHP_EOL;
	echo "1. Create new user" . PHP_EOL;
	echo "2. Validate password" . PHP_EOL;
	echo "3. Login" . PHP_EOL;
	echo "4. Change password" . PHP_EOL;
	echo "-----------------------" . PHP_EOL;
	$chosenAction = readline("Please choose: ");

	$chosenAction = (int)$chosenAction;
	if($chosenAction < 1 || $chosenAction > 4) die("Your chosen action not exist" . PHP_EOL); 

	$passwordManager = new PasswordManager();

	if($chosenAction === 1) {
		// Create user
		echo "----- Create user -----" . PHP_EOL;
		$username = readline("Username: ");
		$password = readline("Password: ");
		$isCreateSuccess = $passwordManager->createUser($username, $password);
		if($isCreateSuccess) {
			die('Create new user successfully. User info is stored in password.txt file.' . PHP_EOL);
		} else {
			throw new \Exception('Create user failed');
		}
	} elseif($chosenAction === 2) {
		// Validate password
		echo "----- Validate password -----" . PHP_EOL;
		$password = readline("Password: ");
		$isValidateSuccess = $passwordManager->validatePassword($password);
		if($isValidateSuccess) {
			die('Validate password success.' . PHP_EOL);
		} else {
			throw new \Exception('Validate password failed.');
		}
	} elseif($chosenAction === 3) {
		// Verify (Login)
		echo "----- Login -----" . PHP_EOL;
		$username = readline("Username: ");
		$password = readline("Password: ");
		$isLoginSuccess = $passwordManager->login($username, $password);
		if($isLoginSuccess) {
			die("User " . $username . " login successfully." . PHP_EOL);
		} else {
			throw new \Exception("Login failed. Password not match");
		}
	} else {
		// Change password
		echo "----- Change password -----" . PHP_EOL;
		$username = readline("Username: ");
		$password = readline("Current password: ");
		$isLoginSuccess = $passwordManager->login($username, $password);
		if($isLoginSuccess) {
			echo "-- User " . $username . " login successfully --" . PHP_EOL;
			$newPassword = readline("New password: ");
			$isChangePasswordSuccess = $passwordManager->setNewPassword($newPassword);
			if($isChangePasswordSuccess) {
				echo 'Change new password successfully. New user info is stored in password.txt file.' . PHP_EOL;
			} else {
				throw new \Exception('Set new password failed');
			}
		} else {
			throw new \Exception("Login failed. Password not match");
		}
	}
	

} catch(\Exception $e) {
	die ('Exit with error: ' . $e->getMessage() . PHP_EOL);
}