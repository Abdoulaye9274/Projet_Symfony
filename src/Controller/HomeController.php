<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findRecent(6);

        return $this->render('home/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/dashboard', name: 'app_dashboard')]
    public function dashboard(ArticleRepository $articleRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $user = $this->getUser();
        $userArticles = $articleRepository->findByAuthor($user);
        $recentArticles = $articleRepository->findRecent(5);

        return $this->render('dashboard/index.html.twig', [
            'user_articles' => $userArticles,
            'recent_articles' => $recentArticles,
        ]);
    }
}