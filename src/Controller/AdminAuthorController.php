<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/author')]
class AdminAuthorController extends AbstractController
{
    #[Route('/', name: 'app_admin_author_index', methods: ['GET','POST'])]
    public function index(AuthorRepository $authorRepository,PaginatorInterface $paginator, Request $request): Response
    {
        if(!is_null($request->request->get("search"))){
            $query = $authorRepository->search($request->request->get("search"));
        }else{
            $query = $authorRepository->findBy([], ["id"=>"DESC"]);
        }
        $authors = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );

        return $this->render('admin_author/index.html.twig', [
            'authors' => $authors,
        ]);
    }

    #[Route('/new', name: 'app_admin_author_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AuthorRepository $authorRepository, SluggerInterface $sluggerInterface ): Response
    {
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if(!is_null($author->getPseudo())){
                $s = $author->getPseudo();
            }else{
                $s = "";
                if(!is_null($author->getFirstName())) $s .= $author->getFirstName();
                if(!is_null($author->getName())){
                    (strlen($s)>0) ? $s .= " ".$author->getName() : $s .= $author->getName();
                }   
            }
            $author->setSlug($sluggerInterface->slug(strtolower ($s)));
            // prise en charge des slug des livres 

            if(count($form->getData()->getBooks())>0){
                foreach($form->getData()->getBooks() as $book){
                    $book->setSlug(strtolower($sluggerInterface->slug($book->getTitle())));
                }
            }

            // 
            $authorRepository->save($author, true);
            // mise en place du flash message
            $this->addFlash('success','Auteur correctement ajouté');

            return $this->redirectToRoute('app_admin_author_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_author/new.html.twig', [
            'author' => $author,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_author_show', methods: ['GET'])]
    public function show(Author $author): Response
    {
        return $this->render('admin_author/show.html.twig', [
            'author' => $author,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_author_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Author $author, AuthorRepository $authorRepository): Response
    {
        $form = $this->createForm(AuthorType::class, $author,["hasBooks"=>false]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $authorRepository->save($author, true);

            // mise en place du flash message
            $this->addFlash('success','Auteur correctement modifié');

            return $this->redirectToRoute('app_admin_author_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_author/edit.html.twig', [
            'author' => $author,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_author_delete', methods: ['POST'])]
    public function delete(Request $request, Author $author, AuthorRepository $authorRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$author->getId(), $request->request->get('_token'))) {
            $authorRepository->remove($author, true);
            // mise en place du flash message
            $this->addFlash('danger','Auteur correctement supprimé');
        }

        return $this->redirectToRoute('app_admin_author_index', [], Response::HTTP_SEE_OTHER);
    }
}
