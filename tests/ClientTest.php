<?php

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    /**
     * @var REINetwork\TheMovieDb\Client
     */
    public $client;

    /**
     * Create instance of the system under test.
     */
    public function setUp()
    {
        parent::setUp();

        $this->client = new REINetwork\TheMovieDb\Client();
    }

    /**
     * Verify `setToken(string $token)` sets API token.
     */
    public function testTokenSetter()
    {
        $token = 'a-test-string';

        $this->client->setToken($token);

        $this->assertEquals(
            $token,
            Assert::readAttribute($this->client, 'token'),
            'API access token is set'
        );
    }

    /**
     * Verify `getToken()` returns the currently set API token.
     */
    public function testTokenGetter()
    {
        $token = 'a-test-string';

        $this->client->setToken($token);

        $this->assertEquals($token, $this->client->getToken(), 'API Access token returned');
    }
}
