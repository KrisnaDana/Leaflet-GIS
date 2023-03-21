let marker;
let mode = "view";

const map = L.map("map").setView([-8.7945, 115.1769], 16); // [y, x], z)
const tiles = L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
  maxZoom: 19,
  attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
}).addTo(map);

const mapIcon = L.icon({
  iconUrl: "images/hotel.png",
  iconSize: [50, 50],
  iconAnchor: [25, 25], // x/2, y-1
});

const viewButton = L.easyButton({
  states: [
    {
      onClick: function (map) {
        mode = "view";
      },
      icon: "fa-solid fa-eye fa-lg",
    },
  ],
}).addTo(map);

const hotelButton = L.easyButton({
  states: [
    {
      onClick: function (map) {
        mode = "hotel";
      },
      icon: "fa-solid fa-building fa-lg",
    },
  ],
}).addTo(map);

map.on("click", function (e) {
  // if (marker) {
  //   map.removeLayer(marker);
  // }
  //history(e.latlng);

  if (mode === "hotel") {
    document.getElementById("buttonModal").click();
    marker = new L.Marker(e.latlng, { icon: mapIcon }).addTo(map);
  } else if (mode === "view") {
    var popup = L.popup(e.latlng, {
      content: `<p>Hello world!${e.latlng}<br />This is a nice popup.</p>`,
    }).openOn(map);
  } else {
  }
});
