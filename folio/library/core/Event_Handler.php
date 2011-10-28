<?php
class LAIKA_Event_Handler extends Laika implements SplSubject{

//-------------------------------------------------------------------
//	PROPERTIES
//-------------------------------------------------------------------
 
    /**
    * Array of SplObserver objects
    *
    * @var array
    */
    private $observers = array();


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
    * The Exception Handler calls notify() and outputs
    * a notice onscreen if DEVELOPMENT_ENVIRONMENT is set
    *
    * @return void
    */
    public function handle(){
        $this->notify();
    }
}