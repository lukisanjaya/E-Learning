<?php

namespace App\Controllers\Views;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/**
* 
*/
class View extends \App\Controllers\BaseController
{
    
    public function index(Request $request, Response $response)
    {
        return $this->view->render($response, 'user/beforelogin/home.twig');
    }

    public function article(Request $request, Response $response)
    {
        return $this->view->render($response, 'user/beforelogin/articles/article.twig');
    }

    public function articleDetail(Request $request, Response $response)
    {
        return $this->view->render($response, 'user/beforelogin/articles/article_detail.twig');
    }

    public function login(Request $request, Response $response)
    {
        return $this->view->render($response, 'user/login.twig');
    }

    public function register(Request $request, Response $response)
    {
        return $this->view->render($response, 'user/register.twig');
    }

    public function resetPassword(Request $request, Response $response)
    {
        return $this->view->render($response, 'user/resetpassword.twig');
    }

    public function newPassword(Request $request, Response $response)
    {
        return $this->view->render($response, 'user/newpassword.twig');
    }

    public function upgrade(Request $request, Response $response)
    {
        return $this->view->render($response, 'user/beforelogin/users/upgrade_premium.twig');
    }

    public function dashboard(Request $request, Response $response)
    {
        return $this->view->render($response, 'user/afterlogin/course.twig');
    }

    public function getAccount(Request $request, Response $response)
    {
        return $this->view->render($response, 'user/afterlogin/users/account.twig');
    }

    public function getProfile(Request $request, Response $response)
    {
        return $this->view->render($response, 'user/afterlogin/users/profile.twig');
    }

    public function getAnotherProfile(Request $request, Response $response)
    {
        return $this->view->render($response, 'user/afterlogin/users/another_profile.twig');
    }

    public function getPassword(Request $request, Response $response)
    {
        return $this->view->render($response, 'user/afterlogin/users/change_password.twig');
    }

    public function dashboardDetail(Request $request, Response $response)
    {
        return $this->view->render($response, 'user/afterlogin/course_detail.twig');
    }
}


?>