<?php

/**
 * Description of DatabaseDriversExists
 *
 * @author mafonso
 */
class DatabaseDriversExists extends Requirement
{
    public function __construct()
    {
        $this->label   = 'SQLite or MySQL extension; Test connection';
        $this->hint    = 'alt-get install libsqlite3-0 php5-sqlite php5-mysql & /etc/init.d/apache restart';
    }
    public function test()
    {
        $result = extension_loaded('pdo_sqlite') | extension_loaded('pdo_mysql');
        return $result;
    }
}
