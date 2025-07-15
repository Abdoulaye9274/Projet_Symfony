<?php

namespace App\Controller\Api;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/articles')]
class ArticleApiController extends AbstractController
{
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;
    private EntityManagerInterface $entityManager;

    public function __construct(
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager
    ) {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->entityManager = $entityManager;
    }

    #[Route('', name: 'api_articles_get_all', methods: ['GET'])]
    public function getArticles(ArticleRepository $articleRepository, Request $request): JsonResponse
    {
        $search = $request->query->get('search');
        $limit = $request->query->getInt('limit', 10);
        
        if ($search) {
            $articles = $articleRepository->findBySearchTerm($search);
        } else {
            $articles = $articleRepository->findPublished();
        }

        // Limit results if needed
        if ($limit > 0) {
            $articles = array_slice($articles, 0, $limit);
        }

        $data = $this->serializer->serialize($articles, 'json', [
            'groups' => ['article:read']
        ]);

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    #[Route('/{id}', name: 'api_articles_get_one', methods: ['GET'])]
    public function getArticle(Article $article): JsonResponse
    {
        if (!$article->isPublished()) {
            return new JsonResponse(['error' => 'Article not found'], Response::HTTP_NOT_FOUND);
        }

        $data = $this->serializer->serialize($article, 'json', [
            'groups' => ['article:read', 'article:detail']
        ]);

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    #[Route('', name: 'api_articles_create', methods: ['POST'])]
    public function createArticle(Request $request): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return new JsonResponse(['error' => 'Invalid JSON'], Response::HTTP_BAD_REQUEST);
        }

        $article = new Article();
        $article->setAuthor($this->getUser());
        
        if (isset($data['title'])) $article->setTitle($data['title']);
        if (isset($data['content'])) $article->setContent($data['content']);
        if (isset($data['summary'])) $article->setSummary($data['summary']);
        if (isset($data['published'])) $article->setPublished((bool) $data['published']);

        $errors = $this->validator->validate($article);
        
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = [
                    'property' => $error->getPropertyPath(),
                    'message' => $error->getMessage()
                ];
            }
            return new JsonResponse(['errors' => $errorMessages], Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->persist($article);
        $this->entityManager->flush();

        $data = $this->serializer->serialize($article, 'json', [
            'groups' => ['article:read', 'article:detail']
        ]);

        return new JsonResponse($data, Response::HTTP_CREATED, [], true);
    }

    #[Route('/{id}', name: 'api_articles_update', methods: ['PUT', 'PATCH'])]
    public function updateArticle(Article $article, Request $request): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        if ($article->getAuthor() !== $this->getUser()) {
            return new JsonResponse(['error' => 'Access denied'], Response::HTTP_FORBIDDEN);
        }

        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return new JsonResponse(['error' => 'Invalid JSON'], Response::HTTP_BAD_REQUEST);
        }

        if (isset($data['title'])) $article->setTitle($data['title']);
        if (isset($data['content'])) $article->setContent($data['content']);
        if (isset($data['summary'])) $article->setSummary($data['summary']);
        if (isset($data['published'])) $article->setPublished((bool) $data['published']);

        $article->updateTimestamp();

        $errors = $this->validator->validate($article);
        
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = [
                    'property' => $error->getPropertyPath(),
                    'message' => $error->getMessage()
                ];
            }
            return new JsonResponse(['errors' => $errorMessages], Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->flush();

        $responseData = $this->serializer->serialize($article, 'json', [
            'groups' => ['article:read', 'article:detail']
        ]);

        return new JsonResponse($responseData, Response::HTTP_OK, [], true);
    }

    #[Route('/{id}', name: 'api_articles_delete', methods: ['DELETE'])]
    public function deleteArticle(Article $article): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        if ($article->getAuthor() !== $this->getUser()) {
            return new JsonResponse(['error' => 'Access denied'], Response::HTTP_FORBIDDEN);
        }

        $this->entityManager->remove($article);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Article deleted successfully'], Response::HTTP_OK);
    }
}