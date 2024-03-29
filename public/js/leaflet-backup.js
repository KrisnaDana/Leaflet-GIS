let mode = "view";
let marker = [];

// Initialize Map
const map = L.map("map").setView([-8.7945, 115.1769], 14); // [y, x], z)
const tiles = L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
    maxZoom: 18,
    attribution:
        '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
}).addTo(map);

// Initialize marker cluster
// let markerClusters = L.markerClusterGroup().addTo(map);
let markerClusters = L.markerClusterGroup(); //c

const mapIcon = L.icon({
    iconUrl: "images/hotel.png",
    iconSize: [50, 50],
    iconAnchor: [25, 25], // x/2, y-1
});

hotels.forEach(function (hotel, index) {
    marker.push(
        // new L.Marker([hotel.lat, hotel.lng], {
        //     icon: mapIcon,
        //     draggable: false,
        // }).addTo(map)
        new L.Marker([hotel.lat, hotel.lng], {
            icon: mapIcon,
            draggable: true,
        }) //c
    );
    // markerClusters.addLayer(L.layerGroup(marker));
    markerClusters.addLayer(L.layerGroup(marker)); //c
});

map.addLayer(markerClusters); //c

if (user) {
    // Initialize view mode
    const viewButton = L.easyButton({
        states: [
            {
                onClick: function (map) {
                    mode = "view";
                    marker.forEach(function (m, index) {
                        //m.dragging.disable();
                        m.options.draggable = false;
                    });
                },
                icon: "fa-solid fa-eye fa-lg",
            },
        ],
    }).addTo(map);

    // Initialize hotel mode
    const hotelButton = L.easyButton({
        states: [
            {
                onClick: function (map) {
                    mode = "hotel";
                    marker.forEach(function (m, index) {
                        //m.dragging.enable();
                        //m.options.draggable = true;
                    });
                },
                icon: "fa-solid fa-building fa-lg",
            },
        ],
    }).addTo(map);
}

// Listener for Map when Clicked
map.on("click", function (e) {
    if (mode === "hotel") {
        document.getElementById("create_hotel_button").click();
        document.getElementById("create_hotel_lat").value = e.latlng.lat;
        document.getElementById("create_hotel_lng").value = e.latlng.lng;
    }
});

// Add Listeners to Marker
marker.forEach(function (m, index) {
    // m.on("click", function (e) {
    //     document.getElementById(`hotel_button_${hotels[index].id}`).click();
    // });
    m.on("drag", function (e) {
        //
    });
    m.on("dragend", function (e) {
        document.getElementById(
            `edit_hotel_location_lat_${hotels[index].id}`
        ).value = e.target.getLatLng().lat;
        document.getElementById(
            `edit_hotel_location_lng_${hotels[index].id}`
        ).value = e.target.getLatLng().lng;
        document
            .getElementById(`edit_hotel_location_button_${hotels[index].id}`)
            .click();
    });
});

//OLD
// marker.forEach(function (m, index) {
//     m.on("click", function (e) {
//         document.getElementById(`hotel_button_${hotels[index].id}`).click();
//         if (mode === "hotel") {
//             document.getElementById(`hotel_button_${hotels[index].id}`).click();
//             var popup = L.popup(e.latlng, {
//                 content: `
//                 <p>Hotel: ${hotels[index].name}
//                 <br />
//                 Address: ${hotels[index].address}
//                 <br />
//                 Phone: ${hotels[index].phone}
//                 <br />
//                 Number of rooms: ${hotels[index].room}
//                 <br />
//                 Star: ${hotels[index].star}
//                 <br />
//                 Lat: ${hotels[index].lat}
//                 <br />
//                 Lng: ${hotels[index].lng}
//                 <br />
//                 Description: ${hotels[index].description}
//                 <br />
//                 <div class="d-flex flex-row-reverse">
//                 <button class="btn btn-success btn-sm" onclick="updateModal(${index})">Edit</button>
//                 <button class="btn btn-danger btn-sm me-2 text-white" onclick="deleteHotel(${hotels[index].id})">Delete</button>
//                 </div>
//                 </p>`,
//             }).openOn(map);
//         } else if (mode === "view") {
//             var popup = L.popup(e.latlng, {
//                 content: `
//                 <p>Hotel: ${hotels[index].name}
//                 <br />
//                 Address: ${hotels[index].address}
//                 <br />
//                 Phone: ${hotels[index].phone}
//                 <br />
//                 Number of rooms: ${hotels[index].room}
//                 <br />
//                 Star: ${hotels[index].star}
//                 <br />
//                 Lat: ${hotels[index].lat}
//                 <br />
//                 Lng: ${hotels[index].lng}
//                 <br />
//                 Description: ${hotels[index].description}
//                 </p>`,
//             }).openOn(map);
//         }
//     });
//     m.on("drag", function (e) {
//         if (mode === "hotel") {
//             var popup = L.popup(e.latlng, {
//                 content: `
//                 <p>Hotel: ${hotels[index].name}
//                 <br />
//                 Address: ${hotels[index].address}
//                 <br />
//                 Phone: ${hotels[index].phone}
//                 <br />
//                 Number of rooms: ${hotels[index].room}
//                 <br />
//                 Star: ${hotels[index].star}
//                 <br />
//                 Lat: ${hotels[index].lat}
//                 <br />
//                 Lng: ${hotels[index].lng}
//                 <br />
//                 Description: ${hotels[index].description}
//                 </p>`,
//             }).openOn(map);
//         }
//     });
//     m.on("dragend", function (e) {
//         if (mode === "hotel") {
//             fetch(`${api_url}/hotel/${hotels[index].id}`, {
//                 headers: {
//                     Accept: "application/json",
//                     "Content-Type": "application/json",
//                 },
//                 method: "PATCH",
//                 body: JSON.stringify({
//                     update_hotel_lat: e.target.getLatLng().lat,
//                     update_hotel_lng: e.target.getLatLng().lng,
//                 }),
//             })
//                 .then((response) => response.json())
//                 .then((data) => {
//                     if (data[0] == 200) {
//                         location.reload();
//                     } else {
//                         alert(data.message);
//                     }
//                 });
//         }
//     });
// });

