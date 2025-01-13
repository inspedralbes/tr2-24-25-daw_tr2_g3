const { spawn } = require('child_process');
const path = require('path');
const mysql = require('mysql2/promise'); // Usamos la versión con promesas
const fs = require('fs'); // Módulo para trabajar con el sistema de archivos

class ClusterController {
    static async loadData(req, res) {
        const { group_id, form_id } = req.body;

        // Verificar si los datos son válidos
        if (!group_id || !form_id) {
            return res.status(400).json({ error: "Faltan parámetros group_id o form_id" });
        }

        console.log(`group_id: ${group_id}, form_id: ${form_id}`);

        // Crear una conexión a la base de datos
        const connection = await mysql.createConnection({
            host: 'localhost',   // Cambia esto por tu host de base de datos
            user: 'root',        // Cambia esto por tu usuario de base de datos
            password: '',        // Cambia esto por tu contraseña de base de datos
            database: 'syncblend_laravel'  // Cambia esto por el nombre de tu base de datos
        });

        try {
            // Realizar la consulta inicial
            const [results] = await connection.query('SELECT * FROM form_answer_users WHERE form_id = ?', [form_id]);
            // const [group_members] = await connection.query('SELECT * FROM group_memebers WHERE group_id = ? AND role = "student"', [group_id]);


            console.log('Resultados de la consulta: ', results);

            const student_id = [];
            const likes = [];
            const helps = [];

            const dislikes = [];
            const insults = [];
            
            // for (const row of group_members){
            //     student_id.push(row.user_id)
            // }

            // Procesar cada fila del resultado
            for (const row of results) {
                student_id.push(row.user_id);

                const answers = JSON.parse(row.answer); // Suponiendo que `answer` está en formato JSON
                console.log(answers);

                let proFound = false;

                for (const answer of answers) {
                    // Consulta interna para obtener la categoría de la pregunta
                    const [response] = await connection.query('SELECT * FROM questions WHERE id = ?', [answer.question_id]);

                    if (response.length > 0) {
                        const question = response[0];
                        if (question.category === 'socPlus') {
                            likes.push(answer.students_id);
                        }

                        if (question.category === 'pro' && !proFound) {
                            helps.push(answer.students_id);
                            proFound = true
                        }

                        if (question.category === 'socMinus') {
                            dislikes.push(answer.students_id);
                        }

                        if (question.category === 'av') {
                            insults.push(answer.students_id);
                        }
                    }
                }
            }

            // Crear la respuesta
            const responseData = {
                student_id: student_id,
                likes: likes,
                dislikes: dislikes,
                helps: helps,
                insults: insults
            };
            console.log(responseData)

            const filePath = path.join(__dirname, '../data.json');
            await fs.promises.writeFile(filePath, JSON.stringify(responseData, null, 2));

            console.log('Archivo JSON creado correctamente en:', filePath);

            // Ejecutar el script de Python y esperar su finalización
            const pythonScript = path.join(__dirname, '../ex.py');
            const pythonSuccess = await new Promise((resolve) => {
                const pythonProcess = spawn('python', [pythonScript]);

                pythonProcess.stdout.on('data', (data) => {
                    console.log(`Salida del script Python: ${data}`);
                });

                pythonProcess.stderr.on('data', (data) => {
                    console.error(`Error en el script Python: ${data}`);
                });

                pythonProcess.on('error', (err) => {
                    console.error('Error en el proceso Python:', err);
                });

                pythonProcess.on('close', (code) => {
                    console.log(`El script Python finalizó con el código: ${code}`);

                    // Ahora lee el archivo graph_data.json y envíalo en la respuesta
                    const graphDataPath = path.join(__dirname, '../graph_data.json');

                    fs.readFile(graphDataPath, 'utf8', (err, data) => {
                        if (err) {
                            return res.status(500).json({ error: 'Error al leer el archivo graph_data.json' });
                        }

                        const graphData = JSON.parse(data);
                        res.json(graphData);
                    });
                });
            });

            // Actualizar el estado de la ejecución del script de Python
            responseData.pythonSuccess = pythonSuccess;


            // Enviar la respuesta
            res.json(responseData);
        } catch (error) {
            console.error('Error al realizar las consultas: ', error);
            res.status(500).json({ error: 'Error al realizar las consultas' });
        } finally {
            // Cerrar la conexión
            await connection.end();
        }
    }
}

module.exports = ClusterController;
