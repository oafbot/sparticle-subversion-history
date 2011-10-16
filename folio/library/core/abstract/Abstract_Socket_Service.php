<?php
abstract class LAIKA_Abstract_Socket_Service extends LAIKA_Singleton{

    abstract function connect($ocket);
    abstract function disconnect();

}