const header = document.querySelector('header')
const nav = document.querySelector('nav')
const times = document.querySelector('.times')
const bars = document.querySelector('.bars')
const overlay = document.querySelector('.overlay')
const tradingLists = document.querySelectorAll('.trading-list ')
const topRestContents = document.querySelectorAll('.top-rest-content-outer')
const coll = document.querySelectorAll(".col-toggle");
const rowGrid = document.querySelector(".row-toggle");
const gridToggle = document.querySelectorAll(".grid-el");
const proDetailsFilters = document.querySelectorAll('.pro-details-filter')
const proDetailsFilterContents = document.querySelectorAll('.pro-details-filter-content')

proDetailsFilters.forEach(proDetailsFilter => {
  proDetailsFilter.addEventListener('click', (e) => {
    proDetailsFilter.classList.add('active')

    proDetailsFilters.forEach(proDetailsFilter2 => {
      if (proDetailsFilter2 != proDetailsFilter) {
        proDetailsFilter2.classList.remove('active')
      }
    })

    const proDetailsFilterData = proDetailsFilter.getAttribute('data-filter')


    proDetailsFilterContents.forEach(proDetailsFilterContent => {
      const proDetailsFilterContentData = proDetailsFilterContent.getAttribute('data-filter-content')

      if (proDetailsFilterData == proDetailsFilterContentData) {
        proDetailsFilterContent.classList.add('active')
      }
      else {
        proDetailsFilterContent.classList.remove('active')
      }
    })
  })
})



const gridView = document.querySelector('.grid-view')
const appListView = document.querySelector('.appointment-list-view')

const appGridLists = document.querySelectorAll('.app-grid-list')

appGridLists.forEach(appGridList => {
  appGridList.addEventListener('click', (e) => {
    if (appGridList.classList.contains('grid-list-left')) {
      console.log('ff')

      gridView.style.display = 'none'
      appListView.style.display = 'block'
    }

    else if (appGridList.classList.contains('grid-list-right')) {
      gridView.style.display = 'block'
      appListView.style.display = 'none'
    }
  })
})



$(function () {
  $('#datepicker').datepicker({
    format: 'dd/mm/yyyy',
  });
});

$(function () {
  $('#datepicker2').datepicker({
    format: 'dd/mm/yyyy',
  });
});
$(function () {
  $('#datepicker3').datepicker({
    format: 'dd/mm/yyyy',
  });
});
$(function () {
  $('#datepicker4').datepicker({
    format: 'dd/mm/yyyy',
  });
});



// var input = document.querySelector('#qty');
// var btnminus = document.querySelector('.qtyminus');
// var btnplus = document.querySelector('.qtyplus');

// if (input !== undefined && btnminus !== undefined && btnplus !== undefined && input !== null && btnminus !== null && btnplus !== null) {

//   var min = Number(input.getAttribute('min'));
//   var max = Number(input.getAttribute('max'));
//   var step = Number(input.getAttribute('step'));

//   function qtyminus(e) {
//     var current = Number(input.value);
//     var newval = (current - step);
//     if (newval < min) {
//       newval = min;
//     } else if (newval > max) {
//       newval = max;
//     }
//     input.value = Number(newval);
//     e.preventDefault();
//   }

//   function qtyplus(e) {
//     var current = Number(input.value);
//     var newval = (current + step);
//     if (newval > max) newval = max;
//     input.value = Number(newval);
//     e.preventDefault();
//   }

//   btnminus.addEventListener('click', qtyminus);
//   btnplus.addEventListener('click', qtyplus);

// }


// const newOrderTableTr = document.querySelector('.new-order-table')
// const inputQty = document.querySelector('#qty');
// //console.log(newOrderTableTr)
// // newOrderTableTr.addEventListener('click', (e) => {
// //   console.log('fff')
// // })
// newOrderTableTr.addEventListener('click', (e) => {
//   if (e.target.classList.contains('qtyplus')) {
//     // console.log('d')
//     let inputQtyValue = +inputQty.value

//     console.log(inputQtyValue++)

//     inputQty = inputQtyValue++
//   }
//   else {
//     console.log('dd')
//   }
// })

