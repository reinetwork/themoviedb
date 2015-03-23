# themoviedb

A pair programming exercise skeleton.

## Installation

**Clone repository locally**

To access and modify the code you will to clone the repository to your local workstation.

```shell
git clone https://github.com/reinetwork/themoviedb.git
```

**Install dependencies with composer**

External dependencies (including PHPUnit) are managed by composer. Use the included `composer.phar` to download and install the necessray tools:

```bash
php composer.phar install
```

## Brief Overview

**Client**

The library contains the verify beginings of a PHP client for [TheMovieDb's API](https://www.themoviedb.org/documentation/api) in `src/Client.php`.

**Test**

The beginings of a PHPUnit test can be found in `tests/ClientTest.php`.

## Example requests

*Note: in the examples below the `[token]` parameter must be replaced by an actual API token that will be provided to you during the exercise.*

**Search**

The following HTTP GET request will search for movies by the name "gravity":

http://api.themoviedb.org/3/search/movie?api_key=[token]&query=gravity

**Details**

The following HTTP GET request will retrieve the movie details for Gravity:

http://api.themoviedb.org/3/movie/49047?api_key=[token]


