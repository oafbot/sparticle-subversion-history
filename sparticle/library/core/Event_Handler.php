<?php
class LAIKA_Event_Handler extends LAIKA_Singleton implements SplSubject{

//-------------------------------------------------------------------
//	PROPERTIES
//-------------------------------------------------------------------
    protected static $instance; 
    /**
    * Array of SplObserver objects
    *
    * @var array
    */
    private $observers = array();
    protected $event;
    protected $param;

//-------------------------------------------------------------------
//	METHODS
//-------------------------------------------------------------------
    
    /**
    * Attaches an SplObserver object to the handler
    *
    * @param SplObserver
    * @return void
    */
    public function attach(SplObserver $observer){
        $id = spl_object_hash($observer);
        $this->observers[$id] = $observer;
    }
    /**
    * Detaches the SplObserver object from the handler
    *
    * @param SplObserver
    * @return void
    */
    public function detach(SplObserver $observer){
        $id = spl_object_hash($observer);
        unset($this->observers[$id]);
    }

    /**
    * Notify all observers
    *
    * @return void
    */
    public function notify(){
        foreach($this->observers as $observer){
            $observer->update($this);
        }
    }

    /**
    * The Event Handler calls notify() and broadcasts
    * state to all the listners.
    *
    * @return void
    */
    public function handle($event,$param){
        $this->event = $event;
        $this->param = $param;
        $this->notify();
    }
}