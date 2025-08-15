(function() {
    'use strict';
    
    console.log('Portfolio loaded successfully!');
    
    // Simple smooth scrolling
    document.querySelectorAll('a[href^="#"]').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
    
    // Add some interactive effects
    document.querySelectorAll('.skill-tag').forEach((tag, index) => {
        tag.style.opacity = '0';
        tag.style.transform = 'translateY(10px)';
        
        setTimeout(() => {
            tag.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
            tag.style.opacity = '1';
            tag.style.transform = 'translateY(0)';
        }, index * 50);
    });
    
    // Contact link click tracking
    document.querySelectorAll('.contact-link').forEach(link => {
        link.addEventListener('click', function() {
            console.log('Contact link clicked:', this.textContent);
        });
    });
    
})();