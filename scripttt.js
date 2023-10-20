let Navbar = document.querySelector('.navbar');
let bars = document.querySelector('.fa-bars');

bars.onclick = () =>{
  Navbar.classList.toggle("active")
  bars.classList.toggle('fa-times')
};




var swiper = new Swiper(".home-slide", {
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
});



var swiper = new Swiper(".astro-slider", {
    loop: true,
    slidesPerView: 1,
    spaceBetween: 10,
    breakpoints: {
      "0": {
        slidesPerView: 1,
        autoplay:{
            delay:700,
            disableOnInteraction:false,
        },
      },
      "768": {
        slidesPerView: 2,
          
      },
      "1020": {
        slidesPerView: 3,
          
      },
    },
  });