/*==================== SWEET ALERT AND FORUM FILTERS ====================*/ 
// Variables
const nombre = document.querySelector('#nombre')
const apellido = document.querySelector('#apellido')
const dia = document.querySelector('#nacimiento_day')
const mes = document.querySelector('#nacimiento_month')
const year = document.querySelector('#nacimiento_year')
const email = document.querySelector('#email')
const pais = document.querySelector('#pais')

const imagen = document.getElementById('file')  // modificar 

const male = document.querySelector('#dot-1')
const fem = document.querySelector('#dot-2')
const non = document.querySelector('#dot-3')

const diagnostico = document.querySelector('#diagnostico')
const porcentaje = document.querySelector('#porcentaje')

const alerta = document.querySelector('#formulario')

// Boton Verificar Imagen
const botonImg = document.querySelector('#verify__image')

// Boton Enviar
const botonEnviar = document.querySelector('#submit__forum')

// Validaciones
// Uso de regular expresion en el email
const resultEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
const resultName = /^[a-zA-ZÀ-ÿ\s]{1,40}$/

eventListener()

// Función que captura información si estamos dentro de cada cosa
function eventListener(){
    //Cuando se carga 
    document.addEventListener('DOMContentLoaded', iniciarWebApp)

    nombre.addEventListener('blur', validateInfo)
    apellido.addEventListener('blur', validateInfo)
    dia.addEventListener('blur', validateInfo)
    mes.addEventListener('blur', validateInfo)
    year.addEventListener('blur', validateInfo)
    email.addEventListener('blur', validateInfo)
    pais.addEventListener('blur', validateInfo)
    imagen.addEventListener('blur', validateInfo)

    male.addEventListener('blur', validateInfo)
    fem.addEventListener('blur', validateInfo)
    non.addEventListener('blur', validateInfo)

    // Verificador de la imagen
    botonImg.addEventListener('click', validateInfo)

    // Submit del formulario
    alerta.addEventListener('submit', sendForm)
}

function iniciarWebApp(){
    console.log('Iniciando Sitio')
    
    // Cuando apenas llegamos al formulario, bloqueamos el boton enviar hasta que se llenen todos los campos
    botonEnviar.disabled = true
}

