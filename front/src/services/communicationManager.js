import questions from '@/assets/questions.json';
import LARAVEL_PORT from '../../config.js'

const Host = `http://localhost:${LARAVEL_PORT}/api`

export function getQuestions() {

  return questions
}

/*--------------------------------------------GET----------------------------------------------*/
export async function getGroupByTeacher(id) {
  try {
    const response = await fetch(Host + '/groups/getMyGroupsByTeacher/' + id, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json'
      },
    });

    if (response.ok) {
      const json = await response.json();
      return json.data;
    } else {
      console.error(`Error en la petición: ${response.status} ${response.statusText}`)
      return null;
    }

  } catch (error) {
    console.error('Error al realizar la petición:', error);
    return null;
  }
}

export async function getGroup(code) {
  try {
    const response = await fetch(Host + '/groups/getGroup/' + code);
    if (response.ok) {
      const json = await response.json();
      return json.data;
    } else {
      console.error(`Error en la petición: ${response.status} ${response.statusText}`)
      return null;
    }

  } catch (error) {
    console.error('Error al realizar la petición:', error);
    return null;
  }
}

export async function getStudentsByTeacher(id) {
  console.log("AAA", id);
  try {
    const response = await fetch(Host + '/students/getStudentsByTeacher/' + id, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json'
      },
    });

    if (response.ok) {
      const json = await response.json();
      console.log("Manager ", json.data);
      return json.data;
    } else {
      console.error(`Error en la petición: ${response.status} ${response.statusText}`)
      return null;
    }

  } catch (error) {
    console.error('Error al realizar la petición:', error);
    return null;
  }
}

/*--------------------------------------------POST----------------------------------------------*/
export async function sendClass(json) {
  console.log("AAA", json);
  try {
    const response = await fetch(Host + '/groups/create', {
      method: 'POST',
      headers: {
        'Content-Type': 'applicaction/json'
      },
      body: JSON.stringify(json)
    });

    if (response.ok) {
      const json = await response.json();
      return json.data;
    } else {
      console.error(`Error en la petición: ${response.status} ${response.statusText}`)
      return null;
    }

  } catch (error) {
    console.error('Error al realizar la petición:', error);
    return null;
  }
}

export async function sendEmail(subject, message, recipientEmail) {
  const URL = Host + `/sendEmail`;

  const payload = {
    subject: subject,
    message: message,
    to: recipientEmail,
  };

  try {
    const response = await fetch(URL, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(payload),
    });

    if (response.ok) {
      const json = await response.json();
      console.log('Correo enviado:', json);
      return json;
    } else {
      console.error(`Error en la petición: ${response.status} ${response.statusText}`);
      return null;
    }
  } catch (error) {
    console.error('Error al realizar la petición:', error);
    return null;
  }
}


