<?php 

use Fortec\GithubTrending;
use PHPUnit\Framework\TestCase;

class GithubTrendingTest extends TestCase
{
    
    public function testGetArrayResult()
    {
        $github = new GithubTrending();
        $result = $github->getTrending();

        // The result is not empty
        $this->assertNotTrue(empty($result));

        // The result is an array
        $this->assertTrue(is_array($result));
    }
}
