<?php

/**
 * Description of MinPhpVersion
 *
 * @author mafonso
 */
class MinPhpVersion extends Requirement
{
    public function __construct()
    {
        $this->label   = 'Minimum PHP version must be superior to 5.3.1';
        $this->hint    = 'Please upgrade PHP version';
    }
    public function test()
    {
        return (version_compare(PHP_VERSION, '5.3.1') >= 0);
    }
}