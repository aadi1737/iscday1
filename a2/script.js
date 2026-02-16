const day = document.querySelector(".day");
const night = document.querySelector(".night");
const sun=document.getElementById("sun");

day.addEventListener("click",(e)=>{

    e.preventDefault();

    sun.classList.toggle("godown");
    
});


night.addEventListener("click",(e)=>{
    
    e.preventDefault();
    
    sun.classList.toggle("goup");
    sun.classList.toggle("show");

})