<!-- Swiper JS -->
<script src="<?php echo $js; ?>swiper-bundle.min.js"></script>
<!-- Initialize Swiper -->
<script>
var swiper = new Swiper(".ladning .mySwiper", {
    spaceBetween: 30,
    centeredSlides: true,
    autoplay: {
        delay: 8000,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
});
</script>
<script>
var swiper = new Swiper(".products .mySwiper", {
    spaceBetween: 30,
    centeredSlides: true,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: ".right-1",
        prevEl: ".left-1",
    },
});
</script>
<script>
var swiper = new Swiper(".products1 .mySwiper", {
    spaceBetween: 30,
    centeredSlides: true,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: ".right-2",
        prevEl: ".left-2",
    },
});
</script>
<script>
var swiper = new Swiper(".products2 .mySwiper", {
    spaceBetween: 30,
    centeredSlides: true,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: ".right-3",
        prevEl: ".left-3",
    },
});
</script>
<script src="<?php echo $js; ?>jquery-3.6.1.min.js"></script>
<script src="<?php echo $js; ?>jquery-ui.min.js"></script>
<script src="<?php echo $js; ?>all.min.js"></script>
<script src="<?php echo $js; ?>bootstrap.bundle.min.js"></script>
<script src="<?php echo $js; ?>jquery.selectBoxIt.min.js"></script>
<script src="<?php echo $js; ?>front.js"></script>
</body>

</html>