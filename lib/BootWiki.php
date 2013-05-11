<?php

/**
 * Description of BootWiki
 * This is the Static class that functions as a singleton of the application
 * It also has some helpers that cannot fit in elsewhere
 *
 * @author mafonso
 */
use RedBean_Facade as R;

class BootWiki {
    
    /**
     * List of password strength descriptions
     * @var array
     */
    public static $pw_description = 
            array("Blank","Weak","Medium","Strong","Very Strong");
    
    /**
     * Initializes application
     */
    public static function init() {
        // Start store
        session_start();
        // start database
        if (DBUSER) R::setup(DBDSN, DBUSER, DBPASS);
        else R::setup(DBDSN, DBUSER, DBPASS);
        // start language
        if (self::getIdiom() == null) self::setIdiom (IDIOM);
        setlocale(LC_ALL, self::getIdiom().'.UTF8');
    }
    
    /**
     * Checks if there are messages to return to user interaction
     * @return boolean
     */
    public static function hasMessage() {
        $msg = self::getMessage();
        return !empty($msg);
    }
    
    /**
     * Setup a message to be returned to user
     * @param string $message
     */
    public static function setMessage($message) {
        self::save('_message', $message);
    }
    
    /**
     * Clears any message that may be already shown to user
     */
    public static function clearMessage() {
        self::save('_message', null);
    }
    
    /**
     * Returns a message
     * @return string
     */
    public static function getMessage() {
        return self::load('_message');
    }
    
    /**
     * Setup an idiom to used by templates, messages and UI
     * @param string $idiom
     */
    public static function setIdiom($idiom) {
        self::save('_idiom', $idiom);
    }
    
    /**
     * Returns a string representation of an idiom. ie. pt, en, fr, etc...
     * @return string
     */
    public static function getIdiom() {
        return self::load('_idiom');
    }
    
    /**
     * Setup an account that is logged
     * @param Account $account
     */
    public static function setLoggedAccount($account) {
        self::save('_account', $account);
    }
    
    /**
     * Returns the logged account
     * @return Account
     */
    public static function getLoggedAccount() {
        return self::load('_account');
    }
    
    /**
     * Starts a session for an account
     * @param string $username
     * @param string $password
     * @return boolean
     */
    public static function login($username, $password) {
        $passwd = self::encrypt($password);
        $result = R::findOne('account', 'username = ? and password = ?', 
                array($username, $passwd));
        if (!empty($result)) {
            $account = new Account();
            $account->importBean($result);
            $account->password = null;
            self::setLoggedAccount($account);
            return true;
        }
        
        self::setMessage('Invalid username or password');
        return false;
    }
    
    /**
     * Logs a user out
     * Destroy user session
     */
    public static function logout() {
        session_destroy();
    }
    
    /**
     * Save a value. This class acts as a registry pattern.
     * @param string $key
     * @param mixed $value
     */
    public static function save($key, $value) {
        $_SESSION[$key] = $value;
    }
    
    /**
     * Returns a value saved onto the registry
     * @param string $key
     * @return mixed
     */
    public static function load($key) {
        return empty($_SESSION[$key]) ? null : $_SESSION[$key];
    }
    
    /**
     * Returns the full path by the given named template
     * @param string $name
     * @param string $idiom
     * @param string $ext
     * @return string
     */
    public static function template($name, $idiom = null, $ext = '.php') {
        $idiom = empty($idiom) ? self::getIdiom() : $idiom;
        return TEMPLATEPATH.'/'.$idiom.'/'.$name.$ext;
    }
    
