<?php

/**
 * Description of Account
 *
 * @author mafonso
 */
use RedBean_Facade as R;

class Account extends Block {
    
    /**
     * Account username
     * This should be an email to receive system emails
     * @var string
     */
    public $username;
    
    /**
     * Account password
     * @var string
     */
    public $password;
    
    /**
     * Person display name
     * @var string
     */
    public $displayname;
    
    public function __construct() {
        parent::__construct('register_form');
    }
    
    /**
     * Creates a new account
     * @param array $post
     * @return boolean
     */
    public function create($post) {
        
        // Validate create before continue
        $result = $this->validateCreate($post);
        if (!$result) return false;
        
        // Create account
        $account = R::dispense('account');
        $account->username = $post['username'];
        $account->displayname = $post['displayname'];
        $account->password = $post['password'];
        $this->importBean($account);
        
        // Encrypt password and save
        $passwd = BootWiki::encrypt($post['password']);
        $account->password = $passwd;
        R::store($account);
        
        // Send email to user
        $this->template_path = BootWiki::template('register_mail');
        $message = (string) $this;
        BootWiki::sendMail($post['username'], 'BootWiki - Register', $message);
        
        // Return success
        return true;
    }
    
    /**
     * Changes account password
     * @param array $post
     * @return boolean
     */
    public function changePassword($post) {
        
        // Validate create before continue
        $result = $this->validatePassword($post);
        if (!$result) return false;
        
        // Load account
        $username = BootWiki::getLoggedAccount()->username;
        $account = R::findOne('account', 'username = ?', array($username));
        $account->password = $post['password'];
        R::store($account);
        $this->importBean($account);
        // Encrypt password
        $passwd = BootWiki::encrypt($post['password']);
        $account->password = $passwd;
        R::store($account);
        
        // Send email to user
        $this->template_path = BootWiki::template('register_mail');
        $message = (string) $this;
        BootWiki::sendMail($username, 'BootWiki - New password', $message);
        
        // Return success
        BootWiki::setMessage('Password has changed!');
        return true;
    }
    
    /**
     * Validates data (or post) to create a new account
     * @param array $post
     * @return boolean
     */
    public function validateCreate($post) {
        // Check if username is in use
        $account = R::findOne('account', 'username = ?', array($post['username']));
        if (!empty($account)) {
            BootWiki::setMessage('Invalid username. Try another username');
            return false;
        }
        if (!$this->validatePassword($post)) return false;
        return true;
    }
    
    /**
     * Validates password
     * $post has $post['password'] and $post['password_confirm']
     * @param array $post
     * @return boolean
     */
    public function validatePassword($post) {
        
        // Validate password strength
        $score = BootWiki::checkPassword($post['password']);
        if ($score < 1) {
            BootWiki::setMessage('Invalid password. Password is '. 
                    BootWiki::getPasswordDescription($score));
            return false;
        }
        
        // Validate password match
        if ($post['password'] != $post['password_confirm']) {
            BootWiki::setMessage('Password was not confirmed');
            return false;
        }
        
        return true;
    }
    
}

?>