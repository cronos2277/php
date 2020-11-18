(function(){
    const menuToggle = document.querySelector('.menu-toggle') || null;
    if(menuToggle){
        menuToggle.onclick = function (){
            document.querySelector('body').classList.toggle('hide-sidebar');
        };
    }

    function addOneSecond(hours,minutes,seconds){
        const d = new Date();
        d.setHours(parseInt(hours));
        d.setMinutes(parseInt(minutes));
        d.setSeconds(parseInt(seconds) + 1);    
        const h = `${d.getHours()}`.padStart(2,0);
        const m = `${d.getMinutes()}`.padStart(2,0);
        const s = `${d.getSeconds()}`.padStart(2,0);
    
        return `${h}:${m}:${s}`;
    }

    const active = document.querySelector('[active-clock]') || null;
    if(active){
        setInterval(function(){
            const parts = active.innerHTML.split(':');
            active.innerHTML = addOneSecond(parts[0],parts[1],parts[2]);
        },1000);
    }  
   
})();


