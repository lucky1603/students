<?php
namespace Studenti\Model;

use Zend\ServiceManager\ServiceManager;

class Dashboard 
{
    public $subjectSummaries;
    
    private $serviceManager;
    
    public function __construct(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        $this->initSummaries();
    }
    
    private function initSummaries()
    {
        
    }
}