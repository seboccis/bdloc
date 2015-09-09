<?php

namespace Controller;

use \W\Controller\Controller;

class DefaultController extends Controller
{

	/**
	 * Page d'accueil par défaut
	 */
	public function home()
	{
		$this->show('default/home');
	}

	/**
	 * Méthode empêchant d'accéder à une page si l'utilisateur n'est pas loggé
	 */
	protected function lock()
	{
		if(empty($this->getUser())){
			$this->redirectToRoute('login');
		}
	}

	public function homeAdmin()
	{
		$this->show('admin/home_admin');
	}

}