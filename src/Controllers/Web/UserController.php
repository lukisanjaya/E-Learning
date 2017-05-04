<?php

namespace App\Controllers\Web;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \GuzzleHttp\Exception\BadResponseException as GuzzleException;

class UserController extends \App\Controllers\BaseController
{
    public function getRegister(Request $request, Response $response)
    {
        return $this->view->render($response,'user/register.twig');
    }
    public function postRegister(Request $request, Response $response)
    {
        $req = $request->getParsedBody();

        try {
            $client = $this->testing->request('POST',
                      $this->router->pathFor('api.user.register'),
                      ['json' => $req]);
            return $response->withRedirect($this->router->pathFor(
                   'web.user.register',
                   ['message' => 'success registered check your email']));
        } catch (GuzzleException $e) {
            $error = $e->getResponse()->getBody()->getContents();
            // return $response->withRedirect($this->router->pathFor('web.user.register',['errors' => $error]));
            echo $error;
        }
    }
    public function activeUser(Request $request, Response $response)
    {
        $options = [
            'query' => [
                'token' => $request->getQueryParam('token'),
            ]
        ];
        try {
            $activation = $this->testing->request('GET', $this->router->pathFor('user.active'), $options);
            return $response->withRedirect($this->router->pathFor(
                   'web.user.register',
                   ['message' => 'success registered check your email']));
            if ($activation->getStatusCode() == 200) {
                return $response->withRedirect(
                    $this->router->pathFor('web.user.login',
                    ['message' => 'your account successfully activated']));
            } else {
                echo "failed to activate your account";
            }
        } catch (GuzzleException $e) {
            $error = $e->getResponse()->getBody()->getContents();
            echo $error;
        }
    }
    public function getLogin (Request $request, Response $response)
    {
        return $this->view->render($response, 'user/login.twig');
    }
    public function postLogin(Request $request, Response $response)
    {
        $body = $request->getParsedBody();
        try {
            $login = $this->testing->request('POST', $this->router->pathFor('api.user.login'),['json' => $body]);

            if ($login->getStatusCode() == 200) {
                echo 'sukses login';
            } else {
                echo 'gagal login';
            }
        } catch (GuzzleException $e) {
            $error = $e->getResponse()->getBody()->getContents();
            echo $error;
            // return $response->withRedirect($this->router->pathFor('web.user.login',['errors' => $error]));
        }
    }

    public function getEditProfil (Request $request, Response $response, $args)
    {
        $id   = $args['id'];

        try {
            $client = $this->testing->request('GET', 
                      $this->router->pathFor('api.user.edit.profil', 
                      ['id' => $id]));
            return $response->withRedirect($this->router->pathFor(
                   'web.user.edit.profile', $client));
        } catch (GuzzleException $e) {
            $error = $e->getResponse()->getBody()->getContents();
            echo $error;
        }
    }

    public function postEditProfil(Request $request, Response $response, $args)
    {
        $id   = $args['id'];
        $req = $request->getParsedBody();

        try {
            $client = $this->testing->request('PUT', 
                      $this->router->pathFor('api.user.edit.profile', 
                      ['id' => $id]),['json' => $req]);
            return $response->withRedirect($this->router->pathFor(
                   'web.user.edit.profile',
                   ['message' => 'success updated your profile']));
        } catch (GuzzleException $e) {
            $error = $e->getResponse()->getBody()->getContents();
            echo $error;
        }
    }
}
