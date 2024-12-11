<template>
    <nav class="breadcrumbs mb-6">
        <ul class="flex">
            <li v-for="(crumb, index) in crumbs" :key="index" class="breadcrumb-item">
                <a :href="crumb.href">{{ crumb.text }}</a>
                <span v-if="index < crumbs.length - 1" class="breadcrumb-separator">/</span>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    name: 'BreadCrumbs',
    props: {
        crumbs: {
            type: Array,
            required: true,
            default: () => []
        }
    }
}
</script>

<style scoped>
/* Contenedor de breadcrumbs */
.breadcrumbs {
    display: flex;
    align-items: center;
    white-space: nowrap; /* Evita que los elementos se rompan en varias líneas */
    overflow: hidden;
    flex-wrap: nowrap; /* Mantiene todo en una sola fila */
}

/* Estilo de los elementos */
.breadcrumb-item {
    display: flex;
    align-items: center;
    font-size: 18px;
    position: relative; /* Necesario para colocar el separador */
}

.breadcrumb-item a {
    display: inline-flex; /* Comportamiento en línea con flexbox */
    align-items: center;
    text-decoration: none;
    padding: 0.5em 1em;
    background-color: #cccdcf; /* Fondo claro similar al de la imagen */
    border-radius: 8px; /* Bordes redondeados */
    color: #6c757d; /* Color del texto */
    font-size: 14px;
    font-weight: 500;
    position: relative; /* Para el diseño del separador */
    white-space: nowrap; /* Evita saltos de línea */
}

/* Eliminar el triángulo del separador */
.breadcrumb-item a::after {
    display: none;
}

/* Último elemento (sin separador) */
.breadcrumb-item:last-child a {
    background-color: #e6e1e1; /* Fondo blanco para destacar el último elemento */
    color: #000000; /* Texto negro */
    font-weight: bold;
}


.breadcrumb-separator {
    position: relative;
    margin: 0 0.8em;
    color: #6c757d; 
}

/* Efecto hover */
.breadcrumb-item a:hover {
    background-color: #e9ecef; /* Color más oscuro en hover */
    color: #495057;
}
</style>

