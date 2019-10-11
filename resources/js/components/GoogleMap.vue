<template> 
  <div>
    <!-- <div>
      <h2>Search and add a pin</h2>
      <label>
        <gmap-autocomplete
          @place_changed="setPlace">
        </gmap-autocomplete>
        <button @click="addMarker">Add</button>
      </label>
      <br/>

    </div>
    <br> -->
    <gmap-map
       ref="mapRef"
      :center="center"
      :zoom="15"
      style="width:100%;  height: 80vh;"
      @click="clicked"
    >
      <!-- <gmap-marker
        :key="index"
        v-for="(m, index) in markers"
        :position="m.position"
        :clickable="true"
        :draggable="true"
        @click="center=m.position"
      ></gmap-marker> -->
      <GmapMarker v-if="marker" :position="marker.latLng" />
    </gmap-map>
  </div>
</template>
<script>
export default {
  name: "GoogleMap",
  data() {
    return {
      // default to Montreal to keep it simple
      // change this to whatever makes sense
      center: { lat: 6.916285, lng: 122.086563 },
      // markers: [],
      // places: [],
      // currentPlace: null,
      marker: null
    };
  },

  mounted() {
    // this.geolocate();
    this.$refs.mapRef.$mapPromise.then((map) => {
      map.panTo({lat: 6.916285, lng: 122.086563})
    })
  },

  methods: {
    // receives a place object via the autocomplete component
    // setPlace(place) {
    //   this.currentPlace = place;
    // },
    // addMarker() {
    //   if (this.currentPlace) {
    //     const marker = {
    //       lat: this.currentPlace.geometry.location.lat(),
    //       lng: this.currentPlace.geometry.location.lng()
    //     };
    //     this.markers.push({ position: marker });
    //     this.places.push(this.currentPlace);
    //     this.center = marker;
    //     this.currentPlace = null;

    //     var infowindow = new google.maps.InfoWindow({
    //     content: 'Latitude: ' + location.lat() +
    //              '<br>Longitude: ' + location.lng()
    //     });
    //     infowindow.open(map,marker);
    //   }
    // },
    geolocate: function() {
      navigator.geolocation.getCurrentPosition(position => {
        this.center = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };
      });
    },
    clicked (e) {
        this.marker = {
          latLng: e.latLng
       }
       console.log(this.marker.latLng);
       
    }
  }
}
</script>