const mediaQuery = window.matchMedia('(max-width: 992px)')
mediaQuery.addEventListener("change", myFunction);

function myFunction(mediaQuery) {
  if (mediaQuery.matches) {
    rowGrid.classList.remove('row-list')
  }
  else {
    rowGrid.classList.remove('row-list', 'flex-column')
    coll.forEach((col) => {
      col.classList.add("col-lg-4", "col-md-6");
    });
  }
}


gridToggle.forEach((item) => {
  item.addEventListener("click", (e) => {
    if (item.classList.contains('list')) {
      gridToggle[0].classList.add('active')
      gridToggle[1].classList.remove('active')

      rowGrid.classList.add("flex-column", 'row-list');
      coll.forEach((col) => {
        col.classList.remove("col-lg-4", "col-md-6");
      });
    } else if (item.classList.contains('grid')) {
      gridToggle[0].classList.remove('active')
      gridToggle[1].classList.add('active')
      rowGrid.classList.remove("flex-column", 'row-list');
      coll.forEach((col) => {
        col.classList.add("col-lg-4", "col-md-6");
      });
    }
  });
});

tradingLists.forEach(tradingList => {
  tradingList.addEventListener('click', (e) => {
    tradingList.classList.add('active')

    tradingLists.forEach(tradingList2 => {
      if (tradingList2 != tradingList) {
        tradingList2.classList.remove('active')
      }
    })

    const tradingListData = tradingList.getAttribute('data-tab')

    topRestContents.forEach(topRestContent => {

      // topRestContent.classList.remove('active')
      topRestContent.classList.add('hide')

      const topRestContentData = topRestContent.getAttribute('data-content')

      if (tradingListData == topRestContentData || tradingListData == 'all') {
        topRestContent.classList.remove('hide')
        //  topRestContent.classList.add('active')

      }


    })
  })
})




bars.addEventListener('click', (e) => {
  header.classList.add('show-sidebar')
})

times.addEventListener('click', (e) => {
  header.classList.remove('show-sidebar')
})
overlay.addEventListener('click', (e) => {
  header.classList.remove('show-sidebar')
})


var swiper = new Swiper(".mySwiper", {
  slidesPerView: 3,
  spaceBetween: 30,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  autoplay: {
    delay: 2500,
    disableOnInteraction: false,
  },
  breakpoints: {
    "@0.00": {
      slidesPerView: 1,
      spaceBetween: 10,
    },
    "@0.75": {
      slidesPerView: 1,
      spaceBetween: 20,
    },
    "@1.00": {
      slidesPerView: 2,
      spaceBetween: 20,
    },
    "@1.50": {
      slidesPerView: 3,
      spaceBetween: 20,
    },
  },
});
var swiper2 = new Swiper(".mySwiper2", {
  slidesPerView: 1,
  spaceBetween: 50,
  
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  autoplay: {
    delay: 5000,
    disableOnInteraction: false,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  breakpoints: {
    "@0.00": {
      slidesPerView: 1,
      spaceBetween: 10,
    },
    "@0.75": {
      slidesPerView: 1,
      spaceBetween: 20,
    },
    "@1.00": {
      slidesPerView: 1,
      spaceBetween: 20,
    },
    "@1.50": {
      slidesPerView: 1,
      spaceBetween: 20,
    },
  },
});
const logoDark = document.querySelector('.logo-dark')
const logoWhite = document.querySelector('.logo-white')
logoDark.style.display = 'none'
window.addEventListener('scroll', (e) => {
  console.log('ff')
  if (window.pageYOffset > 100) {
    nav.classList.add('fixed')
    bars.classList.add('color-dark')
    logoWhite.style.display = 'none'
    logoDark.style.display = 'block'
  }
  else {
    nav.classList.remove('fixed')
    bars.classList.remove('color-dark')
    logoWhite.style.display = 'block'
    logoDark.style.display = 'none'
  }
})




const lightbox = GLightbox({
  touchNavigation: true,
  loop: true,
  autoplayVideos: true,
  zoomable: true,
  draggable: true,
  touchNavigation: true,
});