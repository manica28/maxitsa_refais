<?php

namespace App\Core\Abstract ;

use App\Core\Session;
use App\Core\App;

abstract class AbstractControlleur  extends Session
{
    protected string $layout = 'base';
    private static AbstractControlleur|null $instance = null;
    protected Session $session ;
  

    public function __construct()
    {
      $this->session = App::getDependencies('Session');
    }
    public static function getInstance()
    {
      if (self::$instance === null)
      {
        self::$instance = new static();
      }
      return self::$instance ;
    }


    

    abstract public function show();
    abstract public function edit ();
    abstract public function store ();
    abstract public function create ();
    abstract public function index ();

    public function  renderHtml ( string $views,array $data=[] )
    {
        extract($data);
        ob_start();
        require_once '../templates/'. $views ;

        $contentForLayout = ob_get_clean();

        require_once '../templates/layout/'. $this->layout . '.layout.php' ;

    }
}