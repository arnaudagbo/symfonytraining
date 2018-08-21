<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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



/**
 * @property  userRepository
 */
class UsersController extends FOSRestController
{
    /**
     * @Route("/users", name="users")
     */


    private $userRepository;
    private $em;
    public function __construct(UserRepository $userRepository, EntityManagerInterface $em)
    {
        $this->userRepository = $userRepository;
        $this->em = $em;
    }

    public function getUsersAction()
    {
        $users = $this->userRepository->findAll();
        return $this->view($users);
    } // "get_users"            [GET] /users
    public function getUserAction($id)
    {
        $user = $this->userRepository->find($id);
        return $this->view($user);
    } // "get_user"             [GET] /users/{id}

    /**
     * @Rest\Post("/users")
     * @ParamConverter("user", converter="fos_rest.request_body")
     */
    public function postUsersAction(User $user)
    {
        $this->em->persist($user);
        $this->em->flush();
        return $this->view($user);
    } // "post_users"           [POST] /users
    public function putUserAction(Request $request, int $id)
    {
        $user = $this->userRepository->find($id);

        if (true) {
            $firstname = $request->get('firstname');
            $lastname = $request->get('lastname');
            $email = $request->get('email');

            if (isset($firstname)) {
                $user->setFirstname($firstname);
            }

            if (isset($lastname)) {
                $user->setLastname($lastname);
            }

            if (isset($email)) {
                $user->setEmail($email);
            }

            $this->em->persist($user);
            $this->em->flush();
        }
            return $this->view($user);

    } // "put_user"             [PUT] /users/{id}
    public function deleteUserAction($id)
    {} // "delete_user"          [DELETE] /users/{id}


}
