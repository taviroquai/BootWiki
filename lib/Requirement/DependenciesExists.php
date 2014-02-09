<?php

/**
 * Description of DependenciesExists
 *
 * @author mafonso
 */
class DependenciesExists extends Requirement
{
    public function __construct()
    {
        $this->label   = 'Dependencies installed';
        $this->hint    = 'Get <strong>composer.phar</strong> from <a target="_blank" href="http://getcomposer.org">getcomposer.org</a> and run on command line: <strong>php composer.phar update</strong>';
    }
    public function test()
    {
        return file_exists('./vendor/gabordemooij/redbean')
            & file_exists('./vendor/phpmailer/phpmailer')
            & file_exists('./vendor/slim/slim');
    }
}
