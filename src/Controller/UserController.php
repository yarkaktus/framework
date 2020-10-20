<?php

declare(strict_types = 1);

namespace Controller;

use Framework\Render;
use Service\User\User;
use Service\User\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController
{
    use Render;

    /**
     * Производим аутентификацию и авторизацию
     *
     * @param Request $request
     * @return Response
     */
    public function authenticationAction(Request $request): Response
    {
        if ($request->isMethod(Request::METHOD_POST)) {
            $user = new Security($request->getSession());

            $isAuthenticationSuccess = $user->authentication(
                $request->request->get('login'),
                $request->request->get('password')
            );

            if ($isAuthenticationSuccess) {
                return $this->render('user/authentication_success.html.php', ['user' => $user->getUser()]);
            } else {
                $error = 'Неправильный логин и/или пароль';
            }
        }

        return $this->render('user/authentication.html.php', ['error' => $error ?? '']);
    }

    /**
     * Выходим из системы
     *
     * @param Request $request
     * @return Response
     */
    public function logoutAction(Request $request): Response
    {
        (new Security($request->getSession()))->logout();

        return $this->redirect('index');
    }

    /**
     * Вывод всех пользователей
     * доступно только администраторам
     *
     * @param Request $request
     * @return Response
     */
    public function userList(Request $request): Response
    {
        $user_session = new Security($request->getSession());
        $user = $user_session->getUser();

        if (is_null($user)){
            return  $this->render('error404.html.php');
        }
        $user_role = $user_session->getUser()->getRole();
        if ($user_role->getType() != 'admin'){
            return $this->render('error404.html.php');
        }

        $userList = (new User())->getAll();
        return  $this->render('user/list.html.php', ['userList' => $userList]);
    }
}
