<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<!-- Typeahead.js Bundle -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>

<div>
    <form class="typeahead" role="search" method="GET" action="/">
        <div class="form-group">
            <label for="field">Field:</label>
            <select name="field" id = "field">
                <option value ="physician_first_name">Physician First Name</option>
                <option value ="physician_last_name">Physician Last Name</option>
                <option value ="total_amount_of_payment_usdollars">Amount</option>
                <option value ="recipient_city">City</option>
                <option value ="recipient_state">State</option>
            </select>
            <input type="search" name="q" class="form-control search-input" placeholder="Search" autocomplete="off">
            <button type= "submit">Submit</button>
        </div>
    </form>
</div>

<script>
        
        
        var searchField = $('#field').val();
        jQuery(document).ready(function($) {

            // Set the Options for "Bloodhound" suggestion engine
            var engine = new Bloodhound({
                remote: {
                    url: '/typeaheadSearch',
                    prepare : function(query, settings) {
                        settings.url += '?q=' + query;
                        settings.url += "&field=" + $('#field').val();
                        return settings;
                    }
                },
                datumTokenizer: Bloodhound.tokenizers.whitespace(),
                queryTokenizer: Bloodhound.tokenizers.whitespace
            });

            $(".search-input").typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            }, {
                source: engine.ttAdapter(),
                display: searchField, 

                templates: {
                    header: [
                        '<div class="list-group search-results-dropdown">'
                    ],
                    suggestion: function (data) {
                        let fieldName = $('#field').val()
                        let encodedResult = encodeURI(data[fieldName])
                        return '<a href=/?field=' + fieldName + '&q=' + encodedResult + ' class="list-group-item">' +  data[fieldName] + '</a>'
                    }
                }
            });
        });
</script>