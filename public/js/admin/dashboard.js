// dialogs
const dialogButtons = document.querySelectorAll('.dialog-button')
const addStaffDialog = document.querySelectorAll('.add-staff-dialog')
const closeDialogButtons = document.querySelectorAll('.close-dialog')

// dropdown buttons
const dropdown = document.querySelectorAll('.dropdown')
const dropdownButton = document.querySelectorAll('.dropdown-button')


dropdownButton.forEach((button, index) => {
    button.addEventListener('click', ()=>{
       dropdown[index].classList.toggle('display-block')
    })
})


dialogButtons.forEach((button, index) => {
    button.addEventListener('click', ()=>{
        console.log('wew');
        addStaffDialog[index].showModal()
    })
})

closeDialogButtons.forEach((button, index) => {
    button.addEventListener('click', ()=>{
        addStaffDialog[index].close();
    })
})


