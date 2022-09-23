const dropdown = document.querySelectorAll('.dropdown')
const dropdownButton = document.querySelectorAll('.dropdown-button')

dropdownButton.forEach((button, index) => {
    button.addEventListener('click', ()=>{
       dropdown[index].classList.toggle('display-block')
    })
})