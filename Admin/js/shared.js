fetch('pages/sideNavBar.html')
    .then(response => response.text())
    .then(html => {
        document.getElementById('sidenavContainer').innerHTML = html; 
        var currentUrl = window.location.pathname.slice(1);
        var navLinks = document.querySelectorAll('.nav-page');
        navLinks.forEach(function(link) {
            var linkHref = link.getAttribute('href'); 
            if (linkHref === currentUrl) { 
                link.classList.add('active');
                console.log("Match found! Added 'active' class.");
            }
        });
    })
    .catch(error => console.error('Error loading side navigation bar:', error));

    fetch('pages/headerNavBar.html')
    .then(response => response.text())
    .then(html => {
        document.getElementById('headerNavBarContainer').innerHTML = html; 

        (function ($) {
            "use strict";
        
            // Spinner
            var spinner = function () {
                setTimeout(function () {
                    if ($('#spinner').length > 0) {
                        $('#spinner').removeClass('show');
                    }
                }, 1);
            };
            spinner();
            
            
            // Back to top button
            $(window).scroll(function () {
                if ($(this).scrollTop() > 300) {
                    $('.back-to-top').fadeIn('slow');
                } else {
                    $('.back-to-top').fadeOut('slow');
                }
            });
            $('.back-to-top').click(function () {
                $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
                return false;
            });
        
        
            // Sidebar Toggler
            $('.sidebar-toggler').click(function () {
                $('.sidebar, .content').toggleClass("open");
                return false;
            });
        
         
        })(jQuery);
        
        
        var feedbacksElement = document.getElementById('feedbacks'); 
        feedbacksElement.addEventListener('click', function(event) {
            // Prevent the default behavior of the link
            event.preventDefault();
    
            // Change the URL to the desired page
            window.location.href = 'feedbacks.html';
           $('.sidebar, .content').toggleClass("open");
        });
        // var alertsElement = document.getElementById('alerts'); 
        // alertsElement.addEventListener('click', function(event) {
        //     // Prevent the default behavior of the link
        //     event.preventDefault();
    
        //     // Change the URL to the desired page
        //     window.location.href = 'alerts.html';
        //    $('.sidebar, .content').toggleClass("open");
        // });
       
    })
    .catch(error => console.error('Error loading side headerNavBar  bar:', error));


    fetch('pages/footer.html')
    .then(response => response.text())
    .then(html => {
        document.getElementById('footerContainer').innerHTML = html; 
        
    })
    .catch(error => console.error('Error loading  footer :', error));

 