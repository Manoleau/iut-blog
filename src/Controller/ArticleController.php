<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Commentaire;
use App\Form\ArticleCommentaireType;
use App\Repository\CommentaireRepository;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/article')]
class ArticleController extends AbstractController
{
    #[Route(path:'/', name:'app_article_index')]
    public function returntomenu(): Response
    {
        return $this->redirectToRoute('app_index');
    }
    #[Route('/nouveau', name: 'app_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $actuel = new \DateTimeImmutable();
            $article->setCreatedAt($actuel);
            $article->setUpdatedAt($actuel);
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('app_article_show', [
                'id' => $article->getId(),
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_show', methods: ['GET'])]
    public function show(EntityManagerInterface $entityManager, Request $request, Article $article, CommentaireRepository $commentaireRepository): Response
    {
        $commentaire = new Commentaire();
        $commentaire->setArticle($article);
        $form = $this->createForm(ArticleCommentaireType::class, $commentaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $actuel = new \DateTimeImmutable();
            $commentaire->setCreatedAt($actuel);
            $commentaire->setUpdatedAt($actuel);
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_article_show', ['id'=>$article->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->render('article/show.html.twig', [
            'article' => $article,
            'commentaires' => $commentaireRepository->findBy(['article' => $article]),
            'form'=>$form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $commentaires = $article->getCommentaires();
            for($i = 0; $i<$commentaires->count();$i++){
                $entityManager->remove($commentaires->get($i));
            }
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
    }
}
