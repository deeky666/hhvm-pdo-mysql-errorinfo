<?php

namespace HHVM\Tests;

class PdoExceptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PDO
     */
    private $pdo;

    protected function setUp()
    {
        parent::setUp();

        $host = $GLOBALS['db_host'];
        $port = $GLOBALS['db_port'];
        $user = $GLOBALS['db_username'];
        $password = $GLOBALS['db_password'];

        $this->pdo = new \PDO(sprintf('mysql:host=%s;port=%d;', $host, $port), $user, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec('CREATE DATABASE hhvm_errorinfo_test');

        $this->pdo = new \PDO(sprintf('mysql:host=%s;port=%d;dbname=hhvm_errorinfo_test', $host, $port), $user, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    protected function tearDown()
    {
        $this->pdo->exec('DROP DATABASE hhvm_errorinfo_test');
    }

    /**
     * @expectedException \PDOException
     * @expectedExceptionCode 42S02
     * @expectedExceptionMessage Table 'hhvm_errorinfo_test.unknown_table' doesn't exist
     */
    public function testErrorInfo()
    {
        try {
            $this->pdo->exec('SELECT * FROM unknown_table');
        } catch (\PDOException $exception) {
            $this->assertSame(
                array('42S02', 1146, "Table 'hhvm_errorinfo_test.unknown_table' doesn't exist"),
                $exception->errorInfo
            );

            throw $exception;
        }
    }
}
