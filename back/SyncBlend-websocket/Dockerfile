# Usa una imagen base de Node.js
FROM node:18


# Establece el directorio de trabajo dentro del contenedor
WORKDIR /app


# Instala herramientas necesarias
RUN apt update && apt install -y \
   curl \
   git \
   && apt clean && rm -rf /var/lib/apt/lists/*