const dropdown = document.querySelectorAll('.dropdown')
const dropdownButton = document.querySelectorAll('.dropdown-button')

const notificationButton = document.querySelector('.notification-toggle')
const notificationDialog = document.querySelector('.notification')


dropdownButton.forEach((button, index) => {
     button.addEventListener('click', ()=>{
        dropdown[index].classList.toggle('display-block')
     })
})


notificationButton.addEventListener('click', ()=>{
   notificationDialog.showModal()
})




// dropdownButton.addEventListener('click', ()=> {
//     dropdown.classList.toggle('display-block')

//     if (dropdown.classList.contains('display-block'))
//         console.log('ok')
//     else
//         console.log('nope')
// })