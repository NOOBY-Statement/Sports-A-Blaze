
//hover

let list = document.querySelectorAll(".navigation li")

function activeLink(){
    list.forEach((item) => {
        item.classList.remove("hovered");

    });

    this.classList.add("hovered");

}
list.forEach(item => item.addEventListener("mouseover", activeLink));


// Menu Toggle

let toggle = document.querySelector(".toggle");
let navigation = document.querySelector(".navigation");
let main = document.querySelector(".main");

toggle.onclick = function() {
    navigation.classList.toggle("active");
    main.classList.toggle("active");
};


function toggleSidebar() {
    document.querySelector('.navigation').classList.toggle('active');
    document.querySelector('.header').classList.toggle('active');
    document.querySelector('.main').classList.toggle('active');

    
}

function showPanel(panelId) {
    // Hide all panels
    const panels = document.querySelectorAll('.panel');
    panels.forEach(panel => {
        panel.classList.remove('active');
    });

    // Show the selected panel
    const activePanel = document.getElementById(panelId);
    if (activePanel) {
        activePanel.classList.add('active');
    }
}

function toggleSidebar() {
    const container = document.querySelector('.container');
    container.classList.toggle('active');
}

//button for court and equipment
  
document.addEventListener('DOMContentLoaded', function() {
  // Existing code for popup handling

  // Scroll to specific sections when buttons are clicked
  document.getElementById('courtButton').addEventListener('click', function() {
      document.getElementById('courtSection').scrollIntoView({ behavior: 'smooth' });
  });

  document.getElementById('equipmentButton').addEventListener('click', function() {
      document.querySelector('.gallery').scrollIntoView({ behavior: 'smooth' });
  });
});
  


// POP UP RESERVATION FORM

document.addEventListener('DOMContentLoaded', function() {
    // Select all reserve buttons and add click event listeners
    document.addEventListener('DOMContentLoaded', function () {
      const reserveButtons = document.querySelectorAll('.reserve-btn');
  s
      reserveButtons.forEach(button => {
          button.addEventListener('click', function () {
              const sportType = this.getAttribute('data-sport-type');
              document.getElementById('sportType').value = sportType;
              document.getElementById('disabledSportType').value = this.parentNode.querySelector('h5').innerText;
              
              // Show the reservation popup
              document.getElementById('reservationPopup').style.display = 'block';
          });
      });

  
        // Show the popup
        document.getElementById('reservationPopup').style.display = 'block';
  
        // Autofill user information if available
        document.getElementById('name').value = ''; // Replace with actual user name
        document.getElementById('contactNumber').value = ''; // Replace with actual user contact number
        document.getElementById('address').value = ''; // Replace with actual user address
        document.getElementById('email').value = '';
      });
    });
  
    // Close the popup when the close button (×) is clicked
    document.querySelector('.close').addEventListener('click', function() {
      document.getElementById('reservationPopup').style.display = 'none';
    });
  
    // Optional: Close the popup if the user clicks outside of it
    window.onclick = function(event) {
      if (event.target == document.getElementById('reservationPopup')) {
        document.getElementById('reservationPopup').style.display = 'none';
      }
    };




// sports type
function setSportType(sport) {
  switch (sport) {
      case 'Basketball':
          document.getElementById('sportTypeBasketball').value = sport;
          break;
      case 'Badminton':
          document.getElementById('sportTypeBadminton').value = sport;
          break;
      case 'Volleyball':
          document.getElementById('sportTypeVolleyball').value = sport;
          break;
      default:
          break;
  }
}
