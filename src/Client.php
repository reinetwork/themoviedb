<?php namespace REINetwork\TheMovieDb;

/**
 * Class Client
 *
 * A PHP client for the TheMovieDb.org API.
 *
 * @package REINetwork\TheMovieDb
 * @see https://www.themoviedb.org/documentation/api
 */
class Client {

    /**
     * @var string
     */
    protected $token;

    /**
     * @param string|null $token
     */
    public function __construct($token = null)
    {
        $this->setToken($token);
    }

    /**
     * Set API secret token.
     *
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * Access API secret token.
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }
}
