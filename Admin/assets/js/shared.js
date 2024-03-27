Promise.all([
    fetch('shared/sideNavBar.html').then(response => response.text()),
    fetch('shared/headerNavBar.html').then(response => response.text()),
    fetch('shared/footer.html').then(response => response.text()),
]).then(htmlContents => {
    document.getElementById('sidenavContainer').innerHTML = htmlContents[0];
    document.getElementById('headerNavBarContainer').innerHTML = htmlContents[1];
    document.getElementById('footerContainer').innerHTML = htmlContents[2];

    // Once all components are loaded, append the main.js script
    var script = document.createElement('script');
    script.src = "assets/js/main.js";
    document.body.appendChild(script);
   
        // Get all nav links
        var navLinks = document.querySelectorAll('.sidebar-nav .nav-link');
      
        // Get current page URL without the base URL
        var currentUrl = window.location.pathname.split('/').pop();
      
        // Iterate over each nav link to find the active one
        navLinks.forEach(function(link) {
          // Get the href attribute of the nav link and compare it with the current URL
          if (link.getAttribute('href') === currentUrl) {
            // Add 'active' class to the nav link that matches the current URL
            link.classList.remove('collapsed');
          } else {
            // Optional: Remove 'active' class if it's not the current page
            link.classList.add('collapsed');
          }
        }); 
}).catch(error => {
    console.error('Error loading components:', error);
});