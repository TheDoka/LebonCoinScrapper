<?php

/*
* Interface file, we only have one function here, but it acts like a bridge and checks whether or not the action requested is possible.
*/

include 'scrapper.php';

if (isset($_POST['function']))
{

    switch(true)
    {
        case isset($_POST['function']) && $_POST['function'] == 'makeSearch': 
          makeSearch();
        break;

    }

}


/*
* Return: JSON response of the requested query.
*/

function makeSearch()
{
      
      $requestedQuery = new LebonCoinSearch($_POST);

      $askedFor = intval($_POST['to_fetch']);
      $max_items = 0;
      $retrieved_items = 0;
      
      $fetched = array();
      if ($askedFor >= 100)
      {
        $i = 0;

        do {
          
          $askPerQuery = $askedFor - $retrieved_items;
          if ($askPerQuery > 100)
          {
            $askPerQuery = 100;
          }

          $requestedQuery->setMaxResultsPerQuery($askPerQuery);  

          $response = $requestedQuery->fetchResult();

          $requestedQuery->setPivot($response['pivot']);

          $max_items = $response['total'];

          $retrieved_items += 100; // Always 100 :D
  
          $fetched[$i] = $response;
  
          $i++;
        } while ($retrieved_items < $askedFor && $askedFor < $max_items);
        
      } else {
        $fetched[0] = $requestedQuery->fetchResult();
      }

      echo json_encode($fetched);

}


?>