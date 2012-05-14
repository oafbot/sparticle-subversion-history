<?php
/**
 * LAIKA_Mail class.
 * 
 * @extends Laika
 */
class LAIKA_Mail extends Laika{

/*
    private $sender;
    private $recipient;
    private $subject;
    private $message;
*/

    /**
     * sendmail function.
     * 
     * @access public
     * @static
     * @param mixed  $users
     * @param string $subject
     * @param string $message
     * @param array  $head
     * @return void
     */
    public static function sendmail($users,$subject,$message,$head){
        $recipient = self::set_recipients($users);
        $headers = self::set_headers($head);                
        mail($recipient, $subject, $message ,$headers);
    }
    
    /**
     * set_headers function.
     * 
     * @access public
     * @static
     * @param array $array
     * @return void
     */
    public static function set_headers($array){
        $headers='';
        foreach($array as $key => $value){
            switch($key){
                case 'SENDER':
                    $headers .= "From: $value\n";
                    break;
                case 'CC':
                    $headers .= "Cc: $value\n";
                    break;
                case 'BCC':
                    $headers .= "Bcc: $bcc\n";
                    break;
                case 'FORMAT':
                    $headers .= "Content-type: text/$value; charset=utf-8\n";
                    $headers .= "MIME-Version: 1.0\n";
                    $headers .="Content-Transfer-Encoding: 8bit\n";
                    break;
                case 'MIME':
                    $headers .= "MIME-Version: $value\n"; //1.0
                    break;
                case 'ENCODING':
                    $headers .="Content-Transfer-Encoding: $value\n"; //8bit charset=ISO-8859-1
                    break;       
            }
        }
        return $headers;
    }
    
    /**
     * set_recipients function.
     * 
     * @access public
     * @static
     * @param mixed $users
     * @return void
     */
    public static function set_recipients($users){
        if(is_array($users))
            foreach($users as $key => $user):
                if($key>0)
                    $recepient .= ',';
                $recipient .= $user->firstname().' '.$user->lastname().'<'.$user->email().'>';
            endforeach;
        else
            $recipient = $users->firstname().' '.$users->lastname().'<'.$users->email().'>';
        
        return $recipient;               
    }
    
    /**
     * load_template function.
     * 
     * @access public
     * @static
     * @param string $template
     * @param array  $params
     * @return void
     */
    public static function load_template($template,$params){
        foreach($params as $key => $value)
            $$key = $value;
        include_once($template);
        
        return $content;        
    }
}