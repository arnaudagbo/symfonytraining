<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;

//class UsersController extends AbstractController
//{

 //   public function index()
 //   {
  //      return $this->render('users/index.html.twig', [
  //          'controller_name' => 'UsersController',
   //     ]);
 //   }
// }

class UsersController extends FOSRestController
{
    /**
     * @Route("/users", name="users")
     */
    public function getUsersAction()
    {} // "get_users"            [GET] /users
    public function getUserAction($id)
    {} // "get_user"             [GET] /users/{id}
    public function postUsersAction()
    {} // "post_users"           [POST] /users
    public function putUserAction($id)
    {} // "put_user"             [PUT] /users/{id}
    public function deleteUserAction($id)
    {} // "delete_user"          [DELETE] /users/{id}


}
