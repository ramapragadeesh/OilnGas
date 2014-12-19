<img src="http://www.abrasivesworld.com/ipad_pic.jpg">
<div id="demo">
</div>
<script>
var x = document.getElementById("demo");
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}
function showPosition(position) {
    x.innerHTML = "Latitude: " + position.coords.latitude + 
    "<br>Longitude: " + position.coords.longitude;

     $.ajax({
  url: 'http://abrasivesworld.com/ipad/info',
  type: 'POST',
  data: {searchForm : x.innerHTML },
  success: function(msg) {
  }
});
}

getLocation()


</script>