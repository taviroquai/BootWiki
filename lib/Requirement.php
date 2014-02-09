<?php

/**
 * Description of Requirement
 *
 * @author mafonso
 */
abstract class Requirement
{
    public $label = '';
    public $result;
    public $hint;
    public abstract function test();
}