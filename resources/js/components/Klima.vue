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
            <div class="text-6xl font-semibold">8°C</div>
            <div class="">Feels like 2°C</div>
          </div>
          <div class="mx-5">
            <div class="font-semibold">Cloudy</div>
            <div>Toronto, Canada</div>
          </div>
        </div>
        <div>icon</div>
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
  methods: {
    fetchData() {
    fetch("https://cors-anywhere.herokuapp.com/https://api.weatherbit.io/v2.0/current?city=Raleigh,NC&key=b8cbb3b5938e4e88a590474f8f079560"
, {
	"method": "GET",
	"headers": {
		"x-rapidapi-host": "skyscanner-skyscanner-flight-search-v1.p.rapidapi.com",
		"x-rapidapi-key": "SIGN-UP-FOR-KEY"
	}
})
.then(response => {
	console.log(response);
})
.catch(err => {
	console.log(err);
});
    }
  }
};
</script>
