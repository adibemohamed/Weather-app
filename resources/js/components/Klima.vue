<template>
  <div class="text-white pb-0">
    <div class="place-input">
      <input type="text" class="w-full" />
    </div>
    <div
      class="weather-container font-sans w-128 max-w-lg overflow-hidden bg-gray-900 shadow-lg mt-4"
    >
      <div class="current-weather flex items-center justify-between px-6 py-8">
        <div class="flex items-center">
          <div>
            <div class="text-6xl font-semibold">{{ currentTemperature.actual }}°C</div>
            <div class="">Feels like {{ currentTemperature.feels }}°C</div>
          </div>
          <div class="mx-5">
            <div class="font-semibold">{{ currentTemperature.summary }}</div>
            <div>{{ location.name }}</div>
          </div>
        </div>
        <div>
          <canvas ref="iconCurrent" id="iconCurrent" width="96" height="96"></canvas>
        </div>
      </div>
      <!-- end current wwather -->

      <div
        class="future-weather text-sm bg-gray-800 px-6 py-8  overflow-hidden"
      >
        <div class="flex items-center mt-8">
          <div class="w-1/6 text-lg text-gray-200">MON</div>
          <div class="w-4/6 py-4 flex items-center">
            <div class="">icon</div>
            <div class="ml-3">Cloudy with chance of showers</div>
          </div>
          <div class="w-1/6 text-right">
            <div>5°C</div>
            <div>-2°C</div>
          </div>
        </div>
        <div class="flex items-center mt-8">
          <div class="w-1/6 text-lg text-gray-200">MON</div>
          <div class="w-4/6 py-4 flex items-center">
            <div class="">icon</div>
            <div class="ml-3">Cloudy with chance of showers</div>
          </div>
          <div class="w-1/6 text-right">
            <div>5°C</div>
            <div>-2°C</div>
          </div>
        </div>
        <div class="flex items-center mt-8">
          <div class="w-1/6 text-lg text-gray-200">MON</div>
          <div class="w-4/6 py-4 flex items-center">
            <div class="">icon</div>
            <div class="ml-3">Cloudy with chance of showers</div>
          </div>
          <div class="w-1/6 text-right">
            <div>5°C</div>
            <div>-2°C</div>
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
    this.fetchData();
  },
  data: () => {
    return {
      currentTemperature: {
        actual: '',
        feels: '',
        summary: '',
        icon: ''
      },
      location: {
        name: 'Toronto, Canada',
        lat: 35.775,
        lng: -78.638
      }
    };
  },
  methods: {
    fetchData() {

       var skycons = new Skycons({'color': 'white'});

       fetch(`/api/weather?lat=${this.location.lat}&lng=${this.location.lng}`)
        .then(res => res.json())
        .then(data => { 
          this.currentTemperature.actual = data.data[0].temp;
          this.currentTemperature.feels = data.data[0].temp;
          this.currentTemperature.summary = data.data[0].weather.description;
          this.currentTemperature.icon = data.data[0].weather.icon;
          console.log(data.data);
           skycons.add("iconCurrent", 'partly-cloudy-day');
        })
        .catch(err => {
          console.log(err);
        })
    }
  }
};
</script>
