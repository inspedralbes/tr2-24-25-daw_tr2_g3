<template>
    <!-- <nav class="breadcrumbs mb-6">
        <ul class="flex">
            <li v-for="(crumb, index) in crumbs" :key="index" class="breadcrumb-item">
                <a :href="crumb.href">{{ crumb.text }}</a>
                <span v-if="index < crumbs.length - 1" class="breadcrumb-separator">/</span>
            </li>
        </ul>
    </nav> -->

    <!-- Breadcrumb -->
    <nav class="flex py-2 text-gray-700 rounded-lg mb-2">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li v-for="(crumb, index) in crumbs" :key="index" class="list-item">
                <a :href="crumb.href" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <i :class="crumb.icon" class="mr-2"></i>
                    {{ crumb.text }}
                </a>
                <span v-if="index < crumbs.length - 1" class="breadcrumb-separator">/</span>
            </li>
        </ol>
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

.list-item{
    display: inline-flex;
    align-items: center;
    margin-left: 0px !important; /*Esto ermengol esta puesto porque lo metemos en el template de titulo y para que no se aplique el margen por defecto*/
    text-transform: none;
    padding-left: 0px !important;
}

.list-item a{
    padding-left: 0 !important; /* Eliminar cualquier padding a la izquierda */
    margin-left: 0 !important; /* Eliminar cualquier margen a la izquierda */
}

.breadcrumb-separator {
    position: relative;
    margin: 0 0.5em; /* Ajustar el margen para igualar el espaciado */
    color: #6c757d;
    font-size: 14px;
}

</style>

