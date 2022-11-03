<?php

namespace App\Controller;

use App\Form\UserType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class FrontProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_front_profil')]
    public function index(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        // on recupere l'utilisateur connecté
        $user = $this->getUser();
        $form = $this->createForm(UserType::class,$user);
        // on hydrate le formulaire
        $form->handleRequest($request);
        // si le formulaire est soumis et valide
        if($form->isSubmitted() && $form->isValid()){
            // on traite le plainPassword si necessaire
            if ($form->get('plainPassword')->getData()){
            $encodePassword = $userPasswordHasherInterface->hashPassword($user,$form->get('plainPassword')->getData());
            $user->setPassword($encodePassword);
            }
            // On récupère l'entité User
            $user = $form->getData();
            // On persiste l'entité
            $em->persist($user);
            // On flush
            $em->flush();
            // On ajoute un message flash
            $this->addFlash('success', 'Votre profil a bien été mis à jour.');
            // On redirige vers la page de profil
            return $this->redirectToRoute('app_front_profil');
        }

        return $this->render('front_profil/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/favorite', name: 'app_front_favorite', methods:["POST"])]
    public function favorite(Request $request,EntityManagerInterface $em , BookRepository $bookRepository):Response
    {
        $idLivre=$request->request->get('id');
        $book=$bookRepository->find($idLivre);
        $user=$this->getUser();
        $user->addBook($book);
        $em->persist($user);
        $em->flush();

        return new Response("ok");
    }

    #[Route('/remove-favorite', name: 'app_front_remove_favorite', methods:["POST"])]
    public function removeFavorite(Request $request,EntityManagerInterface $em , BookRepository $bookRepository):Response
    {
        $idLivre=$request->request->get('id');
        $book=$bookRepository->find($idLivre);
        $user=$this->getUser();
        $user->removeBook($book);
        $em->persist($user);
        $em->flush();

        return new Response("ok");
    }
}
