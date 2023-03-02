<?php

class DependencyInjection
{
    protected $instances = array();
    
    public function __construct()
    {
        // Register dependencies here
        $this->instances['my_dependency'] = new MyDependency();
    }
    
    public function __get($key)
    {
        if (isset($this->instances[$key])) {
            return $this->instances[$key];
        }
        
        return null;
    }
}

?>