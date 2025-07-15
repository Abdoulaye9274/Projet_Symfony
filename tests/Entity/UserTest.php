<?php

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        $this->user = new User();
    }

    public function testUserCreation(): void
    {
        $this->assertInstanceOf(User::class, $this->user);
        $this->assertNull($this->user->getId());
        $this->assertEquals(['ROLE_USER'], $this->user->getRoles());
    }

    public function testUserProperties(): void
    {
        $email = 'test@example.com';
        $firstName = 'John';
        $lastName = 'Doe';
        $password = 'hashedpassword123';

        $this->user->setEmail($email);
        $this->user->setFirstName($firstName);
        $this->user->setLastName($lastName);
        $this->user->setPassword($password);

        $this->assertEquals($email, $this->user->getEmail());
        $this->assertEquals($firstName, $this->user->getFirstName());
        $this->assertEquals($lastName, $this->user->getLastName());
        $this->assertEquals($password, $this->user->getPassword());
        $this->assertEquals('John Doe', $this->user->getFullName());
    }

    public function testUserIdentifier(): void
    {
        $email = 'test@example.com';
        $this->user->setEmail($email);
        
        $this->assertEquals($email, $this->user->getUserIdentifier());
    }

    public function testUserRoles(): void
    {
        // Test default role
        $this->assertEquals(['ROLE_USER'], $this->user->getRoles());
        
        // Test custom roles
        $this->user->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
        $roles = $this->user->getRoles();
        
        $this->assertContains('ROLE_USER', $roles);
        $this->assertContains('ROLE_ADMIN', $roles);
        $this->assertCount(2, array_unique($roles));
    }

    public function testEraseCredentials(): void
    {
        // This method should not throw any exception
        $this->user->eraseCredentials();
        $this->assertTrue(true); // If we get here, no exception was thrown
    }
}