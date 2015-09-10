# HHVM pdo_mysql \PDOException::$errorInfo test case

This repository is a simple test case to demonstrate the HHVM issue discussed in https://github.com/facebook/hhvm/issues/4003

## Installation

1. Clone this repository.
2. Execute `composer install` from within the cloned repository directory.
3. Adjust the credentials in `phpunit.xml.dist` to be able to connect to a running MySQL database.

## Running the test case

```
$ cd /path/to/repo
$ phpunit
```
