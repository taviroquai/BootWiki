<?php

/**
 * Description of DatabaseConnection
 *
 * @author mafonso
 */
class DatabaseConnection extends Requirement
{
    public $config;
    
    public function __construct($config)
    {
        $this->config = $config;
        $this->label   = 'Test Database connection';
        $this->hint    = 'Go back to <a href="installer.php?step=2">step 2</a> and correct configuration';
    }
    public function test()
    {
        $result = true;
        if ($this->config['dbdriver'] == 'sqlite') {
            $dsn = 'sqlite:'.$this->config['dbfile'];
        } else {
            $dsn = $this->config['dbdriver']
                    .':host='.$this->config['dbhost'].';'
                    .'dbname='.$this->config['dbname'];
        }
        try {
            $test = new PDO($dsn, $this->config['dbuser'], $this->config['dbpass']);
            $result = $result & true;
        } catch (\PDOException $e) {
            $result = $result & false;
        }
        return $result;
    }
}
