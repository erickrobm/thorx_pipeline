/*==================== DESPLEGAR MENU EN DISP. MOVILES ====================*/
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

/*==================== DESPLAZAR HACIA ABAJO EL MENU DE DISP. MOVILES AL SELECCIONAR UNA OPCION ====================*/
const navLink = document.querySelectorAll('.nav__link')

function linkAction(){
    const navMenu = document.getElementById('nav-menu')
    // Cuando damos click en cada elemento "a" con la etiqueta "nav__link", se borra la clase "show-menu" y
    // desplaza hacia abajo el menu
    navMenu.classList.remove('show-menu')
}
navLink.forEach(n => n.addEventListener('click', linkAction))

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

/*==================== MOSTRAR EL SCROLL HACIA ARRIBA ====================*/ 
function scrollTop(){
    const scrollTop = document.getElementById('scroll-top');
    // Cuando el desplazamiento es superior a 200 de la altura de la ventana gráfica, 
    // se agrega la clase "show-scroll" a la etiqueta a con la clase "scroll-top"
    if(this.scrollY >= 200) scrollTop.classList.add('show-scroll'); else scrollTop.classList.remove('show-scroll')
}
window.addEventListener('scroll', scrollTop)

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

/*==================== REDUCIR EL TAMAÑO Y DESCARGAR EN TAMAÑO A4 ====================*/ 
function scaleReport(){
    document.body.classList.add('scale-report')
}

/*==================== REMOVER LAS PROPIEDADES DE REDIMENSIONAMIENTO DEL TEXTO CUANDO SE HAYA DESCARGADO EL DOCUMENTO ====================*/ 
function removeScale(){
    document.body.classList.remove('scale-report')
}

/*==================== GENERAR PDF ====================*/ 
// Area Generada del PDF
let areaResume = document.getElementById('area-resume')

let resumeButton = document.getElementById('resume-button')

let nombre = document.getElementById('nombre')

let reporte = nombre.value + ".pdf"

// Opciones de Html2pdf
let opt = {
    margin:       0,
    filename:     'Reporte_' + reporte,
    image:        { type: 'jpeg', quality: 0.95 },
    html2canvas:  { scale: 4 },
    jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
}

// Funcion para mandar a llamar las opciones de "areaResume" y "html2pdf" 
function generateResume(){
    html2pdf().set(opt).from(areaResume).save();
}

// TAL PARECE QUE ESTA COSA HACE QUE FUNCIONE LAS DESCARGAS DE PDF

function changeTheme2Day(){
    if (getCurrentTheme === 'dark'){
        // Se almacena el tema de día
        localStorage.setItem('light', getCurrentTheme())
        localStorage.setItem('bx-moon', getCurrentIcon())  
    }
}


// Cuando se descarga el PDF, suceden tres eventos:
resumeButton.addEventListener('click', () =>{
    // Cambiar tema para pdf
    changeTheme2Day()
    
    // 1. The class .scale-cv is added to the body, where it reduces the size of the elements
    scaleReport()

    // 2. The PDF is generated
    generateResume()

    // 3. The .scale-cv class is removed from the body after 5 seconds to return to normal size.
    setTimeout(removeScale, 5000)
})

/*==================== GENERAR FECHA Y HORA ====================*/ 
// Rescatamos la fecha y hora en la que se genera el PDF
date = new Date();

// Declaramos las variables de año, mes, dia, hora y minutos en formato "number"
year = date.getFullYear();
month = date.getMonth() + 1;
day = date.getDate();

hour = date.getHours();
minute = date.getMinutes();

// Convertimos las variables de año, dia, hora y minutos a formato "string"
year = year.toString();
day = day.toString();

hour = hour.toString();
minute = minute.toString();

// Visualizamos los meses por su nombre en lugar de su numero.
if (month == 1)
    month = "Enero"
else if (month == 2)
    month = "Febrero"
else if (month == 3)
    month = "Marzo"
else if (month == 4)
    month = "Abril"
else if (month == 5)
    month = "Mayo"
else if (month == 6)
    month = "Junio"
else if (month == 7)
    month = "Julio"
else if (month == 8)
    month = "Agosto"
else if (month == 9)
    month = "Septiembre"
else if (month == 10)
    month = "Octubre"
else if (month == 11)
    month = "Noviembre"
else
    month = "Diciembre"

// Verificamos si las variables dia, hora y minuto tienen un lenght = 1, si es así,
// se les agrega un "0" antes para la cuestion estetica.
if (day.toString().length == 1)
    day = "0" + day;

if (hour.toString().length == 1)
    hour = "0" + hour;

if (minute.toString().length == 1)
    minute = "0" + minute;

// Imprimir fecha.
document.getElementById("date__info").innerHTML = day + "/" + month + "/" + year;
document.getElementById("time__info").innerHTML = " " + hour + ":" + minute + " (CST)";
