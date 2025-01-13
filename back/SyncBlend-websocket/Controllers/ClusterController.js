const { spawn } = require('child_process');
const path = require('path');
const mysql = require('mysql2');

class ClusterController {
    static loadData(req, res) {
        const { group_id, form_id } = req.body;

        // Verificar si los datos son válidos
        if (!group_id || !form_id) {
            return res.status(400).json({ error: "Faltan parámetros group_id o form_id" });
        }

        console.log(`group_id: ${group_id}, form_id: ${form_id}`);

        // Crear una conexión a la base de datos
        const connection = mysql.createConnection({
            host: 'localhost',   // Cambia esto por tu host de base de datos
            user: 'root',        // Cambia esto por tu usuario de base de datos
            password: '', // Cambia esto por tu contraseña de base de datos
            database: 'syncblend_laravel'  // Cambia esto por el nombre de tu base de datos
        });

        // Realizar una consulta a la base de datos
        connection.query('SELECT * FROM form_answer_users WHERE form_id = ?', [form_id], (err, results) => {
            if (err) {
                console.error('Error al consultar la base de datos: ', err);
                return res.status(500).json({ error: 'Error al consultar la base de datos' });
            }

            console.log('Resultados de la consulta: ', results);

            const student_id = [];
            const likes = [];
            const dislikes = [];

            results.forEach((res, index)=>{
                console.log(res);
                student_id.push(res.user_id)

                // connection.query('SELECT * FROM questions where id = ?', [])
            });

            // Aquí puedes procesar los resultados y enviarlos en la respuesta
            const responseData = {
                group_id: group_id,
                form_id: form_id,
                message: "Datos recibidos correctamente",
                dbResults: results // Incluimos los resultados de la consulta
            };

            // Responder con los datos obtenidos
            res.json(responseData);
        });

        // Cerrar la conexión
        connection.end();
    }
}

module.exports = ClusterController;
