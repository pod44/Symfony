<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SecurityController extends Controller
{
	/**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

	    // get the login error if there is one
	    $error = $authenticationUtils->getLastAuthenticationError();

	    // last username entered by the user
	    $lastUsername = $authenticationUtils->getLastUsername();

	    return $this->render(
	        'users/login.html.twig',
	        array(
	            // last username entered by the user
	            'last_username' => $lastUsername,
	            'error'         => $error,
	        )
	    );
	}

	/**
	* @Route("/login_check", name="login_check")
	*/
	public function check()
	{
	    throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
	}

	/**
	* @Route("/logout", name="logout")
	*/
	public function logout()
	{
	    throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
	}
}

?>