<?php

namespace App\Controller;

use App\Repository\AuthorRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontAuthorController extends AbstractController
{
    #[Route('/auteurs', name: 'app_front_author')]
    public function index(AuthorRepository $authorRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $query = $authorRepository->findAll();
        //
        $authors = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );
        //
        return $this->render('front_author/index.html.twig', [
            'authors' => $authors,
        ]);
    }

    #[Route('/auteur/{slug}', name: 'app_front_author_show')]
    public function show(AuthorRepository $authorRepository, $slug): Response
    {
        $author = $authorRepository->findOneBy(['slug' => $slug]);
        return $this->render('front_author/show.html.twig', [
            'author' => $author,
        ]);
    }

}
