<?php

namespace App\Controller;
use App\Entity\Roles;
use App\Repository\RolesRepository;
use App\Form\RolesType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class RolesController extends AbstractController
{
    private $RolesRepository;

    public function __construct(
        RolesRepository $RolesRepository)
    {
        $this->RolesRepository = $RolesRepository;
    }

    /**
     * @Route("/list-roles", name="list-roles")
     */
    public function index()
    {
       $rolesList = $this->RolesRepository->findAll();
        return $this->render('roles/rolesList.html.twig', [
        'rolesList' => $rolesList,
        ]);
    }

    /**
     * @Route("/create-roles", name="create-roles")
     */
    public function createRole(
        Request $request,
        EntityManagerInterface $entityManager)
    {
        $roles = new Roles();

        $form = $this->createForm(RolesType::class, $roles);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($roles);

            $entityManager->flush();

            return $this->redirectToRoute('create-roles');       
        }
        return $this->render('roles/form-createRoles.html.twig', [
            'createRolesForm' => $form->createView(),
        ]);
    }

}
