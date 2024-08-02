let usernav=document.querySelector('.user_header .header_1 .user_flex .navbar');

document.getElementById('user_menu_btn').onclick=()=>{
  usernav.classList.toggle('active');
  accbox.classList.remove('active');
};

let accbox = document.querySelector('.header_acc_box');
document.getElementById('user_btn').onclick = () => { 
  accbox.classList.toggle('active');
  usernav.classList.remove('active');
};

window.onscroll = () => {
  accbox.classList.remove('active');
  usernav.classList.remove('active');
  let nav = document.querySelector('.user_header .header_1');

  if (window.scrollY > 70) {
    nav.classList.add('active');
  } else {
    nav.classList.remove('active');
  }
};
