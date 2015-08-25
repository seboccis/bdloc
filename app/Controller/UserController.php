<?php

namespace Controller;

use \Manager\UserManager;
use \W\Security\AuthentificationManager;
use \W\Controller\Controller;

class UserController extends DefaultController
{

	public function register()
	{
		$userManager = new UserManager;
		$authentificationManager = new AuthentificationManager;

		$last_name = "";
		$first_name = "";
		$username = "";
		$email = "";
		$password = "";
		$confirmPassword = "";
		$zip_code = "";
		for ($i=75001; $i < 75021; $i++) { 
			$zip[] = $i;
		}
		$address = "";
		$phone_number = "";

		$usernameError = "";
		$emailError = "";
		$zip_codeError = "";
		$passwordError = "";
		
		
		if (!empty($_POST))
		{
			foreach ($_POST as $k => $v)
			{
				$$k = trim(strip_tags($v));
			}

			if (strlen($username) < 4)
			{
				$usernameError = "Pseudo trop court !";
			}

			if ($userManager->usernameExists($username))
			{
				$usernameError = "Pseudo déjà utilisé !";
			}

			if (!filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				$emailError = "Email non valide";
			}

			if ($userManager->emailExists($email))
			{
				$emailError = "Email déjà utilisé !";
			}

			if (!in_array($zip_code, $zip)) {
				$zip_codeError = "Vous devez indiquer un code postal parisien !";
			}

			if ($password != $confirmPassword)
			{
				$passwordError = "le mot de passe ne correspond pas !";
			}

			if (empty($usernameError) && empty($emailError) && empty($zip_codeError) && empty($passwordError)) {
		
				$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

				$newUser = [

					'last_name' => $last_name,
					'first_name' => $first_name,
					'username' => $username,
					'email' => $email,
					'password' => $hashedPassword,
					'zip_code' => $zip_code,
					'address' => $address,
					'phone_number' => $phone_number,
					'role' => 'client',
					'date_created' => date('Y-m-d H:i:s'),
					'date_modified' => date('Y-m-d H:i:s')
				];

				$userManager->insert($newUser);
				$authentificationManager->logUserIn($user);
				if ($userManager) {
					$this->redirectToRoute('catalog');
				}
			}
		}

		$data = [
			'last_name' => $last_name, 
			'first_name' => $first_name, 
			'username' => $username, 
			'email' => $email,
			'zip_code' => $zip_code,
			'address' => $address,
			'phone_number' => $phone_number,
			'usernameError' => $usernameError,
			'emailError' => $emailError,
			'passwordError' => $passwordError,
			'zip_codeError' => $zip_codeError,
			];
		$this->show('user/register', $data);
	}

	public function login()
	{
		$authentificationManager = new AuthentificationManager;

		$username = "";
		$password = "";
		$error = "";
		$data = [];

		if (!empty($_POST))
		{
			$username = $_POST['username'];
			$password = $_POST['password'];

			$result = $authentificationManager->isValidLoginInfo($username, $password);

			if ($result > 0){
					$userId = $result;
					
					$userManager = new \Manager\UserManager();
					$user = $userManager->find($userId);
					
					$authentificationManager->logUserIn($user);

					$this->redirectToRoute('catalog');
				}
				else 
				{
					$error = "Mauvais identifiant !";
				}
		}

		$data['error'] = $error;
		$data['username'] = $username;

		$this->show('user/login', $data);
	}

	public function logout()
	{
		$authentificationManager = new AuthentificationManager;
		$authentificationManager->logUserOut();

		$this->redirectToRoute('home');
	}

	public function account()
	{
		$this->show('user/account');
	}

	public function editProfile()
	{

		$userManager = new UserManager;
		$authentificationManager = new AuthentificationManager;

		$last_name = "";
		$first_name = "";
		$username = "";
		$email = "";
		$zip_code = "";
		for ($i=75001; $i < 75021; $i++) { 
			$zip[] = $i;
		}
		$address = "";
		$phone_number = "";

		$usernameError = "";
		$emailError = "";
		$zip_codeError = "";
	
		if (!empty($_POST)) {
			
			foreach ($_POST as $k => $v)
			{
				$$k = trim(strip_tags($v));
			}

			// Validation des données

			if (strlen($username) < 4)
			{
				$usernameError = "Pseudo trop court !";
			}

			if (!filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				$emailError = "Email non valide";
			}

			if (!in_array($zip_code, $zip)) {
				$zip_codeError = "Vous devez indiquer un code postal parisien !";
			}

			if (empty($usernameError) && empty($emailError) && empty($zip_codeError)) {
		
				// Si l'utilisateur décide de changer de username
				if ($username != $_SESSION['user']['username']) {
					// S'assurer que le nouveau username n'est pas déjà utilisé
					if ($userManager->usernameExists($username)) {
						$usernameError = "Pseudo déjà utilisé !";
					}
				}
				
				// Si l'utilisateur décide de changer d'email
				if ($email != $_SESSION['user']['email']) {
					// S'assurer que le nouvel email n'est pas déjà utilisé
					if ($userManager->emailExists($email)) {
						$emailError = "Email déjà utilisé !";
					}
				}
				
				$newUser = [
					'last_name' => $last_name,
					'first_name' => $first_name,
					'username' => $username,
					'email' => $email,
					'zip_code' => $zip_code,
					'address' => $address,
					'phone_number' => $phone_number,
					'date_modified' => date('Y-m-d H:i:s')
				];


				
				if ($userManager->update($newUser,$_SESSION['user']['id'])) {
					$refreshUser = $userManager->find($_SESSION['user']['id']);
					$_SESSION['user'] = $refreshUser;
				}
			}
					
		}

		$data = [
			'usernameError' => $usernameError,
			'emailError' => $emailError,
			'zip_codeError' => $zip_codeError,
			];

		$this->show('user/edit_profile', $data);
	}
}
