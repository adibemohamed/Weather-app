<template>
  <div class="text-white pb-0 shadow-2xl w-128">
    <div class="place-input">
      <input
        type="search"
        id="address"
        class="form-control text-blue-900 rounded w-128"
        placeholder="Choose a city..."
       
      />
      <p>Selected: <strong id="address-value">none</strong></p>
    </div>
    <div
      class="weather-container rounded  font-sans w-128 max-w-lg overflow-hidden bg-gray-900 shadow-lg mt-4"
    style="background: #6e44ff;"
    >
      <div class="current-weather flex items-center justify-between px-6 py-8">
        <div class="flex items-center">
          <div>
            <div class="text-6xl font-semibold">
              {{ currentTemperature.actual }}°C
            </div>
            <div class="">Feels like {{ currentTemperature.feels }}°C</div>
          </div>
          <div class="mx-5">
            <div class="font-semibold">{{ currentTemperature.summary }}</div>
            <div>{{ location.name }}</div>
          </div>
        </div>
        <div class="text-6xl">
          <i class="wi wi-owm-night-202"></i>
        </div>
      </div>
      <!-- end current wwather -->

      <div
        class="future-weather text-sm  px-6 pt-0 pb-8  overflow-hidden"
      >
        <div
          v-for="(day, index) in daily"
          :key="day.time"
          class="flex items-center mt-8 border-t"
          :class="{ 'mt-8': index > 0 }"
          v-if="index < 5"
        >
          <div class="w-1/6 text-lg text-gray-200">
            {{ toDayOfWeek(day.ts) }}
          </div>
          <div class="w-4/6 py-4 flex items-center">
            <div class="">
               <div class="text-2xl">
                <i :class="`wi wi-owm-night-${day.weather.code}`"></i>
              </div>
            </div>
            <div class="ml-3">{{ day.weather.description }}</div>
          </div>
          <div class="w-1/6 text-right">
            <div>{{ Math.round(day.high_temp) }}°C</div>
            <div>{{ Math.round(day.low_temp) }}°C</div>
          </div>
        </div>
      </div>
      <!-- end future weather -->
    </div>
    <!-- end app container -->
  </div>
</template>

<script>
export default {
  mounted() {
    // get weather data
    this.fetchData();

    var placesAutocomplete = places({
      appId: "plXPYTW07XSN",
      apiKey: "235e8ffff339e06e22dacd3e304f47e8",
      container: document.querySelector("#address")
    });

    // get the location
    var $address = document.querySelector("#address-value");
    placesAutocomplete.on("change", (e) => {
      $address.textContent = e.suggestion.value; 
      this.location.name = `${e.suggestion.name}, ${e.suggestion.country}`;
      this.location.lat = e.suggestion.latlng.lat;
      this.location.lng = e.suggestion.latlng.lng;
      console.log(e)
    });

    placesAutocomplete.on("clear", function() {
      $address.textContent = "none";
    });
  },
  watch: {
    location: {
      handler(newValue, oldValue) {
        this.fetchData();
      },
      deep: true
    }
  },
  data: () => {
    return {
      currentTemperature: {
        actual: "",
        feels: "",
        summary: "",
        icon: ""
      },
      location: {
        name: "Rabat, Morocco",
        lat: 34.0224,
        lng: -6.83454
      },
      daily: []
    };
  },
  methods: {
    fetchData() {
      var skycons = new Skycons({ color: "white" });

      fetch(`/api/weather?lat=${this.location.lat}&lng=${this.location.lng}`)
        .then(res => res.json())
        .then(data => {
          this.currentTemperature.actual = data.data[0].temp;
          this.currentTemperature.feels = data.data[0].temp;
          this.currentTemperature.summary = data.data[0].weather.description;
          this.currentTemperature.icon = data.data[0].weather.icon;

          data.data.map(day => {
            this.daily.push(day); 
          });
            
         
        })
        .catch(err => {
          console.log(err);
        });
    },
      
    toDayOfWeek(timestamp) {
      const newDate = new Date(timestamp * 1000);
      const days = ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"];

      return days[newDate.getDay()];
    }
  }
};
</script>
