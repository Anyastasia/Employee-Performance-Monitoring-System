const dialogButtons = document.querySelectorAll('.dialog-button')
const dialog = document.querySelectorAll('.dialog')
const closeDialogButtons = document.querySelectorAll('.close-dialog')


dialogButtons.forEach((button, index) => {
    button.addEventListener('click', ()=>{
        dialog[index].showModal()
    })
})

closeDialogButtons.forEach((button, index) => {
    button.addEventListener('click', ()=>{
        dialog[index].close();
    })
})