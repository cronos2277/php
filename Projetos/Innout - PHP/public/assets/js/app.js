(function(){
    const menuToggle = document.querySelector('.menu-toggle');
    menuToggle.onclick = function (){
        document.querySelector('body').classList.toggle('hide-sidebar');
    } 
})();
