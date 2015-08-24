<?php

namespace Controller;

use \Manager\UserManager;

class UserController extends DefaultController
{

	public function register()
	{
		$this->show('user/register');
	}

	public function login()
	{
		$this->show('user/login');
	}

}
