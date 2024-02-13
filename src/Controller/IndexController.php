<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/')]
class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('index/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }
}