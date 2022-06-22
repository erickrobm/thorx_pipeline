const showMenu = (toggleId, navId) =>{
    const toggle = document.getElementById(toggleId),
    nav = document.getElementById(navId)
    
    // Validamos que existan estas variables
    if(toggle && nav){
        toggle.addEventListener('click', ()=>{
            // Añadimos la clase "show-menu" a la etiqueta del div que posee la clase "nav__menu"
            nav.classList.toggle('show-menu')
        })
    }
}
showMenu('nav-toggle','nav-menu')

/*==================== DENOTA DE UN COLOR MAS OSCURO DONDE NOS ENCONTRAMOS EN EL MENU ====================*/
const sections = document.querySelectorAll('section[id]')

function scrollActive(){
    const scrollY = window.pageYOffset

    sections.forEach(current =>{
        const sectionHeight = current.offsetHeight
        const sectionTop = current.offsetTop - 50;
        sectionId = current.getAttribute('id')

        if(scrollY > sectionTop && scrollY <= sectionTop + sectionHeight){
            document.querySelector('.nav__menu a[href*=' + sectionId + ']').classList.add('active-link')
        }else{
            document.querySelector('.nav__menu a[href*=' + sectionId + ']').classList.remove('active-link')
        }
    })
}
window.addEventListener('scroll', scrollActive)

/*==================== MODO NOCTURNO ====================*/ 
const themeButton = document.getElementById('theme-button')
const darkTheme = 'dark-theme'
const iconTheme = 'bx-sun'

// Color de Tema Principal (si el usuario lo selecciona)
const selectedTheme = localStorage.getItem('selected-theme')
const selectedIcon = localStorage.getItem('selected-icon')

// Obtenemos el tema actual que tiene la interfaz validando la clase "dark-theme"
const getCurrentTheme = () => document.body.classList.contains(darkTheme) ? 'dark' : 'light'
const getCurrentIcon = () => themeButton.classList.contains(iconTheme) ? 'bx-moon' : 'bx-sun'

// Validamos si el usuario eligió previamente un tema
if (selectedTheme) {
  //Si se cumple la validación, preguntamos cuál fue el problema para saber si activamos o desactivamos el modo nocturno
  document.body.classList[selectedTheme === 'dark' ? 'add' : 'remove'](darkTheme)
  themeButton.classList[selectedIcon === 'bx-moon' ? 'add' : 'remove'](iconTheme)
}

// Activar / Desactivar el modo nocturno manualmente con el boton
themeButton.addEventListener('click', () => {
    // Añadir o remover el modo nocturno
    document.body.classList.toggle(darkTheme)
    themeButton.classList.toggle(iconTheme)
    // Se almacena el tema que elige el usuario
    localStorage.setItem('selected-theme', getCurrentTheme())
    localStorage.setItem('selected-icon', getCurrentIcon())
})