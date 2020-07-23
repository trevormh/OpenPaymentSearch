<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<!-- Typeahead.js Bundle -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>

<div>
    <form class="typeahead" role="search" method="GET" action="/">
        <div class="form-group">
            <input type="search" name="q" class="form-control search-input" placeholder="Search" autocomplete="off">
            <button type= "submit">Submit</button>
        </div>
    </form>
</div>

<script>
        jQuery(document).ready(function($) {

            // Set the Options for "Bloodhound" suggestion engine
            var engine = new Bloodhound({
                remote: {
                    url: '/typeaheadSearch',
                    prepare : function(query, settings) {
                        settings.url += '?q=' + query;
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
                display: true, 

                templates: {
                    header: [
                        '<div class="list-group search-results-dropdown">'
                    ],
                    suggestion: function (response) {
                        let field =response.field
                        let value = encodeURI(response.value)
                        return '<a href=/?field=' + field + '&q=' +  value + ' class="list-group-item">' +  value + '</a>'
                    }
                }
            });
        });
</script>