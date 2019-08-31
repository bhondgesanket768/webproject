const openModelButtons = document.querySelectorAll('[data-modal-target]');
const closeModelButtons = document.querySelectorAll('[data-close-button]');
const overlay = document.getElementById('overlay');

openModelButtons.forEach(button=>{
    button.addEventListener('click',()=>{
        const modal= document.querySelector(button.dataset.modalTarget);
        openModel(modal);
    })
})

closeModelButtons.forEach(button=>{
    button.addEventListener('click',()=>{
        const modal= button.closest('.modal');
        closeModel(modal);
    })
})

overlay.addEventListener('click',()=>{
    const modals = document.querySelectorAll('.modal.active');
    modals.forEach(modal  => {
       closeModel(modal); 
    })
})

function openModel(modal){
    if(modal == null) return;
    modal.classList.add('active');
    overlay.classList.add('active');
}

function closeModel(modal){
    if(modal == null) return;
    modal.classList.remove('active');
    overlay.classList.remove('active');
}