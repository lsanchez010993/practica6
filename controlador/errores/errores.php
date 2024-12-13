<?php

class ErroresPassword {
    const CONTRASEÑA_INCORRECTA = "La contrasela es incorrecta.";
    const CONTRASEÑAS_NO_COINCIDEN = "Las contraseñas no coinciden.";
    const CONTRASEÑA_VACIA = "La contraseña no puede estar vacía.";
    const CONTRASEÑA_CORTA = "La contraseña debe tener al menos 8 caracteres.";
    const CONTRASEÑA_SIN_NUMERO = "La contraseña debe contener al menos un número.";
    const CONTRASEÑA_SIN_MINUSCULA = "La contraseña debe contener al menos una letra minúscula.";
    const CONTRASEÑA_SIN_MAYUSCULA = "La contraseña debe contener al menos una letra mayúscula.";
}
class Mensajes{
    
    const MENSAJE_EXITO_CREAR_USUARIO = '¡Usuario registrado con éxito!';
    const MENSAJE_ACTUALIZACION_CORRECTA = 'El articulo ha sido modificado correctamente';
    const EXITO_INSERTAR_ANIMAL = 'Animal insertado con exito';
    const CONFIRMAR_ACTUALIZACION = "¿Estás seguro de que quieres actualizar este animal?";
    const CONFIRMAR_CREAR_ANIMAL = "¿Estás seguro de que quieres insertar un nuevo animal?";
    const CONFIRMAR_ELIMINACION = "¿Estás seguro de que quieres eliminar este animal?";
    const NO_ANIMALES = "Aún no has insertado ningun animal";
    const PASS_CAMBIADO_OK = "Password Cambiado con exito";

}
class ErroresAnimales{
    const ANIMAL_NO_ENCONTRADO = 'Animal no encontrado';
    const INFORMACION_ANIMAL_VACIO = 'El campo informacion no puede estar vacio.';
    const CAMPO_NOMBRE_VACIO = 'El nombre comun no puede estar vacio.';
}
Class ErroresInicioSesion{
    const ERROR_INICIO_SESION = 'El usuario o la contraseña no son correctos';
    const ERROR_CREAR_USUARIO = 'Error al registrar el usuario.';
    const ERROR_USUARIO_REPETIDO ='El nombre de usuario ya está en uso.'; 
    const ERROR_EMAIL_REPETIDO ='El email ya está en uso.'; 
}





?>