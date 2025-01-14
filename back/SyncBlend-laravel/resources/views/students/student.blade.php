<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información de {{$students[0]['name']}} {{$students[0]['lastname']}}</title>
    <style>
        .container {
            padding: 20px;
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }


        .student-info {
            display: flex;
            gap: 20px;
        }


        .student-photo img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%; /* Imagen redonda */
        }

        .student-details {
            flex: 1; /* Toma el espacio restante */
        }

        .group-info,
        .contact-info,
        .observations,
        .sociogram {
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
        }

        textarea {
            resize: vertical;
            width: 100%;
            padding: 5px;
            font-size: 16px;
        }

        h3 {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="container" id="content-pdf">
    <!-- Información del Estudiante -->

    @foreach ($students as $stu)
        <div class="student-photo">
            <img src="{{ $imageSrc }}" alt="Foto del estudiante" class="rounded-full">
        </div>

        <div class="student-info">

            <div class="student-details">
                <h2 class="text-2xl font-bold">{{ $stu['name'] }} {{ $stu['lastname'] }}</h2>
                <p><strong>Fecha de Nacimiento:</strong> {{ $stu['birthdate'] }}</p>
                <p><strong>Género:</strong> {{ $stu['gender'] }}</p>
                <p><strong>Seguridad Social:</strong> {{ $stu['social_security_number'] }}</p>
                <p><strong>Nacionalidad:</strong> {{ $stu['nationality'] }}</p>
                <p><strong>DNI:</strong> {{ $stu['id_document'] }}</p>
            </div>
        </div>

    @endforeach


    <br>

    <!-- Grupo -->
    @foreach ($groups as $grp)
        <div class="group-info">
            <h3 class="text-xl font-semibold">Grupo</h3>
            <p><strong>Curso:</strong> {{ $grp['course'] }} - <strong>Letra:</strong> {{ $grp['letter'] }}</p>
            <p><strong>Código:</strong> {{ $grp['code'] }}</p>
        </div>
    @endforeach

    <br>

    <!-- Información de Contacto -->
    @foreach ($students as $stu)
        <div class="contact-info">
            <h3 class="text-xl font-semibold">Información de Contacto</h3>
            <p><strong>Dirección:</strong> {{ $stu['address'] }}</p>
            <p><strong>Código Postal:</strong> {{ $stu['postal_code'] }}</p>
            <p><strong>Ciudad:</strong> {{ $stu['city'] }}</p>
            <p><strong>Provincia:</strong> {{ $stu['province'] }}</p>
            <p><strong>Teléfono:</strong> {{ $stu['phone'] }}</p>
            <p><strong>Email:</strong> {{ $stu['email'] }}</p>
        </div>
    @endforeach

    <br>
    <!-- Observaciones -->
    <div class="observations">
        <h3 class="text-xl font-semibold">Observaciones</h3>
        {{--        <textarea>{{ $students[0]['observations'] }}</textarea> --}}
        <textarea>Obsevaciones del estudiante</textarea>
    </div>
</div>
</body>
</html>
