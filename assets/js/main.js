
        $(document).ready(function(){

            // Search method for the items in the table.
            $("#searchItemBox").on("keyup", function() {

                var value = $(this).val().toLowerCase();
                $("#adsTable tbody > tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });

            });

            // Loading spinner on ajax queries.
            $(document).ajaxStart(function() {
                $('#loading-spinner').show();
            }).ajaxStop(function() {
                $('#loading-spinner').hide();
            });

            // Reset pivot on every new search.
            $("#item_search_name").on("keyup", function() {
                $('#current_pivot').val("0,0,0");
                c = 1;
            });

            $("#ClearTableButton").click(function() { c = 1; table.clear().draw(); })

            $("#SearchButton").click(function(e) {
                $('#SearchButton').prop('disabled', true);

                if (!$('#request-form')[0].checkValidity())
                {
                    $("form")[0].reportValidity();
                    $('#SearchButton').prop('disabled', false);
                    return;
                }
                
                e.preventDefault();
                let startTime = performance.now();

                $.ajax({
                        type: "POST",
                        async: true,
                        url: "assets/functions/interface.php",
                        data: {
                            function: 'makeSearch',
                            item_search_name: document.getElementById("item_search_name").value,
                            items_category: $('#items_category').find('option:selected').attr('id'),

                            to_fetch: document.getElementById("item_search_count").value,

                            pivot: document.getElementById("current_pivot").value
                        },
                        success: function(result) {
                                
                            try {
                                
                                var time = performance.now() - startTime;
                                seconds = time / 1000;
                                var seconds = seconds.toFixed(3);

                                result = JSON.parse(result);
                                $('#current_pivot').val(result[result.length-1]['pivot']);
                                drew = populateAdsTable(result);
                                $('#SearchButton').prop('disabled', false);
                                
                                $('#status-text').text("Found " + drew + " matching ads in " + seconds + " seconds."); 

                            } catch (error) {

                                $('#status-text').text("Unable to process the request / Cannot fetch items");     
                                $('#SearchButton').prop('disabled', false);

                            }

                        },
                        error: function(result) {
                            console.log('Error: ' + result)
                        }

                    });

            });

            // Populate select
            $.ajax({
                type: "GET",
                url: "const/categories.json",
                success: function(result) {

                    let select = $('#items_category');

                    for (var j = 0; j < result.length; j++)
                    {

                        select.append(
                            `<optgroup id="opt-gr${j}" label="${result[j].label}"></optgroup>`
                            );

                        for (let i = 0; i < result[j]['subcategories'].length; i++) {
                            $('#opt-gr' + j).append(
                                `<option id="${result[j]['subcategories'][i].id}"> ${result[j]['subcategories'][i].label} </option>`
                            );
                        }

                    }




                },
                error: function(result) {
                    console.log('Error: ' + result)
                }
            });


            var table = $('#adsTable').DataTable({
               searching: false, 
               paging: false, 
               deferRender: true,
               info: false,
               fixedColumns: true,
               bAutoWidth: false,
               lengthChange: false,
               pageLength: 50,
               language: {
                emptyTable: "Make a search :)"
               },
               columns: [
                    { "width": "10%"},
                    { "width": "10%"},
                    { "width": "10%"},
                    { "width": "10%"},
                    { "width": "10%"},
                    { "width": "30%" },
                    { "width": "20%", "orderable": false }
                ]
            });

            
            function populateAdsTable(json)
            {
                drew = 0;
                only_shippable = isOnlyShippable();
                
                for (let i = 0; i < json.length; i++) {
                    
                    // All ads
                    if(json[i]['ads_alu'])
                    {
                        json[i]['ads'] = json[i]['ads'].concat(json[i]['ads_alu']);
                    }
                    
                    json[i]['ads'].forEach(ad => {

                        let info = [
                            drew+1,
                            "<a href='" + ad.url +  "'>"+ ad.list_id +"</a>",
                            ""+ad.subject,
                            ""+ad.price,
                            ""+ad.index_date.split(' ')[0],
                            ""+ad.body.substring(1,200) + "...",
                            "<img alt='Aucune image disponible.' src='" + ad.images.small_url + "'></img>"
                        ];

                        if (only_shippable && isShippable(ad))
                        {
                            table.row.add(info);
                        } else { 
                            table.row.add(info);
                        }
                        
                        drew++;
                        
                    });

                }
                
                //$('#status-text').text($('#status-text').text().replace('x', (c-(new_c-1))-1));
                table.draw();

                return drew;
            }

            function isShippable(ads)
            {

                if (ads['attributes'])
                {
                    for (var item in ads['attributes']) {
                        if (ads['attributes'][item]['key'] == 'shippable') { return true; }
                    }
                }

                return false;

            }
                
            function isOnlyShippable()
            {
                return $('#e_shop_check').checked;
            }



        });



