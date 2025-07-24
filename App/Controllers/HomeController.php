<?php

namespace App\Controllers;


class HomeController
{


    public function __construct() {}

    /*
   * Show the latest listings
   * 
   * @return void
   */
    public function index()
    {

        loadView('home');
    }
}
