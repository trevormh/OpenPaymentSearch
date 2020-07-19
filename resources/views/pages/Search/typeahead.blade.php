<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<!-- Typeahead.js Bundle -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>

<div>
    <form class="typeahead" role="search">
        <div class="form-group">
            <label for="search_params">Field:</label>
            <select name="search_params" id = "search_param">
                <option value ="physician_first_name">Physician First Name</option>
                <option value ="physician_last_name">Physician Last Name</option>
                <option value ="total_amount_of_payment_usdollars">Amount</option>
            </select>
            <input type="search" name="q" class="form-control search-input" placeholder="Search" autocomplete="off">
        </div>
    </form>
</div>

<script>
        jQuery(document).ready(function($) {

            var searchparam = document.getElementById("search_param").value;

            // Set the Options for "Bloodhound" suggestion engine
            var engine = new Bloodhound({
                remote: {
                    url: '/search?field=' + searchparam + '&q=%QUERY%',
                    wildcard: '%QUERY%'
                },
                datumTokenizer: Bloodhound.tokenizers.whitespace('q'),
                queryTokenizer: Bloodhound.tokenizers.whitespace
            });

            $(".search-input").typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            }, {
                source: engine.ttAdapter(),

                // This will be appended to "tt-dataset-" to form the class name of the suggestion menu.
                name: 'usersList',

                // the key from the array we want to display (name,id,email,etc...)
                templates: {
                    empty: [
                        '<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>'
                    ],
                    header: [
                        '<div class="list-group search-results-dropdown">'
                    ],
                    suggestion: function (data) {
                        console.log(data);
                        return '<a href=/"' + data[searchparam] + '" class="list-group-item">' +  data[searchparam] + '</a>'
              }
                }
            });
        });
</script>