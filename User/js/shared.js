 
// document.addEventListener("DOMContentLoaded", function() {
//   fetch('shared/header.html')
//       .then(response => response.text())
//       .then(data => {
//           document.getElementById('header-user').innerHTML = data;

//           // Set active class based on the current page
//           const path = window.location.pathname.split("/").pop();
//           const menuItems = document.querySelectorAll('.site-menu li');

//           menuItems.forEach(item => {
//               const link = item.querySelector('a');
//               const href = link.getAttribute('href').split("/").pop();

//               if (href === path) {
//                   item.classList.add('active');
//               } else {
//                   item.classList.remove('active');
//               }
//           });

           
//       })
//       .catch(error => {
//           console.error('Error loading the header:', error);
//           document.getElementById('header-user').innerHTML = 'Failed to load header.';
//       });
// });

// document.addEventListener("DOMContentLoaded", function() {
//   fetch('shared/footer.html')
//       .then(response => response.text())
//       .then(data => {
//           document.getElementById('footer-user').innerHTML = data; 
//       })
//       .catch(error => {
//           console.error('Error loading the footer-user:', error);
//           document.getElementById('footer-user').innerHTML = 'Failed to load header.';
//       });
// });
$(document).ready(function() {
    $('#dropdownMenuReference').click(function() {
        // Toggle arrow visibility whenever the dropdown icon is clicked
        $(this).find('.dropdown-arrow').toggleClass('hidden');
    });
});
