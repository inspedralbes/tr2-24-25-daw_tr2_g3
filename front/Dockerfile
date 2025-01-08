# Usa una imagen base de Node.js
FROM node:18

# Establece el directorio de trabajo dentro del contenedor
WORKDIR /app

# Copia solo los archivos de dependencias primero (optimización del caché de Docker)
COPY package*.json ./

# Instala las dependencias necesarias
RUN npm install

# Copia el resto del código fuente al contenedor
COPY . .

# Deja el Dockerfile limpio y sin comando de inicio ni puertos
