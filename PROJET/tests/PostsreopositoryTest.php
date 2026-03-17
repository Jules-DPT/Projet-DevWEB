<?php

namespace tests;

use App\php\Repositories\Postsrepository;
use PHPUnit\Framework\TestCase;

class PostsreopositoryTest extends TestCase
{
    private $postsrepo;

    public function setUp()
    {
        parent::setUp();
        $this->postsrepo= new PostsRepository();
    }
}