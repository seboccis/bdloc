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

		$last_name = "";
		$first_name = "";
		$username = "";
		$email = "";
		$password = "";
		$confirmPassword = "";
		$zipCode = "";
		$address = "";
		$phoneNumber = "";
		$error = "";
		
		if (!empty($_POST))
		{

			foreach ($_POST as $k => $v)
			{
				$$k = trim(strip_tags($v));
			}

			if (strlen($username) < 4)
			{
				$error = "Pseudo trop court !";
			}

			if ($userManager->usernameExists($username))
			{
				$error = "Pseudo déjà utilisé !";
			}

			if (!filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				$error = "Email non valide";
			}

			if ($userManager->emailExists($email))
			{
				$error = "Email déjà utilisé !";
			}

			if ($password != $confirmPassword)
			{
				$error = "le mot de passe ne correspond pas !";
			}

			if (empty($error))
			{
				$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

				$newUser = [

					'last_name' => $last_name,
					'first_name' => $first_name,
					'username' => $username,
					'email' => $email,
					'password' => $hashedPassword,
					'zip_code' => $zipCode,
					'address' => $address,
					'phone_number' => $phoneNumber,
					'role' => 'client',
					'date_created' => date('Y-m-d H:i:s'),
					'date_modified' => date('Y-m-d H:i:s')
				];

				$userManager->insert($newUser);
				$this->redirectToRoute('catalog');
			}
		}

		$dataToPassToTheView = ['error' => $error, 'last_name' => $last_name, 'first_name' => $first_name, 'username' => $username, 'email' => $email];
		$this->show('user/register', $dataToPassToTheView);
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

}
