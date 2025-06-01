document.addEventListener('DOMContentLoaded', function () {
    // Swiper bên trái
    var leftSwiper = new Swiper('.leftSwiper', {
        loop: true,
        autoplay: {
            delay: 2000,
            disableOnInteraction: false,
        },
        effect: 'fade',
        pagination: {
            el: '.left-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.left-next',
            prevEl: '.left-prev',
        }
    });

    // Swiper giữa
    var centerSwiper = new Swiper('.centerSwiper', {
        loop: true,
        autoplay: {
            delay: 2000,
            disableOnInteraction: false,
        },
        effect: 'fade',
        pagination: {
            el: '.center-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.center-next',
            prevEl: '.center-prev',
        }
    });

    // Swiper bên phải
    var rightSwiper = new Swiper('.rightSwiper', {
        loop: true,
        autoplay: {
            delay: 2000,
            disableOnInteraction: false,
        },
        effect: 'fade',
        pagination: {
            el: '.right-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.right-next',
            prevEl: '.right-prev',
        }
    });
});