    /**
     * Wiki install procedure
     * NOTE: after install, you should disable the route in the Slim application
     */
    public static function install() {
        
        R::nuke(); // WARNING: THIS WILL DELETE YOUR DATA!!!
    
        $account = R::dispense('account');
        $account->username = 'admin';
        $account->password = sha1('admin');
        $account->displayname = 'Admin';
        R::store ($account);

        // English content
        $idiom_en = R::dispense('idiom');
        $idiom_en->code = 'en';
        $idiom_en->name = 'English';
        $idiom_en->flag_image = 'web/img/flags/United_Kingdom.png';
        R::store ($idiom_en);

        $content = new Content('Welcome to Wiki!');
        $content->idiom = new Idiom($idiom_en->code);
        $content->featured = 1;
        $content->author = $account->username;
        $bean = R::dispense('content');
        R::store($content->exportToBean($bean));

        $content = new Content('Wiki Features');
        $content->idiom = new Idiom($idiom_en->code);
        $content->featured = 1;
        $content->author = $account->username;
        $bean = R::dispense('content');
        R::store($content->exportToBean($bean));

        $content = new Content('How To Install');
        $content->idiom = new Idiom($idiom_en->code);
        $content->featured = 1;
        $content->author = $account->username;
        $bean = R::dispense('content');
        R::store($content->exportToBean($bean));

        $content = new Content('Documentation');
        $content->idiom = new Idiom($idiom_en->code);
        $content->featured = 1;
        $content->author = $account->username;
        $bean = R::dispense('content');
        R::store($content->exportToBean($bean));

        // Portuguese content
        $idiom_pt = R::dispense('idiom');
        $idiom_pt->code = 'pt';
        $idiom_pt->name = 'Português';
        $idiom_pt->flag_image = 'web/img/flags/Portugal.png';
        R::store ($idiom_pt);

        $content = new Content('Bem-vindo à Wiki!');
        $content->idiom = new Idiom($idiom_pt->code);
        $content->featured = 1;
        $content->author = $account->username;
        $bean = R::dispense('content');
        R::store($content->exportToBean($bean));

        $content = new Content('Funcionalidades');
        $content->idiom = new Idiom($idiom_pt->code);
        $content->featured = 1;
        $content->author = $account->username;
        $bean = R::dispense('content');
        R::store($content->exportToBean($bean));

        $content = new Content('Como instalar');
        $content->idiom = new Idiom($idiom_pt->code);
        $content->featured = 1;
        $content->author = $account->username;
        $bean = R::dispense('content');
        R::store($content->exportToBean($bean));

        $content = new Content('Documentação');
        $content->idiom = new Idiom($idiom_pt->code);
        $content->featured = 1;
        $content->author = $account->username;
        $bean = R::dispense('content');
        R::store($content->exportToBean($bean));
    }
    
    /**
     * Send mail. Currently it uses PHPMailer library
     * 
     * @param string $to
     * @param string $subject
     * @param string $message
     * @return boolean
     */
    public static function sendMail($to, $subject, $message) {
        
        $mail = new PHPMailer;

        if (EMAIL_SMTP) {
            $mail->IsSMTP();
            $mail->SMTPDebug  = 2;
        }
        $mail->Host = EMAIL_HOST;
        if (EMAIL_SMTP_SSL) $mail->SMTPSecure = EMAIL_SMTP_SSL;
        if (EMAIL_SMTP_AUTH) {
            $mail->SMTPAuth = true;
            $mail->Username = EMAIL_AUTH_USER;
            $mail->Password = EMAIL_AUTH_PASS;
        }
        
        $mail->From = EMAIL_FROM;
        $mail->FromName = 'BootWiki - Support';
        $mail->AddAddress($to);
        $mail->AddReplyTo(EMAIL_FROM, 'BootWiki - Support');
        if (EMAIL_CC) $mail->AddCC(EMAIL_CC);
        if (EMAIL_BCC) $mail->AddBCC(EMAIL_BCC);
        
        $mail->WordWrap = 50;
        $mail->IsHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        // Run and debug
        try {
            $mail->Debugoutput = 'echo';
            ob_start();
            $result = $mail->Send();
            $log = ob_get_clean();
            if (EMAIL_DEBUG_FILEPATH) file_put_contents(EMAIL_DEBUG_FILEPATH, $log);

            // Check result and inform user
            if(!$result) {
               self::setMessage('Message could not be sent. Error: ' . $mail->ErrorInfo);
               return false;
            }
        }
        catch (Exception $e) {
            self::setMessage('An error came up when sending email. Error: ' . $e->getMessage());
            return false;
        }
        return true;
    }
    
    /**
     * Returns an encrypted string
     * Usefull for encrypting passwords
     * TODO: add a more secure encryption method
     * 
     * @param string $str
     * @return string
     */
    public static function encrypt($str) {
        return sha1($str);
    }
    
    /**
     * Helper to check password strengthness
     * @param string $pwd
     * @return int
     */
    public static function checkPassword($pwd) {
        $score = 0;
        if (strlen($pwd) < 1) {
            return $score;
        }
        if (strlen($pwd) < 6) {
            return $score;
        }
        if (strlen($pwd) >= 6) {
            $score++;
        }
        if (preg_match("/[a-z]/", $pwd) && preg_match("/[A-Z]/", $pwd)) {
            $score++;
        }
        if (preg_match("/[0-9]/", $pwd)) {
            $score++;
        }
        if (preg_match("/.[!,@,#,$,%,^,&,*,?,_,~,-,£,(,)]/", $pwd)) {
            $score++;
        }
        return $score;
    }
    
    /**
     * Return a string representation of a password strengthness
     * @param int $score
     * @return string
     */
    public static function getPasswordDescription($score) {
        return self::$pw_description[$score];
    }
    
}

?>
