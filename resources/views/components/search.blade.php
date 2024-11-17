@push('css')
@endpush
<form id="searchForm" action="{{ route('search.destinations') }}">
    <i class="icon-pckt-search search-icon"></i>
    <input type="text" id="searchMain" name="q" placeholder="Kërkoni destinacionin"
        autocomplete="off" value="{{ request()->q }}">

    <ul id="searchResultMain" style="display: none">
    </ul>
</form>
@push('javascript')
<script>
    const contrysearchapi = "{{ route('api.countries.search') }}";

    $(document).ready(function() {
        $("#searchMain").keyup(function() {
            let query = $('#searchMain').val();
            if (query.length >= 3) {
                fetch(contrysearchapi + '?q=' + query) // API for the GET request
                    .then(response => response.json())
                    .then(data => populateSugesstion(data));
            } else {
                $('#searchResultMain').css('display', 'none');
                $('#searchResultMain').html('');
            }
        })
    })

    const populateSugesstion = countries => {
        $('#searchResultMain').html('');
        if (countries.length > 0) {
            $('#searchResultMain').css('display', 'flex');
            console.log(countries.length);
        } else {
            $('#searchResultMain').css('display', 'none');
        }
        countries.forEach(country => {
            $('#searchResultMain').append(
                `<li><a href="${country.link}"><img src="${country.flag}"> ${country.name}</a></li>`
            );
        });
    }
</script>
@endpush
