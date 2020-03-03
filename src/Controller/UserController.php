<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\UsersRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class UserController extends AbstractController
{
    private $usersRepository;

    public function __construct(
        UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    /**
     * @Route("/list-user", name="list-user")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index()
    {
       $userList = $this->usersRepository->findAll();
        // Send to the View template 'user/index.html.twig' an array of content
        return $this->render('user/userList.html.twig', [
        'userList' => $userList,
        ]);
    }

    /**
     * @Route("/create-user", name="create-user")
     */
    public function createUser(
        Request $request,
        EntityManagerInterface $entityManager)
    {
        $user = new Users();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // objet User rempli avec les infos du formulaire
            


            $createdDate = date('Y-m-d H:i:s');
            $user->setcreateDate(new \DateTime($createdDate));

            $name = $user->getFirstName().' '.$user->getLastName();

            $entityManager->persist($user);

            $entityManager->flush();

            $this->addFlash("success", "L'utilisateur $name a été créé");

            return $this->redirectToRoute('index');       
        }
        return $this->render('user/form-createUser.html.twig', [
            'createUserForm' => $form->createView(),
        ]);
    }
}
