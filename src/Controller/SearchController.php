<?php

namespace App\Controller;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Entity\Commentaire;


#[Route('/search')]
class SearchController extends AbstractController
{
    #[Route('', name: 'app_search', methods: ['GET'])]
    public function search(Request $request,ManagerRegistry $doctrine): Response
    {
        $query = $request->query->get('q');
        if (!empty($query)) {
            $auteurs = $doctrine
                        ->getRepository(Article::class)
                        ->findByAuthor($query);

            $titres = $doctrine
                        ->getRepository(Article::class)
                        ->findByTitle($query);
            
            $commentaires = $doctrine
                            ->getRepository(Commentaire::class)
                            ->findByAuthor($query);
            return $this->render('search/result.html.twig', [
                'auteurs' => $auteurs,
                'titres' => $titres,
                'commentaires' => $commentaires,
            ]);
        }
        return $this->render('search/result.html.twig',[
            'resultat'=> $query,
        ]);
    }
}   