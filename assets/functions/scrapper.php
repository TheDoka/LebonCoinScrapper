<?php

    require "query.php";

    class LebonCoinSearch{

        private $API_URL = "https://api.leboncoin.fr/api/adfinder/v1/search";
        private $Query;
        private $token;

        public function __construct($queryArgs, $token = null)
        {
            $this->Query = $this->createQuery($queryArgs);
            $this->token = $token;
        }


        // Change max result for the query
        public function setMaxResultsPerQuery($limit)
        {
          $this->Query->limit = $limit;
        }


        /*
        * Return: a query with the user's given parameters.
        */
        function createQuery($args)
        {
          $Category = new Category();
          if (isset($args['items_category']))
          {
            $Category->id = $args['items_category'];
          }
      
          $Area = new Area();
            $Area->lat = 0;
            $Area->lng = 0;
            $Area->radius = 0;
        
          $Location = new Location();
            $Location->area = $Area;
            $Location->city_zipcodes = array();
            $Location->departments = array();
            $Location->shippable = true;
            $Location->disable_region = false;
            $Location->location = array();
            $Location->regions = array();
        
          $Enums = new Enums();
            $Enums->ad_type = []; //"offer"
            //$Enums->urgent = ["0"];
        
          $Keyword = new Keywords();
            $Keyword->text = $args['item_search_name'];
            $Keyword->type = "subject";
        
          $Filters = new Filters();
            $Filters->category = $Category;
            $Filters->enums = $Enums;
            $Filters->keywords = $Keyword;
            $Filters->location = $Location;
            $Filters->owner = new Owner();
            $Filters->ranges = new Ranges();
        
          $Query = new Query();
            $Query->limit_alu = 0;//intval($args['item_search_limit_alu']);
            $Query->limit = intval($args['to_fetch']);
            $Query->owner_type = 'all';
            $Query->sort_by = 'time';
            $Query->sort_order = 'desc';
            $Query->filters = $Filters;
            $Query->pivot = $args['pivot'];

          return $Query;
            
        }

        // Change pivot of the query.
        public function setPivot($pivot)
        {

          $this->Query->pivot = $pivot;

        }

        // Return: the output of query
        public function fetchResult()
        {

            $context = stream_context_create(array(
              'http' => array(
                  'method' => 'POST',
                  'header' => "User-Agent: LBC;Android;9;Redmi Note 5;phone;cc5e04b8db948c86;wifi;4.21.3.0;61300;1\r\n".
                              "Content-Type: application/json\r\n".
                              "Host: api.leboncoin.fr\r\n".
                              "Connection: Keep-Alive\r\n".
                              (((isset($this->token)) ?  "Authorization: " . $this->token : "api_key: ba0c2dad52b3ec\r\n")),

                  'content' => json_encode($this->Query),
                  'timeout' => 2
              )
            ));
            
            
            //Send the request
            $response = file_get_contents($this->API_URL, FALSE, $context);
            $responseData = json_decode($response, TRUE);
            return $responseData;

        }


    }

    // Get the user token
    function getToken($user, $pass)
    {

      $context = stream_context_create(array(
        'http' => array(
            'method' => 'POST',
            'header' => "User-Agent: LBC;Android;9;Redmi Note 5;phone;cc5e04b8db948c86;wifi;4.21.3.0;61300;1\n" . 
                        "Content-Type: application/x-www-form-urlencoded",
            'content' => "grant_type=password&client_id=android&client_secret=goova3nejaif3ueChe5uhaedeteezae6&username=$user&password=$pass"
        )
      ));

      $response = file_get_contents("https://api.leboncoin.fr/api/oauth/v1/token", FALSE, $context);
      $responseData = json_decode($response, TRUE);

      return $responseData['access_token'];

    }

    function CreateSampleQuery()
    {
      $Area = new Area();
        $Area->lat = 0;
        $Area->lng = 0;
        $Area->radius = 0;

      $Location = new Location();
        $Location->area = $Area;
        $Location->city_zipcodes = array();
        $Location->departments = array();
        $Location->disable_region = true;
        $Location->location = array();
        $Location->regions = array();

      $Enums = new Enums();
        $Enums->ad_type = ["offer"];
        $Enums->urgent = ["1"];

      $Keyword = new Keywords();
        $Keyword->text = "a";
        $Keyword->type = "subject";

      $Filters = new Filters();
        $Filters->category = new Category();
        $Filters->enums = $Enums;
        $Filters->keywords = $Keyword;
        $Filters->location = $Location;
        $Filters->owner = new Owner();
        $Filters->ranges = new Ranges();

      $Query = new Query();
        $Query->limit_alu = 21;
        $Query->limit = 20;
        $Query->owner_type = 'all';
        $Query->pivot = '0,0,0';
        $Query->sort_by = 'time';
        $Query->sort_order = 'desc';
        $Query->filters = $Filters;

        return $Query;
    }
      
?>