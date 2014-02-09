<?php

/**
 * Description of FolderWriteable
 *
 * @author mafonso
 */
class FolderWriteable extends Requirement
{
    public $path;
    public function __construct($path, $hint = '')
    {
        $this->path = $path;
        $user = trim(shell_exec('whoami'));
        
        $this->label   = 'File (or folder) '.$this->path.' exists and is writeable for user '.$user;
        $this->hint    = 'mkdir '.$this->path.' & sudo chmod -R 777 '.$this->path;
        if (!empty($hint)) $this->hint = $hint;
    }
    public function test()
    {
        return is_writable(realpath($this->path));
    }
}