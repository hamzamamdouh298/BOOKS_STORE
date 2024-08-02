let navbar = document.querySelector('.header_navigation .header_navbar');
document.getElementById('menu_btn').onclick = () => {
  navbar.classList.toggle('active');
  accbox.classList.remove('active');
};

let accbox = document.querySelector('.header_acc_box');
document.getElementById('user_btn').onclick = () => { 
  accbox.classList.toggle('active');
  navbar.classList.remove('active');
};


window.onscroll=()=>{
  navbar.classList.remove('active');
  accbox.classList.remove('active');
}

document.querySelector('#close_update').onclick = () =>{
  document.querySelector('.edit_product_form').style.display='none';
  window.location.href="admin_products.php";
}



