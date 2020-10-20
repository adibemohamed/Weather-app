<template>
  <div class="text-white pb-0  w-128">
    <h1 class="text-white font-black py-2  text-6xl w-full text-center">
      Fresh Weather
    </h1>
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
      class="weather-container shadow-2xl rounded  font-sans w-128 max-w-lg overflow-hidden bg-gray-900 shadow-lg mt-4"
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
          <i
            :class="
              `wi wi-owm-${currentTemperature.dayOrNight}-${currentTemperature.icon}`
            "
          ></i>
        </div>
      </div>
      <!-- end current wwather -->

      <div class="future-weather text-sm  px-6 pt-0 pb-8  overflow-hidden">
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
      apiKey: "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx",
      container: document.querySelector("#address")
    });

    // get the location
    var $address = document.querySelector("#address-value");
    placesAutocomplete.on("change", e => {
      $address.textContent = e.suggestion.value;
      this.location.name = `${e.suggestion.name}, ${e.suggestion.country}`;
      this.location.lat = e.suggestion.latlng.lat;
      this.location.lng = e.suggestion.latlng.lng;
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
        icon: "",
        ts: null,
        sunset_ts: null,
        sunrise_ts: null,
        dayOrNight: ""
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
          this.currentTemperature.icon = data.data[0].weather.code;
          this.currentTemperature.sunset_ts = data.data[0].sunset_ts;
          this.currentTemperature.sunrise_ts = data.data[0].sunrise_ts;
          this.currentTemperature.ts = data.data[0].ts;
          this.daily = data.data;
          this.currentTemperature.dayOrNight = this.dayOrNight(
            this.currentTemperature.sunrise_ts,
            this.currentTemperature.sunset_ts,
            this.currentTemperature.ts,
            this.currentTemperature.actual
          );
          console.log(data.data[0]);
          console.log(this.currentTemperature.dayOrNight);
        })
        .catch(err => {
          console.log(err);
        });
    },
    toDayOfWeek(timestamp) {
      const newDate = new Date(timestamp * 1000);
      const days = ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"];
      return days[newDate.getDay()];
    },
    dayOrNight(sunrise_ts, sunset_ts, ts, actual) {
      var sunrise = [
        new Date(sunrise_ts).getHours(),
        new Date(sunrise_ts).getMinutes()
      ];
      var sunset = [
        new Date(sunset_ts).getHours(),
        new Date(sunset_ts).getMinutes()
      ];

      var sunrise_m = sunrise[0] * 60 + sunrise[1];
      var sunset_m = sunset[0] * 60 + sunset[1];

      var now = new Date(ts);
      var now_m = now.getHours() * 60 + now.getMinutes();

      if (now_m > sunset_m - 60 && now_m <= sunset_m + 60) {
        return "night";
      } else if (now_m > sunrise_m - 60 && now_m <= sunrise_m + 60) {
        return "day";
      } else if (now_m > sunrise_m + 60 && now_m <= sunset_m - 60) {
        return "day";
      } else {
        return "night";
      }
    }
  }
};
</script>
