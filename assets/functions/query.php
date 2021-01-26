<?php 
 
    /*
    * Leboncoin query parameters
    */


    class Query{

        public $limit_alu = 2; //int
        public $limit = 20; //int
        public $owner_type = "all"; //String
        public $pivot = "0,0,0"; //String
        public $sort_by = "time"; //String
        public $sort_order = "desc"; //String

        public $filters; //Filters

    }

    class Category
    {
        public $id; //String
    }
    
    class Enums
    {
        public $ad_type = ["offer"]; //array(Object)
        public $urgent = []; //array(Object)
    } 
    
    class Keywords
    {
        public $text; //String
        public $type; //String
    }  
    
    class Area
    {
        public $lat = 0; //double
        public $lng = 0; //double
        public $radius = 0; //int
    }
        
    class Location
    {
        public $area; //Area
        public $city_zipcodes; //array(Object)
        public $departments; //array(Object)
        public $shippable; // bool
        public $disable_region = true; //boolean
        public $location; //Location
        public $regions; //array(Object)
    }
    
    class Owner
    {
        public $no_salesmen = false;


    }
    
    class Ranges
    {



    }
    
    class Filters
    {
        public $category; //Category
        public $enums; //Enums
        public $keywords; //Keywords
        public $location; //Location
        public $owner; //Owner
        public $ranges; //Ranges
        
    }
        
?>