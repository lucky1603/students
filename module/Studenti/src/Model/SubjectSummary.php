<?php

namespace Studenti\Controller;

use Zend\ServiceManager\ServiceManager;

class SubjectSummary 
{
    public $subject;
    public $passedCol1;
    public $passedCol2;
    public $passedWritten;
    public $passedSpoken;
        
    private $serviceManager;
    
    public function __construct(ServiceManager $serviceManager, $subject)
    {
        $this->serviceManager = $serviceManager;
        $this->subject = $subject;
    }
    
    private function initData()
    {
        
    }
    
    
}