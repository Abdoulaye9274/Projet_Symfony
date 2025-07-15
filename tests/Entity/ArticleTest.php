<?php

namespace App\Tests\Entity;

use App\Entity\Article;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{
    private Article $article;
    private User $user;

    protected function setUp(): void
    {
        $this->article = new Article();
        $this->user = new User();
        $this->user->setEmail('test@example.com')
                   ->setFirstName('John')
                   ->setLastName('Doe');
    }

    public function testArticleCreation(): void
    {
        $this->assertInstanceOf(Article::class, $this->article);
        $this->assertNull($this->article->getId());
        $this->assertInstanceOf(\DateTimeInterface::class, $this->article->getCreatedAt());
        $this->assertFalse($this->article->isPublished());
    }

    public function testArticleProperties(): void
    {
        $title = 'Test Article Title';
        $content = 'This is the article content';
        $summary = 'Article summary';

        $this->article->setTitle($title);
        $this->article->setContent($content);
        $this->article->setSummary($summary);
        $this->article->setAuthor($this->user);
        $this->article->setPublished(true);

        $this->assertEquals($title, $this->article->getTitle());
        $this->assertEquals($content, $this->article->getContent());
        $this->assertEquals($summary, $this->article->getSummary());
        $this->assertEquals($this->user, $this->article->getAuthor());
        $this->assertTrue($this->article->isPublished());
    }

    public function testUpdateTimestamp(): void
    {
        $this->assertNull($this->article->getUpdatedAt());
        
        $this->article->updateTimestamp();
        
        $this->assertInstanceOf(\DateTimeInterface::class, $this->article->getUpdatedAt());
    }

    public function testAuthorRelation(): void
    {
        $this->article->setAuthor($this->user);
        $this->user->addArticle($this->article);

        $this->assertEquals($this->user, $this->article->getAuthor());
        $this->assertTrue($this->user->getArticles()->contains($this->article));
        
        // Test removal
        $this->user->removeArticle($this->article);
        $this->assertFalse($this->user->getArticles()->contains($this->article));
    }

    public function testArticleCreatedAt(): void
    {
        $now = new \DateTime();
        $createdAt = $this->article->getCreatedAt();
        
        // Article should be created within the last few seconds
        $this->assertInstanceOf(\DateTimeInterface::class, $createdAt);
        $this->assertEquals($now->format('Y-m-d H:i'), $createdAt->format('Y-m-d H:i'));
    }
}