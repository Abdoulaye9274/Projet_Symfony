<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/article')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'app_article_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository, Request $request): Response
    {
        $search = $request->query->get('search');
        
        if ($search) {
            $articles = $articleRepository->findBySearchTerm($search);
        } else {
            $articles = $articleRepository->findPublished();
        }

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
            'search' => $search,
        ]);
    }

    #[Route('/new', name: 'app_article_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $article->setAuthor($this->getUser());
        
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash('success', 'Article created successfully!');

            return $this->redirectToRoute('app_article_show', ['id' => $article->getId()]);
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_show', methods: ['GET'])]
    public function show(Article $article): Response
    {
        // Only show published articles or articles owned by current user
        if (!$article->isPublished() && $article->getAuthor() !== $this->getUser()) {
            throw $this->createNotFoundException('Article not found.');
        }

        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_article_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        // Only allow editing own articles
        if ($article->getAuthor() !== $this->getUser()) {
            throw $this->createAccessDeniedException('You can only edit your own articles.');
        }

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->updateTimestamp();
            $entityManager->flush();

            $this->addFlash('success', 'Article updated successfully!');

            return $this->redirectToRoute('app_article_show', ['id' => $article->getId()]);
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_delete', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function delete(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        // Only allow deleting own articles
        if ($article->getAuthor() !== $this->getUser()) {
            throw $this->createAccessDeniedException('You can only delete your own articles.');
        }

        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager->remove($article);
            $entityManager->flush();
            
            $this->addFlash('success', 'Article deleted successfully!');
        }

        return $this->redirectToRoute('app_dashboard');
    }
}