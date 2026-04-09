
        
      //slider

        $(document).ready(function () {
            var currentIndex = 0;
            var totalSlides = $('.slider .slide').length; // Total number of slides

            function showSlide(index) {
                // Move the slider horizontally to show the current slide
                $('.slider').css('transform', 'translateX(' + (-100 * index) + '%)');
            }

            // Next button click
            $('.next').on('click', function () {
                currentIndex = (currentIndex + 1) % totalSlides; // Loop back to first slide
                showSlide(currentIndex);
            });

            // Previous button click
            $('.prev').on('click', function () {
                currentIndex = (currentIndex - 1 + totalSlides) % totalSlides; // Loop back to last slide
                showSlide(currentIndex);
            });

            // Optional: Auto slide every 5 seconds
            setInterval(function () {
                currentIndex = (currentIndex + 1) % totalSlides;
                showSlide(currentIndex);
            }, 5000);
        });
        //product card
        $(document).ready(function () {
            $('.product-card').hover(function () {
                $(this).find('img').css('transform', 'scale(1.1)');
            }, function () {
                $(this).find('img').css('transform', 'scale(1)');
            });
        });