function validateInfo(element){
    const err = document.querySelector('p.error')
    const suc = document.querySelector('p.correcto')

    // Este if elimina la clase .error de la constante de arriba y ya no se despliega "de más" el mensaje de error.
    if (err){
        err.remove()
    }

    if (suc){
        suc.remove()
    }

    //console.log(element.target.type)

    // Este if elimina la clase .correcto de la constante de arriba y ya no se despliega "de más" el mensaje de corecto.
    // CASO PARA SELECTS Y TAMBIEN NOMBRES VACIOS
    if (element.target.value.length > 0){
            element.target.classList.add('correcto');
            element.target.classList.remove('error-mostrar')
        } else {
            element.target.classList.add('error-mostrar');
            element.target.classList.remove('correcto');
            showError('Todos los campos deben ser llenados.');
        }

    // CASO PARA NOMBRE(S) Y APELLIDOS
    if (element.target.type === 'text') {
        if(resultName.test(element.target.value)){
            element.target.classList.add('correcto')
            element.target.classList.remove('error-mostrar')
        } else {
            element.target.classList.add('error-mostrar')
            element.target.classList.remove('correcto')
            showError('Introduzca bien su(s) nombre(s) y/o apellido(s)')
        }
    }
    
    // CASO PARA EMAIL
    if (element.target.type === 'email'){
        if(resultEmail.test(element.target.value)){
            element.target.classList.add('correcto')
            element.target.classList.remove('error-mostrar')
        }
        else {
            element.target.classList.add('error-mostrar')
            element.target.classList.remove('correcto')
            showError('El email no es válido.')
        }
    }

    // Verificación de la imagen.
    if (element.target.type === 'button') { // Verificar que el elemento sea tipo button
        var archivoRuta = imagen.value; // Almacenar ruta de la imagen
        var extPermitidas = /(.jpg|.png|.jpeg)$/i // Extensiones permitidas para la img

        // PASO 1: VERIFICAR QUE NO ESTÉ VACÍO.
        if (archivoRuta === '') {
            showError('Debes seleccionar una imagen.')
        }

        // PASO 2: VERIFICAR QUE EL ARCHIVO SEA IMAGEN CON EXT [.png, .jpeg o .jpg].
        if (!extPermitidas.exec(archivoRuta) && archivoRuta != ''){ // Evaluar si el archivo tiene extensiones permitidas
            element.target.classList.add('error-mostrar')
            showError('Debes seleccionar un archivo con extensión .jpg, .jpeg o .png')
            alerta.reset()
            return false;
        } else { // PASO 2.1: Ya verificamos que existe una imagen.
            // PASO 2.2: La imagen es válida y correcta.
            if (diagnostico.value !== 'No Coincide' && diagnostico.value !== '') { // Diagnóstico correcto
                element.target.classList.add('correcto')
                element.target.classList.remove('error-mostrar')
                botonImg.value = imagen.value
                // Deshabilitamos el botón de verificar imagen cuando esta sea correcta.
                botonImg.disabled = true
                botonImg.value = 'Imagen Válida'
                err.remove()
                showSuccess('Imagen Válida: ' +  imagen.value.substr(12)) //.substr funciona para solo dejar el nombre de la img.
                // const tempRoute = imagen.value
                // desactivarImg()
                // imagen = tempRoute
            } else { // Diagnóstico incorrecto o vacío
                element.target.classList.remove('correcto')
                showError('Vuelva a dar click para verificar la imagen.')
            }
        }

        // console.log((element.target.type === 'button'))
        if (diagnostico.value === 'No Coincide' && imagen.value.length !== 0){
            element.target.classList.remove('correcto')
            element.target.classList.add('error-mostrar')
            Swal.fire({
                title: 'La imagen no es válida.',
                icon: 'error',
                timer: 3000
            })
            alerta.reset()
            diagnostico.remove()
        }
    }

    // Verificación de sexo
    if (male.checked){
        let sexo = male.value
    }

    if (fem.checked){
        let sexo = fem.value
    }

    if (non.checked){
        let sexo = non.value
    }  

    console.log(imagen.value)
    // Habilitar el botón de Enviar Formulario cuando todos los campos estén llenos (filtro).
    if (nombre.value != '' &&
        apellido.value != '' &&
        dia.value != '' &&
        mes.value != '' && 
        year.value != '' && 
        resultEmail.test(email.value) &&
        pais.value != '' && 
        imagen.value.length > 0 &&
        diagnostico.value != ''){ 
            if (err){
                err.remove()
            }

            // document.getElementById.value = imagen.value

            botonEnviar.disabled = false
            
            Swal.fire({
                title: 'Su formulario es válido',
                text: 'Listo para generar PDF.',
                icon: 'success',
                timer: 3000
            })
            showSuccess('Su formulario está listo para ser enviado.')
            // En caso de que ya sea validado el formulario y la persona introduzca otra imagen
        }
}

function showError(msg){
    const indicateError = document.createElement('p')
    indicateError.textContent = msg
    indicateError.classList.add('error')
    
    const numErrors = document.querySelectorAll('.error')
    
    if (numErrors.length === 0){
        alerta.appendChild(indicateError)
    }
}

function showSuccess(msg){
    const indicateSuccess = document.createElement('p')
    indicateSuccess.textContent = msg
    indicateSuccess.classList.add('correcto')

    const numSuccess = document.querySelectorAll('.correcto')
    
    alerta.appendChild(indicateSuccess)
}

function desactivarImg() {
    document.getElementById('file').disabled = true
}

function sendForm() {
}

