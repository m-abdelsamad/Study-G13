@extends('layouts.master')
@section('body')
<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center mt-4">
            <h1 class="">Find nearby Libraries</h1>
        </div>

        <div class=" row text-center mt-3">
            <h3><button class='btn btn-dark shadow' >
                <a class="" onclick="locatorButtonPressed()" style="color: white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-arrow-up-right-circle-fill" viewBox="0 0 16 16">
                        <path
                            d="M0 8a8 8 0 1 0 16 0A8 8 0 0 0 0 8zm5.904 2.803a.5.5 0 1 1-.707-.707L9.293 6H6.525a.5.5 0 1 1 0-1H10.5a.5.5 0 0 1 .5.5v3.975a.5.5 0 0 1-1 0V6.707l-4.096 4.096z" />
                    </svg>
                    Click here to search for libraries near you
                </a>
            </button>
            </h3>
        </div>
    </div>
</div>
<div id="container" class='container'>
    
    <div id="map" class="mb-5"></div>
    <div id="sidebar" class='text-center'>
        <div id='map-result'>
            <h2 class="mt-3 mb-3">Results</h2>
            
        </div>


        <ul id="places"></ul>
        <button id="more" >Load more results</button>
    </div>
</div>


<script>
    
    var lat = "51.24248284045735";
    var lng = "-0.5819955829087929";
    function initMap() {
        // Create the map.
        var pyrmont = new google.maps.LatLng(lat, lng);
        var map = new google.maps.Map(document.getElementById("map"), {
            center: pyrmont,
            zoom: 16,
            mapId: "8d193001f940fde3",
        });
        request = {
            location: pyrmont,
            rankBy: google.maps.places.RankBy.DISTANCE,
            type: "library"
        }
        const image = "https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png";
        const beachMarker = new google.maps.Marker({
            position: pyrmont,
            map,
            icon: image,
        });
        // Create the places service.
        const service = new google.maps.places.PlacesService(map);
        let getNextPage;
        const moreButton = document.getElementById("more");
        moreButton.onclick = function() {
            moreButton.disabled = true;
            if (getNextPage) {
                getNextPage();
            }
        };
        // Perform a nearby search.
        service.nearbySearch(request,
            (results, status, pagination) => {
                if (status !== "OK" || !results) return;
                addPlaces(results, map);
                moreButton.disabled = !pagination || !pagination.hasNextPage;
                if (pagination && pagination.hasNextPage) {
                    getNextPage = () => {
                        // Note: nextPage will call the same handler function as the initial call
                        pagination.nextPage();
                    };
                }
            }
        );
    }
    function addPlaces(places, map) {
        const placesList = document.getElementById("places");
        placesList.innerHTML = "";
        const infowindow = new google.maps.InfoWindow();
        for (const place of places) {
            if (place.geometry && place.geometry.location) {
                const image = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25),
                };
                const marker = new google.maps.Marker({
                    map,
                    title: place.name,
                    position: place.geometry.location,
                });
                google.maps.event.addListener(marker, "click", () => {
                    const content = document.createElement("div");
                    const nameElement = document.createElement("h2");
                    nameElement.textContent = place.name;
                    content.appendChild(nameElement);
                    const placeIdElement = document.createElement("p");
                    placeIdElement.textContent = place.open;
                    content.appendChild(placeIdElement);
                    const placeAddressElement = document.createElement("p");
                    placeAddressElement.textContent = place.formatted_address;
                    content.appendChild(placeAddressElement);
                    infowindow.setContent(content);
                    infowindow.open(map, marker);
                });
                const li = document.createElement("li");
                const ul_r = document.createElement("ul");
                const hr = document.createElement("hr");
                li.textContent = place.name;
                placesList.appendChild(li);
                placesList.appendChild(ul_r);
                placesList.appendChild(hr)
                li.addEventListener("click", () => {
                    map.setCenter(place.geometry.location);
                    const content = document.createElement("div");
                    const nameElement = document.createElement("h2");
                    nameElement.textContent = place.name;
                    content.appendChild(nameElement);
                    // const placeIdElement = document.createElement("p");
                    // placeIdElement.textContent = place.place_id;
                    // content.appendChild(placeIdElement);
                    // const placeAddressElement = document.createElement("p");
                    // placeAddressElement.textContent = place.formatted_address;
                    // content.appendChild(placeAddressElement);
                    infowindow.setContent(content);
                    infowindow.open(map, marker);
                });
            }
        }
    }
    function locatorButtonPressed() {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                this.lat = position.coords.latitude;
                this.lng = position.coords.longitude;
                initMap()
                console.log(this.lat + ',' + this.lng)
            },
            (error) => {
                console.log("Error getting location");
            }
        );
    }
</script>
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDnrcsMxMRiXxSTbPEyKSDvfjyHu7Lwyrg&callback=initMap&libraries=places&v=weekly"
    async></script>
@endsection