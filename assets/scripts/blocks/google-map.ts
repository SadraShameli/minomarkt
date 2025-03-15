declare global {
    interface Window {
        initGoogleMap: () => void;
    }
}

function initGoogleMap() {
    const mapContainers = document.querySelectorAll('.js-google-map');

    for (const mapContainer of mapContainers) {
        const htmlMapContainer = mapContainer as HTMLElement;

        const mapId = htmlMapContainer.dataset.mapId;
        const placeId = htmlMapContainer.dataset.placeId;
        const latitude = parseFloat(htmlMapContainer.dataset.latitude || '0');
        const longitude = parseFloat(htmlMapContainer.dataset.longitude || '0');
        const zoom = parseInt(htmlMapContainer.dataset.zoom || '10');

        const mapOptions: google.maps.MapOptions = {
            mapId: mapId,
            center: { lat: latitude, lng: longitude },
            zoom: zoom,
            disableDefaultUI: true,
            zoomControl: true,
        };

        const map = new google.maps.Map(htmlMapContainer, mapOptions);

        const placesService = new google.maps.places.PlacesService(map);
        placesService.getDetails(
            {
                placeId: placeId || '',
                fields: ['name', 'geometry', 'formatted_address'],
            },
            (
                place: google.maps.places.PlaceResult | null,
                status: google.maps.places.PlacesServiceStatus,
            ) => {
                if (
                    status === google.maps.places.PlacesServiceStatus.OK &&
                    place &&
                    place.geometry &&
                    place.geometry.location
                ) {
                    map.setCenter(place.geometry.location);

                    new google.maps.marker.AdvancedMarkerElement({
                        position: place.geometry.location,
                        map: map,
                        title: place.name,
                    });
                } else {
                    new google.maps.marker.AdvancedMarkerElement({
                        position: { lat: latitude, lng: longitude },
                        map: map,
                    });
                }
            },
        );
    }
}

function initGoogleMaps() {
    const mapContainers = document.querySelectorAll('.js-google-map');

    for (const mapContainer of mapContainers) {
        const htmlMapContainer = mapContainer as HTMLElement;

        if (
            !htmlMapContainer.dataset.apiKey ||
            !htmlMapContainer.dataset.mapId ||
            !htmlMapContainer.dataset.placeId ||
            !htmlMapContainer.dataset.latitude ||
            !htmlMapContainer.dataset.longitude ||
            !htmlMapContainer.dataset.zoom
        ) {
            return;
        }

        const queryParams = new URLSearchParams({
            key: htmlMapContainer.dataset.apiKey,
            callback: 'initGoogleMap',
            libraries: 'places,marker',
            loading: 'async',
        });

        const script = document.createElement('script');
        script.src = `https://maps.googleapis.com/maps/api/js?${queryParams.toString()}`;
        script.async = true;
        script.defer = true;

        window.initGoogleMap = initGoogleMap;
        document.body.appendChild(script);
    }
}

document.addEventListener('DOMContentLoaded', function () {
    initGoogleMaps();
});
