<x-warholshop-layout>
    <!-- resources/views/dalle.blade.php -->

    <div id="spinner" class="fixed z-50 -translate-x-1/2 top-8 left-1/2 animate-pulse" style="display:none;">
        <x-tmk.preloader class="text-white border shadow-2xl bg-lime-700/60 border-lime-700">
            Hold on, I need to blend these colors a bit more...
        </x-tmk.preloader>
    </div>


    <form id="dalle-form">
        <div class="row">
            <div class="col-md-12">
                <input type="text" style="width: 96%;" id="query" placeholder="Enter a query">
                <button id="form-btn" type="submit">Search</button>
                <div id="spinner" style="display: none;" class="spinner-border spinner-border-sm" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>


    </form>

    <div id="result" class="row text-center" style="margin-top: 1%"></div>

    <script>
        document.getElementById("dalle-form").addEventListener("submit", function(e) {
            e.preventDefault();

            document.getElementById("form-btn").style.display = 'none';
            document.getElementById("spinner").style.display = 'inline-block';

            var query = document.getElementById("query").value;
            axios.post('/dall-e-api/', {
                query: query
            })
                .then(function(response) {
                    //handle the response
                    if (response.data != 'Not found') {
                        var img = document.createElement("img");
                        img.src = response.data;
                        document.getElementById("result").appendChild(img);
                    } else {
                        var image_url = response.data;
                        var img = document.createElement("img");
                        img.src = '/404.webp';
                        document.getElementById("result").appendChild(img);
                    }

                })
                .catch(function(error) {
                    console.log(error);
                }).finally(function() {
                document.getElementById("form-btn").style.display = 'inline-block';
                document.getElementById("spinner").style.display = 'none';
            });
        });
    </script>
</x-warholshop-layout>
