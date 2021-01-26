    <html>    


    <head>
        <title>LebonCoinScrapper</title>
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script>
        <script src="assets/js/main.js"></script>
       
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="assets/css/main.css">
        
        <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/3.3.0/css/fixedColumns.dataTables.min.css">
        <link rel="shortcut icon" type="image/png" href="ressources/favicon.png"/>
    
    </head>

    <body>


        <div class="container">
            <h2>LeBoncoin Scrapper</h2>
            <p>What are you searching for:</p>

            <div id='searchBox'>
                <form id="request-form" class="form-inline mr-auto">
                    <input id="item_search_name" class="form-control mr-sm-2" type="text" placeholder="livre, lampe" aria-label="Search">

                    <select class="form-control selectpicker mr-sm-2" id="items_category">
                        <option>Tout</option selected>
                    </select>

                    <input id="item_search_count" class="form-control mr-sm-2" type="number" min="1"placeholder="Nombre à afficher" aria-label="Search" value="1" required>
                    <!-- <input id="search_max_pages" class="form-control mr-sm-2" type="number" placeholder="Pages" aria-label="Search" value="1" min="1" max="100">  -->
                    <input id="current_pivot" class="form-control mr-sm-2" type="text" placeholder="0,0,0" aria-label="Search" disabled>
                    <input type="checkbox" class="form-check-input" id="e_shop_check">E-shop</input>
                </form>

                <span id="status-text"></span>

                <div id='actionsBox'>
                    <button id="SearchButton" type="button" class="btn btn-outline-primary waves-effect">
                        <span id="loading-spinner" style="display: none;" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                        Search
                    </button>
                    <button id="ClearTableButton" type="button" class="btn btn-outline-primary waves-effect">Clear</button> 

                </div>
            </div>

        </div>

            <div class="container-fluid">

                <h2>LebonCoin Scrapper</h2>
                <p>Search by description: </p>  
                <input class="form-control" id="searchItemBox" type="text" placeholder="Search..">

                <table style="word-break:break-all;" id="adsTable" class="table table-bordered table-striped table-dark">
                    
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>ID</th>
                            <th>Titre</th>
                            <th>Prix</th>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Images</th>
                        </tr>
                    </thead>

                    <tbody></tbody>

                </table>

            </div>
    </body>

    <footer class="page-footer font-small blue">
              
        <img id='lookingAtGirl'src="ressources/looking.svg" alt="Kiwi standing on oval">   

    </footer>

</html>