// // Show Update Hotel Modal
// const updateModal = (index) => {
//     document.getElementById("updateButtonModal").click();
//     document.getElementById("update_hotel_id").value = hotels[index].id;
//     document.getElementById("update_hotel_name").value = hotels[index].name;
//     document.getElementById("update_hotel_address").value =
//         hotels[index].address;
//     document.getElementById("update_hotel_phone").value = hotels[index].phone;
//     document.getElementById("update_hotel_room").value = hotels[index].room;
//     document.getElementById("update_hotel_star").value = hotels[index].star;
//     document.getElementById("update_hotel_description").value =
//         hotels[index].description;
// };

// // Delete Hotel Submit
// const deleteHotel = (index) => {
//     fetch(`${api_url}/hotel/${index}`, {
//         headers: {
//             Accept: "application/json",
//             "Content-Type": "application/json",
//         },
//         method: "DELETE",
//     })
//         .then((response) => response.json())
//         .then((data) => {
//             if (data[0] == 200) {
//                 location.reload();
//             } else {
//                 alert(data.message);
//             }
//         });
// };

// // Submit Create Hotel
// document
//     .getElementById("create_hotel_submit")
//     .addEventListener("click", function () {
//         fetch(`${api_url}/hotel`, {
//             headers: {
//                 Accept: "application/json",
//                 "Content-Type": "application/json",
//             },
//             method: "POST",
//             body: JSON.stringify({
//                 create_hotel_name:
//                     document.getElementById("create_hotel_name").value,
//                 create_hotel_address: document.getElementById(
//                     "create_hotel_address"
//                 ).value,
//                 create_hotel_phone:
//                     document.getElementById("create_hotel_phone").value,
//                 create_hotel_room:
//                     document.getElementById("create_hotel_room").value,
//                 create_hotel_star:
//                     document.getElementById("create_hotel_star").value,
//                 create_hotel_description: document.getElementById(
//                     "create_hotel_description"
//                 ).value,
//                 create_hotel_lat:
//                     document.getElementById("create_hotel_lat").value,
//                 create_hotel_lng:
//                     document.getElementById("create_hotel_lng").value,
//             }),
//         })
//             .then((response) => response.json())
//             .then((data) => {
//                 if (data[0] == 200) {
//                     location.reload();
//                 } else {
//                     alert(data.message);
//                 }
//             });
//     });

// // Submit Update Hotel
// document
//     .getElementById("update_hotel_submit")
//     .addEventListener("click", function () {
//         let hotel_id = document.getElementById("update_hotel_id").value;
//         fetch(`${api_url}/hotel/${hotel_id}`, {
//             headers: {
//                 Accept: "application/json",
//                 "Content-Type": "application/json",
//             },
//             method: "PATCH",
//             body: JSON.stringify({
//                 update_hotel_name:
//                     document.getElementById("update_hotel_name").value,
//                 update_hotel_address: document.getElementById(
//                     "update_hotel_address"
//                 ).value,
//                 update_hotel_phone:
//                     document.getElementById("update_hotel_phone").value,
//                 update_hotel_room:
//                     document.getElementById("update_hotel_room").value,
//                 update_hotel_star:
//                     document.getElementById("update_hotel_star").value,
//                 update_hotel_description: document.getElementById(
//                     "update_hotel_description"
//                 ).value,
//             }),
//         })
//             .then((response) => response.json())
//             .then((data) => {
//                 if (data[0] == 200) {
//                     location.reload();
//                 } else {
//                     alert(data.message);
//                 }
//             });
//     });
